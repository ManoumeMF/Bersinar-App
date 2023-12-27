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
        // Tambah bloodtype
        function addBloodType() {
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
            $("#addBloodTypeForm").on("submit", function(e) {
                e.preventDefault();
                let bloodTypeNameValue = $("input[name='bloodTypeName']").val();
                let descriptionValue = $("textarea[name='description']").val();
                if (bloodTypeNameValue.trim() !== "" && descriptionValue.trim() !== "") {
                    let formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: 'golongan-darah',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $("#modal_default_tabCreate").modal("hide");
                            $("#addBloodTypeForm")[0].reset();
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

        // Edit bloodtype
        function editBloodType(bloodTypeId) {
            $.ajax({
                type: 'GET',
                url: 'golongan-darah/edit/' + bloodTypeId,
                success: function(data) {
                    $('#editBloodTypeId').val(data.bloodTypeId);
                    $('#editBloodTypeForm input[name="bloodTypeName"]').val(data
                        .bloodTypeName);
                    $('#editBloodTypeForm textarea[name="description"]').val(data
                        .description);
                    $('#modal_edit_' + bloodTypeId).modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
        $('#bloodTypeTable').on('click', '.edit-button', function() {
            const id = $(this).data('id');
            editBloodType(id);
        });

        // Update bloodtype
        $('#editBloodTypeForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editBloodTypeId').val();
            let formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'golongan-darah/update/' + id,
                data: formData + "&_method=PUT",
                success: function(data) {
                    $('#modal_edit_' + id).modal('hide');
                    $(`#bloodTypeTable tbody tr[data-id="${id}"] td:nth-child(1)`).text($(
                        '#updateBloodTypeForm input[name="bloodTypeName"]').val());
                    $(`#bloodTypeTable tbody tr[data-id="${id}"] td:nth-child(2)`).text($(
                        '#updateBloodTypeForm textarea[name="description"]').val());
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        // Hapus bloodtype
        function confirmDeleteBloodType(bloodTypeId) {
            const url = 'golongan-darah/delete/' + bloodTypeId;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            ajaxDelete(url, csrfToken);
        }
        $(document).ready(function() {
            addBloodType();
        });
    </script>


    <div class="card">
        <div class="card-header d-flex">
            <h5 class="mb-0">Daftar Golongan Darah</h5>
            <div class="ms-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_default_tabCreate"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Baru</span></button>
            </div>
        </div>
        <table id="bloodTypeTable" class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>Golongan Darah</th>
                    <th>Keterangan</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bloodTypes['data'] as $bt)
                    <tr>
                        <td>{{ $bt['bloodTypeName'] }}</td>
                        <td>{{ $bt['description'] }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex">
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#" class="dropdown-item text-info" data-bs-toggle="modal"
                                            data-bs-target="#modal_detail_{{ $bt['bloodTypeId'] }}">
                                            <i class="ph-list me-2"></i>
                                            Detail
                                        </a>
                                        <a href="#" class="dropdown-item text-secondary edit-blood-type"
                                            data-bs-toggle="modal" data-bs-target="#modal_edit_{{ $bt['bloodTypeId'] }}"
                                            data-blood-type-id="{{ $bt['bloodTypeId'] }}">
                                            <i class="ph-pencil me-2"></i>
                                            Edit
                                        </a>
                                        <a href="#" class="dropdown-item text-danger"
                                            onclick="confirmDeleteBloodType({{ $bt['bloodTypeId'] }})">
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
                        <h5 class="modal-title">Tambah Golongan Darah</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="addBloodTypeForm">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Golongan Darah:</label>
                                    <div class="col-lg-7">
                                        <input type="text" name="bloodTypeName" class="form-control"
                                            placeholder="Masukkan Golongan Darah">
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
        @foreach ($bloodTypes['data'] as $bt)
            <div id="modal_edit_{{ $bt['bloodTypeId'] }}" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Golongan Darah</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form id="editBloodTypeForm_{{ $bt['bloodTypeId'] }}"
                            action="{{ route('bloodType.update', ['id' => $bt['bloodTypeId']]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row mb-2">
                                        <label class="col-lg-4 col-form-label">Golongan Darah:</label>
                                        <div class="col-lg-7">
                                            <input type="text" name="bloodTypeName" class="form-control"
                                                value="{{ $bt['bloodTypeName'] }}">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-lg-4 col-form-label">Keterangan:</label>
                                        <div class="col-lg-7">
                                            <textarea rows="3" cols="3" name="description" class="form-control">{{ $bt['description'] }}</textarea>
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

        {{-- Detail Modal --}}
        @foreach ($bloodTypes['data'] as $bt)
            <div id="modal_detail_{{ $bt['bloodTypeId'] }}" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Golongan Darah</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row mb-2">
                                    <label for="detail_bloodType_name" class="col-lg-4 col-form-label">Golongan
                                        Darah:</label>
                                    <div class="col-lg-7">
                                        <label id="detail_bloodType_name"
                                            class="col-form-label">{{ $bt['bloodTypeName'] }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="detail_bloodType_description"
                                        class="col-lg-4 col-form-label">Keterangan:</label>
                                    <div class="col-lg-7">
                                        <label id="detail_bloodType_description"
                                            class="col-form-label">{{ $bt['description'] }}</label>
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
    </div>
    {{-- @foreach ($bloodTypes['data'] as $bt)
        <form id="delete-form-{{ $bt['bloodTypeId'] }}" action="{{ route('bloodType.delete', $bt['bloodTypeId']) }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endforeach --}}
@endsection
