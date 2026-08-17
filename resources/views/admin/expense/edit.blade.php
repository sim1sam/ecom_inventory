@extends('admin.master_layout')
@section('title')<title>{{__('admin.Edit Expense')}}</title>@endsection
@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('admin.Edit Expense')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.expense.index') }}">{{__('admin.Expenses')}}</a></div>
                <div class="breadcrumb-item">{{__('admin.Edit Expense')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.expense.update', $expense->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('admin.expense.partials.form')
                        <button type="submit" class="btn btn-primary">{{__('admin.Update')}}</button>
                        <a href="{{ route('admin.expense.index') }}" class="btn btn-secondary">{{__('admin.Cancel')}}</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
