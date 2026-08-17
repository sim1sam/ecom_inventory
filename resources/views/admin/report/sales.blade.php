@extends('admin.master_layout')
@section('title')<title>{{__('admin.Sales Report')}}</title>@endsection
@section('admin-content')
@include('admin.report.partials.filters')
@php $icon = $setting->currency_icon ?? ''; @endphp
<div class="main-content">
    <section class="section">
        <div class="section-header"><h1>{{__('admin.Sales Report')}}</h1></div>
        <div class="section-body">
            <form method="GET" class="form-inline mb-3 no-print">
                <input type="date" name="from_date" class="form-control mr-2 mb-2" value="{{ $from }}">
                <input type="date" name="to_date" class="form-control mr-2 mb-2" value="{{ $to }}">
                <select name="status" class="form-control mr-2 mb-2">
                    <option value="">{{__('admin.All')}}</option>
                    @foreach($statuses as $id => $label)
                    <option value="{{ $id }}" {{ request('status') !== null && request('status') !== '' && (int) request('status') === (int) $id ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary mb-2 mr-2">{{__('admin.Filter')}}</button>
                <a href="{{ route('admin.report.sales') }}" class="btn btn-secondary mb-2 mr-2">{{__('admin.Reset')}}</a>
                <button type="button" class="btn btn-info mb-2 mr-2" onclick="window.print()"><i class="fa fa-print"></i> {{__('admin.Print')}}</button>
                @include('admin.report.partials.export_buttons', ['report' => 'sales'])
            </form>
            <div class="card"><div class="card-body">
                <div class="mb-3 font-weight-bold">{{__('admin.Orders')}}: {{ $orders->count() }} &nbsp; | &nbsp; {{__('admin.Quantity')}}: {{ number_format($qty) }} &nbsp; | &nbsp; {{__('admin.Total')}}: {{ $icon }}{{ number_format($total, 2) }}</div>
                <table class="table table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>{{__('admin.Order Id')}}</th>
                            <th>{{__('admin.Date')}}</th>
                            <th>{{__('admin.Customer')}}</th>
                            <th>{{__('admin.Quantity')}}</th>
                            <th>{{__('admin.Status')}}</th>
                            <th>{{__('admin.Payment')}}</th>
                            <th class="text-right">{{__('admin.Amount')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td><a href="{{ route('admin.order-show', $order->id) }}">{{ $order->order_id }}</a></td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>{{ $order->user->name ?? '-' }}</td>
                        <td>{{ $order->product_qty }}</td>
                        <td>{{ $statuses[$order->order_status] ?? $order->order_status }}</td>
                        <td>
                            @if($order->payment_status == 1)
                            <span class="badge badge-success">{{__('admin.success')}}</span>
                            @else
                            <span class="badge badge-danger">{{__('admin.Pending')}}</span>
                            @endif
                        </td>
                        <td class="text-right">{{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div></div>
        </div>
    </section>
</div>
@endsection
