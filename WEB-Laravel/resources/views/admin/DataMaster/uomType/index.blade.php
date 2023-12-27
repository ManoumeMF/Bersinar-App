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
                        targets: [2]
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

    {{-- CRUD Ajax --}}
    <script>
        // Tambah uomType
        function adduomType() {
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
            $("#adduomTypeForm").on("submit", function(e) {
                e.preventDefault();
                let uomTypeNameValue = $("input[name='uomType']").val();
                let descriptionValue = $("textarea[name='description']").val();
                if (uomTypeNameValue.trim() !== "" && descriptionValue.trim() !== "") {
                    let formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: 'jenis-satuan-barang/store',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $("#modal_default_tabCreate").modal("hide");
                            $("#adduomTypeForm")[0].reset();
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

        // Edit edituomType
        function edituomType(uomTypeId) {
            $.ajax({
                type: 'GET',
                url: 'jenis-satuan-barang/edit/' + uomTypeId,
                success: function(data) {
                    $('#edituomTypeId').val(data.uomTypeId);
                    $('#edituomTypeForm input[name="uomType"]').val(data
                        .uomTypeName);
                    $('#edituomTypeForm textarea[name="description"]').val(data
                        .description);
                    $('#modal_edit_' + uomTypeId).modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
        $('#uomTypeTable').on('click', '.edit-button', function() {
            const id = $(this).data('id');
            edituomType(id);
        });

        // Update uomType
        $('#edituomTypeForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#edituomTypeId').val();
            let formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'jenis-satuan-barang/update/' + id,
                data: formData + "&_method=PUT",
                success: function(data) {
                    $('#modal_edit_' + id).modal('hide');
                    $(`#uomTypeTable tbody tr[data-id="${id}"] td:nth-child(1)`).text($(
                        '#updateUomTypeForm input[name="uomType"]').val());
                    $(`#uomTypeTable tbody tr[data-id="${id}"] td:nth-child(2)`).text($(
                        '#updateUomTypeForm textarea[name="description"]').val());
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        // Hapus uomType
        function confirmDeleteuomType(uomTypeId) {
            const url = 'jenis-satuan-barang/hapus/' + uomTypeId;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            ajaxDelete(url, csrfToken);
        }
        $(document).ready(function() {
            adduomType();
        });
    </script>


    <div class="card">
        <div class="card-header d-flex">
            <h5 class="mb-0">Daftar Jenis Satuan Barang</h5>
            <div class="ms-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_default_tabCreate"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Baru</span></button>
            </div>
        </div>
        <table id="uomTypeTable" class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>Jenis Satuan Barang</th>
                    <th>Keterangan</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($uomType['data'] as $uomtype)
                    <tr>
                        <td>{{ $uomtype['uomType'] }}</td>
                        <td>{{ $uomtype['description'] }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex">
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#" class="dropdown-item text-info detail-button"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal_detail_{{ $uomtype['uomTypeId'] }}">
                                            <i class="ph-list me-2"></i>
                                            Detail
                                        </a>
                                        <a href="#" class="dropdown-item text-secondary edit-uom-type"
                                            data-bs-toggle="modal" data-bs-target="#modal_edit_{{ $uomtype['uomTypeId'] }}"
                                            data-uom-type-id="{{ $uomtype['uomTypeId'] }}">
                                            <i class="ph-pencil me-2"></i>
                                            Edit
                                        </a>
                                        <a href="#" class="dropdown-item text-danger"
                                            onclick="confirmDeleteuomType({{ $uomtype['uomTypeId'] }})">
                                            <i class="ph-trash me-2"></i>
                                            Hapus
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Create Modal --}}
        <div id="modal_default_tabCreate" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Jenis Satuan Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="adduomTypeForm">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Jenis Satuan Barang:</label>
                                    <div class="col-lg-7">
                                        <input type="text" name="uomType" class="form-control"
                                            placeholder="Masukkan Jenis Satuan Barang">
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
        @if (isset($uomType['data']) && is_array($uomType['data']) && count($uomType['data']) > 0)
            @foreach ($uomType['data'] as $uomtype)
                <div id="modal_edit_{{ $uomtype['uomTypeId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Jenis Barang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="edituomTypeForm_{{ $uomtype['uomTypeId'] }}"
                                action="{{ route('uomType.update', ['id' => $uomtype['uomTypeId']]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Jenis Barang:</label>
                                            <div class="col-lg-7">
                                                <input type="text" name="uomType" class="form-control"
                                                    value="{{ $uomtype['uomType'] }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Keterangan:</label>
                                            <div class="col-lg-7">
                                                <textarea rows="3" cols="3" name="description" class="form-control">{{ $uomtype['description'] }}</textarea>
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
        @if (isset($uomType['data']) && is_array($uomType['data']) && count($uomType['data']) > 0)
            @foreach ($uomType['data'] as $uomtype)
                <div id="modal_detail_{{ $uomtype['uomTypeId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Jenis Orang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row mb-2">
                                        <label for="detail_uomType_name" class="col-lg-4 col-form-label">
                                            Nama Jenis Orang:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_uomType_name"
                                                class="col-form-label">{{ $uomtype['uomType'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_uomType_description"
                                            class="col-lg-4 col-form-label">Keterangan:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_uomType_description"
                                                class="col-form-label">{{ $uomtype['description'] }}</label>
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
    @if (isset($uomType['data']) && is_array($uomType['data']) && count($uomType['data']) > 0)
        @foreach ($uomType['data'] as $uomtype)
            <form id="delete-form-{{ $uomtype['uomTypeId'] }}"
                action="{{ route('uomType.hapus', ['id' => $uomtype['uomTypeId']]) }}" method="POST"
                style="display: none">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @else
    @endif
@endsection
