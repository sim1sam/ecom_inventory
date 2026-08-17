@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Create RTV')}}</title>
@endsection
@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ request('reason') === 'damage' ? __('admin.Damage Product Return') : __('admin.Create RTV') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.purchase-return.index') }}">{{__('admin.Return To Vendor')}}</a></div>
                <div class="breadcrumb-item">{{__('admin.Create RTV')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form id="purchaseItemForm" action="{{ route('admin.purchase-return.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label>{{ __('admin.Supplier') }} <span class="text-danger">*</span></label>
                                <select name="supplier_id" class="form-control select2" required>
                                    @foreach($suppliers as $s)
                                    <option value="{{ $s->id }}" {{ optional($selectedOrder)->supplier_id == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>{{ __('admin.Warehouse') }} <span class="text-danger">*</span></label>
                                <select name="warehouse_id" class="form-control" required>
                                    @foreach($warehouses as $w)
                                    <option value="{{ $w->id }}" {{ optional($selectedOrder)->warehouse_id == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>{{ __('admin.Return Date') }} <span class="text-danger">*</span></label>
                                <input type="date" name="return_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label>{{__('admin.Purchase Order')}}</label>
                                <select name="purchase_order_id" class="form-control">
                                    <option value="">{{__('admin.Optional')}}</option>
                                    @foreach($orders as $o)
                                    <option value="{{ $o->id }}" {{ optional($selectedOrder)->id == $o->id ? 'selected' : '' }}>{{ $o->po_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{ __('admin.Return Type') }} <span class="text-danger">*</span></label>
                                <select name="reason" class="form-control" required>
                                    <option value="Damage" {{ request('reason') === 'damage' ? 'selected' : '' }}>{{__('admin.Damage Product Return')}}</option>
                                    <option value="Wrong item">{{__('admin.Wrong Item')}}</option>
                                    <option value="Expired">{{__('admin.Expired')}}</option>
                                    <option value="Excess">{{__('admin.Excess Quantity')}}</option>
                                    <option value="Other">{{__('admin.Other')}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-8">
                                <label>{{__('admin.Note')}}</label>
                                <input type="text" name="notes" class="form-control" placeholder="{{__('admin.Damage details')}}">
                            </div>
                        </div>

                        <h6 class="mb-3">{{__('admin.Return Items')}}</h6>
                        @include('admin.purchase.partials.item_picker', [
                            'products' => $products,
                            'categories' => $categories,
                            'units' => $units,
                            'qtyName' => 'qty[]',
                            'costName' => 'unit_cost[]',
                        ])

                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-undo"></i> {{__('admin.Post RTV & Reduce Stock')}}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
