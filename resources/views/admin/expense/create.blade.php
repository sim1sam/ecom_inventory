@extends('admin.master_layout')
@section('title')<title>{{__('admin.Create Expense')}}</title>@endsection
@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('admin.Create Expense')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.expense.index') }}">{{__('admin.Expenses')}}</a></div>
                <div class="breadcrumb-item">{{__('admin.Create Expense')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @if($categories->isEmpty())
                    <div class="alert alert-warning">{{__('admin.Please create an expense category first')}} <a href="{{ route('admin.expense-category.index') }}">{{__('admin.Expense Categories')}}</a></div>
                    @endif
                    <form action="{{ route('admin.expense.store') }}" method="POST">
                        @csrf
                        @include('admin.expense.partials.form')
                        <button type="submit" class="btn btn-primary" {{ $categories->isEmpty() ? 'disabled' : '' }}>{{__('admin.Save')}}</button>
                        <a href="{{ route('admin.expense.index') }}" class="btn btn-secondary">{{__('admin.Cancel')}}</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
