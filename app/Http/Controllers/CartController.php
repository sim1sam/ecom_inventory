<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BreadcrumbImage;
use App\Models\BannerImage;
use App\Models\ProductVariantItem;
use App\Models\Product;
use App\Models\FlashSaleProduct;
use App\Models\FlashSale;
use App\Models\Coupon;
use App\Models\Setting;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartVariant;
use App\Models\CampaignProduct;
use Cart;
use Session;
use Auth;
class CartController extends Controller
{

    public function __construct()
    {
        // Remove auth middleware to support guest users
    }


    public function cart(){
        if (Auth::guard('api')->check()) {
            // Authenticated user - get from database
            $user = Auth::guard('api')->user();
            $cartProducts = ShoppingCart::with('product','variants.variantItem')->where('user_id', $user->id)->select('id','product_id','qty')->get();
        } else {
            // Guest user - get from session
            $sessionCart = Session::get('guest_cart', []);
            $cartProducts = collect();
            
            foreach ($sessionCart as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $cartItem = (object) [
                        'id' => $item['id'],
                        'product_id' => $item['product_id'],
                        'qty' => $item['qty'],
                        'product' => $product,
                        'variants' => collect($item['variants'] ?? [])
                    ];
                    $cartProducts->push($cartItem);
                }
            }
        }

