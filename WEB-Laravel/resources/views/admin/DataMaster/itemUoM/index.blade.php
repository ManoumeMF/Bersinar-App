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
        // Add itemUoM
        function addItemUoM() {
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
            $("#addItemUoMForm").on("submit", function(e) {
                e.preventDefault();
                let uomTypeNameValue = $("select[name='uomTypeId']").val();
                let uomItemNameValue = $("input[name='uomItem']").val();
                let descriptionValue = $("textarea[name='description']").val();
                if (uomTypeNameValue.trim() !== "" && uomItemNameValue.trim() !== "" && descriptionValue
                    .trim() !== "") {
                    let formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: 'satuan-barang/store',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $("#modal_default_tabCreate").modal("hide");
                            $("#addItemUoMForm")[0].reset();
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

        // Edit itemUoM
        function editItemUoM(itemUoMId) {
            $.ajax({
                type: 'GET',
                url: 'satuan-barang/edit/' + itemUoMId,
                success: function(data) {
                    $('#editItemUoMId').val(data.itemUoMId);
                    $('#editItemUoMForm select[name="uomTypeId"]').val(data
                        .uomTypeId);
                    $('#editItemUoMForm input[name="uomItem"]').val(data
                        .uomItem);
                    $('#editItemUoMForm textarea[name="description"]').val(data
                        .description);
                    $('#modal_edit_' + itemUoMId).modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
        $('#itemUoMTable').on('click', '.edit-button', function() {
            const id = $(this).data('id');
            editItemUoM(id);
        });

        // Update itemUoM
        $('#editItemUoMForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editItemUoMId').val();
            let formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'satuan-barang/update/' + id,
                data: formData + "&_method=PUT",
                success: function(data) {
                    $('#modal_edit_' + id).modal('hide');
                    $(`#itemUoMTable tbody tr[data-id="${id}"] td:nth-child(1)`).text($(
                        '#updateitemUoMForm select[name="uomTypeId"]').val());
                    $(`#itemUoMTable tbody tr[data-id="${id}"] td:nth-child(2)`).text($(
                        '#updateitemUoMForm input[name="uomItem"]').val());
                    $(`#itemUoMTable tbody tr[data-id="${id}"] td:nth-child(3)`).text($(
                        '#updateitemUoMForm textarea[name="description"]').val());
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        // Delete itemUoM
        function confirmDeleteItemUoM(itemUoMId) {
            const url = 'satuan-barang/delete/' + itemUoMId;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            ajaxDelete(url, csrfToken);
        }

        $(document).ready(function() {
            addItemUoM();
        });
    </script>

    <script>
        $(document).ready(function() {
            // Your existing Select2 initialization
            $('.select').each(function() {
                $(this).select2({
                    dropdownParent: $(this).closest('.modal')
                });
            });
        });
    </script>
    <div class="card">
        <div class="card-header d-flex">
            <h5 class="mb-0">Daftar Satuan Barang</h5>
            <div class="ms-auto">
                {{-- <a class="btn btn-primary" href="{{ route('itemUoM.create') }}"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Baru</span></a> --}}
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_default_tabCreate"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Baru</span></button>
            </div>
        </div>
        <table id="itemUoMTable" class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>Jenis Satuan Barang</th>
                    <th>Satuan Barang</th>
                    <th>Keterangan</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($itemUoM['data']) && is_array($itemUoM['data']) && count($itemUoM['data']) > 0)
                    @foreach ($itemUoM['data'] as $IU)
                        <tr>
                            <td>{{ isset($IU['uomTypeData']['uomType']) ? $IU['uomTypeData']['uomType'] : 'N/A' }}</td>
                            <td>{{ isset($IU['uomItem']) ? $IU['uomItem'] : 'N/A' }}</td>
                            <td>{{ isset($IU['description']) ? $IU['description'] : 'N/A' }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item text-info" data-bs-toggle="modal"
                                                data-bs-target="#modal_detail_{{ $IU['itemUoMId'] }}">
                                                <i class="ph-list me-2"></i>
                                                Detail
                                            </a>
                                            <a href="#" class="dropdown-item text-secondary edit-itemUoM"
                                                data-bs-toggle="modal" data-bs-target="#modal_edit_{{ $IU['itemUoMId'] }}"
                                                data-itemUoM-id="{{ $IU['itemUoMId'] }}">
                                                <i class="ph-pencil me-2"></i>
                                                Edit
                                            </a>
                                            <a href="#" class="dropdown-item text-danger"
                                                onclick="confirmDeleteItemUoM({{ $IU['itemUoMId'] }})">
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
        {{-- Create Modal --}}
        <div id="modal_default_tabCreate" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Satuan Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="addItemUoMForm">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Jenis Satuan Barang: </label>
                                    <div class="col-lg-7">
                                        @php
                                            $response = Http::get(Config('app.api_url') . 'uomType/viewAll');
                                            $uomTypes = $response->json();
                                        @endphp
                                        <select class="form-control select" data-placeholder="Pilih Satuan Barang"
                                            aria-label="Default select example" name="uomTypeId">
                                            <option></option>
                                            <optgroup label="Satuan Barang">
                                                @foreach ($uomTypes['data'] as $uT)
                                                    <option value="{{ $uT['uomTypeId'] }}">{{ $uT['uomType'] }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Satuan Barang:</label>
                                    <div class="col-lg-7">
                                        <input type="text" name="uomItem" class="form-control"
                                            placeholder="Masukkan Satuan Barang">
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
        @if (isset($itemUoM['data']) && is_array($itemUoM['data']) && count($itemUoM['data']) > 0)
            @foreach ($itemUoM['data'] as $IU)
                <div id="modal_edit_{{ $IU['itemUoMId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Satuan Barang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="editItemUoMForm_{{ $IU['itemUoMId'] }}"
                                action="{{ route('itemUoM.update', ['id' => $IU['itemUoMId']]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Pilih Jenis Barang:</label>
                                            <div class="col-lg-7">
                                                <select class="form-control select" data-placeholder="Pilih Jenis Barang"
                                                    aria-label="Default select example" name="uomTypeId">
                                                    <option></option>
                                                    @php
                                                        $response = Http::get(Config('app.api_url') . 'uomType/viewAll');
                                                        $uomItems = $response->json();
                                                    @endphp
                                                    <optgroup>
                                                        @foreach ($uomItems['data'] as $uI)
                                                            <option value="{{ $uI['uomTypeId'] }}"
                                                                {{ $uI['uomTypeId'] == $IU['uomTypeId'] ? 'selected' : '' }}>
                                                                {{ $uI['uomType'] }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Kategori Barang:</label>
                                            <div class="col-lg-7">
                                                <input type="text" name="uomItem" class="form-control"
                                                    value="{{ $IU['uomItem'] }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Keterangan:</label>
                                            <div class="col-lg-7">
                                                <textarea rows="3" cols="3" name="description" class="form-control">{{ $IU['description'] }}</textarea>
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
        @if (isset($itemUoM['data']) && is_array($itemUoM['data']) && count($itemUoM['data']) > 0)
            @foreach ($itemUoM['data'] as $IU)
                <div id="modal_detail_{{ $IU['itemUoMId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Satuan Barang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row mb-2">
                                        <label for="detail_uomType_name" class="col-lg-4 col-form-label">Jenis Satuan
                                            Barang
                                            :</label>
                                        <div class="col-lg-7">
                                            <label id="detail_uomType_name" class="col-form-label">
                                                {{ $IU['uomTypeData']['uomType'] }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_uomItem_name" class="col-lg-4 col-form-label">Kategori
                                            Barang:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_uomItem_name"
                                                class="col-form-label">{{ $IU['uomItem'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_uomItem_description"
                                            class="col-lg-4 col-form-label">Keterangan:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_uomItem_description"
                                                class="col-form-label">{{ $IU['description'] }}</label>
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
    @if (isset($itemUoM['data']) && is_array($itemUoM['data']) && count($itemUoM['data']) > 0)
        @foreach ($itemUoM['data'] as $IU)
            <form id="delete-form-{{ $IU['itemUoMId'] }}" action="{{ route('itemUoM.delete', $IU['itemUoMId']) }}"
                method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @else
    @endif
@endsection
