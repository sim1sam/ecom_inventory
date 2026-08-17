@extends('admin.master_layout')
@section('title')<title>{{__('admin.RTV')}}</title>@endsection
@section('admin-content')
<div class="main-content"><section class="section">
<div class="section-header"><h1>{{__('admin.Return To Vendor')}}</h1></div>
<div class="section-body">
<a href="{{ route('admin.purchase-return.create') }}" class="btn btn-primary mb-3">{{__('admin.Create RTV')}}</a>
<a href="{{ route('admin.purchase-return.create', ['reason' => 'damage']) }}" class="btn btn-warning mb-3 ml-1">{{__('admin.Damage Product Return')}}</a>
<div class="card"><div class="card-body"><table class="table table-striped" id="dataTable"><thead><tr>
<th>{{__('admin.Return No')}}</th><th>{{__('admin.Supplier')}}</th><th>{{__('admin.Warehouse')}}</th><th>{{__('admin.Date')}}</th><th>{{__('admin.Reason')}}</th><th>{{__('admin.Action')}}</th>
</tr></thead><tbody>@foreach($returns as $r)<tr>
<td>{{ $r->return_number }}</td><td>{{ $r->supplier->name }}</td><td>{{ $r->warehouse->name }}</td>
<td>{{ $r->return_date?->format('d M Y') }}</td><td>{{ $r->reason }}</td>
<td><a href="{{ route('admin.purchase-return.show', $r->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a></td>
</tr>@endforeach</tbody></table></div></div>
</div></section></div>
@endsection
