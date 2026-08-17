@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Create Warehouse')}}</title>
@endsection
@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('admin.Create Warehouse')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.warehouse.index') }}">{{__('admin.Warehouses')}}</a></div>
                <div class="breadcrumb-item">{{__('admin.Create Warehouse')}}</div>
            </div>
        </div>
        <div class="section-body">
            <a href="{{ route('admin.warehouse.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('admin.Warehouses')}}</a>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.warehouse.store') }}" method="POST">
                                @csrf
                                <div class="form-group"><label>{{__('admin.Name')}} *</label><input type="text" name="name" class="form-control" required></div>
                                <div class="form-group"><label>{{__('admin.Code')}}</label><input type="text" name="code" class="form-control"></div>
                                <div class="form-group"><label>{{__('admin.Phone')}}</label><input type="text" name="phone" class="form-control"></div>
                                <div class="form-group"><label>{{__('admin.Address')}}</label><textarea name="address" class="form-control" rows="3"></textarea></div>
                                <div class="form-group">
                                    <label>{{__('admin.Status')}} *</label>
                                    <select name="status" class="form-control"><option value="1">{{__('admin.Active')}}</option><option value="0">{{__('admin.Inactive')}}</option></select>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="is_default" value="1" class="custom-control-input" id="is_default">
                                        <label class="custom-control-label" for="is_default">{{__('admin.Set as default warehouse')}}</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{__('admin.Save')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
