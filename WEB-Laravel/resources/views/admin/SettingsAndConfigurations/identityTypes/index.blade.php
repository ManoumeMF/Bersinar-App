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
    <div class="card">
        <div class="card-header d-flex">
            <h5 class="mb-0">Daftar Jenis Identitas</h5>
            <div class="ms-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_default_tabCreate"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Baru</span></button>
            </div>
        </div>
        <table id="identityTypeTable" class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>Jenis Identitas</th>
                    <th>Keterangan</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($identityType['data']) && is_array($identityType['data']) && count($identityType['data']) > 0)
                    @foreach ($identityType['data'] as $IT)
                        <tr>
                            <td>{{ $IT['identityType'] }}</td>
                            <td>{{ $IT['description'] }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item text-info" data-bs-toggle="modal"
                                                data-bs-target="#modal_detail_{{ $IT['identityTypeId'] }}">
                                                <i class="ph-list me-2"></i>
                                                Detail
                                            </a>
                                            <a href="#" class="dropdown-item text-secondary edit-identity-type"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal_edit_{{ $IT['identityTypeId'] }}"
                                                data-identity-type-id="{{ $IT['identityTypeId'] }}">
                                                <i class="ph-pencil me-2"></i>
                                                Edit
                                            </a>
                                            <a href="#" class="dropdown-item text-danger"
                                                onclick="confirmDeleteIdentityType({{ $IT['identityTypeId'] }})">
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
                        <h5 class="modal-title">Tambah Jenis Identitas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="addIdentityTypeForm">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Jenis Identitas:</label>
                                    <div class="col-lg-7">
                                        <input type="text" name="identityType" class="form-control"
                                            placeholder="Masukkan Jenis Identitas">
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
    </div>

    {{-- Edit Modal --}}
    @if (isset($identityType['data']) && is_array($identityType['data']) && count($identityType['data']) > 0)
        @foreach ($identityType['data'] as $IT)
            <div id="modal_edit_{{ $IT['identityTypeId'] }}" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Jenis Identitas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form id="editIdentityTypeForm_{{ $IT['identityTypeId'] }}"
                            action="{{ route('identityType.update', ['id' => $IT['identityTypeId']]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row mb-2">
                                        <label class="col-lg-4 col-form-label">Nama Jenis Identitas:</label>
                                        <div class="col-lg-7">
                                            <input type="text" name="identityType" class="form-control"
                                                placeholder="Masukkan Jenis Identitas" value="{{ $IT['identityType'] }}">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-lg-4 col-form-label">Keterangan:</label>
                                        <div class="col-lg-7">
                                            <textarea rows="3" cols="3" name="description" class="form-control">{{ $IT['description'] }}</textarea>
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
    @if (isset($identityType['data']) && is_array($identityType['data']) && count($identityType['data']) > 0)
        @foreach ($identityType['data'] as $IT)
            <div id="modal_detail_{{ $IT['identityTypeId'] }}" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Jenis Identitas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row mb-2">
                                    <label for="detail_identityType_name" class="col-lg-4 col-form-label">Jenis
                                        Identitas:</label>
                                    <div class="col-lg-7">
                                        <label id="detail_identityType_name"
                                            class="col-form-label">{{ $IT['identityType'] }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="detail_identityType_description"
                                        class="col-lg-4 col-form-label">Keterangan:</label>
                                    <div class="col-lg-7">
                                        <label id="detail_identityType_description"
                                            class="col-form-label">{{ $IT['description'] }}</label>
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

    <script>
        function addIdentityType() {
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
            $("#addIdentityTypeForm").on("submit", function(e) {
                e.preventDefault();
                let identityTypeValue = $("input[name='identityType']").val();
                let descriptionValue = $("textarea[name='description']").val();
                if (identityTypeValue.trim() !== "" && descriptionValue.trim() !== "") {
                    let formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: 'jenis-identitas/store',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $("#modal_default_tabCreate").modal("hide");
                            $("#addIdentityTypeForm")[0].reset();
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

        // Edit IdentityType
        function editIdentityType(identityTypeId) {
            $.ajax({
                type: 'GET',
                url: 'jenis-identitas/edit/' + identityTypeId,
                success: function(data) {
                    $('#editIdentityTypeId').val(data.identityTypeId);
                    $('#editIdentityTypeForm input[name="identityType"]').val(data.identityType);
                    $('#editIdentityTypeForm textarea[name="description"]').val(data.description);
                    $('#modal_edit_' + identityTypeId).modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
        $('#identityTypeTable').on('click', '.edit-button', function() {
            const id = $(this).data('id');
            editIdentityType(id);
        });

        $('#editIdentityTypeForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editIdentityTypeId').val();
            let formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'jenis-identitas/update/' + id,
                data: formData + "&_method=PUT",
                success: function(data) {
                    $('#modal_edit_' + id).modal('hide');
                    $(`#editIdentityTypeId tbody tr[data-id="${id}"] td:nth-child(1)`).text($(
                        '#updateIdentityTypeForm input[name="identityType"]').val());
                    $(`#editIdentityTypeId tbody tr[data-id="${id}"] td:nth-child(2)`).text($(
                        '#updateIdentityTypeForm textarea[name="description"]').val());
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        // Delete IdentityType
        function confirmDeleteIdentityType(identityTypeId) {
            const url = 'jenis-identitas/delete/' + identityTypeId;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            ajaxDelete(url, csrfToken);
        }
        $(document).ready(function() {
            addIdentityType();

            $('#updateIdentityTypeForm').on('submit', function(e) {
                e.preventDefault();
                const id = $('#modal_default_tabUpdate').find('.edit-button').data('id');
            });
        });
    </script>
@endsection
