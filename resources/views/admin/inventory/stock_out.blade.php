@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Stock Out')}}</title>
@endsection
@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header"><h1>{{__('admin.Stock Out')}}</h1></div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.inventory.stock-out.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>{{__('admin.Product')}} <span class="text-danger">*</span></label>
                                <select name="product_id" class="form-control select2" required>
                                    <option value="">{{__('admin.Select Product')}}</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} ({{__('admin.Stock')}}: {{ $product->qty }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{__('admin.Warehouse')}} <span class="text-danger">*</span></label>
                                <select name="warehouse_id" class="form-control" required>
                                    @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{__('admin.Quantity')}} <span class="text-danger">*</span></label>
                                <input type="number" name="qty" class="form-control" min="1" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{__('admin.Reason')}} <span class="text-danger">*</span></label>
                                <select name="reason" class="form-control" required>
                                    <option value="sale">{{__('admin.Sale')}}</option>
                                    <option value="damage">{{__('admin.Damage')}}</option>
                                    <option value="lost">{{__('admin.Lost')}}</option>
                                    <option value="return">{{__('admin.Return')}}</option>
                                    <option value="other">{{__('admin.Other')}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{__('admin.Reference No')}}</label>
                                <input type="text" name="reference_no" class="form-control">
                            </div>
                            <div class="form-group col-md-12">
                                <label>{{__('admin.Note')}}</label>
                                <textarea name="note" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{__('admin.Save')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
