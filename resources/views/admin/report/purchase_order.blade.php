@extends('admin.master_layout')
@section('title')<title>{{__('admin.Purchase Order Report')}}</title>@endsection
@section('admin-content')
@include('admin.report.partials.filters')
@php $icon = $setting->currency_icon ?? ''; @endphp
<div class="main-content">
    <section class="section">
        <div class="section-header"><h1>{{__('admin.Purchase Order Report')}}</h1></div>
        <div class="section-body">
            <form method="GET" class="form-inline mb-3 no-print">
                <input type="date" name="from_date" class="form-control mr-2 mb-2" value="{{ $from }}">
                <input type="date" name="to_date" class="form-control mr-2 mb-2" value="{{ $to }}">
                <select name="supplier_id" class="form-control mr-2 mb-2">
                    <option value="">{{__('admin.All Suppliers')}}</option>
                    @foreach($suppliers as $s)
                    <option value="{{ $s->id }}" {{ request('supplier_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                    @endforeach
                </select>
                <select name="warehouse_id" class="form-control mr-2 mb-2">
                    <option value="">{{__('admin.All Warehouses')}}</option>
                    @foreach($warehouses as $w)
                    <option value="{{ $w->id }}" {{ request('warehouse_id') == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                    @endforeach
                </select>
                <select name="status" class="form-control mr-2 mb-2">
                    <option value="">{{__('admin.All')}}</option>
                    @foreach(['draft','submitted','partial','received','cancelled'] as $st)
                    <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary mb-2 mr-2">{{__('admin.Filter')}}</button>
                <a href="{{ route('admin.report.purchase-order') }}" class="btn btn-secondary mb-2 mr-2">{{__('admin.Reset')}}</a>
                <button type="button" class="btn btn-info mb-2 mr-2" onclick="window.print()"><i class="fa fa-print"></i> {{__('admin.Print')}}</button>
                @include('admin.report.partials.export_buttons', ['report' => 'purchase-order'])
            </form>
            <div class="card"><div class="card-body">
                <div class="mb-3 font-weight-bold">{{__('admin.Total')}}: {{ $icon }}{{ number_format($total, 2) }}</div>
                <table class="table table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>{{__('admin.PO Number')}}</th>
                            <th>{{__('admin.Date')}}</th>
                            <th>{{__('admin.Supplier')}}</th>
                            <th>{{__('admin.Warehouse')}}</th>
                            <th>{{__('admin.Status')}}</th>
                            <th class="text-right">{{__('admin.Total')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $o)
                    <tr>
                        <td><a href="{{ route('admin.purchase-order.show', $o->id) }}">{{ $o->po_number }}</a></td>
                        <td>{{ $o->order_date?->format('d M Y') }}</td>
                        <td>{{ $o->supplier->name ?? '-' }}</td>
                        <td>{{ $o->warehouse->name ?? '-' }}</td>
                        <td><span class="badge badge-info">{{ strtoupper($o->status) }}</span></td>
                        <td class="text-right">{{ number_format($o->total, 2) }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div></div>
        </div>
    </section>
</div>
@endsection
