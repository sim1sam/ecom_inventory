@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Warehouses')}}</title>
@endsection
@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('admin.Warehouses')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.inventory.dashboard') }}">{{__('admin.Inventory')}}</a></div>
                <div class="breadcrumb-item">{{__('admin.Warehouses')}}</div>
            </div>
        </div>
        <div class="section-body">
            <a href="{{ route('admin.warehouse.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{__('admin.Add New')}}</a>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>{{__('admin.SN')}}</th>
                                        <th>{{__('admin.Name')}}</th>
                                        <th>{{__('admin.Code')}}</th>
                                        <th>{{__('admin.Phone')}}</th>
                                        <th>{{__('admin.Default')}}</th>
                                        <th>{{__('admin.Status')}}</th>
                                        <th>{{__('admin.Products')}}</th>
                                        <th>{{__('admin.Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($warehouses as $index => $warehouse)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $warehouse->name }}</td>
                                        <td>{{ $warehouse->code }}</td>
                                        <td>{{ $warehouse->phone }}</td>
                                        <td>@if($warehouse->is_default)<span class="badge badge-success">{{__('admin.Yes')}}</span>@else - @endif</td>
                                        <td>@if($warehouse->status)<span class="badge badge-success">{{__('admin.Active')}}</span>@else<span class="badge badge-danger">{{__('admin.Inactive')}}</span>@endif</td>
                                        <td>{{ $warehouse->stocks_count }}</td>
                                        <td>
                                            <a href="{{ route('admin.warehouse.edit', $warehouse->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                            @if(!$warehouse->is_default)
                                            <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $warehouse->id }})"><i class="fa fa-trash"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
function deleteData(id){
    $("#deleteForm").attr("action",'{{ url("admin/warehouse") }}'+"/"+id)
}
</script>
@endsection
