@extends('admin.master_layout')
@section('title')<title>{{__('admin.Inventory Report')}}</title>@endsection
@section('admin-content')
@include('admin.report.partials.filters')
@php $icon = $setting->currency_icon ?? ''; @endphp
<div class="main-content">
    <section class="section">
        <div class="section-header"><h1>{{__('admin.Inventory Report')}}</h1></div>
        <div class="section-body">
            <form method="GET" class="form-inline mb-3 no-print">
                <select name="warehouse_id" class="form-control mr-2 mb-2">
                    <option value="">{{__('admin.All Warehouses')}}</option>
                    @foreach($warehouses as $w)
                    <option value="{{ $w->id }}" {{ request('warehouse_id') == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                    @endforeach
                </select>
                <select name="category_id" class="form-control mr-2 mb-2">
                    <option value="">{{__('admin.All Categories')}}</option>
                    @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
                <select name="stock" class="form-control mr-2 mb-2">
                    <option value="">{{__('admin.All Stock')}}</option>
                    <option value="low" {{ request('stock') === 'low' ? 'selected' : '' }}>{{__('admin.Low Stock')}}</option>
                    <option value="out" {{ request('stock') === 'out' ? 'selected' : '' }}>{{__('admin.Stock out')}}</option>
                </select>
                <button class="btn btn-primary mb-2 mr-2">{{__('admin.Filter')}}</button>
                <a href="{{ route('admin.report.inventory') }}" class="btn btn-secondary mb-2 mr-2">{{__('admin.Reset')}}</a>
                <button type="button" class="btn btn-info mb-2 mr-2" onclick="window.print()"><i class="fa fa-print"></i> {{__('admin.Print')}}</button>
                @include('admin.report.partials.export_buttons', ['report' => 'inventory'])
            </form>
            <div class="card"><div class="card-body">
                <div class="mb-3 font-weight-bold">{{__('admin.Total Stock')}}: {{ number_format($totalQty) }} {{__('admin.Pcs')}} &nbsp; | &nbsp; {{__('admin.Stock Value')}}: {{ $icon }}{{ number_format($totalValue, 2) }}</div>
                <table class="table table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>{{__('admin.Product')}}</th>
                            <th>{{__('admin.SKU')}}</th>
                            <th>{{__('admin.Stock')}} ({{__('admin.Pcs')}})</th>
                            <th>{{__('admin.Cost Price')}}</th>
                            <th>{{__('admin.Stock Value')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                        <tr>
                            <td>{{ $row['product']->name }}</td>
                            <td>{{ $row['product']->sku }}</td>
                            <td>
                                @if($row['qty'] <= 0)<span class="badge badge-danger">{{ $row['qty'] }}</span>
                                @elseif($row['qty'] <= ($row['product']->low_stock_threshold ?? 5))<span class="badge badge-warning">{{ $row['qty'] }}</span>
                                @else{{ $row['qty'] }}@endif
                            </td>
                            <td>{{ number_format($row['cost'], 2) }}</td>
                            <td>{{ number_format($row['value'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div></div>
        </div>
    </section>
</div>
@endsection
