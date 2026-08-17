@extends('admin.master_layout')
@section('title')<title>{{__('admin.RTV')}} {{ $return->return_number }}</title>@endsection
@section('admin-content')
<div class="main-content"><section class="section">
<div class="section-header"><h1>{{__('admin.RTV')}}: {{ $return->return_number }}</h1></div>
<div class="section-body"><div class="card"><div class="card-body">
<p><strong>{{__('admin.Supplier')}}:</strong> {{ $return->supplier->name }}</p>
<p><strong>{{__('admin.Warehouse')}}:</strong> {{ $return->warehouse->name }}</p>
<p><strong>{{__('admin.Reason')}}:</strong> {{ $return->reason }}</p>
<table class="table table-striped mt-3"><thead><tr><th>{{__('admin.Product')}}</th><th>{{__('admin.Unit')}}</th><th>{{__('admin.Quantity')}}</th><th>{{__('admin.Pcs')}}</th><th>{{__('admin.Unit Cost')}}</th></tr></thead>
<tbody>@foreach($return->items as $item)
<tr>
<td>{{ $item->product->name }}</td>
<td>{{ \App\Models\Unit::label($item->unit ?? 'pc') }}</td>
<td>{{ $item->qty }}</td>
<td>{{ \App\Models\Product::convertToPcs((int) $item->qty, $item->unit ?? 'pc', (int) ($item->pcs_per_box ?: 1)) }}</td>
<td>{{ number_format($item->unit_cost,2) }}</td>
</tr>
@endforeach</tbody></table>
</div></div></div></section></div>
@endsection
