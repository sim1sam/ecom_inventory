@extends('admin.master_layout')
@section('title')<title>{{__('admin.Suppliers')}}</title>@endsection
@section('admin-content')
<div class="main-content"><section class="section">
<div class="section-header"><h1>{{__('admin.Suppliers')}}</h1></div>
<div class="section-body">
<div class="row">
<div class="col-md-5"><div class="card"><div class="card-header"><h4>{{__('admin.Add New')}}</h4></div><div class="card-body">
<form action="{{ route('admin.supplier.store') }}" method="POST">@csrf
<div class="form-group"><label>{{__('admin.Name')}} *</label><input type="text" name="name" class="form-control" required></div>
<div class="form-group"><label>{{__('admin.Code')}}</label><input type="text" name="code" class="form-control"></div>
<div class="form-group"><label>{{__('admin.Phone')}}</label><input type="text" name="phone" class="form-control"></div>
<div class="form-group"><label>{{__('admin.Email')}}</label><input type="email" name="email" class="form-control"></div>
<div class="form-group"><label>{{__('admin.Address')}}</label><textarea name="address" class="form-control" rows="2"></textarea></div>
<div class="form-group"><label>{{__('admin.Status')}}</label><select name="status" class="form-control"><option value="1">{{__('admin.Active')}}</option><option value="0">{{__('admin.Inactive')}}</option></select></div>
<button class="btn btn-primary">{{__('admin.Save')}}</button>
</form></div></div></div>
<div class="col-md-7"><div class="card"><div class="card-body"><table class="table table-striped" id="dataTable"><thead><tr>
<th>{{__('admin.Name')}}</th><th>{{__('admin.Code')}}</th><th>{{__('admin.Phone')}}</th><th>{{__('admin.Status')}}</th><th>{{__('admin.Action')}}</th>
</tr></thead><tbody>@foreach($suppliers as $s)<tr>
<td>{{ $s->name }}</td><td>{{ $s->code }}</td><td>{{ $s->phone }}</td>
<td>@if($s->status)<span class="badge badge-success">{{__('admin.Active')}}</span>@else<span class="badge badge-danger">{{__('admin.Inactive')}}</span>@endif</td>
<td><a href="javascript:;" class="btn btn-danger btn-sm" onclick="deleteData({{ $s->id }})"><i class="fa fa-trash"></i></a></td>
</tr>@endforeach</tbody></table></div></div></div>
</div></div></section></div>
<script>function deleteData(id){$("#deleteForm").attr("action",'{{ url("admin/supplier") }}/'+id);$("#deleteModal").modal("show");}</script>
@endsection
