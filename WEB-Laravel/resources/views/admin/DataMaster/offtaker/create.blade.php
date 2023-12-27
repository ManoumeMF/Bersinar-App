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
    <!-- Basic layout -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Offtaker</h5>
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
                                text-align: left;
                            }
                        }
                    </style>
                    <ul class="nav nav-tabs nav-tabs-vertical nav-tabs-vertical-start wmin-lg-200 me-lg-3 mb-3 mb-lg-0">
                        <li class="nav-item">
                            <a href="#vertical-left-tab1" class="nav-link active" data-bs-toggle="tab">
                                <i class="ph ph-user me-2"></i>
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
                                <i class="ph ph-bank me-2"></i>
                                Rekening
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#vertical-left-tab4" class="nav-link" data-bs-toggle="tab">
                                <i class="ph ph-hard-drives me-2"></i>
                                Rincian Barang
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content flex-lg-fill">
                        <div class="tab-pane fade show active" id="vertical-left-tab1">
                            <form action="{{route('offtaker.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Kategori Offtaker:</label>
                                    <div class="col-lg-7">
                                        @php
                                            $response = Http::get(Config('app.api_url') . 'offtaker/viewCombo');
                                            $offtaker = $response->json();
                                        @endphp
                                        <div class="input-group">
                                            <select data-placeholder="Pilih Jenis Offtaker" class="form-control select"
                                                data-width="1%" name="partnerTypeId">
                                                <option></option>
                                                @foreach ($offtaker['data'] as $customer)
                                                    <option value="{{ $customer['partnerTypeId'] }}">
                                                        {{ $customer['partnerType'] }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-primary "><i
                                                    class="ph-plus-circle"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Kode Offtaker:</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" placeholder="Kode Offtaker"
                                            name="customerCode">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Nama Ofttaker:</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" placeholder="Masukkan Nama Offtaker"
                                            name="customerName">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Email:</label>
                                    <div class="col-lg-7">
                                        <input type="email" class="form-control" placeholder="Masukkan Email"
                                            name="email">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Nomor Telepon Kantor/Rumah:</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control"
                                            placeholder="Masukkan Nomor Telepon Kantor" name="teleponNumber">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Faxmile:</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" placeholder="Masukkan Nomor Faxmile"
                                            name="faxNumber">
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
                                            placeholder="Masukkan Nomor Kontak Person" name="contactPerson">
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center">
                                    <label class="col-lg-3 col-form-label">Gambar Barang:</label>
                                    <div class="col-lg-7">
                                        <img id="preview" src="#" alt="Preview" class="mb-2"
                                            style="display: none; max-width: 150px; max-height: 150px;">
                                        <input type="file" class="form-control" name="customerPhoto"
                                            id="customerPhoto" onchange="previewImage(this);">
                                        <div class="form-text text-muted mt-2">Format File: (*.jpg, *.jpeg, *.png) (Max 2MB)
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
                                    <h6>Alamat Offtaker</h6>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modal_default_tab2"><i class="ph-plus-circle"></i><span
                                                class="d-none d-lg-inline-block ms-2">Tambah Alamat</span></button>
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
                                                                    <select data-placeholder="Pilih Provinsi"
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
                                                                <span class="form-check-label">Alamat Kantor</span>
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
                                    <div class="table-responsive">
                                        <table class="table table-bordered mt-2">
                                            <thead class="text-center">
                                                <tr>
                                                    <th class="col-md-4">Nama Alamat</th>
                                                    <th class="col-md-5">Detail Alamat</th>
                                                    <th class="col-md-1">Alamat Utama</th>
                                                    <th class="col-md-2">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                <tr>
                                                    <td>Jl. Kemayoran Baru, No. 17</td>
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
                                    <h6>Rekening Offtaker</h6>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modal_default_tab3"><i class="ph-plus-circle"></i><span
                                                class="d-none d-lg-inline-block ms-2">Tambah Rekening</span></button>
                                    </div>
                                    <div id="modal_default_tab3" class="modal fade " tabindex="-1">
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
                                                                        <option value="1">Giro</option>
                                                                        <option value="2">Debit</option>
                                                                        <option value="3">Kredit</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">Nama Bank:</label>
                                                            <div class="col-lg-7">
                                                                <input type="number" class="form-control"
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
                                                                    placeholder="Masukkan Alamat Detail (Cth: Jalan, Nomor Rumah, Block, dll)"></textarea>
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
                                                    <td>BNI</td>
                                                    <td>1945424219249214</td>
                                                    <td>Arie Susanto</td>
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
                                    <h6>Rincian Barang Offtaker</h6>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modal_default_tab4"></i><span
                                                class="d-none d-lg-inline-block ms-2">Tambah Barang</span></button>
                                    </div>
                                    <div id="modal_default_tab4" class="modal fade " tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tambah Rincian Barang</h5>
                                                    {{-- <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button> --}}
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container">
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">Kategori
                                                                Barang:</label>
                                                            <div class="col-lg-7">
                                                                <div class="input-group">
                                                                    <select data-placeholder="Pilih Kategori Barang"
                                                                        class="form-control select" data-width="1%">
                                                                        <option></option>
                                                                        <option value="1">P17 - PETE</option>
                                                                        <option value="2">P18 - HDPE</option>
                                                                        <option value="3">P19 - PVC</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">Jenis Barang:</label>
                                                            <div class="col-lg-7">
                                                                <input class="form-control"
                                                                    placeholder="Pilih Jenis Barang">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <label class="col-lg-4 col-form-label">Kategori Barang:</label>
                                                            <div class="col-lg-7">
                                                                <input class="form-control"
                                                                    placeholder="Pilih Kategori Barang">
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
                                                    <th>Nama Barang</th>
                                                    <th>Jenis Barang</th>
                                                    <th>Kategori Barang</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                <tr>
                                                    <td>
                                                        <select data-placeholder="P17 - PETE" class="form-control select">
                                                            <option></option>
                                                            <option value="1">P17 - PETE</option>
                                                            <option value="2">P18 - HDPE</option>
                                                            <option value="3">P19 - PVC</option>
                                                        </select>
                                                    </td>
                                                    <td>Sulit terurai</td>
                                                    <td>Limbah plastik</td>
                                                    <td>
                                                        <a class="badge bg-success" href="#"><i
                                                                class="ph ph-pencil"></i><span
                                                                class="d-none d-sm-inline-block"></span></a>
                                                        <a class="badge bg-danger" href="#"><i
                                                                class="ph ph-x-circle"></i><span
                                                                class="d-none d-sm-inline-block"></span></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <select data-placeholder="P19 - PVC" class="form-control select">
                                                            <option></option>
                                                            <option value="1">P17 - PETE</option>
                                                            <option value="2">P18 - HDPE</option>
                                                            <option value="3">P19 - PVC</option>
                                                        </select>
                                                    </td>
                                                    <td>Sulit terurai</td>
                                                    <td>Limbah plastik</td>
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
    <script>
        function previewImage(input) {
            var preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.style.display = 'block';
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
                preview.src = '#';
            }
        }
    </script>
@endsection
