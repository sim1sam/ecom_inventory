@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Barcode Generator')}}</title>
@endsection
@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header"><h1>{{__('admin.Barcode Generator')}}</h1></div>
        <div class="section-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ route('admin.inventory.barcode.generate') }}" method="POST" class="form-inline">
                        @csrf
                        <select name="product_id" class="form-control mr-2 select2" style="width:250px" required>
                            <option value="">{{__('admin.Select Product')}}</option>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">{{__('admin.Generate Barcode')}}</button>
                    </form>
                </div>
                <div class="col-md-6 text-right">
                    <form action="{{ route('admin.inventory.barcode.generate-all') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-warning">{{__('admin.Generate All Missing Barcodes')}}</button>
                    </form>
                </div>
            </div>

            @include('admin.inventory.partials.barcode_print_toolbar', ['products' => $products])

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th width="40"></th>
                                    <th>{{__('admin.Name')}}</th>
                                    <th>{{__('admin.SKU')}}</th>
                                    <th>{{__('admin.Barcode')}}</th>
                                    <th>{{__('admin.Preview')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="barcode-product-check" value="{{ $product->id }}" {{ $product->barcode ? '' : 'disabled' }}>
                                    </td>
                                    <td>{{ $product->short_name }}</td>
                                    <td>{{ $product->sku }}</td>
                                    <td>{{ $product->barcode ?: __('admin.Not generated') }}</td>
                                    <td>@if($product->barcode)<svg class="barcode-preview" data-barcode="{{ $product->barcode }}"></svg>@endif</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
@include('admin.inventory.partials.barcode_selection_script')
<script>
document.querySelectorAll('.barcode-preview').forEach(function(el){
    JsBarcode(el, el.dataset.barcode, {format:'CODE128', width:1, height:40, displayValue:true});
});
</script>
@endsection
