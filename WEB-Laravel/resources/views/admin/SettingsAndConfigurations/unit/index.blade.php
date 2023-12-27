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
                        targets: [5]
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
            <h5 class="mb-0">Daftar Unit</h5>
            <div class="ms-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_default_tabCreate"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Baru</span></button>
            </div>
        </div>
        <table class="table datatable-basic table-striped" id="unitTable">
            <thead>
                <tr>
                    <th>Unis Bisnis</th>
                    <th>Departemen</th>
                    <th>Parent</th>
                    <th>Unit</th>
                    <th>Keterangan</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($unit['data']) && is_array($unit['data']) && count($unit['data']) > 0)
                    @foreach ($unit['data'] as $ut)
                        <tr>
                            <td>{{ $ut['businessUnitName'] }}</td>
                            <td>{{ $ut['departmentName'] }}</td>
                            <td>{{ $ut['parentUnitName'] }}</td>
                            <td>{{ $ut['unitName'] }}</td>
                            <td>{{ $ut['description'] }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item text-info" data-bs-toggle="modal"
                                                data-bs-target="#modal_detail_{{ $ut['unitId'] }}">
                                                <i class="ph-list me-2"></i>
                                                Detail
                                            </a>
                                            <a href="#" class="dropdown-item text-secondary edit-unit"
                                                data-bs-toggle="modal" data-bs-target="#modal_edit_{{ $ut['unitId'] }}"
                                                data-itemCategory-id="{{ $ut['unitId'] }}">
                                                <i class="ph-pencil me-2"></i>
                                                Edit
                                            </a>
                                            <a href="#" class="dropdown-item text-danger"
                                                onclick="confirmDeleteUnit({{ $ut['unitId'] }})">
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
                        <h5 class="modal-title">Tambah Unit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="addUnitForm">
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
                                    <label class="col-lg-4 col-form-label">Departemen: </label>
                                    <div class="col-lg-7">
                                        @php
                                            $response = Http::get(Config('app.api_url') . 'department/viewAll');
                                            $department = $response->json();
                                        @endphp
                                        <select class="form-control select" data-placeholder="Pilih Departemen"
                                            aria-label="Default select example" name="departmentId">
                                            <option></option>
                                            <optgroup label="Departemen">
                                                @foreach ($department['data'] as $dp)
                                                    <option value="{{ $dp['departmentId'] }}">
                                                        {{ $dp['departmentName'] }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Parent:</label>
                                    <div class="col-lg-7">
                                        <select class="form-control select" data-placeholder="Pilih Parent"
                                            aria-label="Default select example" name="parentUnit">
                                            <option></option>
                                            @php
                                                $response = Http::get(Config('app.api_url') . 'unit/viewCombo');
                                                $unit = $response->json();
                                            @endphp
                                            <optgroup label = "Pilih Parent">
                                                @foreach ($unit['data'] as $parent)
                                                    <option value="{{ $parent['unitId'] }}">
                                                        {{ $parent['parentUnitName'] }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Nama Unit:</label>
                                    <div class="col-lg-7">
                                        <input type="text" name="unitName" class="form-control"
                                            placeholder="Masukkan nama Unit">
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
        @if (isset($unitDetail['data']) && is_array($unitDetail['data']) && count($unitDetail['data']) > 0)
            @foreach ($unitDetail['data'] as $uD)
                <div id="modal_edit_{{ $uD['unitId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Unit</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="editUnitForm_{{ $uD['unitId'] }}"
                                action="{{ route('unit.update', ['id' => $uD['unitId']]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Unit Bisnis:</label>
                                            <div class="col-lg-7">
                                                <select class="form-control select" data-placeholder="Pilih Unit Bisnis"
                                                    aria-label="Default select example" name="businessUnitId">
                                                    <option></option>
                                                    @php
                                                        $response = Http::get(Config('app.api_url') . 'businessUnit/viewAll');
                                                        $businessUnitData = $response->json();
                                                    @endphp
                                                    <optgroup label="Unit Bisnis">
                                                        @foreach ($businessUnitData['data'] as $bUnitData)
                                                            <option value="{{ $bUnitData['businessUnitId'] }}"
                                                                {{ $bUnitData['businessUnitName'] == $uD['businessUnitName'] ? 'selected' : '' }}>
                                                                {{ $bUnitData['businessUnitName'] }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Departemen:</label>
                                            <div class="col-lg-7">
                                                <select class="form-control select" data-placeholder="Pilih Unit Bisnis"
                                                    aria-label="Default select example" name="departmentId">
                                                    <option></option>
                                                    @php
                                                        $response = Http::get(Config('app.api_url') . 'department/viewAll');
                                                        $departmentData = $response->json();
                                                    @endphp
                                                    <optgroup label="Unit Bisnis">
                                                        @foreach ($departmentData['data'] as $dData)
                                                            <option value="{{ $dData['departmentId'] }}"
                                                                {{ $dData['departmentName'] == $uD['departmentName'] ? 'selected' : '' }}>
                                                                {{ $dData['departmentName'] }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Parent Unit:</label>
                                            <div class="col-lg-7">
                                                <select class="form-control select" data-placeholder="Pilih Unit Bisnis"
                                                    aria-label="Default select example" name="parentUnit">
                                                    <option></option>
                                                    @php
                                                        $response = Http::get(Config('app.api_url') . 'unit/viewCombo');
                                                        $parentUnitData = $response->json();
                                                    @endphp
                                                    <optgroup label="Parent Unit">
                                                        @foreach ($parentUnitData['data'] as $pUnitData)
                                                            <option value="{{ $pUnitData['unitId'] }}"
                                                                {{ $pUnitData['parentUnitName'] == $uD['parentUnitName'] ? 'selected' : '' }}>
                                                                {{ $pUnitData['parentUnitName'] }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Unit:</label>
                                            <div class="col-lg-7">
                                                <input type="text" name="unitName" class="form-control"
                                                    value="{{ $uD['unitName'] }}">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Keterangan:</label>
                                            <div class="col-lg-7">
                                                <textarea rows="3" cols="3" name="description" class="form-control">{{ $uD['description'] }}</textarea>
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
        @if (isset($unitDetail['data']) && is_array($unitDetail['data']) && count($unitDetail['data']) > 0)
            @foreach ($unitDetail['data'] as $uD)
                <div id="modal_detail_{{ $uD['unitId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Unit</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row mb-2">
                                        <label for="detail_businessUnit_name" class="col-lg-4 col-form-label">Unit Bisnis
                                            :</label>
                                        <div class="col-lg-7">
                                            <label id="detail_businessUnit_name" class="col-form-label">
                                                {{ $uD['businessUnitName'] }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_department_name" class="col-lg-4 col-form-label">Departemen
                                            :</label>
                                        <div class="col-lg-7">
                                            <label id="detail_department_name" class="col-form-label">
                                                {{ $uD['departmentName'] }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_parentUnit_name" class="col-lg-4 col-form-label">Parent Unit
                                            :</label>
                                        <div class="col-lg-7">
                                            <label id="detail_parentUnit_name" class="col-form-label">
                                                {{ $uD['parentUnitName'] }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_unit_name" class="col-lg-4 col-form-label">Unit
                                            :</label>
                                        <div class="col-lg-7">
                                            <label id="detail_unit_name" class="col-form-label">
                                                {{ $uD['unitName'] }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_unit_description"
                                            class="col-lg-4 col-form-label">Keterangan:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_unit_description"
                                                class="col-form-label">{{ $uD['description'] }}</label>
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
        // Add Unit
        function addUnit() {
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
            $("#addUnitForm").on("submit", function(e) {
                e.preventDefault();
                let businessUnitIdValue = $("select[name='businessUnitId']").val();
                let departmentIdValue = $("select[name='departmentId']").val();
                let parentUnitValue = $("select[name='parentUnit']").val();
                let unitNameValue = $("input[name='unitName']").val();
                let descriptionValue = $("textarea[name='description']").val();
                if (businessUnitIdValue.trim() !== "" &&
                    departmentIdValue.trim() !== "" &&
                    parentUnitValue.trim() !== "" &&
                    unitNameValue.trim() !== "" &&
                    descriptionValue.trim() !== "") {
                    let formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: 'unit/store',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $("#modal_default_tabCreate").modal("hide");
                            $("#addUnitForm")[0].reset();
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

        // Edit Unit
        function editUnit(unitId) {
            $.ajax({
                type: 'GET',
                url: 'unit/edit/' + unitId,
                success: function(data) {
                    $('#editunitId').val(data.unitId);
                    $('#editUnitForm_ select[name="businessUnitName"]').val(data
                        .businessUnitName);
                    $('#editUnitForm_ select[name="departmentName"]').val(data
                        .departmentName);
                    $('#editUnitForm_ select[name = "parentUnit"]').val(data.parentUnit);
                    $('#editUnitForm_ input[name = "unitName"]').val(data.unitName);
                    $('#editUnitForm_ textarea[name="description"]').val(data
                        .description);
                    $('#modal_edit_' + unitId).modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
        $('#UnitTable').on('click', '.edit-button', function() {
            const id = $(this).data('id');
            editUnit(id);
        });

        $('#editUnitForm_').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editUnitId').val();
            let formData = $(this).serialize();
            console.log("Form Data:", formData);
            $.ajax({
                type: 'POST',
                url: 'unit/update/' + id,
                data: formData + "&_method=PUT",
                success: function(data) {
                    $('#modal_edit_' + id).modal('hide');
                    $(`#unitTable tbody tr[data-id="${id}"] td:nth-child(1)`).text($(
                        '#updateUnitForm select[name="businessUnitName"]').val());
                    $(`#unitTable tbody tr[data-id="${id}"] td:nth-child(1)`).text($(
                        '#updateUnitForm select[name="departmentName"]').val());
                    $(`#unitTable tbody tr[data-id="${id}"] td:nth-child(1)`).text($(
                        '#updateUnitForm select[name="parentUnit"]').val());
                    $(`#unitTable tbody tr[data-id="${id}"] td:nth-child(2)`).text($(
                        '#updateUnitForm input[name="unitName"]').val());
                    $(`#unittTable tbody tr[data-id="${id}"] td:nth-child(3)`).text($(
                        '#updateUnitForm textarea[name="description"]').val());
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        // Delete Unit
        function confirmDeleteUnit(unitId) {
            const url = 'unit/delete/' + unitId;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            ajaxDelete(url, csrfToken);
        }

        $(document).ready(function() {
            addUnit();
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

@endsection
