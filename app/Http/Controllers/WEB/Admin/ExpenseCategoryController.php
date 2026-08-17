<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $categories = ExpenseCategory::withCount('expenses')->orderBy('name')->get();

        return view('admin.expense.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:expense_categories,name',
            'status' => 'required|in:0,1',
        ]);

        ExpenseCategory::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.expense-category.index')->with([
            'messege' => trans('admin.Created Successfully'),
            'alert-type' => 'success',
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = ExpenseCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:expense_categories,name,'.$category->id,
            'status' => 'required|in:0,1',
        ]);

        $category->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.expense-category.index')->with([
            'messege' => trans('admin.Update Successfully'),
            'alert-type' => 'success',
        ]);
    }

    public function destroy($id)
    {
        $category = ExpenseCategory::findOrFail($id);

        if (Expense::where('expense_category_id', $category->id)->exists()) {
            return redirect()->back()->with([
                'messege' => trans('admin.Category is used on expenses and cannot be deleted'),
                'alert-type' => 'error',
            ]);
        }

        $category->delete();

        return redirect()->back()->with([
            'messege' => trans('admin.Deleted Successfully'),
            'alert-type' => 'success',
        ]);
    }
}
