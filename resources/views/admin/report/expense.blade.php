@extends('admin.master_layout')
@section('title')<title>{{__('admin.Expense Report')}}</title>@endsection
@section('admin-content')
@include('admin.report.partials.filters')
@php $icon = $setting->currency_icon ?? ''; @endphp
<div class="main-content">
    <section class="section">
        <div class="section-header"><h1>{{__('admin.Expense Report')}}</h1></div>
        <div class="section-body">
            <form method="GET" class="form-inline mb-3 no-print">
                <input type="date" name="from_date" class="form-control mr-2 mb-2" value="{{ $from }}">
                <input type="date" name="to_date" class="form-control mr-2 mb-2" value="{{ $to }}">
                <select name="category_id" class="form-control mr-2 mb-2">
                    <option value="">{{__('admin.All Categories')}}</option>
                    @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary mb-2 mr-2">{{__('admin.Filter')}}</button>
                <a href="{{ route('admin.report.expense') }}" class="btn btn-secondary mb-2 mr-2">{{__('admin.Reset')}}</a>
                <button type="button" class="btn btn-info mb-2 mr-2" onclick="window.print()"><i class="fa fa-print"></i> {{__('admin.Print')}}</button>
                @include('admin.report.partials.export_buttons', ['report' => 'expense'])
            </form>
            <div class="row">
                <div class="col-md-4">
                    <div class="card"><div class="card-header"><h4>{{__('admin.Expense by Category')}}</h4></div>
                    <div class="card-body">
                        <table class="table table-sm table-striped">
                            <thead><tr><th>{{__('admin.Category')}}</th><th>{{__('admin.Quantity')}}</th><th class="text-right">{{__('admin.Amount')}}</th></tr></thead>
                            <tbody>
                            @foreach($byCategory as $row)
                            <tr><td>{{ $row->category->name ?? '-' }}</td><td>{{ $row->qty }}</td><td class="text-right">{{ number_format($row->total, 2) }}</td></tr>
                            @endforeach
                            </tbody>
                            <tfoot><tr class="font-weight-bold"><td colspan="2">{{__('admin.Total')}}</td><td class="text-right">{{ $icon }}{{ number_format($total, 2) }}</td></tr></tfoot>
                        </table>
                    </div></div>
                </div>
                <div class="col-md-8">
                    <div class="card"><div class="card-body">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th>{{__('admin.Expense No')}}</th>
                                    <th>{{__('admin.Date')}}</th>
                                    <th>{{__('admin.Category')}}</th>
                                    <th>{{__('admin.Title')}}</th>
                                    <th>{{__('admin.Payment Method')}}</th>
                                    <th class="text-right">{{__('admin.Amount')}}</th>
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
                                <td class="text-right">{{ number_format($e->amount, 2) }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div></div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