        return response()->json(['cartProducts' => $cartProducts],200);
    }

    public function addToCart(Request $request){
        $productStock = Product::find($request->product_id);
        $stock = $productStock->qty - $productStock->sold_qty;

        if($stock == 0){
            $notification = trans('Product stock out');
            return response()->json(['message' => $notification],403);
        }

        if($stock < $request->quantity){
            $notification = trans('Quantity not available in our stock');
            return response()->json(['message' => $notification],403);
        }

        if (Auth::guard('api')->check()) {
            // Authenticated user - save to database
            $user = Auth::guard('api')->user();
            $item = new ShoppingCart();
            $item->user_id = $user->id;
            $item->product_id = $request->product_id;
            $item->qty = $request->quantity;
            $item->coupon_name = '';
            $item->offer_type = 0;
            $item->save();

            if($request->variants && $request->items){
                foreach($request->variants as $index => $varr){
                    if($request->items[$index] != '-1' && $request->variants[$index] != '-1'){
                        $variant = new ShoppingCartVariant();
                        $variant->shopping_cart_id = $item->id;
                        $variant->variant_id = $varr;
                        $variant->variant_item_id = $request->items[$index];
                        $variant->save();
                    }
                }
            }
        } else {
            // Guest user - save to session
            $sessionCart = Session::get('guest_cart', []);
            $cartItemId = 'guest_' . time() . '_' . rand(1000, 9999);
            
            $variants = [];
            if($request->variants && $request->items){
                foreach($request->variants as $index => $varr){
                    if($request->items[$index] != '-1' && $request->variants[$index] != '-1'){
                        $variants[] = [
                            'variant_id' => $varr,
                            'variant_item_id' => $request->items[$index]
                        ];
                    }
                }
            }
            
            $sessionCart[] = [
                'id' => $cartItemId,
                'product_id' => $request->product_id,
                'qty' => $request->quantity,
                'variants' => $variants
            ];
            
            Session::put('guest_cart', $sessionCart);
        }

        $notification = trans('Item added successfully');
        return response()->json(['message' => $notification]);
    }

    public function cartItemIncrement($id){
        if (Auth::guard('api')->check()) {
            // Authenticated user
            $item = ShoppingCart::find($id);
            $current_qty = $item->qty;

            $productStock = Product::find($item->product_id);
            $stock = $productStock->qty - $productStock->sold_qty;

            if($stock < $current_qty){
                $notification = trans('Quantity not available in our stock');
                return response()->json(['message' => $notification],403);
            }

            $item->qty = $item->qty + 1;
            $item->save();
        } else {
            // Guest user
            $sessionCart = Session::get('guest_cart', []);
            $itemIndex = array_search($id, array_column($sessionCart, 'id'));
            
            if ($itemIndex !== false) {
                $current_qty = $sessionCart[$itemIndex]['qty'];
                $productStock = Product::find($sessionCart[$itemIndex]['product_id']);
                $stock = $productStock->qty - $productStock->sold_qty;

                if($stock < $current_qty){
                    $notification = trans('Quantity not available in our stock');
                    return response()->json(['message' => $notification],403);
                }

                $sessionCart[$itemIndex]['qty'] += 1;
                Session::put('guest_cart', $sessionCart);
            }
        }

        $notification = trans('Update successfully');
        return response()->json(['message' => $notification]);
    }

    public function cartItemDecrement($id){
        if (Auth::guard('api')->check()) {
            // Authenticated user
            $item = ShoppingCart::find($id);
            if($item->qty > 1){
                $item->qty = $item->qty - 1;
                $item->save();

                $notification = trans('Update successfully');
                return response()->json(['message' => $notification]);
            }else{
                $notification = trans('Something went wrong');
                return response()->json(['message' => $notification],403);
            }
        } else {
            // Guest user
            $sessionCart = Session::get('guest_cart', []);
            $itemIndex = array_search($id, array_column($sessionCart, 'id'));
            
            if ($itemIndex !== false && $sessionCart[$itemIndex]['qty'] > 1) {
                $sessionCart[$itemIndex]['qty'] -= 1;
                Session::put('guest_cart', $sessionCart);
                
                $notification = trans('Update successfully');
                return response()->json(['message' => $notification]);
            } else {
                $notification = trans('Something went wrong');
                return response()->json(['message' => $notification],403);
            }
        }
    }

    public function cartItemRemove($rowId){
        if (Auth::guard('api')->check()) {
            // Authenticated user
            $user = Auth::guard('api')->user();
            $cartProduct = ShoppingCart::where(['user_id' => $user->id, 'id' => $rowId])->first();
            ShoppingCartVariant::where('shopping_cart_id', $rowId)->delete();
            $cartProduct->delete();
        } else {
            // Guest user
            $sessionCart = Session::get('guest_cart', []);
            $itemIndex = array_search($rowId, array_column($sessionCart, 'id'));
            
            if ($itemIndex !== false) {
                array_splice($sessionCart, $itemIndex, 1);
                Session::put('guest_cart', $sessionCart);
            }
        }

        $notification = trans('Remove successfully');
        return response()->json(['message' => $notification]);
    }

    public function cartClear(){
        if (Auth::guard('api')->check()) {
            // Authenticated user
            $user = Auth::guard('api')->user();
            $cartProducts = ShoppingCart::where(['user_id' => $user->id])->get();
            foreach($cartProducts as $cartProduct){
                ShoppingCartVariant::where('shopping_cart_id', $cartProduct->id)->delete();
                $cartProduct->delete();
            }
        } else {
            // Guest user
            Session::forget('guest_cart');
        }

        $notification = trans('Cart clear successfully');
        return response()->json(['message' => $notification]);
    }


    public function applyCoupon(Request $request){
        if($request->coupon == null){
            $notification = trans('Coupon Field is required');
            return response()->json(['message' => $notification],403);
        }

        // Check cart count for both authenticated and guest users
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
            $count = ShoppingCart::where('user_id', $user->id)->count();
        } else {
            $sessionCart = Session::get('guest_cart', []);
            $count = count($sessionCart);
        }
        
        if($count == 0){
            $notification = trans('Your shopping cart is empty');
            return response()->json(['message' => $notification],403);
        }

        $coupon = Coupon::where(['code' => $request->coupon, 'status' => 1])->first();

        if(!$coupon){
            $notification = trans('Invalid Coupon');
            return response()->json(['message' => $notification],403);
        }

        if($coupon->expired_date < date('Y-m-d')){
            $notification = trans('Coupon already expired');
            return response()->json(['message' => $notification],403);
        }

        if($coupon->apply_qty >=  $coupon->max_quantity ){
            $notification = trans('Sorry! You can not apply this coupon');
            return response()->json(['message' => $notification],403);
        }

        return response()->json(['coupon' => $coupon]);
    }


    public function calculateProductPrice(Request $request) {
        try {
            \Log::info('calculateProductPrice called with:', $request->all());
            
            $prices = [];
            $variantPrice = 0;
            if($request->variants){
                foreach($request->variants as $index => $varr){
                    if (!isset($request->items[$index])) {
                        \Log::error('Missing item for variant index: ' . $index);
                        continue;
                    }
                    $item = ProductVariantItem::where(['id' => $request->items[$index]])->first();
                    if ($item) {
                        $prices[] = $item->price;
                    } else {
                        \Log::error('ProductVariantItem not found for id: ' . $request->items[$index]);
                    }
                }
                $variantPrice = $variantPrice + array_sum($prices);
            }

            $product = Product::find($request->product_id);
            if (!$product) {
                \Log::error('Product not found for id: ' . $request->product_id);
                return response()->json(['error' => 'Product not found'], 404);
            }


        // Campaign functionality commented out - CampaignProduct model not found
        // $isCampaign = false;
        // $today = date('Y-m-d');
        // $campaign = CampaignProduct::where(['status' => 1, 'product_id' => $product->id])->first();
        // if($campaign){
        //     $campaign = $campaign->campaign;
        //     if($campaign->start_date <= $today &&  $today <= $campaign->end_date){
        //         $isCampaign = true;
        //     }
        //     $campaignOffer = $campaign->offer;
        //     $productPrice = $product->price;
        //     $campaignOfferPrice = ($campaignOffer / 100) * $productPrice;
        //     $totalPrice = $product->price;
        //     $campaignOfferPrice = $totalPrice - $campaignOfferPrice;
        // }else{
        //     $totalPrice = $product->price;
        //     if($product->offer_price != null){
        //         $offerPrice = $product->offer_price;
        //     }
        // }

        // Simplified price calculation without campaign logic
        $productPrice = 0;
        if ($product->offer_price == null) {
            $productPrice = $product->price + $variantPrice;
        } else {
            $productPrice = $product->offer_price + $variantPrice;
        }

            $productPrice = round($productPrice, 2);
            \Log::info('Calculated product price: ' . $productPrice);
            return response()->json(['productPrice' => $productPrice]);
        } catch (\Exception $e) {
            \Log::error('Error in calculateProductPrice: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

}
