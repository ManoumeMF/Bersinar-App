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
        // Tambah Jenis Unit Bisnis
        function addBusinessUnitType() {
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
            $("#addBusinessUnitTypeForm").on("submit", function(e) {
                e.preventDefault();
                let businessUnitTypeValue = $("input[name='businessUnitType']").val();
                let descriptionValue = $("textarea[name='description']").val();
                if (businessUnitTypeValue.trim() !== "" && descriptionValue.trim() !== "") {
                    let formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: 'jenis-unit-bisnis/store',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $("#modal_default_tabCreate").modal("hide");
                            $("#addBusinessUnitTypeForm")[0].reset();
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

        // Edit jenis unit bisnis
        function editBusinessUnitType(sbuTypeId) {
            $.ajax({
                type: 'GET',
                url: 'jenis-unit-bisnis/edit/' + sbuTypeId,
                success: function(data) {
                    $('#editBusinessUnitTypeId').val(data.sbuTypeId);
                    $('#editBusinessUnitTypeForm input[name="businessUnitType"]').val(data
                        .positionName);
                    $('#editBusinessUnitTypeForm textarea[name="description"]').val(data
                        .description);
                    $('#modal_edit_' + sbuTypeId).modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
        $('#businessUnitTypeTable').on('click', '.edit-button', function() {
            const id = $(this).data('id');
            editBusinessUnitType(id);
        });
        $('#editBusinessUnitTypeForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editBusinessUnitTypeId').val();
            let formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'jenis-unit-bisnis/update/' + id,
                data: formData + "&_method=PUT",
                success: function(data) {
                    $('#modal_edit_' + id).modal('hide');
                    $(`#businessUnitTypeTable tbody tr[data-id="${id}"] td:nth-child(1)`).text($(
                        '#updatePositionForm input[name="positionName"]').val());
                    $(`#businessUnitTypeTable tbody tr[data-id="${id}"] td:nth-child(2)`).text($(
                        '#updatePositionForm textarea[name="description"]').val());
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        // Hapus jenis unit bisnis
        function confirmDeleteBusinessUnitType(sbuTypeId) {
            const url = 'jenis-unit-bisnis/hapus/' + sbuTypeId;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            ajaxDelete(url, csrfToken);
        }

        $(document).ready(function() {
            addBusinessUnitType();
        });
    </script>
    <div class="card">
        <div class="card-header d-flex">
            <h5 class="mb-0">Daftar Jenis Unit Bisnis</h5>
            <div class="ms-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_default_tabCreate"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Baru</span></button>
            </div>
        </div>
        <table id="businessUnitTypeTable" class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>Jenis Unit Bisnis</th>
                    <th>Keterangan</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($businessUnitType['data']) && is_array($businessUnitType['data']) && count($businessUnitType['data']) > 0)
                    @foreach ($businessUnitType['data'] as $tipeBisnisUnit)
                        <tr>
                            <td>{{ $tipeBisnisUnit['businessUnitType'] }}</td>
                            <td>{{ $tipeBisnisUnit['description'] }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item text-info" data-bs-toggle="modal"
                                                data-bs-target="#modal_detail_{{ $tipeBisnisUnit['sbuTypeId'] }}">
                                                <i class="ph-list me-2"></i>
                                                Detail
                                            </a>
                                            <a href="#" class="dropdown-item text-secondary edit-position"
                                                data-bs-toggle="modal" data-bs-target="#modal_edit_{{ $tipeBisnisUnit['sbuTypeId'] }}"
                                                data-position-id="{{ $tipeBisnisUnit['sbuTypeId'] }}">
                                                <i class="ph-pencil me-2"></i>
                                                Edit
                                            </a>
                                            <a href="#" class="dropdown-item text-danger"
                                                onclick="confirmDeleteBusinessUnitType({{ $tipeBisnisUnit['sbuTypeId'] }})">
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
                    <form id="addBusinessUnitTypeForm">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Jenis Unit Bisnis:</label>
                                    <div class="col-lg-7">
                                        <input type="text" name="businessUnitType" class="form-control"
                                            placeholder="Masukkan Jenis Unit Bisnis">
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
        @if (isset($businessUnitType['data']) && is_array($businessUnitType['data']) && count($businessUnitType['data']) > 0)
            @foreach ($businessUnitType['data'] as $tipeBisnisUnit)
                <div id="modal_edit_{{ $tipeBisnisUnit['sbuTypeId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Jenis Unit Bisnis</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="editBusinessUnitTypeForm_{{ $tipeBisnisUnit['sbuTypeId'] }}"
                                action="{{ route('businessUnitTypes.update', ['id' => $tipeBisnisUnit['sbuTypeId']]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Jenis Unit Bisnis:</label>
                                            <div class="col-lg-7">
                                                <input type="text" name="businessUnitType" class="form-control"
                                                    value="{{ $tipeBisnisUnit['businessUnitType'] }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Keterangan:</label>
                                            <div class="col-lg-7">
                                                <textarea rows="3" cols="3" name="description" class="form-control">{{ $tipeBisnisUnit['description'] }}</textarea>
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
        @if (isset($businessUnitType['data']) && is_array($businessUnitType['data']) && count($businessUnitType['data']) > 0)
            @foreach ($businessUnitType['data'] as $tipeBisnisUnit)
                <div id="modal_detail_{{ $tipeBisnisUnit['sbuTypeId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Jenis Unit Bisnis</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row mb-2">
                                        <label for="detail_businessUnitType_name"
                                            class="col-lg-4 col-form-label">Pekerjaan:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_businessUnitType_name"
                                                class="col-form-label">{{ $tipeBisnisUnit['businessUnitType'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_businessUnitType_description"
                                            class="col-lg-4 col-form-label">Keterangan:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_businessUnitType_description"
                                                class="col-form-label">{{ $tipeBisnisUnit['description'] }}</label>
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
    @if (isset($businessUnitType['data']) && is_array($businessUnitType['data']) && count($businessUnitType['data']) > 0)
        @foreach ($businessUnitType['data'] as $tipeBisnisUnit)
            <form id="delete-form-{{ $tipeBisnisUnit['sbuTypeId'] }}"
                action="{{ route('businessUnitTypes.hapus', $tipeBisnisUnit['sbuTypeId']) }}" method="POST"
                style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @else
    @endif
@endsection
