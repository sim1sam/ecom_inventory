@extends('admin.master_layout')
@section('title')<title>{{__('admin.Units')}}</title>@endsection
@section('admin-content')
<div class="main-content"><section class="section">
<div class="section-header"><h1>{{__('admin.Units')}}</h1></div>
<div class="section-body">
<p class="text-muted">{{__('admin.Create units like Box, Carton or Dozen. Stock always stays in Pcs. Set Pcs per pack on each product')}}</p>
<div class="row">
<div class="col-md-5"><div class="card"><div class="card-header"><h4>{{__('admin.Add New')}}</h4></div><div class="card-body">
<form action="{{ route('admin.unit.store') }}" method="POST">@csrf
<div class="form-group"><label>{{__('admin.Name')}} <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" required placeholder="Box, Carton, Dozen"></div>
<div class="form-group"><label>{{__('admin.Code')}}</label><input type="text" name="code" class="form-control" placeholder="{{__('admin.Auto generated if empty')}}"></div>
<div class="form-group"><label>{{__('admin.Status')}}</label><select name="status" class="form-control"><option value="1">{{__('admin.Active')}}</option><option value="0">{{__('admin.Inactive')}}</option></select></div>
<button class="btn btn-primary">{{__('admin.Save')}}</button>
</form></div></div></div>
<div class="col-md-7"><div class="card"><div class="card-body"><table class="table table-striped" id="dataTable"><thead><tr>
<th>{{__('admin.Name')}}</th><th>{{__('admin.Code')}}</th><th>{{__('admin.Type')}}</th><th>{{__('admin.Status')}}</th><th>{{__('admin.Action')}}</th>
</tr></thead><tbody>@foreach($units as $u)<tr>
<td>
<form action="{{ route('admin.unit.update', $u->id) }}" method="POST" class="form-inline">@csrf @method('PUT')
<input type="text" name="name" class="form-control form-control-sm mr-1" value="{{ $u->name }}" required style="max-width:140px">
<input type="hidden" name="status" value="{{ $u->status }}">
<button class="btn btn-sm btn-primary">{{__('admin.Update')}}</button>
</form>
</td>
<td>{{ $u->code }}</td>
<td>@if($u->is_base)<span class="badge badge-info">{{__('admin.Stock unit')}}</span>@else<span class="badge badge-secondary">{{__('admin.Pack unit')}}</span>@endif</td>
<td>
@if($u->is_base)
<span class="badge badge-success">{{__('admin.Active')}}</span>
@else
<form action="{{ route('admin.unit.update', $u->id) }}" method="POST" class="d-inline">@csrf @method('PUT')
<input type="hidden" name="name" value="{{ $u->name }}">
<select name="status" class="form-control form-control-sm d-inline" style="width:auto" onchange="this.form.submit()">
<option value="1" {{ $u->status ? 'selected' : '' }}>{{__('admin.Active')}}</option>
<option value="0" {{ !$u->status ? 'selected' : '' }}>{{__('admin.Inactive')}}</option>
</select>
</form>
@endif
</td>
<td>
@if(!$u->is_base)
<a href="javascript:;" class="btn btn-danger btn-sm" onclick="deleteData({{ $u->id }})"><i class="fa fa-trash"></i></a>
@else
-
@endif
</td>
</tr>@endforeach</tbody></table></div></div></div>
</div></div></section></div>
<script>function deleteData(id){$("#deleteForm").attr("action",'{{ url("admin/unit") }}/'+id);$("#deleteModal").modal("show");}</script>
@endsection
