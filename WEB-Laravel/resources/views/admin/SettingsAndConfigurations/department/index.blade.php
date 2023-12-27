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
        // Add Department
        function addDepartment() {
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
            $("#addDepartmentForm").on("submit", function(e) {
                e.preventDefault();
                let businessUnitNameValue = $("select[name='businessUnitId']").val();
                let departmentNameValue = $("input[name='departmentName']").val();
                let descriptionValue = $("textarea[name='description']").val();
                if (businessUnitNameValue.trim() !== "" && departmentNameValue.trim() !== "" && descriptionValue
                    .trim() !== "") {
                    let formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: 'departemen/store',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $("#modal_default_tabCreate").modal("hide");
                            $("#addDepartmentForm")[0].reset();
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

        // Edit Department
        function editDepartment(departmentId) {
            $.ajax({
                type: 'GET',
                url: 'departemen/edit/' + departmentId,
                success: function(data) {
                    $('#editDepartmentId').val(data.departmentId);
                    $('#editDepartmentForm_ select[name="businessUnitId"]').val(data
                        .businessUnitId);
                    $('#editDepartmentForm_ input[name="departmentName"]').val(data
                        .departmentName);
                    $('#editDepartmentForm_ textarea[name="description"]').val(data
                        .description);
                    $('#modal_edit_' + departmentId).modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
        $('#departmentTable').on('click', '.edit-button', function() {
            const id = $(this).data('id');
            editDepartment(id);
        });

        $('#editDepartmentForm_').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editDepartmentId').val();
            let formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'departemen/update/' + id,
                data: formData + "&_method=PUT",
                success: function(data) {
                    $('#modal_edit_' + id).modal('hide');
                    $(`#departmentTable tbody tr[data-id="${id}"] td:nth-child(1)`).text($(
                        '#updateDepartmentForm select[name="businessUnitId"]').val());
                    $(`#departmentTable tbody tr[data-id="${id}"] td:nth-child(2)`).text($(
                        '#updateDepartmentForm input[name="departmentName"]').val());
                    $(`#departmentTable tbody tr[data-id="${id}"] td:nth-child(3)`).text($(
                        '#updateDepartmentForm textarea[name="description"]').val());
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        // Delete Departemen
        function confirmDeleteDepartment(departmentId) {
            const url = 'departemen/hapus/' + departmentId;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            ajaxDelete(url, csrfToken);
        }

        $(document).ready(function() {
            addDepartment();
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
            <h5 class="mb-0">Daftar Departemen</h5>
            <div class="ms-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_default_tabCreate"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Baru</span></button>
            </div>
        </div>
        <table id="departmentTable" class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>Unis Bisnis</th>
                    <th>Nama Departemen</th>
                    <th>Keterangan</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($department['data']) && is_array($department['data']) && count($department['data']) > 0)
                    @foreach ($department['data'] as $dT)
                        <tr>
                            <td>
                                {{ $dT['businessUnitData']['businessUnitName'] }}
                            </td>
                            <td>{{ $dT['departmentName'] }}</td>
                            <td>{{ $dT['description'] }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item text-info" data-bs-toggle="modal"
                                                data-bs-target="#modal_detail_{{ $dT['departmentId'] }}">
                                                <i class="ph-list me-2"></i>
                                                Detail
                                            </a>
                                            <a href="#" class="dropdown-item text-secondary edit-department"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal_edit_{{ $dT['departmentId'] }}"
                                                data-department-id="{{ $dT['departmentId'] }}">
                                                <i class="ph-pencil me-2"></i>
                                                Edit
                                            </a>
                                            <a href="#" class="dropdown-item text-danger"
                                                onclick="confirmDeleteDepartment({{ $dT['departmentId'] }})">
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
                        <h5 class="modal-title">Tambah Department</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="addDepartmentForm">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Unit Bisnis: </label>
                                    <div class="col-lg-7">
                                        @php
                                            $response = Http::get(Config('app.api_url') . 'businessUnit/viewAll');
                                            $businessUnit = $response->json();
                                        @endphp
                                        <select class="form-control select" data-placeholder="Pilih Unit Bisnis"
                                            aria-label="Default select example" name="businessUnitId">
                                            <option></option>
                                            <optgroup label="Unit Bisnis">
                                                @foreach ($businessUnit['data'] as $bU)
                                                    <option value="{{ $bU['businessUnitId'] }}">
                                                        {{ $bU['businessUnitName'] }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Nama Departemen:</label>
                                    <div class="col-lg-7">
                                        <input type="text" name="departmentName" class="form-control"
                                            placeholder="Masukkan Departemen">
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
        @if (isset($department['data']) && is_array($department['data']) && count($department['data']) > 0)
            @foreach ($department['data'] as $dT)
                <div id="modal_edit_{{ $dT['departmentId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Departemen</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="editDepartmentForm_{{ $dT['departmentId'] }}"
                                action="{{ route('department.update', ['id' => $dT['departmentId']]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Pilih Unit Bisnis:</label>
                                            <div class="col-lg-7">
                                                <select class="form-control select" data-placeholder="Pilih Unit Bisnis"
                                                    aria-label="Default select example" name="businessUnitId">
                                                    <option></option>
                                                    @php
                                                        $response = Http::get(Config('app.api_url') . 'businessUnit/viewAll');
                                                        $businessUnit = $response->json();
                                                    @endphp
                                                    <optgroup label="Unit Bisnis">
                                                        @foreach ($businessUnit['data'] as $bU)
                                                            <option value="{{ $bU['businessUnitId'] }}"
                                                                {{ $bU['businessUnitId'] == $dT['businessUnitId'] ? 'selected' : '' }}>
                                                                {{ $bU['businessUnitName'] }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Nama Departemen:</label>
                                            <div class="col-lg-7">
                                                <input type="text" name="departmentName" class="form-control"
                                                    value="{{ $dT['departmentName'] }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Keterangan:</label>
                                            <div class="col-lg-7">
                                                <textarea rows="3" cols="3" name="description" class="form-control">{{ $dT['description'] }}</textarea>
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
        @if (isset($department['data']) && is_array($department['data']) && count($department['data']) > 0)
            @foreach ($department['data'] as $dT)
                <div id="modal_detail_{{ $dT['departmentId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Departemen</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row mb-2">
                                        <label for="detail_businessUnit_name" class="col-lg-4 col-form-label">Unit Bisnis
                                            :</label>
                                        <div class="col-lg-7">
                                            <label id="detail_businessUnit_name" class="col-form-label">
                                                {{ $dT['businessUnitData']['businessUnitName'] }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_department_name" class="col-lg-4 col-form-label">Nama Departemen:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_department_name"
                                                class="col-form-label">{{ $dT['departmentName'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_department_description"
                                            class="col-lg-4 col-form-label">Keterangan:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_department_description"
                                                class="col-form-label">{{ $dT['description'] }}</label>
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
    @if (isset($department['data']) && is_array($department['data']) && count($department['data']) > 0)
        @foreach ($department['data'] as $dT)
            <form id="delete-form-{{ $dT['departmentId'] }}"
                action="{{ route('department.delete', $dT['departmentId']) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @else
    @endif
@endsection
