@php
    $expense = $expense ?? null;
    $paymentMethods = \App\Models\Expense::PAYMENT_METHODS;
@endphp
<div class="row">
    <div class="form-group col-md-4">
        <label>{{__('admin.Category')}} <span class="text-danger">*</span></label>
        <select name="expense_category_id" class="form-control" required>
            <option value="">{{__('admin.Select Category')}}</option>
            @foreach($categories as $c)
            <option value="{{ $c->id }}" {{ old('expense_category_id', $expense->expense_category_id ?? '') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>
        <small class="text-muted"><a href="{{ route('admin.expense-category.index') }}" target="_blank">{{__('admin.Expense Categories')}}</a></small>
    </div>
    <div class="form-group col-md-4">
        <label>{{__('admin.Title')}} <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $expense->title ?? '') }}" required>
    </div>
    <div class="form-group col-md-4">
        <label>{{__('admin.Amount')}} <span class="text-danger">*</span></label>
        <input type="number" step="0.01" min="0.01" name="amount" class="form-control" value="{{ old('amount', $expense->amount ?? '') }}" required>
    </div>
    <div class="form-group col-md-4">
        <label>{{__('admin.Date')}} <span class="text-danger">*</span></label>
        <input type="date" name="expense_date" class="form-control" value="{{ old('expense_date', optional($expense)->expense_date ? $expense->expense_date->format('Y-m-d') : date('Y-m-d')) }}" required>
    </div>
    <div class="form-group col-md-4">
        <label>{{__('admin.Payment Method')}} <span class="text-danger">*</span></label>
        <select name="payment_method" class="form-control" required>
            @foreach($paymentMethods as $code => $label)
            <option value="{{ $code }}" {{ old('payment_method', $expense->payment_method ?? 'cash') == $code ? 'selected' : '' }}>{{ __('admin.'.$label) }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-4">
        <label>{{__('admin.Reference')}}</label>
        <input type="text" name="reference" class="form-control" value="{{ old('reference', $expense->reference ?? '') }}">
    </div>
    <div class="form-group col-md-12">
        <label>{{__('admin.Note')}}</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $expense->notes ?? '') }}</textarea>
    </div>
</div>
