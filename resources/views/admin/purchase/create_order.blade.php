@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Create Purchase Order')}}</title>
@endsection
@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('admin.Create Purchase Order')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.purchase-order.index') }}">{{__('admin.Purchase Orders')}}</a></div>
                <div class="breadcrumb-item">{{__('admin.Create Purchase Order')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form id="purchaseItemForm" action="{{ route('admin.purchase-order.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>{{ __('admin.Supplier') }} <span class="text-danger">*</span></label>
                                <select name="supplier_id" class="form-control select2" required>
                                    <option value="">{{__('admin.Select Supplier')}}</option>
                                    @foreach($suppliers as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{ __('admin.Warehouse') }} <span class="text-danger">*</span></label>
                                <select name="warehouse_id" class="form-control" required>
                                    @foreach($warehouses as $w)
                                    <option value="{{ $w->id }}" {{ $w->is_default ? 'selected' : '' }}>{{ $w->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>{{ __('admin.Order Date') }} <span class="text-danger">*</span></label>
                                <input type="date" name="order_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="form-group col-md-2">
                                <label>{{__('admin.Expected Date')}}</label>
                                <input type="date" name="expected_date" class="form-control">
                            </div>
                        </div>

                        <h6 class="mb-3">{{__('admin.Order Items')}}</h6>
                        @include('admin.purchase.partials.item_picker', [
                            'products' => $products,
                            'categories' => $categories,
                            'units' => $units,
                            'qtyName' => 'ordered_qty[]',
                            'costName' => 'unit_cost[]',
                        ])

                        <div class="form-group">
                            <label>{{__('admin.Note')}}</label>
                            <textarea name="notes" class="form-control" rows="2"></textarea>
                        </div>
                        <button type="submit" name="submit" value="0" class="btn btn-primary">{{__('admin.Save Draft')}}</button>
                        <button type="submit" name="submit" value="1" class="btn btn-success">{{__('admin.Submit Order')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
