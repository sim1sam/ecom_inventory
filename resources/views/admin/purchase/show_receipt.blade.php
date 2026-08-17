@extends('admin.master_layout')
@section('title')<title>{{__('admin.Purchase Receipt')}}</title>@endsection
@section('admin-content')
<div class="main-content"><section class="section">
<div class="section-header"><h1>{{__('admin.Purchase Receipt')}}: {{ $receipt->receipt_number }}</h1></div>
<div class="section-body"><div class="card"><div class="card-body">
<p><strong>{{__('admin.PO Number')}}:</strong> {{ $receipt->purchaseOrder->po_number }}</p>
<p><strong>{{__('admin.Supplier')}}:</strong> {{ $receipt->purchaseOrder->supplier->name }}</p>
<p><strong>{{__('admin.Warehouse')}}:</strong> {{ $receipt->warehouse->name }}</p>
<table class="table table-striped mt-3"><thead><tr><th>{{__('admin.Product')}}</th><th>{{__('admin.Unit')}}</th><th>{{__('admin.Quantity')}}</th><th>{{__('admin.Pcs')}}</th><th>{{__('admin.Unit Cost')}}</th></tr></thead>
<tbody>@foreach($receipt->items as $item)
@php $orderItem = $item->orderItem; @endphp
<tr>
<td>{{ $item->product->name }}</td>
<td>{{ optional($orderItem)->unitLabel() ?? 'Pc' }}</td>
<td>{{ $item->received_qty }}</td>
<td>{{ $orderItem ? $orderItem->toBaseQty((int) $item->received_qty) : $item->received_qty }}</td>
<td>{{ number_format($item->unit_cost,2) }}</td>
</tr>
@endforeach</tbody></table>
</div></div></div></section></div>
@endsection
