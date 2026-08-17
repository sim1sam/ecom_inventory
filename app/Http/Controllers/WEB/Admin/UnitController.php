<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $units = Unit::orderByDesc('is_base')->orderBy('name')->get();

        return view('admin.inventory.units', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'code' => 'nullable|string|max:30|unique:units,code',
            'status' => 'required|in:0,1',
        ]);

        $code = Unit::makeCode($request->name, $request->code);
        if (Unit::where('code', $code)->exists()) {
            $code .= '_'.random_int(10, 99);
        }

        Unit::create([
            'name' => $request->name,
            'code' => $code,
            'is_base' => 0,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.unit.index')->with([
            'messege' => trans('admin.Created Successfully'),
            'alert-type' => 'success',
        ]);
    }

    public function update(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:50',
            'status' => 'required|in:0,1',
        ]);

        $data = [
            'name' => $request->name,
            'status' => $unit->is_base ? 1 : $request->status,
        ];

        $unit->update($data);

        return redirect()->route('admin.unit.index')->with([
            'messege' => trans('admin.Update Successfully'),
            'alert-type' => 'success',
        ]);
    }

    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);

        if ($unit->is_base) {
            return redirect()->back()->with([
                'messege' => trans('admin.Base unit cannot be deleted'),
                'alert-type' => 'error',
            ]);
        }

        if (Product::where('purchase_unit', $unit->code)->exists()) {
            return redirect()->back()->with([
                'messege' => trans('admin.Unit is used on products and cannot be deleted'),
                'alert-type' => 'error',
            ]);
        }

        $unit->delete();

        return redirect()->back()->with([
            'messege' => trans('admin.Deleted Successfully'),
            'alert-type' => 'success',
        ]);
    }
}
