@extends('admin.master_layout')
@section('title')<title>{{__('admin.Purchase Orders')}}</title>@endsection
@section('admin-content')
<div class="main-content"><section class="section">
<div class="section-header"><h1>{{__('admin.Purchase Orders')}}</h1></div>
<div class="section-body">
<a href="{{ route('admin.purchase-order.create') }}" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> {{__('admin.Create Purchase Order')}}</a>
<div class="card"><div class="card-body"><table class="table table-striped" id="dataTable"><thead><tr>
<th>{{__('admin.PO Number')}}</th><th>{{__('admin.Supplier')}}</th><th>{{__('admin.Warehouse')}}</th><th>{{__('admin.Date')}}</th><th>{{__('admin.Status')}}</th><th>{{__('admin.Total')}}</th><th>{{__('admin.Action')}}</th>
</tr></thead><tbody>@foreach($orders as $o)<tr>
<td>{{ $o->po_number }}</td><td>{{ $o->supplier->name ?? '-' }}</td><td>{{ $o->warehouse->name ?? '-' }}</td>
<td>{{ $o->order_date?->format('d M Y') }}</td><td><span class="badge badge-info">{{ strtoupper($o->status) }}</span></td>
<td>{{ number_format($o->total, 2) }}</td>
<td><a href="{{ route('admin.purchase-order.show', $o->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
@if($o->status==='draft')<a href="{{ route('admin.purchase-order.submit', $o->id) }}" class="btn btn-primary btn-sm">{{__('admin.Submit')}}</a>@endif
@if(in_array($o->status,['submitted','partial']))<a href="{{ route('admin.purchase-receipt.create', ['purchase_order_id'=>$o->id]) }}" class="btn btn-warning btn-sm">{{__('admin.Receive')}}</a>@endif
</td></tr>@endforeach</tbody></table></div></div>
</div></section></div>
@endsection
