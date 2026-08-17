<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $query = Expense::with('category')->latest('expense_date')->latest('id');

        if ($request->filled('category_id')) {
            $query->where('expense_category_id', $request->category_id);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('expense_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('expense_date', '<=', $request->to_date);
        }

        $expenses = $query->get();
        $total = $expenses->sum('amount');
        $categories = ExpenseCategory::activeCategories();

        return view('admin.expense.index', compact('expenses', 'categories', 'total'));
    }

    public function create()
    {
        $categories = ExpenseCategory::activeCategories();

        return view('admin.expense.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());

        Expense::create([
            'expense_number' => Expense::generateNumber(),
            'expense_category_id' => $request->expense_category_id,
            'title' => $request->title,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
            'payment_method' => $request->payment_method,
            'reference' => $request->reference,
            'notes' => $request->notes,
            'created_by' => Auth::guard('admin')->id(),
        ]);

        return redirect()->route('admin.expense.index')->with([
            'messege' => trans('admin.Created Successfully'),
            'alert-type' => 'success',
        ]);
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $categories = ExpenseCategory::activeCategories();
        if ($expense->category && $categories->where('id', $expense->expense_category_id)->isEmpty()) {
            $categories->prepend($expense->category);
        }

        return view('admin.expense.edit', compact('expense', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $request->validate($this->rules());

        $expense->update([
            'expense_category_id' => $request->expense_category_id,
            'title' => $request->title,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
            'payment_method' => $request->payment_method,
            'reference' => $request->reference,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.expense.index')->with([
            'messege' => trans('admin.Update Successfully'),
            'alert-type' => 'success',
        ]);
    }

    public function destroy($id)
    {
        Expense::findOrFail($id)->delete();

        return redirect()->back()->with([
            'messege' => trans('admin.Deleted Successfully'),
            'alert-type' => 'success',
        ]);
    }

    protected function rules(): array
    {
        return [
            'expense_category_id' => 'required|exists:expense_categories,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'payment_method' => 'required|in:'.implode(',', array_keys(Expense::PAYMENT_METHODS)),
            'reference' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ];
    }
}
