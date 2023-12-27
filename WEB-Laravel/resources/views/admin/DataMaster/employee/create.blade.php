@extends('layouts.admin.template')
@section('content')
    <script>
        $(document).ready(function() {
            // Your existing Select2 initialization
            $('.select').each(function() {
                if ($(this).closest('.modal').length) {
                    // If the Select2 element is inside a modal
                    $(this).select2({
                        dropdownParent: $(this).closest('.modal')
                    });
                } else {
                    // If the Select2 element is not inside a modal
                    $(this).select2();
                }
            });
        });
    </script>
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
    <!-- Basic layout -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Pegawai</h5>
        </div>
        <div class="container mt-3 mx-auto">
            <div class="row">
                <div class="d-lg-flex">
                    <style>
                        @media (min-width: 992px) {
                            .nav-tabs-vertical {
                                position: absolute;
                                top: 75px;
                                left: 10px;
                                margin: 0;
                                border-right: none;
                            }

                            .nav-tabs-vertical~.tab-content {
                                margin-left: 200px;
                            }

                            .nav-tabs-vertical .nav-item {
                                width: 100%;
                            }

                            .nav-tabs-vertical .nav-link {
                                border-radius: 0;
                                /* border: none; */
                                text-align: left;
                            }
                        }
                    </style>
                    <ul class="nav nav-tabs nav-tabs-vertical nav-tabs-vertical-start wmin-lg-200 me-lg-3 mb-3 mb-lg-0">
                        <li class="nav-item">
                            <a href="#vertical-left-tab1" class="nav-link active" data-bs-toggle="tab">
                                <i class="ph ph-user me-2"></i> Data Pribadi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#vertical-left-tab2" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-address-book me-2"></i>
                                Alamat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#vertical-left-tab3" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-thin ph-identification-card me-2"></i>
                                Identitas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#vertical-left-tab4" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-thin ph-hard-drives me-2"></i>
                                Data Kepegawaian
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#vertical-left-tab5" class="nav-link" data-bs-toggle="tab">
                                <i class="ph ph-bank me-2"></i>
                                Rekening
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content flex-lg-fill">
                        <div class="tab-pane fade show active" id="vertical-left-tab1">
                            <form action="{{ route('employeePersonal.store') }}" method="POST"
                                enctype="multipart/form-data">
                                {{-- <div class="row mb-3">
                                    <label class="col-lg-4 col-form-label d-flex justify-content-center">Data Pribadi
                                        Offtaker</label>
                                </div> --}}
                                @csrf
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Nama Lengkap (Sesuai Identitas):</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" placeholder="Masukkan Nama Lengkap"
                                            name="employeeName">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Tempat, Tanggal Lahir:</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" placeholder="Masukkan Tempat Lahir"
                                            name="birthPlace">
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input id="tanggal-kirim" name="birthDate" type="text"
                                                class="form-control datepicker-autohide" placeholder="31 - 10 - 2023">
                                            <span class="input-group-text">
                                                <i class="ph-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Jenis Kelamin:</label>
                                    <div class="col-lg-7">
                                        <div class="form-check-horizontal">
                                            <label class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="sex"
                                                    value="Laki-laki">
                                                <span class="form-check-label">Laki-laki</span>
                                            </label>
                                            <label class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="sex"
                                                    value="Perempuan">
                                                <span class="form-check-label">Perempuan</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Agama:</label>
                                    <div class="col-lg-7">
                                        @php
                                            $response = Http::get(config('app.api_url') . 'religion/viewAll');
                                            $religion = $response->json();
                                        @endphp
                                        <div class="input-group">
                                            <select data-placeholder="Pilih Agama" class="form-control select"
                                                data-width="1%" name="religionId">
                                                <option></option>
                                                <optgroup label="Agama">
                                                    @foreach ($religion['data'] as $rl)
                                                        <option value="{{ $rl['religionId'] }}">
                                                            {{ $rl['religionName'] }}</option>
                                                    @endforeach
                                            </select>
                                            <button type="button" class="btn btn-primary "><i
                                                    class="ph-plus-circle"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Status Pernikahan:</label>
                                    <div class="col-lg-7">
                                        @php
                                            $response = Http::get(config('app.api_url') . 'statusType/viewAll');
                                            $statusType = $response->json();
                                        @endphp
                                        <div class="input-group">
                                            <select data-placeholder="Pilih Status" class="form-control select"
                                                data-width="1%" name="marriageStatusId">
                                                <option></option>
                                                <optgroup label="Status Pernikahan">
                                                    @foreach ($statusType['data'] as $sT)
                                                        <option value="{{ $sT['statusTypeId'] }}">
                                                            {{ $sT['statusType'] }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <button type="button" class="btn btn-primary "><i
                                                    class="ph-plus-circle"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Kewarganegaraan:</label>
                                    <div class="col-lg-7">
                                        <div class="form-check-horizontal">
                                            <label class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="nationalityStatus"
                                                    value="1" unchecked>
                                                <span class="form-check-label">WNI</span>
                                            </label>
                                            <label class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="nationalityStatus"
                                                    value="2">
                                                <span class="form-check-label">WNA</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Nomor Telepon:</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" placeholder="Masukkan Nomor Telepon"
                                            name="teleponNumber">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Nomor Telepon Seluler:</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control"
                                            placeholder="Masukkan Nomor Telepon Seluler" name="mobileNumber">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Nomor WhatsApp:</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" placeholder="Masukkan Nomor WhatsApp"
                                            name="whatsappNumber">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Kontak Person:</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control"
                                            placeholder="Masukkan Nomor Kontak Person" name="personType">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Email:</label>
                                    <div class="col-lg-7">
                                        <input type="email" class="form-control" placeholder="Masukkan Email"
                                            name="email">
                                    </div>
                                </div>
                                <div class="row">
                                    <style>
                                        .badge {
                                            border: none
                                        }
                                    </style>
                                    <div class="col-md-11 text-end mb-5">
                                        <button type="submit" class="badge bg-primary">Simpan<i
                                                class="ph-check-circle"></i></button>
                                        <button type="reset" class="badge bg-danger">Batal<i
                                                class="ph-x-circle"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="vertical-left-tab2">
                            <div class="row justify-content-center">
                                <div class="col-md-10 mb-5">
                                    <h6>Alamat Pegawai</h6>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modal_default_tab2"><i class="ph-plus-circle"></i><span
                                                class="d-none d-lg-inline-block ms-2">Tambah Baru</span></button>
                                    </div>
                                    <div id="modal_default_tab2" class="modal fade" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tambah Alamat</h5>
                                                    {{-- <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button> --}}
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container">
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">Provinsi:</label>
                                                            <div class="col-lg-7">
                                                                <div class="input-group">
                                                                    <select class="form-control select"
                                                                        data-placeholder="Pilih Provinsi" data-width="1%">
                                                                        <option></option>
                                                                        <optgroup label="Provinsi">
                                                                            <option value="1">Sumatera Utara</option>
                                                                            <option value="2">DKI Jakarta</option>
                                                                            <option value="3">NTB</option>
                                                                        </optgroup>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">Kabupaten:</label>
                                                            <div class="col-lg-7">
                                                                <div class="input-group">
                                                                    <select data-placeholder="Pilih Kabupaten"
                                                                        class="form-control select" data-width="1%">
                                                                        <option></option>
                                                                        <option value="1">Sumatera Utara</option>
                                                                        <option value="2">DKI Jakarta</option>
                                                                        <option value="3">NTB</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">Kecamatan:</label>
                                                            <div class="col-lg-7">
                                                                <div class="input-group">
                                                                    <select data-placeholder="Pilih Kecamatan"
                                                                        class="form-control select" data-width="1%">
                                                                        <option></option>
                                                                        <option value="1">Sumatera Utara</option>
                                                                        <option value="2">DKI Jakarta</option>
                                                                        <option value="3">NTB</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">Desa:</label>
                                                            <div class="col-lg-7">
                                                                <div class="input-group">
                                                                    <select data-placeholder="Pilih Desa"
                                                                        class="form-control select" data-width="1%">
                                                                        <option></option>
                                                                        <option value="1">Sumatera Utara</option>
                                                                        <option value="2">DKI Jakarta</option>
                                                                        <option value="3">NTB</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">Alamat Detail:</label>
                                                            <div class="col-lg-7">
                                                                <textarea rows="3" cols="3" class="form-control"
                                                                    placeholder="Masukkan Alamat Detail (Cth: Jalan, Nomor Rumah, Block, dll)"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">RT/RW:</label>
                                                            <div class="col-lg-2">
                                                                <input type="text" class="form-control text-center"
                                                                    placeholder="RT">
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <input type="text" class="form-control text-center"
                                                                    placeholder="RW">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label class="col-lg-4 col-form-label">Atur Sebagai:</label>
                                                            <div class="col-lg-3">
                                                                <input type="checkbox"
                                                                    class="form-check-input form-check-input" unchecked>
                                                                <span class="form-check-label">Alamat di KTP</span>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <input type="checkbox"
                                                                    class="form-check-input form-check-input" unchecked>
                                                                <span class="form-check-label">Alamat Rumah</span>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-lg-3 offset-4">
                                                                <input type="checkbox"
                                                                    class="form-check-input form-check-input" unchecked>
                                                                <span class="form-check-label">Alamat Kantor</span>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <input type="checkbox"
                                                                    class="form-check-input form-check-input" unchecked>
                                                                <span class="form-check-label">Lainnya</span>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">Nama Alamat
                                                                Lainnya:</label>
                                                            <div class="col-lg-7">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Alamat Lainnya (Rumah Ortu, Toko, Dll.)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Simpan<i
                                                            class="ph-check-circle ms-2"></i></button>
                                                    <button type="reset" class="btn btn-danger">Batal<i
                                                            class="ph-x-circle ms-2"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="row">
                                        <div class="col-lg-12">

                                        </div>
                                    </div> --}}
                                    <style>
                                        .table-responsive {
                                            /* padding-top: 10px */
                                        }

                                        @media screen and (max-width:768px) {
                                            .table-responsive a {
                                                display: inline-block;
                                                margin: 5px;
                                            }
                                        }
                                    </style>
                                    <div class="table-responsive">
                                        <table class="table table-bordered mt-2">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Nama Alamat</th>
                                                    <th>Detail Alamat</th>
                                                    <th>Alamat Utama</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                <tr>
                                                    <td>Alamat Offtaker</td>
                                                    <td>Alamat Detail-1</td>
                                                    <td>
                                                        <input type="checkbox" class="form-check-input" id="cc_li_c">
                                                    </td>
                                                    <td>
                                                        <a class="badge bg-success" href="#"><i
                                                                class="ph ph-pencil"></i><span
                                                                class="d-none d-sm-inline-block"></span></a>
                                                        <a class="badge bg-danger" href="#"><i
                                                                class="ph ph-x-circle"></i><span
                                                                class="d-none d-sm-inline-block"></span></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="vertical-left-tab3">
                            <div class="row justify-content-center">
                                <div class="col-md-10 mb-5">
                                    <h6>Identitas Pegawai</h6>
                                    <div class="d-flex justify-content-end mb-2">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modal_default_tab3"><i class="ph-plus-circle"></i><span
                                                class="d-none d-lg-inline-block ms-2">Tambah Baru</span></button>
                                    </div>
                                    <div id="modal_default_tab3" class="modal fade " tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tambah Identitas</h5>
                                                    {{-- <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button> --}}
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container">
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">Jenis Kartu
                                                                Identitas:</label>
                                                            <div class="col-lg-7">
                                                                <div class="input-group">
                                                                    <select id="jenisKartuIdentitas"
                                                                        data-placeholder="Pilih Jenis Kartu Identitas"
                                                                        class="form-control select" data-width="1%">
                                                                        <option></option>
                                                                        <option value="1">KTP</option>
                                                                        <option value="2">SIM</option>
                                                                        <option value="3">SKCK</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">Nomor Kartu
                                                                Identitas:</label>
                                                            <div class="col-lg-7">
                                                                <input type="number" class="form-control"
                                                                    placeholder="Masukkan Nomor Kartu Identitas">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">Tanggal
                                                                Kadaluarsa:</label>
                                                            <div class="col-lg-7">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Masukkan Tanggal Kadaluarsa">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label class="col-lg-4 col-form-label">Gambar Kartu
                                                                Identitas:</label>
                                                            <div class="col-lg-7">
                                                                <img id="preview" src="#" alt="Preview"
                                                                    style="display: none; max-width: 200px; max-height: 200px;">
                                                                <input type="file" class="form-control"
                                                                    name="company_logo" id="company_logo"
                                                                    {{-- onchange="previewImage(this);" --}}>
                                                                <div class="form-text text-muted">Format File: (*.jpg,
                                                                    *.jpeg, *.png) (Max 2MB)
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Simpan<i
                                                            class="ph-check-circle ms-2"></i></button>
                                                    <button type="reset" class="btn btn-danger">Batal<i
                                                            class="ph-x-circle ms-2"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="row"> --}}
                                    {{-- <div class="col-lg-12"> --}}
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Jenis Identitas</th>
                                                    <th>Nomor Identitas</th>
                                                    <th>Expire Data</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                <tr>
                                                    <td>Jenis Identitas-1</td>
                                                    <td>XXXXXXXXXXXXXXXX</td>
                                                    <td>XX/XX/XXXX</td>
                                                    <td>
                                                        <a class="badge bg-success" href="#"><i
                                                                class="ph ph-pencil"></i><span
                                                                class="d-none d-sm-inline-block"></span></a>
                                                        <a class="badge bg-danger" href="#"><i
                                                                class="ph ph-x-circle"></i><span
                                                                class="d-none d-sm-inline-block"></span></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- </div> --}}
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="vertical-left-tab4">
                            <div class="row justify-content-center">
                                <div class="col md-10 mb-5">
                                    <div class="col-md-3 mb-4 offset-1">
                                        <h6>Data Kepegawaian</h6>
                                    </div>
                                    <form action="#">
                                        <div class="row mb-3 justify-content-center">
                                            <label class="col-lg-3 col-form-label">NIP:</label>
                                            <div class="col-lg-7">
                                                <input type="text" class="form-control" placeholder="Masukkan NIP">
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center">
                                            <label class="col-lg-3 col-form-label">Status Pegawai:</label>
                                            <div class="col-lg-7">
                                                <div class="input-group">
                                                    <select data-placeholder="Pilih Status" class="form-control select"
                                                        data-width="1%">
                                                        <option></option>
                                                        <option value="1">Aktif</option>
                                                        <option value="2">Cuti</option>
                                                        <option value="3">Dipecat</option>
                                                    </select>
                                                    <button type="button" class="btn btn-primary "><i
                                                            class="ph-plus-circle"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center">
                                            <label class="col-lg-3 col-form-label">Departemen:</label>
                                            <div class="col-lg-7">
                                                <div class="input-group">
                                                    <select data-placeholder="Pilih Departemen"
                                                        class="form-control select" data-width="1%">
                                                        <option></option>
                                                        <option value="1">IT</option>
                                                        <option value="2">Manajemen</option>
                                                        <option value="3">Keamanan</option>
                                                    </select>
                                                    <button type="button" class="btn btn-primary "><i
                                                            class="ph-plus-circle"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center">
                                            <label class="col-lg-3 col-form-label">Unit:</label>
                                            <div class="col-lg-7">
                                                <div class="input-group">
                                                    <select data-placeholder="Pilih Unit" class="form-control select"
                                                        data-width="1%">
                                                        <option></option>
                                                        <option value="1">IT</option>
                                                        <option value="2">Manajemen</option>
                                                        <option value="3">Keamanan</option>
                                                    </select>
                                                    <button type="button" class="btn btn-primary "><i
                                                            class="ph-plus-circle"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center">
                                            <label class="col-lg-3 col-form-label">Jabatan:</label>
                                            <div class="col-lg-7">
                                                <div class="input-group">
                                                    <select data-placeholder="Pilih Jabatan" class="form-control select"
                                                        data-width="1%">
                                                        <option></option>
                                                        <option value="1">CEO</option>
                                                        <option value="2">CTO</option>
                                                        <option value="3">HEad Officer</option>
                                                    </select>
                                                    <button type="button" class="btn btn-primary "><i
                                                            class="ph-plus-circle"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3 justify-content-center">
                                            <label class="col-lg-3 col-form-label">Foto Pegawai:</label>
                                            <div class="col-lg-7">
                                                <img id="preview" src="#" alt="Preview"
                                                    style="display: none; max-width: 200px; max-height: 200px;">
                                                <input type="file" class="form-control" name="company_logo"
                                                    id="company_logo" onchange="previewImage(this);">
                                                <div class="form-text text-muted">Format File: (*.jpg,
                                                    *.jpeg, *.png) (Max 2MB)
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-11 text-end mb-5">
                                                <button type="submit" class="btn btn-primary">Simpan<i
                                                        class="ph-check-circle ms-2"></i></button>
                                                <button type="reset" class="btn btn-danger">Batal<i
                                                        class="ph-x-circle ms-2"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="vertical-left-tab5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 mb-5">
                                    <h6>Rekening Pegawai</h6>
                                    <div class="d-flex justify-content-end mb-2">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modal_default_tab5"><i class="ph-plus-circle"></i><span
                                                class="d-none d-lg-inline-block ms-2">Tambah Baru</span></button>
                                    </div>
                                    <div id="modal_default_tab5" class="modal fade " tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tambah Rekening</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container">
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">Kategori
                                                                Rekening:</label>
                                                            <div class="col-lg-7">
                                                                <div class="input-group">
                                                                    <select data-placeholder="Pilih Kategori Rekening"
                                                                        class="form-control select" data-width="1%">
                                                                        <option></option>
                                                                        <option value="1">Giro</option>
                                                                        <option value="2">Administratif</option>
                                                                        <option value="3">Koran</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">Nama Bank:</label>
                                                            <div class="col-lg-7">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Pilih Nama Bank">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">Nomor Rekening:</label>
                                                            <div class="col-lg-7">
                                                                <input type="number" class="form-control"
                                                                    placeholder="Masukkan Nomor Rekening">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">Nama Pemilik
                                                                Rekening:</label>
                                                            <div class="col-lg-7">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Masukkan Nama Pemilik Rekening">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">Keterangan:</label>
                                                            <div class="col-lg-7">
                                                                <textarea rows="3" cols="3" class="form-control"
                                                                    placeholder="Masukkan Keterangan (Cth: Kantor Cabang, dll)"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Simpan<i
                                                            class="ph-check-circle ms-2"></i></button>
                                                    <button type="reset" class="btn btn-danger">Batal<i
                                                            class="ph-x-circle ms-2"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="row"> --}}
                                    {{-- <div class="col-lg-12"> --}}
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Nama Rekening</th>
                                                    <th>Nomor Rekening</th>
                                                    <th>Nama Pemilik Rekneing</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                <tr>
                                                    <td>Nama Rekening-1</td>
                                                    <td>XXXXXXXXXXXXXXXX</td>
                                                    <td>Nama Pemilik Rekening-1</td>
                                                    <td>
                                                        <a class="badge bg-success" href="#"><i
                                                                class="ph ph-pencil"></i><span
                                                                class="d-none d-sm-inline-block"></span></a>
                                                        <a class="badge bg-danger" href="#"><i
                                                                class="ph ph-x-circle"></i><span
                                                                class="d-none d-sm-inline-block"></span></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- </div> --}}
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /basic layout -->
    {{-- <script src="{{ asset('admin_resources/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('admin_resources/assets/demo/pages/form_select2.js') }}"></script>
    <script src="{{ asset('admin_resources/assets/demo/pages/components_modals.js') }}"></script> --}}

    <script>
        function clearModalContent() {
            var selectElement = document.querySelector('#modal_default_tab3 select');
            selectElement.selectedIndex = 0; // Resets the select element
            var selectElement = document.getElementById('jenisKartuIdentitas');
            selectElement.selectedIndex = 0; // Reset the select element

            var inputElements = document.querySelectorAll(
                '#modal_default_tab3 input:not([type="submit"]):not([type="reset"])');
            inputElements.forEach(function(input) {
                if (input.type === 'file') {
                    input.value = ''; // Resets the file input
                    document.getElementById('preview').style.display = 'none'; // Hide the preview image
                } else {
                    input.value = ''; // Resets other input elements
                }
            });
        }

        document.querySelector('#modal_default_tab3 .btn-danger').addEventListener('click', clearModalContent);

        document.addEventListener('click', function(event) {
            var modal = document.getElementById('modal_default_tab3');
            var isClickInsideModal = modal.contains(event.target);

            if (!isClickInsideModal && window.getComputedStyle(modal).display !== 'none') {
                clearModalContent();
            }
        });
    </script>
    {{-- <script src="{{ asset('admin_resources/demo/pages/form_layouts.js')}}"></script> --}}
@endsection
