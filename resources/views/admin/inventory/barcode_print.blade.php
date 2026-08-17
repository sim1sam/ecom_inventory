@php
    $isA4 = ($printerType ?? 'label') === 'a4';
    $totalLabels = $products->count() * $copies;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ __('admin.Print Barcodes') }}</title>
    <style>
        @page {
            @if($isA4)
            size: A4 portrait;
            margin: 8mm;
            @else
            size: {{ $size['w'] }}mm {{ $size['h'] }}mm;
            margin: 0;
            @endif
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #fff;
            color: #000;
        }

        .print-controls {
            position: fixed;
            top: 12px;
            left: 12px;
            z-index: 10;
            width: 440px;
            padding: 14px 16px;
            background: #fff;
            border: 1px solid #d0d0d0;
            border-radius: 6px;
            box-shadow: 0 4px 16px rgba(0,0,0,.12);
            font-size: 13px;
            line-height: 1.5;
        }

        .print-controls h4 { margin: 0 0 8px; font-size: 15px; }
        .print-controls ol { margin: 8px 0 12px 18px; padding: 0; }
        .print-controls button {
            background: #28a745;
            color: #fff;
            border: 0;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .label {
            width: {{ $size['w'] }}mm;
            height: {{ $size['h'] }}mm;
            padding: 1.2mm 1.5mm;
            text-align: center;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: #fff;
        }

        .label-name {
            font-size: {{ $size['h'] <= 30 ? '7pt' : '9pt' }};
            font-weight: 700;
            line-height: 1.1;
            max-height: {{ $size['h'] <= 30 ? '7mm' : '10mm' }};
            overflow: hidden;
            width: 100%;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .label-meta { margin-top: 0.4mm; font-size: 6pt; line-height: 1.1; }
        .label svg { max-width: calc({{ $size['w'] }}mm - 3mm); margin: 0.6mm 0; }
        .label-code { font-size: 6.5pt; letter-spacing: 0.4px; }
        .label-price { margin-top: 0.4mm; font-size: 8pt; font-weight: 700; }

        @if($isA4)
        .labels {
            display: grid;
            grid-template-columns: repeat({{ $size['cols'] }}, {{ $size['w'] }}mm);
            gap: 3mm;
            justify-content: start;
        }
        .label {
            border: 0.2mm dashed #999;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        @else
        html, body {
            width: {{ $size['w'] }}mm;
            height: {{ $size['h'] }}mm;
        }
        .label {
            page-break-after: always;
            break-after: page;
        }
        .label:last-child {
            page-break-after: auto;
            break-after: auto;
        }
        @endif

        @media print {
            .no-print { display: none !important; }
            body { background: #fff !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            @if($isA4)
            .label { border: 0.2mm solid #000; }
            @else
            html, body { width: {{ $size['w'] }}mm; height: {{ $size['h'] }}mm; }
            .label { page-break-after: always; break-after: page; }
            .label:last-child { page-break-after: auto; break-after: auto; }
            @endif
        }

        @media screen {
            body {
                width: auto !important;
                height: auto !important;
                min-height: 100vh;
                padding: 110px 20px 20px;
                background: #ececec;
            }
            @if($isA4)
            .labels {
                max-width: 210mm;
                margin: 0 auto;
                padding: 10mm;
                background: #fff;
                box-shadow: 0 2px 10px rgba(0,0,0,.08);
            }
            @else
            .label {
                margin: 0 auto 12px;
                border: 1px dashed #bbb;
                box-shadow: 0 1px 4px rgba(0,0,0,.08);
            }
            @endif
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
</head>
<body>
    <div class="print-controls no-print">
        @if($isA4)
        <h4>{{ __('admin.A4 Printer') }} — {{ $size['w'] }}mm × {{ $size['h'] }}mm</h4>
        <ol>
            <li>{{ __('admin.Click Print and choose your A4 printer') }}</li>
            <li>{{ __('admin.Set paper size to A4') }}</li>
            <li>{{ __('admin.Set margins to None / 0 and disable headers and footers') }}</li>
        </ol>
        @else
        <h4>{{ __('admin.Label Printer') }} — {{ $size['w'] }}mm × {{ $size['h'] }}mm</h4>
        <ol>
            <li>{{ __('admin.Click Print and choose your thermal label printer') }}</li>
            <li>{{ __('admin.Set paper size to the same label size') }} ({{ $size['w'] }}mm × {{ $size['h'] }}mm)</li>
            <li>{{ __('admin.Set margins to None / 0 and disable headers and footers') }}</li>
        </ol>
        @endif
        <strong>{{ __('admin.Total Labels') }}:</strong> {{ $totalLabels }}
        &nbsp;
        <button type="button" onclick="window.print()">{{ __('admin.Print') }}</button>
    </div>

    @if($isA4)
    <div class="labels">
    @endif
        @foreach($products as $product)
            @if($product->barcode)
                @for($i = 1; $i <= $copies; $i++)
                <div class="label">
                    <p class="label-name">{{ $product->short_name }}</p>
                    @if($size['h'] >= 30)
                    <p class="label-meta">{{ __('admin.SKU') }}: {{ $product->sku }}</p>
                    @endif
                    <svg class="barcode" data-code="{{ $product->barcode }}" data-height="{{ $size['h'] <= 25 ? 22 : ($size['h'] <= 30 ? 28 : 40) }}"></svg>
                    <p class="label-code">{{ $product->barcode }}</p>
                    @if($size['h'] >= 30)
                    <p class="label-price">{{ __('admin.Price') }}: {{ $product->price }}</p>
                    @endif
                </div>
                @endfor
            @endif
        @endforeach
    @if($isA4)
    </div>
    @endif

    <script>
        document.querySelectorAll('.barcode').forEach(function (el) {
            JsBarcode(el, el.dataset.code, {
                format: 'CODE128',
                width: {{ $size['w'] <= 40 ? 1.1 : 1.6 }},
                height: parseInt(el.dataset.height, 10),
                displayValue: false,
                margin: 0
            });
        });
    </script>
</body>
</html>
