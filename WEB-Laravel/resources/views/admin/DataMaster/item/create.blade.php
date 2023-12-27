@extends('layouts.admin.template')
@section('content')
    <!-- Basic layout -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Barang</h5>
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
                                <a href="#tab-tambah-barang" class="nav-link active" data-bs-toggle="tab">
                                    Nama dan Keterangan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab-persediaan-barang" class="nav-link" data-bs-toggle="tab">
                                    Persediaan Barang
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab-harga-barang" class="nav-link" data-bs-toggle="tab">
                                    Harga Barang
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content flex-lg-fill">
                            <div class="tab-pane fade show active" id="tab-tambah-barang">
                                <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3 justify-content-center">
                                        <label class="col-lg-3 col-form-label">Unit Bisnis:</label>
                                        <div class="col-lg-7">
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
                                                            <option value="{{ $bU['businessUnitId'] }}">
                                                                {{ $bU['businessUnitName'] }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                                <button type="button" class="btn btn-primary "><i
                                                        class="ph-plus-circle"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 justify-content-center">
                                        <label class="col-lg-3 col-form-label">Kode Barang:</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control" name="itemCode"
                                                placeholder="Masukkan Kode Barang" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 justify-content-center">
                                        <label class="col-lg-3 col-form-label">Nama Barang:</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control" name="itemName"
                                                placeholder="Masukkan Nama Barang" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 justify-content-center">
                                        <label class="col-lg-3 col-form-label">Kategori Barang:</label>
                                        <div class="col-lg-7">
                                            @php
                                                $response = Http::get(Config('app.api_url') . 'itemCategory/viewAll');
                                                $itemCategory = $response->json();
                                            @endphp
                                            <div class="input-group">
                                                <select data-placeholder="Pilih Kategori Barang" name="itemCategoryId"
                                                    class="form-control select" data-width="1%">
                                                    <option></option>
                                                    <optgroup label="Kategori Barang">
                                                        @foreach ($itemCategory['data'] as $iC)
                                                            <option value="{{ $iC['itemCategoryId'] }}">
                                                                {{ $iC['itemCategoryName'] }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                                <button type="button" class="btn btn-primary "><i
                                                        class="ph-plus-circle"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 justify-content-center">
                                        <label class="col-lg-3 col-form-label">Satuan Barang:</label>
                                        <div class="col-lg-7">
                                            @php
                                                $response = Http::get(Config('app.api_url') . 'itemUoM/viewAll');
                                                $itemUoM = $response->json();
                                            @endphp
                                            <div class="input-group">
                                                <select data-placeholder="Pilih Kategori Barang" name="itemUoMId"
                                                    class="form-control select" data-width="1%">
                                                    <option></option>
                                                    <optgroup label="Satuan Barang">
                                                        @foreach ($itemUoM['data'] as $itemuom)
                                                            <option value="{{ $itemuom['itemUoMId'] }}">
                                                                {{ $itemuom['uomItem'] }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                                <button type="button" class="btn btn-primary "><i
                                                        class="ph-plus-circle"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 justify-content-center">
                                        <label class="col-lg-3 col-form-label">Spesifikasi:</label>
                                        <div class="col-lg-7">
                                            <textarea rows="3" cols="3" class="form-control" name="specification" placeholder="Masukkan Spesifikasi"
                                                required></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3 justify-content-center">
                                        <label class="col-lg-3 col-form-label">Barcode Barang:</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control" name="barcode"
                                                placeholder="Masukkan Kode Barang" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 justify-content-center">
                                        <label class="col-lg-3 col-form-label">Gambar Barang:</label>
                                        <div class="col-lg-7">
                                            <img id="preview" src="#" alt="Preview"
                                                style="display: none; max-width: 150px; max-height: 150px;">
                                            <input type="file" class="form-control" name="gambar" id="gambar"
                                                onchange="previewImage(this);">
                                            <div class="form-text text-muted">Format File: (*.jpg, *.jpeg, *.png) (Max 2MB)
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 justify-content-center">
                                        <label class="col-lg-3 col-form-label">Keterangan:</label>
                                        <div class="col-lg-7">
                                            <textarea rows="3" cols="3" class="form-control" name="description" placeholder="Masukkan Keterangan"
                                                required></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11 text-end mb-5">
                                            <button type="submit" class="btn btn-primary">Simpan<i
                                                    class="ph-check-circle ms-1"></i></button>
                                            <button type="reset" class="btn btn-danger">Batal<i
                                                    class="ph-x-circle ms-1"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="tab-persediaan-barang">
                                <form action="#">
                                    <div class="row mb-3 justify-content-center">
                                        <label class="col-lg-3 col-form-label">Batas Re-Order:</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control"
                                                placeholder="Masukkan Batas Re-Order Barang">
                                        </div>
                                    </div>
                                    <div class="row mb-3 justify-content-center">
                                        <label class="col-lg-3 col-form-label">Minimum Order:</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control"
                                                placeholder="Masukkan Minimum Order Barang">
                                        </div>
                                    </div>
                                    <div class="row mb-3 justify-content-center">
                                        <label class="col-lg-3 col-form-label">Jumlah Stok Awal:</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control"
                                                placeholder="Masukkan Jumlah Stok Awal Barang">
                                        </div>
                                    </div>
                                    <div class="row mb-3 justify-content-center">
                                        <label class="col-lg-3 col-form-label">Gudang:</label>
                                        <div class="col-lg-7">
                                            {{-- @php
                                                $response = Http::get(Config('app.api_url') . 'itemUoM/viewAll');
                                                $itemUoM = $response->json();
                                            @endphp --}}
                                            <div class="input-group">
                                                <select data-placeholder="Pilih Gudang" name=""
                                                    class="form-control select" data-width="1%">
                                                    <option></option>
                                                    <optgroup label="Gudang">
                                                        {{-- @foreach ($itemUoM['data'] as $itemuom)
                                                            <option value="{{ $itemuom['itemUoMId'] }}">
                                                                {{ $itemuom['uomItem'] }}</option>
                                                        @endforeach --}}
                                                        <option value="0">BU</option>
                                                        <option value="1">BSI</option>
                                                        <option value="2">BSE</option>

                                                    </optgroup>
                                                </select>
                                                <button type="button" class="btn btn-primary "><i
                                                        class="ph-plus-circle"></i></button>
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
                            <div class="tab-pane fade" id="tab-harga-barang">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Harga Pembelian</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex justify-content-end mb-2">
                                                    <a class="btn btn-primary" href="#"><i
                                                            class="ph-plus-circle"></i><span
                                                            class="d-none d-lg-inline-block ms-2">Tambah Harga</span></a>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mt-2">
                                                        <thead class="text-center">
                                                            <tr>
                                                                <th class="cold-sm-">Jenis Nasabah</th>
                                                                <th class="cold-sm-1">Ada Harga</th>
                                                                <th class="cold-sm-2">Range Awal</th>
                                                                <th class="cold-sm-2">Range Akhir</th>
                                                                <th class="cold-sm-">Satuan</th>
                                                                <th class="cold-sm-2">Harga</th>
                                                                <th class="cold-sm-1">Default</th>
                                                                <th class="cold-sm-1">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-center">
                                                            <tr>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <select data-placeholder="Jenis Nasabah"
                                                                            class="form-control select">
                                                                            <option></option>
                                                                            <option value="1">Reguler</option>
                                                                            <option value="2">Prioritas</option>
                                                                            <option value="3">VVIP</option>
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="cc_li_c">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control text-center"
                                                                        placeholder="0">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control text-center"
                                                                        placeholder="0">
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <select data-placeholder="Satuan"
                                                                            class="form-control select">
                                                                            <option></option>
                                                                            <option value="1">tes1</option>
                                                                            <option value="2">tes2</option>
                                                                            <option value="3">tes3</option>
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control text-center"
                                                                        placeholder="0">
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="cc_li_c">
                                                                </td>
                                                                <td>
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
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Harga Penjualan</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <div class="d-flex justify-content-end mb-2">
                                                            <a class="btn btn-primary" href="#"><i
                                                                    class="ph-plus-circle"></i><span
                                                                    class="d-none d-lg-inline-block ms-2">Tambah
                                                                    Harga</span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered mt-2">
                                                                <div class="row">
                                                                    <thead class="text-center">
                                                                        <tr>
                                                                            <th class="col-md-3">Satuan</th>
                                                                            <th class="col-md-3">Harga</th>
                                                                            <th class="col-md-3">Default</th>
                                                                            <th class="col-md-3">Aksi</th>
                                                                        </tr>
                                                                    </thead>
                                                                </div>
                                                                <tbody class="text-center">
                                                                    <tr>
                                                                        <td>
                                                                            <div class="input-group">
                                                                                <select data-placeholder="Satuan"
                                                                                    class="form-control select">
                                                                                    <option></option>
                                                                                    <option value="1">tes1</option>
                                                                                    <option value="2">tes2</option>
                                                                                    <option value="3">tes3</option>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text"
                                                                                class="form-control text-center"
                                                                                placeholder="0">
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox"
                                                                                class="form-check-input" id="cc_li_c">
                                                                        </td>
                                                                        <td>
                                                                            <a class="badge bg-danger" href="#"><i
                                                                                    class="ph ph-x-circle"></i><span
                                                                                    class="d-none d-sm-inline-block"></span></a>
                                                                        </td>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-end mb-5">
                                        <button type="submit" class="btn btn-primary">Simpan<i
                                                class="ph-check-circle ms-2"></i></button>
                                        <button type="reset" class="btn btn-danger">Batal<i
                                                class="ph-x-circle ms-2"></i></button>
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
