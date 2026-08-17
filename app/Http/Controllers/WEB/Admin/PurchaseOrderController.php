<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Warehouse;
use App\Services\PurchaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function __construct(protected PurchaseService $purchaseService)
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $orders = PurchaseOrder::with(['supplier', 'warehouse'])->latest()->get();
        return view('admin.purchase.orders', compact('orders'));
    }

    public function create()
    {
        $suppliers = Supplier::where('status', 1)->orderBy('name')->get();
        $warehouses = Warehouse::where('status', 1)->get();
        $categories = Category::orderBy('name')->get(['id', 'name']);
        $products = Product::orderBy('name')->get(['id', 'name', 'short_name', 'sku', 'barcode', 'cost_price', 'qty', 'category_id', 'pcs_per_box', 'purchase_unit']);
        $units = Unit::activeUnits();
        return view('admin.purchase.create_order', compact('suppliers', 'warehouses', 'products', 'categories', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'order_date' => 'required|date',
            'product_id' => 'required|array|min:1',
            'product_id.*' => 'exists:products,id',
            'ordered_qty' => 'required|array',
            'unit_cost' => 'required|array',
            'unit' => 'nullable|array',
            'pcs_per_box' => 'nullable|array',
        ]);

        DB::transaction(function () use ($request) {
            $order = PurchaseOrder::create([
                'po_number' => $this->purchaseService->generateNumber('PO'),
                'supplier_id' => $request->supplier_id,
                'warehouse_id' => $request->warehouse_id,
                'status' => $request->input('submit') == 1 ? 'submitted' : 'draft',
                'order_date' => $request->order_date,
                'expected_date' => $request->expected_date,
                'tax' => $request->tax ?? 0,
                'discount' => $request->discount ?? 0,
                'notes' => $request->notes,
                'created_by' => Auth::guard('admin')->id(),
            ]);

            foreach ($request->product_id as $i => $productId) {
                $qty = (int) ($request->ordered_qty[$i] ?? 0);
                $cost = (float) ($request->unit_cost[$i] ?? 0);
                if ($qty <= 0) {
                    continue;
                }
                $unit = Product::resolvePurchaseUnit($request->unit[$i] ?? 'pc');
                $pcsPerBox = max(1, (int) ($request->pcs_per_box[$i] ?? 1));
                PurchaseOrderItem::create([
                    'purchase_order_id' => $order->id,
                    'product_id' => $productId,
                    'unit' => $unit,
                    'pcs_per_box' => $pcsPerBox,
                    'ordered_qty' => $qty,
                    'unit_cost' => $cost,
                    'line_total' => $qty * $cost,
                ]);
            }

            $this->purchaseService->recalculateOrder($order);
        });

        return redirect()->route('admin.purchase-order.index')->with(['messege' => trans('admin.Purchase order created'), 'alert-type' => 'success']);
    }

    public function show($id)
    {
        $order = PurchaseOrder::with(['supplier', 'warehouse', 'items.product', 'receipts.items'])->findOrFail($id);
        return view('admin.purchase.show_order', compact('order'));
    }

    public function submit($id)
    {
        $order = PurchaseOrder::findOrFail($id);
        if ($order->status !== 'draft') {
            return redirect()->back()->with(['messege' => trans('admin.Invalid status'), 'alert-type' => 'error']);
        }
        $order->update(['status' => 'submitted']);
        return redirect()->back()->with(['messege' => trans('admin.Purchase order submitted'), 'alert-type' => 'success']);
    }
}
