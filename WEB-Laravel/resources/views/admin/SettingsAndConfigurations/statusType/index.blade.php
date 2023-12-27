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

    {{-- CRUD AJAX --}}
    <script>
        // Tambah statusType
        function addStatusType() {
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
            $("#addStatusTypeForm").on("submit", function(e) {
                e.preventDefault();
                let statusypeNameValue = $("input[name='statusType']").val();
                let descriptionValue = $("textarea[name='description']").val();
                if (statusypeNameValue.trim() !== "" && descriptionValue.trim() !== "") {
                    let formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: 'jenis-status/store',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $("#modal_default_tabCreate").modal("hide");
                            $("#addStatusTypeForm")[0].reset();
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

        // Edit statusType
        function editStatusType(statusTypeId) {
            $.ajax({
                type: 'GET',
                url: 'jenis-status/edit/' + statusTypeId,
                success: function(data) {
                    $('#editStatusTypeId').val(data.statusTypeId);
                    $('#editStatusTypeForm input[name="statusType"]').val(data.statusType);
                    $('#editStatusTypeForm textarea[name="description"]').val(data.description);
                    $('#modal_edit_' + statusTypeId).modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
        $('#statusTypeTable').on('click', '.edit-status-type', function() {
            const id = $(this).data('data-status-type-id');
            editStatusType(id);
        });

        // Update statusType
        $('#editStatusTypeForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editStatusTypeId').val();
            let formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'jenis-status/update/' + id,
                data: formData + "&_method=PUT",
                success: function(data) {
                    $('#modal_edit_' + id).modal('hide');
                    // Update the table row with the edited data
                    $(`#statusTypeTable tbody tr[data-status-type-id="${id}"] td:nth-child(1)`).text($(
                        '#editStatusTypeForm input[name="statusType"]').val());
                    $(`#statusTypeTable tbody tr[data-status-type-id="${id}"] td:nth-child(2)`).text($(
                        '#editStatusTypeForm textarea[name="description"]').val());
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        // Hapus statusType
        function confirmDeleteStatusType(statusTypeId) {
            const url = 'jenis-status/hapus/' + statusTypeId;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            ajaxDelete(url, csrfToken);
        }
        $(document).ready(function() {
            addStatusType();
        });
    </script>

    <div class="card">
        <div class="card-header d-flex">
            <h5 class="mb-0">Daftar Jenis Status</h5>
            <div class="ms-auto">
                {{-- <a class="btn btn-primary" href="{{ route('statusType.create') }}"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Jenis Status</span></a> --}}
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_default_tabCreate"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Baru</span></button>
            </div>
        </div>
        <table id="statusTypeTable" class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>Jenis Status</th>
                    <th>Keterangan</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($statusType['data']) && is_array($statusType['data']) && count($statusType['data']) > 0)
                    @foreach ($statusType['data'] as $sT)
                        <tr>
                            <td>{{ $sT['statusType'] }}</td>
                            <td>{{ $sT['description'] }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item text-info detail-button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal_detail_{{ $sT['statusTypeId'] }}">
                                                <i class="ph-list me-2"></i>
                                                Detail
                                            </a>
                                            <a href="#" class="dropdown-item text-secondary edit-status-type"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal_edit_{{ $sT['statusTypeId'] }}"
                                                data-status-type-id="{{ $sT['statusTypeId'] }}">
                                                <i class="ph-pencil me-2"></i>
                                                Edit
                                            </a>
                                            <a href="#" class="dropdown-item text-danger"
                                                onclick="confirmDeleteStatusType({{ $sT['statusTypeId'] }})">
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
                        <h5 class="modal-title">Tambah Jenis Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="addStatusTypeForm">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Nama Jenis Status:</label>
                                    <div class="col-lg-7">
                                        <input type="text" name="statusType" class="form-control"
                                            placeholder="Masukkan Jenis Status">
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
        @if (isset($statusType['data']) && is_array($statusType['data']) && count($statusType['data']) > 0)
            @foreach ($statusType['data'] as $sT)
                <div id="modal_edit_{{ $sT['statusTypeId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Jenis Status</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="editStatusTypeForm_{{ $sT['statusTypeId'] }}"
                                action="{{ route('statusType.update', ['id' => $sT['statusTypeId']]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Jenis Status:</label>
                                            <div class="col-lg-7">
                                                <input type="text" name="statusType" class="form-control"
                                                    value="{{ $sT['statusType'] }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Keterangan:</label>
                                            <div class="col-lg-7">
                                                <textarea rows="3" cols="3" name="description" class="form-control">{{ $sT['description'] }}</textarea>
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
        @if (isset($statusType['data']) && is_array($statusType['data']) && count($statusType['data']) > 0)
            @foreach ($statusType['data'] as $sT)
                <div id="modal_detail_{{ $sT['statusTypeId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Jenis Status</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row mb-2">
                                        <label for="detail_statusType_name" class="col-lg-4 col-form-label">
                                            Nama Jenis Status:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_statusType_name"
                                                class="col-form-label">{{ $sT['statusType'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_statusType_description"
                                            class="col-lg-4 col-form-label">Keterangan:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_statusType_description"
                                                class="col-form-label">{{ $sT['description'] }}</label>
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
    @if (isset($statusType['data']) && is_array($statusType['data']) && count($statusType['data']) > 0)
        @foreach ($statusType['data'] as $sT)
            <form id="delete-form-{{ $sT['statusTypeId'] }}"
                action="{{ route('statusType.hapus', $sT['statusTypeId']) }}" method="POST" style="display: none">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @else
    @endif
@endsection
