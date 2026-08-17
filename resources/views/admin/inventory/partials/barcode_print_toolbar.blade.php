@php
    $printableProducts = $products->filter(fn ($product) => !empty($product->barcode));
    $printableIds = $printableProducts->pluck('id')->values()->all();
@endphp

<div class="card mb-3 barcode-print-toolbar">
    <div class="card-body py-3">
        <form id="barcodePrintForm" action="{{ route('admin.inventory.barcode.print') }}" method="POST" target="_blank">
            @csrf
            <div class="d-flex flex-wrap align-items-center">
                <div class="custom-control custom-checkbox mr-3 mb-2">
                    <input type="checkbox" class="custom-control-input barcode-select-page" id="barcodeSelectPage">
                    <label class="custom-control-label" for="barcodeSelectPage">{{__('admin.Select Page')}}</label>
                </div>
                <div class="custom-control custom-checkbox mr-3 mb-2">
                    <input type="checkbox" class="custom-control-input barcode-select-all" id="barcodeSelectAll">
                    <label class="custom-control-label" for="barcodeSelectAll">{{__('admin.Select All Products')}} ({{ count($printableIds) }})</label>
                </div>
                <span class="text-muted mr-3 mb-2">{{__('admin.Selected')}}: <strong id="barcodeSelectedCount">0</strong></span>

                <label class="mb-2 mr-2">{{__('admin.Printer')}}:</label>
                <select name="printer_type" id="barcodePrinterType" class="form-control mr-3 mb-2" style="width:auto;">
                    <option value="label">{{__('admin.Label Printer')}}</option>
                    <option value="a4">{{__('admin.A4 Printer')}}</option>
                </select>

                <label class="mb-2 mr-2">{{__('admin.Label Size')}}:</label>
                <select name="label_size" class="form-control mr-3 mb-2" style="width:auto;">
                    <option value="50x30">50mm × 30mm ({{__('admin.Standard')}})</option>
                    <option value="40x30">40mm × 30mm</option>
                    <option value="50x25">50mm × 25mm</option>
                    <option value="38x25">38mm × 25mm</option>
                    <option value="58x40">58mm × 40mm</option>
                    <option value="60x40">60mm × 40mm</option>
                    <option value="100x50">100mm × 50mm ({{__('admin.Shelf Label')}})</option>
                </select>

                <label class="mb-2 mr-2">{{__('admin.Copies')}}:</label>
                <input type="number" name="copies" class="form-control mr-3 mb-2" value="1" min="1" max="100" style="width:80px;">

                <button type="submit" class="btn btn-success mb-2" id="barcodePrintBtn" disabled>
                    <i class="fas fa-print"></i> {{__('admin.Print Barcodes')}}
                </button>
            </div>
            <div id="barcodePrintInputs"></div>
        </form>
    </div>
</div>

<script>
window.barcodePrintableIds = @json($printableIds);
</script>
