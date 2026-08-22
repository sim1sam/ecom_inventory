<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Setting;
use App\Models\OrderProduct;
use App\Models\OrderProductVariant;
use App\Models\OrderAddress;
use App\Models\Country;
use App\Models\City;
use App\Models\CountryState;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Footer;
use App\Models\Address;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function dashboard(Request $request)
    {
        [$from, $to] = $this->orderDateRange($request);
        $setting = Setting::first();
        $stats = $this->orderStats($from, $to);
        $recentOrders = Order::with('user')->latest()->limit(12)->get();
        $topProducts = OrderProduct::query()
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$from.' 00:00:00', $to.' 23:59:59'])
            ->where('orders.order_status', '!=', 4)
            ->groupBy('order_products.product_id', 'order_products.product_name')
            ->selectRaw('order_products.product_id, order_products.product_name, SUM(order_products.qty) as sold_qty, SUM(order_products.unit_price * order_products.qty) as sale_amount')
            ->orderByDesc('sold_qty')
            ->limit(10)
            ->get();

        return view('admin.order_dashboard', compact('from', 'to', 'setting', 'stats', 'recentOrders', 'topProducts'));
    }

    public function index(){
        $orders = Order::with('user')->orderBy('id','desc')->get();
        $title = trans('admin_validation.All Orders');
        $setting = Setting::first();
        $stats = $this->orderStats();

        return view('admin.order', compact('orders','title','setting','stats'));

    }

    public function pendingOrder(){
        $orders = Order::with('user')->orderBy('id','desc')->where('order_status',0)->get();
        $title = trans('admin_validation.Pending Orders');
        $setting = Setting::first();

        return view('admin.order', compact('orders','title','setting'));
    }

    public function pregressOrder(){
        $orders = Order::with('user')->orderBy('id','desc')->where('order_status',1)->get();
        $title = trans('admin_validation.Pregress Orders');
        $setting = Setting::first();

        return view('admin.order', compact('orders','title','setting'));
    }

    public function deliveredOrder(){
        $orders = Order::with('user')->orderBy('id','desc')->where('order_status',2)->get();
        $title = trans('admin_validation.Delivered Orders');
        $setting = Setting::first();

        return view('admin.order', compact('orders','title','setting'));
    }

    public function completedOrder(){
        $orders = Order::with('user')->orderBy('id','desc')->where('order_status',3)->get();
        $title = trans('admin_validation.Completed Orders');
        $setting = Setting::first();
        return view('admin.order', compact('orders','title','setting'));
    }

    public function declinedOrder(){
        $orders = Order::with('user')->orderBy('id','desc')->where('order_status',4)->get();
        $title = trans('admin_validation.Declined Orders');
        $setting = Setting::first();
        return view('admin.order', compact('orders','title','setting'));
    }

    public function cashOnDelivery(){
        $orders = Order::with('user')->orderBy('id','desc')->where('cash_on_delivery',1)->get();
        $title = trans('admin_validation.Cash On Delivery');
        $setting = Setting::first();
        return view('admin.order', compact('orders','title','setting'));
    }

    public function show($id){
        $countries = Country::all();
        $city = City::all();
        $state = CountryState::all();
        $brands = Brand::all();
        $products = Product::where('status',1)->where('vendor_id',0)->get();
        $categories = Category::with('subCategories','products')->get();
        $order = Order::with('user','orderProducts.orderProductVariants','orderAddress')->findOrFail($id);
        $setting = Setting::first();
        $footer = Footer::first();
        $customerDefaultAddress = null;
        if ($order->user_id) {
            $customerDefaultAddress = Address::with(['country', 'countryState', 'city'])
                ->where('user_id', $order->user_id)
                ->orderByDesc('default_billing')
                ->orderByDesc('default_shipping')
                ->first();
        }
        return view('admin.show_order',compact('order','setting','footer','countries','city','state','brands','categories','products','customerDefaultAddress'));
    }

    public function updateOrderAddress(Request $request, $id)
    {
        $rules = [
            'billing_address' => 'required|string|max:1000',
            'delivery_area' => 'required|in:inside,outside',
        ];
        $this->validate($request, $rules);

        $order = Order::with('user')->findOrFail($id);
        $address = OrderAddress::firstOrNew(['order_id' => $order->id]);
        $customer = $order->user;

        $name = $address->billing_name ?: ($customer->name ?? 'Customer');
        $email = $address->billing_email ?: ($customer->email ?? null);
        $phone = $address->billing_phone ?: ($customer->phone ?? null);
        $line = $request->billing_address;
        $area = $request->delivery_area;

        $address->billing_name = $name;
        $address->billing_email = $email;
        $address->billing_phone = $phone;
        $address->billing_address = $line;
        $address->billing_country = 'Bangladesh';
        $address->billing_state = null;
        $address->billing_city = null;
        $address->billing_address_type = $area;
        $address->shipping_name = $name;
        $address->shipping_email = $email;
        $address->shipping_phone = $phone;
        $address->shipping_address = $line;
        $address->shipping_country = 'Bangladesh';
        $address->shipping_state = null;
        $address->shipping_city = null;
        $address->shipping_address_type = $area;
        $address->delivery_area = $area;
        $address->order_id = $order->id;
        $address->save();

        $notification = trans('admin.Address updated successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function updateOrderStatus(Request $request , $id){
        $rules = [
            'order_status' => 'required',
            'payment_status' => 'required',
        ];
        $this->validate($request, $rules);

        $order = Order::find($id);
        if($request->order_status == 0){
            $order->order_status = 0;
            $order->save();
        }else if($request->order_status == 1){
            $order->order_status = 1;
            $order->order_approval_date = date('Y-m-d');
            $order->save();
        }else if($request->order_status == 2){
            $order->order_status = 2;
            $order->order_delivered_date = date('Y-m-d');
            $order->save();
        }else if($request->order_status == 3){
            $order->order_status = 3;
            $order->order_completed_date = date('Y-m-d');
            $order->save();
        }else if($request->order_status == 4){
            $order->order_status = 4;
            $order->order_declined_date = date('Y-m-d');
            $order->save();
        }

        if($request->payment_status == 0){
            $order->payment_status = 0;
            $order->save();
        }elseif($request->payment_status == 1){
            $order->payment_status = 1;
            $order->payment_approval_date = date('Y-m-d');
            $order->save();
        }

        $notification = trans('admin_validation.Order Status Updated successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


    public function destroy($id){
        $order = Order::find($id);
        $order->delete();
        $orderProducts = OrderProduct::where('order_id',$id)->get();
        $orderAddress = OrderAddress::where('order_id',$id)->first();
        foreach($orderProducts as $orderProduct){
            OrderProductVariant::where('order_product_id',$orderProduct->id)->delete();
            $orderProduct->delete();
        }
        OrderAddress::where('order_id',$id)->delete();

        $notification = trans('admin_validation.Delete successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.all-order')->with($notification);
    }

    public function addNewProduct(Request $request,$id)
    {
        $product = Product::find($request->product_id);
        if($product->offer_price == NULL)
        {
            $amount = $product->price;
        }else{
            $amount = $product->offer_price;
        }
        $order_product = new OrderProduct();
        $order_product->order_id = $id;
        $order_product->product_id = $request->product_id;
        $order_product->seller_id = $product->vendor_id;
        $order_product->product_name = $product->name;
        $order_product->unit_price = $amount;
        $order_product->qty = $request->quantity;
        $order_product->save();

        if($product->offer_price == NULL)
        {
            $add_amount = $product->price*$request->quantity;
        }else{
            $add_amount = $product->offer_price*$request->quantity;
        }
        $order = Order::find($id);
        Order::where('id',$id)->update([
            'total_amount' => $order->total_amount + $add_amount
        ]);

        $notification = trans('admin_validation.New Product Added in Order successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);

    }

    public function incrementOrderQuantity($id,$order_id)
    {
        $orderProduct = OrderProduct::find($id);
        OrderProduct::where('id',$id)->update([
            'qty' => $orderProduct->qty + 1
        ]);

        $order = Order::find($order_id);
        Order::where('id',$order_id)->update([
            'total_amount' => $order->total_amount + $orderProduct->unit_price
        ]);

        $notification = trans('admin_validation.Updated successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }
    public function decrementOrderQuantity($id,$order_id)
    {
        $orderProduct = OrderProduct::find($id);
        if($orderProduct->qty > 1){
            OrderProduct::where('id',$id)->update([
                'qty' => $orderProduct->qty - 1
            ]);
    
            $order = Order::find($order_id);
            Order::where('id',$order_id)->update([
                'total_amount' => $order->total_amount - $orderProduct->unit_price
            ]);
    
            $notification = trans('admin_validation.Updated successfully');
            $notification = array('messege'=>$notification,'alert-type'=>'success');
        }else{
            $notification = trans('Updated Not Posible');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
        }
    
        return redirect()->back()->with($notification);
    }

    public function deleteOrderProduct($id,$order_id)
    {
        
        $orderProduct = OrderProduct::find($id);

        // Check if there is more than one product in the order
        $order = Order::find($orderProduct->order_id);
        if ($order->orderProducts->count() > 1) {
            $amount = $orderProduct->unit_price * $orderProduct->qty;
            $orderProduct->delete();
        
            // Update the order's total_amount
            Order::where('id', $order->id)->update([
                'total_amount' => $order->total_amount - $amount
            ]);
        
            $notification = trans('admin_validation.Delete successfully');
            $notification = array('messege' => $notification, 'alert-type' => 'success');
        } else {
            $notification = trans('Delete not allowed. At least one product must remain in the order.');
            $notification = array('messege' => $notification, 'alert-type' => 'error');
        }
        
        return redirect()->back()->with($notification);
        
    }

    protected function orderDateRange(Request $request): array
    {
        $from = $request->from_date ?: now()->startOfMonth()->toDateString();
        $to = $request->to_date ?: now()->toDateString();

        return [$from, $to];
    }

    protected function orderStats(?string $from = null, ?string $to = null): array
    {
        $query = Order::query();
        if ($from && $to) {
            $query->whereBetween('created_at', [$from.' 00:00:00', $to.' 23:59:59']);
        }

        $todayQuery = Order::whereDate('created_at', now()->toDateString());

        return [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('order_status', 0)->count(),
            'progress' => (clone $query)->where('order_status', 1)->count(),
            'delivered' => (clone $query)->where('order_status', 2)->count(),
            'completed' => (clone $query)->where('order_status', 3)->count(),
            'declined' => (clone $query)->where('order_status', 4)->count(),
            'cod' => (clone $query)->where('cash_on_delivery', 1)->count(),
            'unpaid' => (clone $query)->where('payment_status', 0)->where('order_status', '!=', 4)->count(),
            'paid' => (clone $query)->where('payment_status', 1)->count(),
            'qty' => (int) (clone $query)->where('order_status', '!=', 4)->sum('product_qty'),
            'sales' => (float) (clone $query)->where('order_status', '!=', 4)->sum('total_amount'),
            'unpaid_amount' => (float) (clone $query)->where('payment_status', 0)->where('order_status', '!=', 4)->sum('total_amount'),
            'today' => (clone $todayQuery)->count(),
            'today_pending' => (clone $todayQuery)->where('order_status', 0)->count(),
            'today_sales' => (float) (clone $todayQuery)->where('order_status', '!=', 4)->sum('total_amount'),
        ];
    }
}
