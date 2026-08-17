@extends('admin.master_layout')
@section('title')<title>{{__('admin.Purchase Received')}}</title>@endsection
@section('admin-content')
<div class="main-content"><section class="section">
<div class="section-header"><h1>{{__('admin.Purchase Received')}}</h1></div>
<div class="section-body">
<a href="{{ route('admin.purchase-receipt.create') }}" class="btn btn-primary mb-3">{{__('admin.Receive Purchase')}}</a>
<div class="card"><div class="card-body"><table class="table table-striped" id="dataTable"><thead><tr>
<th>{{__('admin.Receipt No')}}</th><th>{{__('admin.PO Number')}}</th><th>{{__('admin.Supplier')}}</th><th>{{__('admin.Warehouse')}}</th><th>{{__('admin.Date')}}</th><th>{{__('admin.Action')}}</th>
</tr></thead><tbody>@foreach($receipts as $r)<tr>
<td>{{ $r->receipt_number }}</td><td>{{ $r->purchaseOrder->po_number ?? '-' }}</td><td>{{ $r->purchaseOrder->supplier->name ?? '-' }}</td>
<td>{{ $r->warehouse->name ?? '-' }}</td><td>{{ $r->receipt_date?->format('d M Y') }}</td>
<td><a href="{{ route('admin.purchase-receipt.show', $r->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a></td>
</tr>@endforeach</tbody></table></div></div>
</div></section></div>
@endsection
