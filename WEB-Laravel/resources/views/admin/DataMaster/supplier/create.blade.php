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
    <!-- Basic layout -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Nasabah</h5>
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
                                <i class="ph-user-circle me-2"></i>
                                Data Pribadi
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
                                <i class="ph ph-bank me-2"></i>
                                Rekening
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content flex-lg-fill">
                        <div class="tab-pane fade show active" id="vertical-left-tab1">
                            <form action="{{ route('supplier.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Jenis Nasabah:</label>
                                    <div class="col-lg-7">
                                        @php
                                            $response = Http::get(Config('app.api_url') . 'supplier/viewCombo');
                                            $partnerTypeCbo = $response->json();
                                        @endphp
                                        <div class="input-group">
                                            <select data-placeholder="Pilih Jenis Nasabah" name="partnerTypeId"
                                                class="form-control select" data-width="1%">
                                                <option></option>
                                                <optgroup label="Jenis Nasabah">
                                                    @foreach ($partnerTypeCbo['data'] as $pCb)
                                                        <option value="{{ $pCb['partnerTypeId'] }}">
                                                            {{ $pCb['partnerType'] }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <button type="button" class="btn btn-primary "><i
                                                    class="ph-plus-circle"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Kode Nasabah:</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" placeholder="Kode Nasabah"
                                            name="supplierCode">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Nama Lengkap (Sesuai Identitas):</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" placeholder="Masukkan Nama Lengkap"
                                            name="fullName">
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
                                    <label class="col-lg-3 col-form-label">Tempat, Tanggal Lahir:</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" placeholder="Masukkan Tempat Lahir"
                                            name="birthPlace">
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="ph-calendar"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker-autohide"
                                                placeholder="Tanggal Lahir" name="birthDate">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Email:</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" placeholder="Masukkan Email"
                                            name="email">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Nomor Telepon:</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" placeholder="Masukkan Nomor Telepon"
                                            name="mobileNumber">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">WhatsApp:</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" placeholder="Masukkan Nomor WhatsApp"
                                            name="whatsAppNumber">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Pekerjaan:</label>
                                    <div class="col-lg-7">
                                        @php
                                            $response = Http::get(Config('app.api_url') . 'occupation/viewAll');
                                            $getDataOccupation = $response->json();
                                        @endphp
                                        <div class="input-group">
                                            <select data-placeholder="Pilih Pekerjaan" class="form-control select"
                                                data-width="1%" name="occupationId">
                                                <option></option>
                                                <optgroup label="Pekerjaan">
                                                    @foreach ($getDataOccupation['data'] as $gDO)
                                                        <option value="{{ $gDO['occupationId'] }}">
                                                            {{ $gDO['occupationName'] }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <button type="button" class="btn btn-primary "><i
                                                    class="ph-plus-circle"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Nama Ibu Kandung:</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control"
                                            placeholder="Masukkan Nama Ibu Kandung" name="mothersName">
                                    </div>
                                </div>
                                {{-- <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Unit Bisnis:</label>
                                    <div class="col-lg-7">
                                        @php
                                            $response = Http::get(Config('app.api_url') . 'businessUnit/viewAll');
                                            $businessUnitCbo = $response->json();
                                        @endphp
                                        <div class="input-group">
                                            <select data-placeholder="Pilih Unit Bisnis" class="form-control select"
                                                data-width="1%" name="businessUnitId">
                                                <option></option>
                                                <optgroup label="Unit Bisnis">
                                                    @foreach ($businessUnitCbo['data'] as $gBUData)
                                                        <option value="{{ $gBUData['businessUnitId'] }}">
                                                            {{ $gBUData['businessUnitName'] }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            <button type="button" class="btn btn-primary "><i
                                                    class="ph-plus-circle"></i></button>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Penanggung Jawab:</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control"
                                            placeholder="Masukkan Penanggung Jawab" name="responsiblePerson">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Foto Nasabah:</label>
                                    <div class="col-lg-7">
                                        <img id="preview" src="#" alt="Preview"
                                            style="display: none; max-width: 200px; max-height: 200px;">
                                        <input type="file" class="form-control" name="supplierPhoto"
                                            id="supplierPhoto" onchange="previewImage(this);">
                                        <div class="form-text text-muted">Format File: (*.jpg, *.jpeg, *.png) (Max 2MB)
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
                        <div class="tab-pane fade" id="vertical-left-tab2">
                            <div class="row justify-content-center">
                                <div class="col-md-10 mb-5">
                                    <h6>Alamat Nasabah</h6>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modal_default_tab2"><i class="ph-plus-circle"></i><span
                                                class="d-none d-lg-inline-block ms-2">Tambah Baru</span></button>
                                    </div>
                                    <form>
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
                                                                        <select data-placeholder="Pilih Provinsi"
                                                                            class="form-control select" data-width="1%">
                                                                            <option></option>
                                                                            <optgroup label="Provinsi">
                                                                                <option value="1">Sumatera Utara
                                                                                </option>
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
                                                                            <optgroup label="Kabupaten">
                                                                                <option value="1">Toba</option>
                                                                                <option value="2">Humbang</option>
                                                                                <option value="3">Samosir</option>
                                                                            </optgroup>
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
                                                                            <optgroup label="Kecamatan">
                                                                                <option value="1">Sumatera Utara
                                                                                </option>
                                                                                <option value="2">DKI Jakarta</option>
                                                                                <option value="3">NTB</option>
                                                                            </optgroup>
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
                                                                            <optgroup label="Desa">
                                                                                <option value="1">Sumatera Utara
                                                                                </option>
                                                                                <option value="2">DKI Jakarta</option>
                                                                                <option value="3">NTB</option>
                                                                            </optgroup>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <label class="col-lg-4 col-form-label">Alamat
                                                                    Detail:</label>
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
                                                                <label class="col-lg-4 col-form-label">Atur
                                                                    Sebagai:</label>
                                                                <div class="col-lg-3">
                                                                    <input type="checkbox"
                                                                        class="form-check-input form-check-input">
                                                                    <span class="form-check-label">Alamat di KTP</span>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <input type="checkbox"
                                                                        class="form-check-input form-check-input">
                                                                    <span class="form-check-label">Alamat Kantor</span>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-lg-3 offset-4">
                                                                    <input type="checkbox"
                                                                        class="form-check-input form-check-input">
                                                                    <span class="form-check-label">Alamat Rumah</span>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <input type="checkbox"
                                                                        class="form-check-input form-check-input">
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
                                                        <button type="cancel" class="btn btn-danger">Batal<i
                                                                class="ph-x-circle ms-2"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
                                    <div class="table-responsive mt-2">
                                        <table class="table table-bordered">
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
                                                    <td>Jl. Kemayoran Baru</td>
                                                    <td>Jl. Kemayoran Baru, No. 17, Gg. Cendrawasih</td>
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
                                    <h6>Identitas Nasabah</h6>
                                    <div class="d-flex justify-content-end">
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
                                                                    <select data-placeholder="Pilih Jenis Kartu Identitas"
                                                                        class="form-control select" data-width="1%">
                                                                        <option></option>
                                                                        <optgroup label="Jenis Kartu Identitas">
                                                                            <option value="1">Sumatera Utara</option>
                                                                            <option value="2">DKI Jakarta</option>
                                                                            <option value="3">NTB</option>
                                                                        </optgroup>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">Nomor Kartu
                                                                Identitas:</label>
                                                            <div class="col-lg-7">
                                                                <input type="text" class="form-control"
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
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">Foto Nasabah:</label>
                                                            <div class="col-lg-7">
                                                                <img id="preview" src="#" alt="Preview"
                                                                    style="display: none; max-width: 200px; max-height: 200px;">
                                                                <input type="file" class="form-control"
                                                                    name="company_logo" id="company_logo"
                                                                    onchange="previewImage(this);">
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
                                    <div class="table-responsive">
                                        <table class="table table-bordered mt-2">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Jenis Identitas</th>
                                                    <th>Nomor Identitas</th>
                                                    <th>Expire Date</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                <tr>
                                                    <td>e-KTP</td>
                                                    <td>12121114030210001</td>
                                                    <td>Seumur Hidup</td>
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
                        <div class="tab-pane fade" id="vertical-left-tab4">
                            <div class="row justify-content-center">
                                <div class="col-md-10 mb-5">
                                    <h6>Rekening Nasabah</h6>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modal_default_tab4"><i class="ph-plus-circle"></i><span
                                                class="d-none d-lg-inline-block ms-2">Tambah Baru</span></button>
                                    </div>
                                    <div id="modal_default_tab4" class="modal fade " tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tambah Rekening</h5>
                                                    {{-- <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button> --}}
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
                                                                        <optgroup label="Kategori Rekening">
                                                                            <option value="1">Giro</option>
                                                                            <option value="2">Administratif</option>
                                                                            <option value="3">Koran</option>
                                                                        </optgroup>
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
                                    <div class="table-responsive">
                                        <table class="table table-bordered mt-2">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Nama Rekening</th>
                                                    <th>Nomor Rekening</th>
                                                    <th>Nama Pemilik Rekening</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                <tr>
                                                    <td>Tabungan Giro</td>
                                                    <td>1945424219249219</td>
                                                    <td>Siska</td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /basic layout -->
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

            $('form').has('.datepicker-autohide').submit(function(e) {
                e.preventDefault();
                var nilaiTanggal = $(this).find('.datepicker-autohide').val();
                var tanggalTerformat = nilaiTanggal.split('/').reverse().join('-');
                $(this).find('.datepicker-autohide').val(tanggalTerformat);
                this.submit();
            });
        });
    </script>
@endsection
