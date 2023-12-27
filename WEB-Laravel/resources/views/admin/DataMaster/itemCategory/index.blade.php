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
                        targets: [3]
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

    {{-- CRUD AJAX --}}
    <script>
        // Add ItemCategory
        function addItemCategory() {
            const notyWarning = new Noty({
                text: "Kedua field harus diisi sebelum mengirimkan form.",
                type: "warning",
                progressBar: false,
                layout: 'topCenter',
            });
            const notyError = new Noty({
                text: "Terjadi kesalahan saat mengirimkan data.",
                type: "error",
                progressBar: false,
                layout: 'topCenter',
            });
            $("#addItemCategoryForm").on("submit", function(e) {
                e.preventDefault();
                let itemTypeNameValue = $("select[name='itemTypeId']").val();
                let itemCategoryNameValue = $("input[name='itemCategoryName']").val();
                let descriptionValue = $("textarea[name='description']").val();
                if (itemTypeNameValue.trim() !== "" && itemCategoryNameValue.trim() !== "" && descriptionValue
                    .trim() !== "") {
                    let formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: 'kategori-barang',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $("#modal_default_tabCreate").modal("hide");
                            $("#addItemCategoryForm")[0].reset();
                            location.reload();
                        },
                        error: function(data) {
                            notyError.setText(data.responseText ||
                                "Terjadi kesalahan saat mengirimkan data.");
                            notyError.show();
                        },
                    });
                } else {
                    notyWarning.show();
                }
            });
        }

        // Edit ItemCategory
        function editItemCategory(itemCategoryId) {
            $.ajax({
                type: 'GET',
                url: 'kategori-barang/edit/' + itemCategoryId,
                success: function(data) {
                    $('#editItemCategoryId').val(data.itemCategoryId);
                    $('#editItemCategoryForm_ select[name="itemTypeId"]').val(data
                        .itemTypeId);
                    $('#editItemCategoryForm_ input[name="itemCategoryName"]').val(data
                        .itemCategoryName);
                    $('#editItemCategoryForm_ textarea[name="description"]').val(data
                        .description);
                    $('#modal_edit_' + itemCategoryId).modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
        $('#itemCategoryTable').on('click', '.edit-button', function() {
            const id = $(this).data('id');
            editItemCategory(id);
        });

        // Update ItemCategory
        $('#editItemCategoryForm_').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editItemCategoryId').val();
            let formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'kategori-barang/update/' + id,
                data: formData + "&_method=PUT",
                success: function(data) {
                    $('#modal_edit_' + id).modal('hide');
                    $(`#itemCategoryTable tbody tr[data-id="${id}"] td:nth-child(1)`).text($(
                        '#updateitemCategoryForm select[name="itemTypeId"]').val());
                    $(`#itemCategoryTable tbody tr[data-id="${id}"] td:nth-child(2)`).text($(
                        '#updateitemCategoryForm input[name="itemCategoryName"]').val());
                    $(`#itemCategoryTable tbody tr[data-id="${id}"] td:nth-child(3)`).text($(
                        '#updateitemCategoryForm textarea[name="description"]').val());
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        // Delete itemCategory
        function confirmDeleteItemCategory(itemCategoryId) {
            const url = 'kategori-barang/delete/' + itemCategoryId;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            ajaxDelete(url, csrfToken);
        }

        $(document).ready(function() {
            addItemCategory();
        });
    </script>

    {{-- Script for select2 --}}
    <script>
        $(document).ready(function() {
            $('.select').each(function() {
                $(this).select2({
                    dropdownParent: $(this).closest('.modal')
                });
            });
        });
    </script>

    <div class="card">
        <div class="card-header d-flex">
            <h5 class="mb-0">Daftar Kategori Barang</h5>
            <div class="ms-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_default_tabCreate"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Baru</span></button>
            </div>
        </div>
        <table id="itemCategoryTable" class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>Jenis Barang</th>
                    <th>Kategori Barang</th>
                    <th>Keterangan</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($itemCategory['data']) && is_array($itemCategory['data']) && count($itemCategory['data']) > 0)
                    @foreach ($itemCategory['data'] as $iC)
                        <tr>
                            <td>
                                {{ $iC['itemTypeData']['itemType'] }}
                            </td>
                            <td>{{ $iC['itemCategoryName'] }}</td>
                            <td>{{ $iC['description'] }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item text-info" data-bs-toggle="modal"
                                                data-bs-target="#modal_detail_{{ $iC['itemCategoryId'] }}">
                                                <i class="ph-list me-2"></i>
                                                Detail
                                            </a>
                                            <a href="#" class="dropdown-item text-secondary edit-itemCategory"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal_edit_{{ $iC['itemCategoryId'] }}"
                                                data-itemCategory-id="{{ $iC['itemCategoryId'] }}">
                                                <i class="ph-pencil me-2"></i>
                                                Edit
                                            </a>
                                            <a href="#" class="dropdown-item text-danger"
                                                onclick="confirmDeleteItemCategory({{ $iC['itemCategoryId'] }})">
                                                <i class="ph-trash me-2"></i>
                                                Hapus
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                    @endforeach
                @else
                @endif
            </tbody>
        </table>

        {{-- Create Modal --}}
        <div id="modal_default_tabCreate" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kategori Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="addItemCategoryForm">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-form-label col-lg-4 ">Jenis Barang: </label>
                                    <div class="col-lg-7">
                                        @php
                                            $response = Http::get(Config('app.api_url') . 'itemType/viewAll');
                                            $itemTypes = $response->json();
                                        @endphp
                                        <select class="form-control select" data-placeholder="Pilih Jenis Barang"
                                            aria-label="Default select example" name="itemTypeId">
                                            <option></option>
                                            <optgroup label="Jenis Barang">
                                                @foreach ($itemTypes['data'] as $item)
                                                    <option value="{{ $item['itemTypeId'] }}">{{ $item['itemType'] }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Kategori Barang:</label>
                                    <div class="col-lg-7">
                                        <input type="text" name="itemCategoryName" class="form-control"
                                            placeholder="Masukkan Kategori Barang">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Keterangan:</label>
                                    <div class="col-lg-7">
                                        <textarea rows="3" cols="3" name="description" class="form-control" placeholder="Masukkan Keterangan"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Edit Modal --}}
        @if (isset($itemCategory['data']) && is_array($itemCategory['data']) && count($itemCategory['data']) > 0)
            @foreach ($itemCategory['data'] as $iC)
                <div id="modal_edit_{{ $iC['itemCategoryId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Kategori Barang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="editItemCategoryForm_{{ $iC['itemCategoryId'] }}"
                                action="{{ route('itemCategory.update', ['id' => $iC['itemCategoryId']]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Pilih Jenis Barang:</label>
                                            <div class="col-lg-7">
                                                <select class="form-control select" data-placeholder="Pilih Jenis Barang"
                                                    aria-label="Default select example" name="itemTypeId">
                                                    <option></option>
                                                    @php
                                                        $response = Http::get(Config('app.api_url') . 'itemType/viewAll');
                                                        $itemTypes = $response->json();
                                                    @endphp
                                                    <optgroup label="Jenis Barang">
                                                        @foreach ($itemTypes['data'] as $item)
                                                            <option value="{{ $item['itemTypeId'] }}"
                                                                {{ $item['itemTypeId'] == $iC['itemTypeId'] ? 'selected' : '' }}>
                                                                {{ $item['itemType'] }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Kategori Barang:</label>
                                            <div class="col-lg-7">
                                                <input type="text" name="itemCategoryName" class="form-control"
                                                    value="{{ $iC['itemCategoryName'] }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Keterangan:</label>
                                            <div class="col-lg-7">
                                                <textarea rows="3" cols="3" name="description" class="form-control">{{ $iC['description'] }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
        @endif

        {{-- Detail Modal --}}
        @if (isset($itemCategory['data']) && is_array($itemCategory['data']) && count($itemCategory['data']) > 0)
            @foreach ($itemCategory['data'] as $iC)
                <div id="modal_detail_{{ $iC['itemCategoryId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Kategori Barang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row mb-2">
                                        <label for="detail_itemType_name" class="col-lg-4 col-form-label">Jenis Barang
                                            :</label>
                                        <div class="col-lg-7">
                                            <label id="detail_itemType_name" class="col-form-label">
                                                {{ $iC['itemTypeData']['itemType'] }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_itemCategory_name" class="col-lg-4 col-form-label">Kategori
                                            Barang:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_itemCategory_name"
                                                class="col-form-label">{{ $iC['itemCategoryName'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_itemCategory_description"
                                            class="col-lg-4 col-form-label">Keterangan:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_itemCategory_description"
                                                class="col-form-label">{{ $iC['description'] }}</label>
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
    @if (isset($itemCategory['data']) && is_array($itemCategory['data']) && count($itemCategory['data']) > 0)
        @foreach ($itemCategory['data'] as $iC)
            <form id="delete-form-{{ $iC['itemCategoryId'] }}"
                action="{{ route('itemCategory.delete', $iC['itemCategoryId']) }}" method="POST"
                style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @else
    @endif
@endsection
