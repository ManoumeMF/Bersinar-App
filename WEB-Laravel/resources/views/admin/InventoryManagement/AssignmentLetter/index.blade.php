@extends('layouts.admin.template')
@section('content')
    <script>
        // Setup module
        // ------------------------------

        var DateTimePickers = function() {


            //
            // Setup module components
            //

            // Daterange picker
            const _componentDaterange = function() {
                if (!$().daterangepicker) {
                    console.warn('Warning - daterangepicker.js is not loaded.');
                    return;
                }

                // Basic initialization
                $('.daterange-basic').daterangepicker({
                    parentEl: '.content-inner'
                });
                $('.daterange-time').daterangepicker({
                    parentEl: '.content-inner',
                    timePicker: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
                $('.daterange-increments').daterangepicker({
                    parentEl: '.content-inner',
                    timePicker: true,
                    timePickerIncrement: 10,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

            };

            // Date picker
            const _componentDatepicker = function() {
                if (typeof Datepicker == 'undefined') {
                    console.warn('Warning - datepicker.min.js is not loaded.');
                    return;
                }

                // Hide on selection
                const dpAutoHideElement = document.querySelector('.datepicker-autohide');
                if (dpAutoHideElement) {
                    const dpAutoHide = new Datepicker(dpAutoHideElement, {
                        container: '.content-inner',
                        buttonClass: 'btn',
                        prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                        nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                        autohide: true,
                        format: 'yyyy-mm-dd'
                    });
                }

                const dpAutoHideElement2 = document.querySelector('.datepicker-autohide2');
                if (dpAutoHideElement2) {
                    const dpAutoHide = new Datepicker(dpAutoHideElement2, {
                        container: '.content-inner',
                        buttonClass: 'btn',
                        prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                        nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                        autohide: true,
                        format: 'yyyy-mm-dd'
                    });
                }

            };


            //
            // Return objects assigned to module
            //

            return {
                init: function() {
                    _componentDaterange();
                    _componentDatepicker();
                }
            }
        }();


        // Initialize module
        // ------------------------------

        document.addEventListener('DOMContentLoaded', function() {
            DateTimePickers.init();
        });
    </script>
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
    <script>
        // Edit assignmentLetter
        function editassignmentLetter(assignmentId) {
            $.ajax({
                type: 'GET',
                url: 'surat-jalan/edit/' + assignmentId,
                success: function(data) {
                    $('#editassignmentLetterId').val(data.data.assignmentId);
                    $('#editassignmentLetterForm input[name="assignmentLetterNum"]').val(data
                        .assignmentLetterNum);
                    $('#editassignmentLetterForm select[name="businessUnitId"]').val(data
                        .businessUnitId);
                    $('#editassignmentLetterForm input[name="dateCreated"]').val(data
                        .dateCreated);
                    $('#editassignmentLetterForm input[name="expiredDate"]').val(data
                        .expiredDate);
                    $('#editassignmentLetterForm select[name="assignedTo"]').val(data
                        .assignedTo);
                    $('#editassignmentLetterForm select[name="vehicleTypeId"]').val(data
                        .vehicleTypeId);
                    $('#editassignmentLetterForm input[name="vehicleRegistrationNumber"]').val(data
                        .vehicleRegistrationNumber);
                    $('#editassignmentLetterForm input[name="needFor"]').val(data
                        .needFor);
                    $('#editassignmentLetterForm select[name="createBy"]').val(data
                        .createBy);
                    $('#modal_edit_' + assignmentId).modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
        $('#assignmentLetterTable').on('click', '.edit-button', function() {
            const id = $(this).data('id');
            editassignmentLetter(id);
        });

        // Update assignmentLetter
        $('#editassignmentLetterForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editassignmentLetterId').val();
            let formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'surat-jalan/update/' + id,
                data: formData + "&_method=PUT",
                success: function(data) {
                    $('#modal_edit_' + id).modal('hide');
                    $(`#assignmentLetterTable tbody tr[data-id="${id}"] td:nth-child(1)`).text($(
                        '#updateassignmentLetterForm input[name="assignmentLetterNum"]').val());
                    $(`#assignmentLetterTable tbody tr[data-id="${id}"] td:nth-child(2)`).text($(
                        '#updateassignmentLetterForm select[name="businessUnitId"]').val());
                    $(`#assignmentLetterTable tbody tr[data-id="${id}"] td:nth-child(3)`).text($(
                        '#updateassignmentLetterForm input[name="dateCreated"]').val());
                    $(`#assignmentLetterTable tbody tr[data-id="${id}"] td:nth-child(4)`).text($(
                        '#updateassignmentLetterForm input[name="expiredDate"]').val());
                    $(`#assignmentLetterTable tbody tr[data-id="${id}"] td:nth-child(5)`).text($(
                        '#updateassignmentLetterForm select[name="assignedTo"]').val());
                    $(`#assignmentLetterTable tbody tr[data-id="${id}"] td:nth-child(6)`).text($(
                        '#updateassignmentLetterForm select[name="vehicleTypeId"]').val());
                    $(`#assignmentLetterTable tbody tr[data-id="${id}"] td:nth-child(7)`).text($(
                            '#updateassignmentLetterForm input[name="vehicleRegistrationNumber"]')
                        .val());
                    $(`#assignmentLetterTable tbody tr[data-id="${id}"] td:nth-child(8)`).text($(
                        '#updateassignmentLetterForm input[name="needFor"]').val());
                    $(`#assignmentLetterTable tbody tr[data-id="${id}"] td:nth-child(9)`).text($(
                        '#updateassignmentLetterForm select[name="createBy"]').val());


                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });
    </script>
    <div class="card">
        <div class="card-header d-flex">
            <h5 class="mb-0">Daftar Surat Jalan</h5>
            <div class="ms-auto">
                <a class="btn btn-primary" href="{{ route('assignment.create') }}"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Baru</span></a>
            </div>
        </div>
        <table id="identityTable" class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>No. Surat Jalan</th>
                    <th>Tanggal dibuat</th>
                    <th>Ditugaskan kepada</th>
                    <th>Tanggal berlaku</th>
                    <th>Dibuat oleh</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assignmentletter['data'] as $al)
                    <tr>
                        <td>{{ $al['assignmentLetter'] }}</td>
                        <td>{{ $al['dateCreated'] }}</td>
                        <td>{{ $al['employeeName'] }}</td>
                        <td>{{ $al['expiredDate'] }}</td>
                        <td>{{ $al['createdBy'] }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex">
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#" class="dropdown-item text-info" data-bs-toggle="modal"
                                            data-bs-target="#modal_detail_{{ $al['assignmentId'] }}">
                                            <i class="ph-list me-2"></i>
                                            Detail
                                        </a>
                                        <a href="#" class="dropdown-item text-secondary" data-bs-toggle="modal"
                                            data-bs-target="#modal_edit_{{ $al['assignmentId'] }}">
                                            <i class="ph-pencil me-2"></i>
                                            Edit
                                        </a>
                                        <a href="#" class="dropdown-item text-danger">
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
        {{-- Edit Modal --}}
        @if (isset($assignmentletter['data']) && is_array($assignmentletter['data']) && count($assignmentletter['data']) > 0)
            @foreach ($assignmentletter['data'] as $al)
                <div id="modal_edit_{{ $al['assignmentId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Surat Jalan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="editassignmentLetterForm_{{ $al['assignmentId'] }}"
                                action="{{ route('assignment.update', ['id' => $al['assignmentId']]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">No. Surat Jalan:</label>
                                            <div class="col-lg-7">
                                                <input type="text" name="assignmentLetterNum" class="form-control"
                                                    value="{{ $al['assignmentLetter'] }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Pilih Unit Bisnis:</label>
                                            <div class="col-lg-7">
                                                <select class="form-control select" data-placeholder="Pilih Unit Bisnis"
                                                    aria-label="Default select example" name="businessUnitId">
                                                    @php
                                                        $response = Http::get(Config('app.api_url') . 'businessUnit/viewAll');
                                                        $bisnisUnit = $response->json();
                                                    @endphp
                                                    <div class="input-group">
                                                        <select class="form-control select" name="businessUnitId"
                                                            data-placeholder="Pilih Unit Bisnis" data-width="1%">
                                                            <option></option>
                                                            <optgroup label="Unit Bisnis">
                                                                @foreach ($bisnisUnit['data'] as $bU)
                                                                    <option value="{{ $bU['businessUnitId'] }}"
                                                                        {{ $bU['businessUnitId'] == $al['businessUnitId'] ? 'selected' : '' }}>
                                                                        {{ $bU['businessUnitName'] }}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                </select>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-lg-4 col-form-label">Tanggal Dibuat:</label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <input id="tanggal-kirim" type="text"
                                                            class="form-control datepicker-autohide"
                                                            value="{{ $al['dateCreated'] }}" name="dateCreated" required>
                                                        <span class="input-group-text">
                                                            <i class="ph-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-lg-4 col-form-label">Tanggal Berlaku:</label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <input id="tanggal-kirim" type="text"
                                                            class="form-control datepicker-autohide2"
                                                            value="{{ $al['expiredDate'] }}" name="expiredDate"required>
                                                        <span class="input-group-text">
                                                            <i class="ph-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-lg-4 col-form-label">Pilih Petugas:</label>
                                                <div class="col-lg-7">
                                                    <select class="form-control select" data-placeholder="Pilih Petugas"
                                                        aria-label="Default select example" name="assignedTo">
                                                        <option></option>
                                                        @php
                                                            $response = Http::get(Config('app.api_url') . 'employeePersonal/viewAll');
                                                            $assignedTo = $response->json();
                                                        @endphp
                                                        <optgroup>
                                                            @foreach ($assignedTo['data'] as $aT)
                                                                <option value="{{ $aT['employeeId'] }}"
                                                                    {{ isset($al['assignedTo']) && $aT['employeeId'] == $al['assignedTo'] ? 'selected' : '' }}>
                                                                    {{ $aT['employeeName'] }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-lg-4 col-form-label">Pilih Jenis Kendaraan:</label>
                                                <div class="col-lg-7">
                                                    <select class="form-control select"
                                                        data-placeholder="Pilih Jenis Kendaraan"
                                                        aria-label="Default select example" name="vehicleTypeId">
                                                        <option></option>
                                                        @php
                                                            $response = Http::get(Config('app.api_url') . 'vehicleType/viewAll');
                                                            $vehicleType = $response->json();
                                                        @endphp
                                                        <optgroup>
                                                            @foreach ($vehicleType['data'] as $vt)
                                                                <option value="{{ $vt['vehicleTypeId'] }}"
                                                                    {{ isset($al['vehicleTypeId']) && $vt['vehicleTypeId'] == $al['vehicleTypeId'] ? 'selected' : '' }}>
                                                                    {{ $vt['vehicleTypeName'] }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-lg-4 col-form-label">Nomor Polisi Kendaraan:</label>
                                                <div class="col-lg-7">
                                                    <input type="text" name="vehicleRegistrationNumber"
                                                        class="form-control"
                                                        value="{{ isset($al['vehicleRegistrationNumber']) }}">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-lg-4 col-form-label">Keperluan:</label>
                                                <div class="col-lg-7">
                                                    <input type="text" name="needFor" class="form-control"
                                                        value="{{ isset($al['needFor']) }}">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-lg-4 col-form-label">Ditugaskan Kepada:</label>
                                                <div class="col-lg-7">
                                                    <select class="form-control select"
                                                        data-placeholder="Ditugaskan Kepada"
                                                        aria-label="Default select example" name="createBy">
                                                        <option></option>
                                                        @php
                                                            $response = Http::get(Config('app.api_url') . 'employeePersonal/viewAll');
                                                            $createBy = $response->json();
                                                        @endphp
                                                        <optgroup>
                                                            @foreach ($createBy['data'] as $cB)
                                                                <option value="{{ $cB['employeeId'] }}"
                                                                    {{ isset($al['createBy']) && $cB['employeeId'] == $al['createBy'] ? 'selected' : '' }}>
                                                                    {{ $cB['employeeName'] }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-danger"
                                            data-bs-dismiss="modal">Batal</button>
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
        @if (isset($assignmentletter['data']) && is_array($assignmentletter['data']) && count($assignmentletter['data']) > 0)
            @foreach ($assignmentletter['data'] as $al)
                <div id="modal_detail_{{ $al['assignmentId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Surat Jalan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    {{-- <div class="row mb-2">
                                        <label for="detail_businessUnit_name" class="col-lg-4 col-form-label">Unit Bisnis
                                            :</label>
                                        <div class="col-lg-7">
                                            <label id="detail_businessUnit_name" class="col-form-label">
                                                {{ $al['businessUnitData']['businessUnitName'] }}
                                            </label>
                                        </div>
                                    </div> --}}
                                    <div class="row mb-2">
                                        <label for="detail_assignmentLetter_name" class="col-lg-4 col-form-label">No.
                                            Surat Jalan:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_assignmentLetter_name"
                                                class="col-form-label">{{ $al['assignmentLetter'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_dateCreated_name" class="col-lg-4 col-form-label">Tanggal
                                            Dibuat:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_dateCreated_name"
                                                class="col-form-label">{{ $al['dateCreated'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_expiredDate_name" class="col-lg-4 col-form-label">Tanggal
                                            Berlaku:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_expiredDate_name"
                                                class="col-form-label">{{ $al['expiredDate'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_employeeName_name" class="col-lg-4 col-form-label">Nama
                                            Petugas:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_employeeName_name"
                                                class="col-form-label">{{ $al['employeeName'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_employeeName_name" class="col-lg-4 col-form-label">Nama
                                            Petugas:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_employeeName_name"
                                                class="col-form-label">{{ $al['employeeName'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_createdBy_name" class="col-lg-4 col-form-label">Dibuat
                                            Oleh:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_createdBy_name"
                                                class="col-form-label">{{ $al['createdBy'] }}</label>
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
@endsection
