@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Edit Warehouse')}}</title>
@endsection
@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('admin.Edit Warehouse')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.warehouse.index') }}">{{__('admin.Warehouses')}}</a></div>
                <div class="breadcrumb-item">{{__('admin.Edit Warehouse')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.warehouse.update', $warehouse->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group"><label>{{__('admin.Name')}} *</label><input type="text" name="name" class="form-control" value="{{ $warehouse->name }}" required></div>
                                <div class="form-group"><label>{{__('admin.Code')}}</label><input type="text" name="code" class="form-control" value="{{ $warehouse->code }}"></div>
                                <div class="form-group"><label>{{__('admin.Phone')}}</label><input type="text" name="phone" class="form-control" value="{{ $warehouse->phone }}"></div>
                                <div class="form-group"><label>{{__('admin.Address')}}</label><textarea name="address" class="form-control" rows="3">{{ $warehouse->address }}</textarea></div>
                                <div class="form-group">
                                    <label>{{__('admin.Status')}} *</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ $warehouse->status ? 'selected' : '' }}>{{__('admin.Active')}}</option>
                                        <option value="0" {{ !$warehouse->status ? 'selected' : '' }}>{{__('admin.Inactive')}}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="is_default" value="1" class="custom-control-input" id="is_default" {{ $warehouse->is_default ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_default">{{__('admin.Set as default warehouse')}}</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{__('admin.Update')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
