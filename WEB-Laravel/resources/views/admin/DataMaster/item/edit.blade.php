@extends('layouts.admin.template')

@section('content')
    <script>
        $(document).ready(function() {
            // Your existing Select2 initialization
            $('.select').each(function() {

                $(this).select({
                    dropdownParent: $(this).closest('.modal')

                });
            });
        });
    </script>
    <!-- Basic layout -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Edit Barang</h5>
        </div>
        <div class="card-body border-top">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <form action="{{ route('item.update', ['id' => $editItem['itemId']]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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
                                                <option value="{{ $bU['businessUnitId'] }}"
                                                    {{ $bU['businessUnitId'] == $editItem['businessUnitId'] ? 'selected' : '' }}>
                                                    {{ $bU['businessUnitName'] }}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <button type="button" class="btn btn-primary "><i class="ph-plus-circle"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Kode Barang:</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control" value="{{ $editItem['itemCode'] }}"
                                    name="itemCode" placeholder="Masukkan Kode Barang" required>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Nama Barang:</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control" value="{{ $editItem['itemName'] }}"
                                    name="itemName" placeholder="Masukkan Nama Barang" required>
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
                                                <option value="{{ $iC['itemCategoryId'] }}"
                                                    {{ $iC['itemCategoryId'] == $editItem['itemCategoryId'] ? 'selected' : '' }}>
                                                    {{ $iC['itemCategoryName'] }}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <button type="button" class="btn btn-primary "><i class="ph-plus-circle"></i></button>
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
                                                <option value="{{ $itemuom['itemUoMId'] }}"
                                                    {{ $itemuom['itemUoMId'] == $editItem['itemUoMId'] ? 'selected' : '' }}>
                                                    {{ $itemuom['uomItem'] }}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <button type="button" class="btn btn-primary "><i class="ph-plus-circle"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Spesifikasi:</label>
                            <div class="col-lg-7">
                                <textarea rows="3" cols="3" class="form-control" name="specification" placeholder="Masukkan Spesifikasi"
                                    required>{{ $editItem['specification'] }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Barcode Barang:</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control" value="{{ $editItem['barcode'] }}"
                                    name="barcode" placeholder="Masukkan Kode Barang" required>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Gambar Barang:</label>
                            <div class="col-lg-7">
                                <img id="preview" src="#" alt="Preview" class="mb-2"
                                    style="display: none; max-width: 150px; max-height: 150px;">
                                <input type="file" class="form-control mt-2" value="{{ $editItem['gambar'] }}"
                                    name="gambar" onchange="previewImage(this);">
                                <div class="form-text text-muted">Format File: (*.jpg, *.jpeg, *.png) (Max 2MB)
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Keterangan:</label>
                            <div class="col-lg-7">
                                <textarea rows="3" cols="3" class="form-control" name="description" placeholder="Masukkan Keterangan"
                                    required>{{ $editItem['description'] }}</textarea>
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
