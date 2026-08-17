<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $warehouses = Warehouse::withCount('stocks')->orderBy('id', 'desc')->get();

        return view('admin.inventory.warehouses', compact('warehouses'));
    }

    public function create()
    {
        return view('admin.inventory.create_warehouse');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:warehouses,code',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'status' => 'required|in:0,1',
        ]);

        if ($request->is_default) {
            Warehouse::query()->update(['is_default' => 0]);
        }

        Warehouse::create([
            'name' => $request->name,
            'code' => $request->code,
            'phone' => $request->phone,
            'address' => $request->address,
            'is_default' => $request->is_default ? 1 : 0,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.warehouse.index')->with([
            'messege' => trans('admin.Created Successfully'),
            'alert-type' => 'success',
        ]);
    }

    public function edit($id)
    {
        $warehouse = Warehouse::findOrFail($id);

        return view('admin.inventory.edit_warehouse', compact('warehouse'));
    }

    public function update(Request $request, $id)
    {
        $warehouse = Warehouse::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:warehouses,code,'.$warehouse->id,
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'status' => 'required|in:0,1',
        ]);

        if ($request->is_default) {
            Warehouse::where('id', '!=', $warehouse->id)->update(['is_default' => 0]);
        }

        $warehouse->update([
            'name' => $request->name,
            'code' => $request->code,
            'phone' => $request->phone,
            'address' => $request->address,
            'is_default' => $request->is_default ? 1 : 0,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.warehouse.index')->with([
            'messege' => trans('admin.Update Successfully'),
            'alert-type' => 'success',
        ]);
    }

    public function destroy($id)
    {
        $warehouse = Warehouse::findOrFail($id);

        if ($warehouse->is_default) {
            return redirect()->back()->with([
                'messege' => trans('admin.Default warehouse cannot be deleted'),
                'alert-type' => 'error',
            ]);
        }

        if ($warehouse->stocks()->where('qty', '>', 0)->exists()) {
            return redirect()->back()->with([
                'messege' => trans('admin.Warehouse has stock and cannot be deleted'),
                'alert-type' => 'error',
            ]);
        }

        $warehouse->delete();

        return redirect()->route('admin.warehouse.index')->with([
            'messege' => trans('Deleted Successfully'),
            'alert-type' => 'success',
        ]);
    }
}
