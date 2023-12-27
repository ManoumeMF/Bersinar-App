@extends('layouts.admin.template')

@section('content')
    <script>
        const DatatableBasic = function() {


            //
            // Setup module components
            //

            // Basic Datatable examples
            const _componentDatatableBasic = function() {
                if (!$().DataTable) {
                    console.warn('Warning - datatables.min.js is not loaded.');
                    return;
                }

                // Setting datatable defaults
                $.extend($.fn.dataTable.defaults, {
                    autoWidth: false,
                    columnDefs: [{
                        orderable: false,
                        width: 100,
                        targets: [4]
                    }],
                    dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                    language: {
                        search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                        searchPlaceholder: 'Type to filter...',
                        lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                        paginate: {
                            'first': 'First',
                            'last': 'Last',
                            'next': document.dir == "rtl" ? '&larr;' : '&rarr;',
                            'previous': document.dir == "rtl" ? '&rarr;' : '&larr;'
                        }
                    }
                });

                // Basic datatable
                $('.datatable-basic').DataTable();

                // Alternative pagination
                $('.datatable-pagination').DataTable({
                    pagingType: "simple",
                    language: {
                        paginate: {
                            'next': document.dir == "rtl" ? 'Next &larr;' : 'Next &rarr;',
                            'previous': document.dir == "rtl" ? '&rarr; Prev' : '&larr; Prev'
                        }
                    }
                });

                // Datatable with saving state
                $('.datatable-save-state').DataTable({
                    stateSave: true
                });

                // Scrollable datatable
                const table = $('.datatable-scroll-y').DataTable({
                    autoWidth: true,
                    scrollY: 300
                });

                // Resize scrollable table when sidebar width changes
                $('.sidebar-control').on('click', function() {
                    table.columns.adjust().draw();
                });
            };


            //
            // Return objects assigned to module
            //

            return {
                init: function() {
                    _componentDatatableBasic();
                }
            }
        }();


        // Initialize module
        // ------------------------------

        document.addEventListener('DOMContentLoaded', function() {
            DatatableBasic.init();
        });
    </script>
    <div class="card">
        <div class="card-header d-flex">
            <h5 class="mb-0">Daftar Barang</h5>
            <div class="ms-auto">
                <a class="btn btn-primary" href="{{ route('item.create') }}"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Barang</span></a>
            </div>
        </div>
        <table class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori Barang</th>
                    <th>Satuan Barang</th>
                    <th>Keterangan</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($item['data']) && is_array($item['data']) && count($item['data']) > 0)
                    @foreach ($item['data'] as $barang)
                        <tr>
                            <td>{{ $barang['itemCode'] }}</td>
                            <td>{{ $barang['itemName'] }}</td>
                            <td>{{ $barang['itemCategoryName'] }}</td>
                            <td>{{ $barang['uomItem'] }}</td>
                            <td>{{ $barang['description'] }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item text-info" data-bs-toggle="modal"
                                                data-bs-target="#modal_detail_{{ $barang['itemId'] }}">
                                                <i class="ph-list me-2"></i>
                                                Detail
                                            </a>
                                            <a href="{{ route('item.edit', ['id' => isset($barang['itemId']) ? $barang['itemId'] : null]) }}"
                                                class="dropdown-item text-secondary">
                                                <i class="ph-pencil me-2"></i>
                                                Edit
                                            </a>
                                            <a href="#" class="dropdown-item text-danger"
                                                onclick="confirmDeleteItem({{ $barang['itemId'] }})">
                                                <i class="ph-trash me-2"></i>
                                                Hapus
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                @endif
            </tbody>
        </table>

        {{-- Detail Modal --}}
        @if (isset($item['data']) && is_array($item['data']) && count($item['data']) > 0)
            @foreach ($item['data'] as $barang)
                <div id="modal_detail_{{ $barang['itemId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row mb-1">
                                        <label for="detail_business_unit" class="col-lg-4 col-form-label">
                                            Unit Bisnis:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_business_unit"
                                                class="col-form-label">{{ $barang['itemDetail']['businessUnitName'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_item_code" class="col-lg-4 col-form-label">
                                            Kode Barang:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_item_code"
                                                class="col-form-label">{{ $barang['itemDetail']['itemCode'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_item_name" class="col-lg-4 col-form-label">
                                            Nama Barang:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_item_name"
                                                class="col-form-label">{{ $barang['itemDetail']['itemName'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_itemCategoryId" class="col-lg-4 col-form-label">Kategori
                                            Barang:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_itemCategoryId"
                                                class="col-form-label">{{ $barang['itemDetail']['itemCategoryName'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_itemUoMId" class="col-lg-4 col-form-label">Satuan Barang:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_itemUoMId"
                                                class="col-form-label">{{ $barang['itemDetail']['uomItem'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_spesification"
                                            class="col-lg-4 col-form-label">Spesifikasi:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_spesification"
                                                class="col-form-label">{{ $barang['itemDetail']['specification'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_barcode" class="col-lg-4 col-form-label">Barkode:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_barcode"
                                                class="col-form-label">{{ $barang['itemDetail']['barcode'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_description" class="col-lg-4 col-form-label">Deskripsi:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_description"
                                                class="col-form-label">{{ $barang['itemDetail']['description'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_gambar" class="col-lg-4 col-form-label">Gambar:</label>
                                        <div class="col-lg-7">
                                            <img src="{{ asset('images/' . $barang['itemDetail']['gambar']) }}"
                                                alt="Gambar Barang" style="max-width: 25%; height: auto;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
        @endif
    </div>
    <script>
        function confirmDeleteItem(itemId) {
            const url = 'barang/hapus/' + itemId;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            ajaxDelete(url, csrfToken);
        }
    </script>
@endsection
