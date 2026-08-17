<script>
(function ($) {
    "use strict";

    const selectedIds = new Set();
    const printableIds = window.barcodePrintableIds || [];

    function getRowCheckboxes() {
        return $('.barcode-product-check:not(:disabled)');
    }

    function getVisibleCheckboxes() {
        if (!$.fn.DataTable || !$.fn.DataTable.isDataTable('#dataTable')) {
            return getRowCheckboxes();
        }
        const table = $('#dataTable').DataTable();
        return table.rows({ page: 'current' }).nodes().to$().find('.barcode-product-check:not(:disabled)');
    }

    function syncRowStates() {
        getRowCheckboxes().each(function () {
            const id = String($(this).val());
            $(this).prop('checked', selectedIds.has(id));
        });
        updateToolbar();
    }

    function updateToolbar() {
        const count = selectedIds.size;
        $('#barcodeSelectedCount').text(count);
        $('#barcodePrintBtn').prop('disabled', count === 0);

        const visible = getVisibleCheckboxes();
        const visibleChecked = visible.filter(':checked').length;
        $('#barcodeSelectPage').prop('checked', visible.length > 0 && visibleChecked === visible.length);
        $('#barcodeSelectAll').prop('checked', printableIds.length > 0 && count === printableIds.length);
    }

    function setHiddenInputs() {
        const container = $('#barcodePrintInputs');
        container.empty();
        selectedIds.forEach(function (id) {
            container.append('<input type="hidden" name="product_ids[]" value="' + id + '">');
        });
    }

    function bindDataTableEvents() {
        if ($.fn.DataTable && $.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').off('draw.dt.barcode').on('draw.dt.barcode', function () {
                syncRowStates();
            });
        }
    }

    $(document).on('change', '.barcode-product-check', function () {
        const id = String($(this).val());
        if ($(this).is(':checked')) {
            selectedIds.add(id);
        } else {
            selectedIds.delete(id);
        }
        updateToolbar();
    });

    $('#barcodeSelectPage').on('change', function () {
        const checked = $(this).is(':checked');
        getVisibleCheckboxes().each(function () {
            const id = String($(this).val());
            $(this).prop('checked', checked);
            if (checked) {
                selectedIds.add(id);
            } else {
                selectedIds.delete(id);
            }
        });
        updateToolbar();
    });

    $('#barcodeSelectAll').on('change', function () {
        selectedIds.clear();
        if ($(this).is(':checked')) {
            printableIds.forEach(function (id) {
                selectedIds.add(String(id));
            });
        }
        syncRowStates();
    });

    $('#barcodePrintForm').on('submit', function (e) {
        if (selectedIds.size === 0) {
            e.preventDefault();
            toastr.error('{{ __('admin.Please select at least one product') }}');
            return false;
        }
        setHiddenInputs();
    });

    $(document).ready(function () {
        updateToolbar();
        bindDataTableEvents();
        setTimeout(bindDataTableEvents, 600);
    });
})(jQuery);
</script>
