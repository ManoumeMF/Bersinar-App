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
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Surat Jalan</h5>
        </div>
        <div class="card-body border-top">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <form action="{{ route('assignment.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3 justify-content-center">
                            <label class="col-sm-3 col-form-label">No. Surat Jalan:</label>
                            <div class="col-sm-7">
                                <input type="text" name="assignmentLetterNum" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-sm-3 col-form-label">Unit Bisnis: </label>
                            <div class="col-lg-7">
                                @php
                                    $response = Http::get(Config('app.api_url') . 'businessUnit/viewAll');
                                    $businessUnit = $response->json();
                                @endphp
                                <select class="form-control select" data-placeholder="Pilih Unit Bisnis"
                                    aria-label="Default select example" name="businessUnitId" required>
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
                        <div class="row mb-3 justify-content-center">
                            <label class="col-sm-3 col-form-label">Tanggal Dibuat:</label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <input id="tanggal-kirim" type="text" class="form-control datepicker-autohide"
                                        placeholder="23-03-2023" name="dateCreated" required>
                                    <span class="input-group-text">
                                        <i class="ph-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-sm-3 col-form-label">Tanggal Berlaku:</label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <input id="tanggal-kirim" type="text" class="form-control datepicker-autohide2"
                                        placeholder="23-03-2023" name="expiredDate"required>
                                    <span class="input-group-text">
                                        <i class="ph-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-sm-3 col-form-label">Ditugaskan Kepada:</label>
                            <div class="col-sm-7">
                                @php
                                    $response = Http::get(config('app.api_url') . 'employeePersonal/viewAll');
                                    $pegawai = $response->json();
                                @endphp
                                <div class="input-group">
                                    <select data-placeholder="Pilih Petugas" class="form-control select" name="assignedTo"
                                        required>
                                        <option></option>
                                        <optgroup label="pegawai">
                                            @foreach ($pegawai['data'] as $pg)
                                                <option value="{{ $pg['employeeId'] }}">
                                                    {{ $pg['employeeName'] }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-sm-3 col-form-label">Jenis Kendaraan Yang Digunakan:</label>
                            <div class="col-sm-7">
                                @php
                                    $response = Http::get(config('app.api_url') . 'vehicleType/viewAll');
                                    $kendaraan = $response->json();
                                @endphp
                                <div class="input-group">
                                    <select data-placeholder="Pilih Jenis Kendaraan" class="form-control select"
                                        name="vehicleTypeId" required>
                                        <option></option>
                                        <<optgroup label="kendaraan">
                                            @foreach ($kendaraan['data'] as $kn)
                                                <option value="{{ $kn['vehicleTypeId'] }}">
                                                    {{ $kn['vehicleTypeName'] }}
                                                </option>
                                            @endforeach
                                            </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-sm-3 col-form-label">Nomor Polisi Kendaraan:</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control"
                                    placeholder="Masukkan Nomor Polisi Kendaraan"name="vehicleRegistrationNumber" required>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-sm-3 col-form-label">Keperluan:</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" placeholder="Masukkan Keperluan" name="needFor"
                                    required>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-sm-3 col-form-label">Ditugaskan Kepada:</label>
                            <div class="col-sm-7">
                                @php
                                    $response = Http::get(config('app.api_url') . 'employeePersonal/viewAll');
                                    $pegawai = $response->json();
                                @endphp
                                <div class="input-group">
                                    <select data-placeholder="Masukkan nama petugas" class="form-control select" name="createBy"
                                        required>
                                        <option></option>
                                        <optgroup label="pegawai">
                                            @foreach ($pegawai['data'] as $pg)
                                                <option value="{{ $pg['employeeId'] }}">
                                                    {{ $pg['employeeName'] }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-11 text-end mb-5">
                                <button type="submit" class="btn btn-primary ms-2">Simpan<i
                                        class="ph-check-circle ms-2"></i></button>
                                <button type="reset" class="btn btn-danger">Batal<i class="ph-x-circle ms-2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
