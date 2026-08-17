<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $suppliers = Supplier::orderBy('name')->get();
        return view('admin.purchase.suppliers', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:suppliers,code',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'status' => 'required|in:0,1',
        ]);

        Supplier::create($request->only('code', 'name', 'contact_person', 'email', 'phone', 'address', 'tax_no', 'status', 'notes'));

        return redirect()->back()->with(['messege' => trans('admin.Created Successfully'), 'alert-type' => 'success']);
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:suppliers,code,'.$supplier->id,
            'status' => 'required|in:0,1',
        ]);

        $supplier->update($request->only('code', 'name', 'contact_person', 'email', 'phone', 'address', 'tax_no', 'status', 'notes'));

        return redirect()->back()->with(['messege' => trans('admin.Update Successfully'), 'alert-type' => 'success']);
    }

    public function destroy($id)
    {
        Supplier::findOrFail($id)->delete();
        return redirect()->back()->with(['messege' => trans('Deleted Successfully'), 'alert-type' => 'success']);
    }
}
