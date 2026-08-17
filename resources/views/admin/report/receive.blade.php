@extends('admin.master_layout')
@section('title')<title>{{__('admin.Purchase Receive Report')}}</title>@endsection
@section('admin-content')
@include('admin.report.partials.filters')
@php $icon = $setting->currency_icon ?? ''; @endphp
<div class="main-content">
    <section class="section">
        <div class="section-header"><h1>{{__('admin.Purchase Receive Report')}}</h1></div>
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
                <button class="btn btn-primary mb-2 mr-2">{{__('admin.Filter')}}</button>
                <a href="{{ route('admin.report.receive') }}" class="btn btn-secondary mb-2 mr-2">{{__('admin.Reset')}}</a>
                <button type="button" class="btn btn-info mb-2 mr-2" onclick="window.print()"><i class="fa fa-print"></i> {{__('admin.Print')}}</button>
                @include('admin.report.partials.export_buttons', ['report' => 'receive'])
            </form>
            <div class="card"><div class="card-body">
                <div class="mb-3 font-weight-bold">{{__('admin.Quantity')}}: {{ number_format($totalQty) }} &nbsp; | &nbsp; {{__('admin.Total Pcs')}}: {{ number_format($totalPcs) }} &nbsp; | &nbsp; {{__('admin.Total')}}: {{ $icon }}{{ number_format($totalValue, 2) }}</div>
                <table class="table table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>{{__('admin.Receipt No')}}</th>
                            <th>{{__('admin.Date')}}</th>
                            <th>{{__('admin.PO Number')}}</th>
                            <th>{{__('admin.Supplier')}}</th>
                            <th>{{__('admin.Warehouse')}}</th>
                            <th>{{__('admin.Product')}}</th>
                            <th>{{__('admin.Quantity')}}</th>
                            <th>{{__('admin.Total Pcs')}}</th>
                            <th class="text-right">{{__('admin.Amount')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($rows as $row)
                    <tr>
                        <td><a href="{{ route('admin.purchase-receipt.show', $row['receipt']->id) }}">{{ $row['receipt']->receipt_number }}</a></td>
                        <td>{{ $row['receipt']->receipt_date?->format('d M Y') }}</td>
                        <td>{{ $row['receipt']->purchaseOrder->po_number ?? '-' }}</td>
                        <td>{{ $row['receipt']->purchaseOrder->supplier->name ?? '-' }}</td>
                        <td>{{ $row['receipt']->warehouse->name ?? '-' }}</td>
                        <td>{{ $row['item']->product->name ?? '-' }}</td>
                        <td>{{ $row['item']->received_qty }}</td>
                        <td>{{ $row['pcs'] }}</td>
                        <td class="text-right">{{ number_format($row['value'], 2) }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div></div>
        </div>
    </section>
</div>
@endsection
