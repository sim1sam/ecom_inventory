@php
    $setting = App\Models\Setting::first();
@endphp

<div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{__('admin.Item Delete Confirmation')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>{{__('admin.Are You sure delete this item ?')}}</p>
        </div>
        <div class="modal-footer bg-whitesmoke br">
            <form id="deleteForm" action="" method="POST">
                @csrf
                @method("DELETE")
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('admin.Close')}}</button>
                <button type="submit" class="btn btn-primary">{{__('admin.Yes, Delete')}}</button>
            </form>
        </div>
      </div>
    </div>
  </div>




  <script src="{{ asset('backend/js/popper.min.js') }}"></script>
  <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('backend/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('backend/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('backend/js/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('backend/js/moment.min.js') }}"></script>
  <script src="{{ asset('backend/js/stisla.js') }}"></script>
  <script src="{{ asset('backend/js/scripts.js') }}"></script>
  <script src="{{ asset('backend/js/custom.js') }}"></script>
  <script src="{{ asset('backend/js/select2.min.js') }}"></script>
  <script src="{{ asset('backend/js/tagify.js') }}"></script>
  <script src="{{ asset('toastr/toastr.min.js') }}"></script>
  <script src="{{ asset('backend/js/bootstrap4-toggle.min.js') }}"></script>
  <script src="{{ asset('backend/js/fontawesome-iconpicker.min.js') }}"></script>
  <script src="{{ asset('backend/js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('backend/clockpicker/dist/bootstrap-clockpicker.js') }}"></script>
  <script src="{{ asset('backend/datetimepicker/jquery.datetimepicker.js') }}"></script>
  <script src="{{ asset('backend/js/iziToast.min.js') }}"></script>
  <script src="{{ asset('backend/js/modules-toastr.js') }}"></script>
  <script src="{{ asset('backend/tinymce/js/tinymce/tinymce.min.js') }}"></script>

    <script>
        @if(Session::has('messege'))
        var type="{{Session::get('alert-type','info')}}"
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('messege') }}");
                break;
            case 'success':
                toastr.success("{{ Session::get('messege') }}");
                break;
            case 'warning':
                toastr.warning("{{ Session::get('messege') }}");
                break;
            case 'error':
                toastr.error("{{ Session::get('messege') }}");
                break;
        }
        @endif
    </script>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                toastr.error('{{ $error }}');
            </script>
        @endforeach
    @endif



