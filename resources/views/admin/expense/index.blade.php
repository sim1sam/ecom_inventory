@extends('admin.master_layout')
@section('title')<title>{{__('admin.Expenses')}}</title>@endsection
@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('admin.Expenses')}}</h1>
            <div class="section-header-button">
                <a href="{{ route('admin.expense.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{__('admin.Create Expense')}}</a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="form-inline mb-3">
                        <select name="category_id" class="form-control mr-2 mb-2">
                            <option value="">{{__('admin.All Categories')}}</option>
                            @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                        <input type="date" name="from_date" class="form-control mr-2 mb-2" value="{{ request('from_date') }}" placeholder="{{__('admin.From Date')}}">
                        <input type="date" name="to_date" class="form-control mr-2 mb-2" value="{{ request('to_date') }}">
                        <button class="btn btn-primary mb-2 mr-2">{{__('admin.Filter')}}</button>
                        <a href="{{ route('admin.expense.index') }}" class="btn btn-secondary mb-2">{{__('admin.Reset')}}</a>
                    </form>
                    <table class="table table-striped" id="dataTable">
                        <thead>
                            <tr>
                                <th>{{__('admin.Expense No')}}</th>
                                <th>{{__('admin.Date')}}</th>
                                <th>{{__('admin.Category')}}</th>
                                <th>{{__('admin.Title')}}</th>
                                <th>{{__('admin.Payment Method')}}</th>
                                <th>{{__('admin.Amount')}}</th>
                                <th>{{__('admin.Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expenses as $e)
                            <tr>
                                <td>{{ $e->expense_number }}</td>
                                <td>{{ $e->expense_date?->format('d M Y') }}</td>
                                <td>{{ $e->category->name ?? '-' }}</td>
                                <td>{{ $e->title }}</td>
                                <td>{{ $e->paymentMethodLabel() }}</td>
                                <td>{{ number_format($e->amount, 2) }}</td>
                                <td>
                                    <a href="{{ route('admin.expense.edit', $e->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:;" class="btn btn-danger btn-sm" onclick="deleteData({{ $e->id }})"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-right font-weight-bold mt-3">{{__('admin.Total')}}: {{ number_format($total, 2) }}</div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>function deleteData(id){$("#deleteForm").attr("action",'{{ url("admin/expense") }}/'+id);$("#deleteModal").modal("show");}</script>
@endsection
