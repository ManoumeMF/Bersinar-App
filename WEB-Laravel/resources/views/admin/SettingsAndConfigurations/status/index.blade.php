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
    <script>
        function addStatus() {
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
            $("#addStatusForm").on("submit", function(e) {
                e.preventDefault();
                let statusTypeNameValue = $("select[name='statusTypeId']").val();
                let statusNameValue = $("input[name='status']").val();
                let descriptionValue = $("textarea[name='description']").val();
                if (statusTypeNameValue.trim() !== "" && statusNameValue.trim() !== "" && descriptionValue
                    .trim() !== "") {
                    let formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: 'status/store',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $("#modal_default_tabCreate").modal("hide");
                            $("#addStatusForm")[0].reset();
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

        // Edit Status
        function editStatus(statusId) {
            $.ajax({
                type: 'GET',
                url: 'status/edit/' + statusId,
                success: function(data) {
                    $('#editStatusId').val(data.statusId);
                    $('#editStatusForm select[name="statusTypeId"]').val(data
                        .statusTypeId);
                    $('#editStatusForm input[name="status"]').val(data
                        .status);
                    $('#editStatusForm textarea[name="description"]').val(data
                        .description);
                    $('#modal_edit_' + statusId).modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
        $('#statusTable').on('click', '.edit-button', function() {
            const id = $(this).data('id');
            editStatus(id);
        });

        // Update Status
        $('#editStatusForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editStatusId').val();
            let formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'status/update/' + id,
                data: formData + "&_method=PUT",
                success: function(data) {
                    $('#modal_edit_' + id).modal('hide');
                    $(`#statusTable tbody tr[data-id="${id}"] td:nth-child(1)`).text($(
                        '#updateStatusForm select[name="statusTypeId"]').val());
                    $(`#statusTable tbody tr[data-id="${id}"] td:nth-child(2)`).text($(
                        '#updateStatusForm input[name="status"]').val());
                    $(`#statusTable tbody tr[data-id="${id}"] td:nth-child(3)`).text($(
                        '#updateStatusForm textarea[name="description"]').val());
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        // Delete Status
        function confirmDeleteStatus(statudId) {
            const url = 'status/delete/' + statudId;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            ajaxDelete(url, csrfToken);
        }

        $(document).ready(function() {
            addStatus();
        });
    </script>
    <div class="card">
        <div class="card-header d-flex">
            <h5 class="mb-0">Daftar Status</h5>
            <div class="ms-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_default_tabCreate"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Baru</span></button>
            </div>
        </div>
        <table id="statusTable" class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>Jenis Status</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($status['data']) && is_array($status['data']) && count($status['data']) > 0)
                    @foreach ($status['data'] as $st)
                        <tr>
                            <td>{{ $st['statusType'] }}</td>
                            <td>{{ $st['status'] }}</td>
                            <td>{{ $st['description'] }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            {{-- <a href="#" class="dropdown-item text-info" data-bs-toggle="modal"
                                                data-bs-target="#modal_detail">
                                                <i class="ph-list me-2"></i>
                                                Detail
                                            </a> --}}
                                            {{-- <a href="{{ route('status.detail', ['id' => $st['statusId']]) }}"
                                                class="dropdown-item text-info">
                                                <i class="ph-list me-2"></i>
                                                Detail
                                            </a> --}}
                                            <a href="#" class="dropdown-item text-info detail-link"
                                                data-bs-toggle="modal" data-bs-target="#modal_detail_{{ $st['statusId'] }}"
                                                data-status-id="{{ $st['statusId'] }}">
                                                <i class="ph-list me-2"></i>
                                                Detail
                                            </a>
                                            {{-- <a href="#" class="dropdown-item text-secondary">
                                                <i class="ph-pencil me-2"></i>
                                                Edit
                                            </a> --}}
                                            <a href="#" class="dropdown-item text-secondary edit-status"
                                                data-bs-toggle="modal" data-bs-target="#modal_edit_{{ $st['statusId'] }}"
                                                data-status-id="{{ $st['statusId'] }}">
                                                <i class="ph-pencil me-2"></i>
                                                Edit
                                            </a>
                                            {{-- <a href="#" class="dropdown-item text-danger">
                                                <i class="ph-trash me-2"></i>
                                                Hapus
                                            </a> --}}
                                            <a href="#" class="dropdown-item text-danger"
                                                onclick="confirmDeleteStatus({{ $st['statusId'] }})">
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
                        <h5 class="modal-title">Tambah Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="addStatusForm">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label">Jenis Status:</label>
                                    <div class="col-sm-7">
                                        @php
                                            $response = Http::get(Config('app.api_url') . 'status/viewCombo');
                                            $statusTypeData = $response->json();
                                        @endphp
                                        <div class="input-group">
                                            <select data-placeholder="Pilih Jenis Status" class="form-control select"
                                                data-width="1%" name="statusTypeId">
                                                <option></option>
                                                @foreach ($statusTypeData['data'] as $sTypeData)
                                                    <option value="{{ $sTypeData['statusTypeId'] }}">
                                                        {{ $sTypeData['statusType'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-primary "><i
                                                    class="ph-plus-circle"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-sm-4 col-form-label">Nama Status:</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="status" class="form-control"
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
                            <button type="reset" class="btn btn-danger" id="cancelButton"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Edit Modal --}}
        @if (isset($status['data']) && is_array($status['data']) && count($status['data']) > 0)
            @foreach ($status['data'] as $st)
                <div id="modal_edit_{{ $st['statusId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Status</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="editStatusForm_{{ $st['statusId'] }}"
                                action="{{ route('status.update', ['id' => $st['statusId']]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Pilih Jenis Status:</label>
                                            <div class="col-lg-7">
                                                <select class="form-control select" data-placeholder="Pilih Jenis Status"
                                                    aria-label="Default select example" name="statusTypeId">
                                                    <option></option>
                                                    @php
                                                        $response = Http::get(Config('app.api_url') . 'status/viewCombo');
                                                        $statusTypeData = $response->json();
                                                    @endphp
                                                    <optgroup label="Jenis Status">
                                                        @foreach ($statusTypeData['data'] as $sTypeData)
                                                            <option value="{{ $sTypeData['statusTypeId'] }}"
                                                                {{ $sTypeData['statusType'] == $st['statusType'] ? 'selected' : '' }}>
                                                                {{ $sTypeData['statusType'] }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Status:</label>
                                            <div class="col-lg-7">
                                                <input type="text" name="status" class="form-control"
                                                    value="{{ $st['status'] }}">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Keterangan:</label>
                                            <div class="col-lg-7">
                                                <textarea rows="3" cols="3" name="description" class="form-control">{{ $st['description'] }}</textarea>
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
        @if (isset($status['data']) && is_array($status['data']) && count($status['data']) > 0)
            @foreach ($status['data'] as $st)
                <div id="modal_detail_{{ $st['statusId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Status</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row mb-2">
                                        <label for="detail_statusType_name" class="col-lg-4 col-form-label">Jenis Status
                                            :</label>
                                        <div class="col-lg-7">
                                            <label id="detail_statusType_name" class="col-form-label">
                                                {{ $st['statusType'] }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_status_code" class="col-lg-4 col-form-label">Status
                                            :</label>
                                        <div class="col-lg-7">
                                            <label id="detail_status_code" class="col-form-label">
                                                {{ $st['status'] }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_status_description"
                                            class="col-lg-4 col-form-label">Keterangan:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_status_description"
                                                class="col-form-label">{{ $st['description'] }}</label>
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
    {{-- @if (isset($status['data']) && is_array($status['data']) && count($status['data']) > 0)
        @foreach ($status['data'] as $st)
            <form id="delete-form-{{ $st['statusId'] }}" action="{{ route('status.delete', $st['statusId']) }}"
                method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @else
    @endif --}}
@endsection
