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
        // Tambah Jabatan
        function addPosition() {
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
            $("#addPositionForm").on("submit", function(e) {
                e.preventDefault();
                let positionNameValue = $("input[name='positionName']").val();
                let descriptionValue = $("textarea[name='description']").val();
                if (positionNameValue.trim() !== "" && descriptionValue.trim() !== "") {
                    let formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: 'jabatan/store',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $("#modal_default_tabCreate").modal("hide");
                            $("#addPositionForm")[0].reset();
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

        // Edit Jabatan
        function editOccupation(positionId) {
            $.ajax({
                type: 'GET',
                url: 'jabatan/edit/' + positionId,
                success: function(data) {
                    $('#editPositionId').val(data.positionId);
                    $('#editPositionForm input[name="positionName"]').val(data
                        .positionName);
                    $('#editPositionForm textarea[name="description"]').val(data
                        .description);
                    $('#modal_edit_' + positionId).modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
        $('#positionTable').on('click', '.edit-button', function() {
            const id = $(this).data('id');
            editOccupation(id);
        });
        $('#editPositionForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editPositionId').val();
            let formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'jabatan/update/' + id,
                data: formData + "&_method=PUT",
                success: function(data) {
                    $('#modal_edit_' + id).modal('hide');
                    $(`#positionTable tbody tr[data-id="${id}"] td:nth-child(1)`).text($(
                        '#updatePositionForm input[name="positionName"]').val());
                    $(`#positionTable tbody tr[data-id="${id}"] td:nth-child(2)`).text($(
                        '#updatePositionForm textarea[name="description"]').val());
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        // Hapus Jabatan
        function confirmDeletePosition(positionId) {
            const url = 'jabatan/hapus/' + positionId;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            ajaxDelete(url, csrfToken);
        }

        $(document).ready(function() {
            addPosition();
        });
    </script>
    <div class="card">
        <div class="card-header d-flex">
            <h5 class="mb-0">Daftar Jabatan</h5>
            <div class="ms-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_default_tabCreate"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Baru</span></button>
            </div>
        </div>
        <table id="positionTable" class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>Nama Jabatan</th>
                    <th>Keterangan</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($position['data']) && is_array($position['data']) && count($position['data']) > 0)
                    @foreach ($position['data'] as $pN)
                        <tr>
                            <td>{{ $pN['positionName'] }}</td>
                            <td>{{ $pN['description'] }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item text-info" data-bs-toggle="modal"
                                                data-bs-target="#modal_detail_{{ $pN['positionId'] }}">
                                                <i class="ph-list me-2"></i>
                                                Detail
                                            </a>
                                            <a href="#" class="dropdown-item text-secondary edit-position"
                                                data-bs-toggle="modal" data-bs-target="#modal_edit_{{ $pN['positionId'] }}"
                                                data-position-id="{{ $pN['positionId'] }}">
                                                <i class="ph-pencil me-2"></i>
                                                Edit
                                            </a>
                                            <a href="#" class="dropdown-item text-danger"
                                                onclick="confirmDeletePosition({{ $pN['positionId'] }})">
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
                        <h5 class="modal-title">Tambah Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="addPositionForm">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Jabatan:</label>
                                    <div class="col-lg-7">
                                        <input type="text" name="positionName" class="form-control"
                                            placeholder="Masukkan Jabatan">
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
        @if (isset($position['data']) && is_array($position['data']) && count($position['data']) > 0)
            @foreach ($position['data'] as $pN)
                <div id="modal_edit_{{ $pN['positionId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Jabatan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="editPositionForm_{{ $pN['positionId'] }}"
                                action="{{ route('position.update', ['id' => $pN['positionId']]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Jabatan:</label>
                                            <div class="col-lg-7">
                                                <input type="text" name="positionName" class="form-control"
                                                    value="{{ $pN['positionName'] }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Keterangan:</label>
                                            <div class="col-lg-7">
                                                <textarea rows="3" cols="3" name="description" class="form-control">{{ $pN['description'] }}</textarea>
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
        @if (isset($position['data']) && is_array($position['data']) && count($position['data']) > 0)
            @foreach ($position['data'] as $pN)
                <div id="modal_detail_{{ $pN['positionId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Pekerjaan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row mb-2">
                                        <label for="detail_position_name"
                                            class="col-lg-4 col-form-label">Pekerjaan:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_position_name"
                                                class="col-form-label">{{ $pN['positionName'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_position_description"
                                            class="col-lg-4 col-form-label">Keterangan:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_position_description"
                                                class="col-form-label">{{ $pN['description'] }}</label>
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
    @if (isset($position['data']) && is_array($position['data']) && count($position['data']) > 0)
        @foreach ($position['data'] as $pN)
            <form id="delete-form-{{ $pN['positionId'] }}" action="{{ route('position.hapus', $pN['positionId']) }}"
                method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @else
    @endif
@endsection