<script>
    (function($) {
    "use strict";
    $(document).ready(function () {
        tinymce.init({
            selector: '.summernote',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [
                { value: 'First.Name', title: 'First Name' },
                { value: 'Email', title: 'Email' },
            ]
        });

        $('#dataTable').DataTable();
        $('.select2').select2();
        $('.sub_cat_one').select2();
        $('.tags').tagify();

        $('.datetimepicker_mask').datetimepicker({
            format:'Y-m-d H:i',

        });
        $('.custom-icon-picker').iconpicker({
            templates: {
                popover: '<div class="iconpicker-popover popover"><div class="arrow"></div>' +
                    '<div class="popover-title"></div><div class="popover-content"></div></div>',
                footer: '<div class="popover-footer"></div>',
                buttons: '<button class="iconpicker-btn iconpicker-btn-cancel btn btn-default btn-sm">Cancel</button>' +
                    ' <button class="iconpicker-btn iconpicker-btn-accept btn btn-primary btn-sm">Accept</button>',
                search: '<input type="search" class="form-control iconpicker-search" placeholder="Type to filter" />',
                iconpicker: '<div class="iconpicker"><div class="iconpicker-items"></div></div>',
                iconpickerItem: '<a role="button" href="javascript:;" class="iconpicker-item"><i></i></a>'
            }
        })
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-Infinity'
        });
        $('.clockpicker').clockpicker();

        if (window.purchaseProducts && $('#productScanSearchInput').length) {
            var purchaseProducts = window.purchaseProducts;
            var qtyName = window.purchaseQtyName || 'ordered_qty[]';
            var costName = window.purchaseCostName || 'unit_cost[]';
            var $input = $('#productScanSearchInput');
            var $results = $('#purchaseSearchResults');
            var $categoryFilter = $('#purchaseCategoryFilter');
            var $productCount = $('#purchaseProductCount');
            var activeIndex = -1;
            var currentMatches = [];

            function getCategoryId() {
                var val = $categoryFilter.val();
                return val ? parseInt(val, 10) : null;
            }

            function getFilteredProducts() {
                var categoryId = getCategoryId();
                if (!categoryId) {
                    return purchaseProducts;
                }
                return purchaseProducts.filter(function (p) {
                    return p.category_id === categoryId;
                });
            }

            function updateProductCount() {
                if (!$productCount.length) return;
                var count = getFilteredProducts().length;
                $productCount.text(count + ' {{ __('admin.Products') }}');
            }

            function findExact(query, pool) {
                var q = String(query || '').trim().toLowerCase();
                if (!q) return null;
                var list = pool || purchaseProducts;
                return list.find(function (p) {
                    return (p.barcode && String(p.barcode).toLowerCase() === q) ||
                        (p.sku && String(p.sku).toLowerCase() === q);
                });
            }

            function searchProducts(query) {
                var q = String(query || '').trim().toLowerCase();
                var pool = getFilteredProducts();
                if (!q) return pool.slice(0, 15);
                return pool.filter(function (p) {
                    return (p.name && String(p.name).toLowerCase().indexOf(q) > -1) ||
                        (p.sku && String(p.sku).toLowerCase().indexOf(q) > -1) ||
                        (p.barcode && String(p.barcode).toLowerCase().indexOf(q) > -1) ||
                        (p.category && String(p.category).toLowerCase().indexOf(q) > -1);
                }).slice(0, 15);
            }

            function rowExists(id, unit) {
                return document.querySelector('#purchaseItemsBody tr[data-id="'+id+'"][data-unit="'+unit+'"]');
            }

            var purchaseUnits = window.purchaseUnits || [];

            function getPackUnits() {
                return purchaseUnits.filter(function (u) { return !u.is_base && u.code !== 'pc'; });
            }

            function unitNameByCode(code) {
                var found = purchaseUnits.find(function (u) { return u.code === code; });
                return found ? found.name : (code || '{{ __('admin.Pc') }}');
            }

            function productPcs(product) {
                return Math.max(1, parseInt((product && product.pcs_per_box) || 1, 10));
            }

            function productUnit(product) {
                var code = product && product.purchase_unit ? String(product.purchase_unit).toLowerCase() : 'pc';
                if (code && code !== 'pc' && code !== 'pcs') {
                    return code;
                }
                return 'pc';
            }

            function isPackUnit(unit) {
                return unit && unit !== 'pc' && unit !== 'pcs';
            }

            function unitCostFor(product, unit) {
                return '';
            }

            function formatCostValue(cost) {
                return '';
            }

            function buildUnitOptions(product, selected) {
                var html = '';
                purchaseUnits.forEach(function (u) {
                    html += '<option value="'+u.code+'"'+(selected===u.code?' selected':'')+'>'+u.name+'</option>';
                });
                if (!html) {
                    html = '<option value="pc"'+(selected==='pc'?' selected':'')+'>{{ __('admin.Pc') }}</option>';
                    getPackUnits().forEach(function (u) {
                        html += '<option value="'+u.code+'"'+(selected===u.code?' selected':'')+'>'+u.name+'</option>';
                    });
                }
                return html;
            }

            function refreshRowSummary($tr, source) {
                var unit = $tr.find('.item-unit').val() || 'pc';
                var $pcsInput = $tr.find('.item-pcs-per');
                var $cost = $tr.find('.item-cost');
                var $pcCost = $tr.find('.item-pc-cost');
                var pcs = isPackUnit(unit) ? Math.max(1, parseInt($pcsInput.val(), 10) || 1) : 1;
                if (!isPackUnit(unit)) {
                    $pcsInput.val(1);
                }
                $tr.attr('data-pcs', pcs);
                $tr.find('.pcs-per-wrap').toggle(isPackUnit(unit));
                $tr.find('.pcs-pc-dash').toggle(!isPackUnit(unit));
                $tr.find('.pc-cost-wrap').toggle(isPackUnit(unit));
                $tr.find('.pc-cost-dash').toggle(!isPackUnit(unit));

                var qty = parseInt($tr.find('.item-qty').val(), 10) || 0;
                var cost = parseFloat($cost.val()) || 0;
                var pcCost = parseFloat($pcCost.val()) || 0;

                if (isPackUnit(unit)) {
                    if (source === 'pc') {
                        cost = pcCost * pcs;
                        $cost.val(cost > 0 ? cost.toFixed(2) : '');
                    } else {
                        pcCost = (cost > 0 && pcs > 0) ? (cost / pcs) : 0;
                        $pcCost.val(pcCost > 0 ? pcCost.toFixed(4) : '');
                    }
                }

                cost = parseFloat($cost.val()) || 0;
                var totalPcs = isPackUnit(unit) ? qty * pcs : qty;
                $tr.find('.item-total-pcs').text(totalPcs);
                $tr.find('.item-line-total').text((qty * cost).toFixed(2));
                $cost.attr('placeholder', '0');
                $pcCost.attr('placeholder', '0');
            }

            function toggleEmpty() {
                var hasRows = document.querySelectorAll('#purchaseItemsBody tr').length > 0;
                var hint = document.getElementById('purchaseEmptyHint');
                if (hint) hint.style.display = hasRows ? 'none' : 'block';
            }

            function addProduct(product, qty, silent, unit) {
                if (!product) {
                    if (!silent) toastr.error('{{ __('admin.Product not found') }}');
                    return false;
                }
                unit = unit || productUnit(product);
                if (!unit) unit = 'pc';
                var pcs = isPackUnit(unit) ? productPcs(product) : 1;
                var existing = rowExists(product.id, unit);
                if (existing) {
                    var qtyInput = existing.querySelector('.item-qty');
                    qtyInput.value = parseInt(qtyInput.value || 1, 10) + (qty || 1);
                    refreshRowSummary($(existing));
                    if (!silent) toastr.success(product.name + ' qty updated');
                    return true;
                }
                var packVisible = isPackUnit(unit);
                var tr = document.createElement('tr');
                tr.setAttribute('data-id', product.id);
                tr.setAttribute('data-unit', unit);
                tr.setAttribute('data-pcs', pcs);
                tr.innerHTML =
                    '<td><input type="hidden" name="product_id[]" value="'+product.id+'"><strong>'+product.name+'</strong></td>' +
                    '<td>'+(product.sku || '-')+'</td>' +
                    '<td><select name="unit[]" class="form-control item-unit">' +
                    buildUnitOptions(product, unit) +
                    '</select></td>' +
                    '<td>' +
                    '<div class="pcs-per-wrap"'+(packVisible?'':' style="display:none"')+'>' +
                    '<input type="number" name="pcs_per_box[]" class="form-control item-pcs-per" min="1" value="'+pcs+'">' +
                    '</div>' +
                    '<span class="pcs-pc-dash text-muted"'+(packVisible?' style="display:none"':'')+'>-</span>' +
                    '</td>' +
                    '<td><input type="number" name="'+qtyName+'" class="form-control item-qty" min="1" value="'+(qty || 1)+'" required></td>' +
                    '<td><input type="number" step="0.01" name="'+costName+'" class="form-control item-cost" min="0" value="" placeholder="0"></td>' +
                    '<td>' +
                    '<div class="pc-cost-wrap"'+(packVisible?'':' style="display:none"')+'>' +
                    '<input type="number" step="0.0001" class="form-control item-pc-cost" min="0" value="" placeholder="0">' +
                    '</div>' +
                    '<span class="pc-cost-dash text-muted"'+(packVisible?' style="display:none"':'')+'>-</span>' +
                    '</td>' +
                    '<td class="item-total-pcs text-center">'+(packVisible ? (qty || 1) * pcs : (qty || 1))+'</td>' +
                    '<td class="item-line-total text-right">0.00</td>' +
                    '<td class="text-center"><button type="button" class="btn btn-danger btn-sm remove-item"><i class="fa fa-trash"></i></button></td>';
                document.getElementById('purchaseItemsBody').appendChild(tr);
                toggleEmpty();
                if (!silent) toastr.success(product.name + ' {{ __('admin.added') }}');
                return true;
            }

            function resetSearch() {
                $input.val('').removeClass('scan-ok');
                hideResults();
                setTimeout(function () { $input.trigger('focus'); }, 10);
            }

            function hideResults() {
                $results.hide().empty();
                activeIndex = -1;
                currentMatches = [];
            }

            function renderResults(list) {
                currentMatches = list;
                activeIndex = -1;
                if (!list.length) {
                    $results.html('<div class="no-result">{{ __('admin.No products found') }}</div>').show();
                    return;
                }
                var html = '';
                list.forEach(function (p, i) {
                    html += '<div class="result-item" data-index="'+i+'">' +
                        '<div class="result-name">'+p.name+'</div>' +
                        '<div class="result-meta">SKU: '+(p.sku || '-')+' | Barcode: '+(p.barcode || '-') +
                        (p.category ? ' | ' + p.category : '') +
                        (productPcs(p) > 1 ? ' | 1 ' + unitNameByCode(productUnit(p) === 'pc' ? 'box' : productUnit(p)) + ' = ' + productPcs(p) + ' {{ __('admin.Pcs') }}' : '') +
                        '</div>' +
                        '</div>';
                });
                $results.html(html).show();
            }

            function addFromInput() {
                var value = $input.val().trim();
                if (!value) {
                    toastr.warning('{{ __('admin.Please enter barcode, SKU or product name') }}');
                    return;
                }
                var exact = findExact(value, getFilteredProducts()) || findExact(value, purchaseProducts);
                if (exact) {
                    addProduct(exact, 1);
                    resetSearch();
                    return;
                }
                if (currentMatches.length === 1) {
                    addProduct(currentMatches[0], 1);
                    resetSearch();
                    return;
                }
                if (activeIndex >= 0 && currentMatches[activeIndex]) {
                    addProduct(currentMatches[activeIndex], 1);
                    resetSearch();
                    return;
                }
                var matches = searchProducts(value);
                if (matches.length === 1) {
                    addProduct(matches[0], 1);
                    resetSearch();
                    return;
                }
                toastr.error('{{ __('admin.Product not found') }}');
            }

            $input.on('input click focus', function () {
                renderResults(searchProducts(this.value));
            });

            $categoryFilter.on('change', function () {
                updateProductCount();
                hideResults();
                renderResults(searchProducts($input.val()));
                $input.focus();
            });

            $('#selectAllCategoryBtn').on('click', function () {
                var pool = getFilteredProducts();
                if (!pool.length) {
                    toastr.warning('{{ __('admin.No products found in this category') }}');
                    return;
                }
                var categoryId = getCategoryId();
                var msg = categoryId
                    ? '{{ __('admin.Add all products from selected category?') }} (' + pool.length + ')'
                    : '{{ __('admin.Add all products?') }} (' + pool.length + ')';
                if (!confirm(msg)) return;
                var added = 0;
                pool.forEach(function (p) {
                    if (addProduct(p, 1, true)) added++;
                });
                toastr.success(added + ' {{ __('admin.products added') }}');
                hideResults();
                $input.focus();
            });

            $input.on('keydown', function (e) {
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    if (!currentMatches.length) return;
                    activeIndex = Math.min(activeIndex + 1, currentMatches.length - 1);
                    $results.find('.result-item').removeClass('active').eq(activeIndex).addClass('active');
                    return;
                }
                if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    if (!currentMatches.length) return;
                    activeIndex = Math.max(activeIndex - 1, 0);
                    $results.find('.result-item').removeClass('active').eq(activeIndex).addClass('active');
                    return;
                }
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addFromInput();
                    $input.addClass('scan-ok');
                    setTimeout(function () { $input.removeClass('scan-ok'); }, 400);
                    return;
                }
                if (e.key === 'Escape') {
                    hideResults();
                }
            });

            $results.on('mousedown', '.result-item', function (e) {
                e.preventDefault();
            });

            $results.on('click', '.result-item', function () {
                var index = parseInt($(this).data('index'), 10);
                if (currentMatches[index]) {
                    addProduct(currentMatches[index], 1);
                    resetSearch();
                }
            });

            $('#addProductBtn').on('click', function () {
                addFromInput();
            });

            $(document).on('mousedown', function (e) {
                if (!$(e.target).closest('.purchase-search-wrap').length) {
                    hideResults();
                }
            });

            $('#purchaseItemsBody').on('change', '.item-unit', function () {
                var $tr = $(this).closest('tr');
                var unit = $(this).val() || 'pc';
                var id = parseInt($tr.data('id'), 10);
                if (rowExists(id, unit) && rowExists(id, unit) !== $tr.get(0)) {
                    toastr.warning('{{ __('admin.This product is already added with this unit') }}');
                    $(this).val($tr.attr('data-unit'));
                    return;
                }
                $tr.attr('data-unit', unit);
                var $pcs = $tr.find('.item-pcs-per');
                var product = purchaseProducts.find(function (p) { return String(p.id) === String(id); });
                if (isPackUnit(unit)) {
                    var productPcsVal = productPcs(product);
                    if (!parseInt($pcs.val(), 10) || parseInt($pcs.val(), 10) <= 1) {
                        $pcs.val(productPcsVal > 1 ? productPcsVal : 1);
                    }
                    $tr.find('.pcs-per-wrap').show();
                    $tr.find('.pcs-pc-dash').hide();
                    $tr.find('.pc-cost-wrap').show();
                    $tr.find('.pc-cost-dash').hide();
                    $pcs.focus().select();
                } else {
                    $pcs.val(1);
                    $tr.find('.pcs-per-wrap').hide();
                    $tr.find('.pcs-pc-dash').show();
                    $tr.find('.pc-cost-wrap').hide();
                    $tr.find('.pc-cost-dash').show();
                    $tr.find('.item-pc-cost').val('');
                }
                refreshRowSummary($tr);
            });

            $('#purchaseItemsBody').on('input', '.item-qty, .item-cost, .item-pcs-per', function () {
                refreshRowSummary($(this).closest('tr'), 'unit');
            });

            $('#purchaseItemsBody').on('input', '.item-pc-cost', function () {
                refreshRowSummary($(this).closest('tr'), 'pc');
            });

            $('#purchaseItemsBody').on('click', '.remove-item', function () {
                $(this).closest('tr').remove();
                toggleEmpty();
            });

            $('#purchaseItemForm').on('submit', function (e) {
                if (!$('#purchaseItemsBody tr').length) {
                    e.preventDefault();
                    toastr.error('{{ __('admin.Please add at least one item') }}');
                }
            });

            toggleEmpty();
            updateProductCount();
            $input.focus();
        }

    });

    })(jQuery);
</script>

</body>
</html>
