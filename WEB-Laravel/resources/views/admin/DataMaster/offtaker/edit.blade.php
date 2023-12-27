@extends('layouts.admin.template')

@section('content')
    {{-- <script>
        $(document).ready(function() {
            // Your existing Select2 initialization
            $('.select').each(function() {
                $(this).select({
                    dropdownParent: $(this).closest('.modal')
                });
            });
        });
    </script> --}}
    <!-- Basic layout -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Edit Offtaker</h5>
        </div>
        <div class="card-body border-top">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <form action="{{ route('offtaker.update', ['id' => $editOfftaker['customerId']]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Kategori Offtaker:</label>
                            <div class="col-lg-7">
                                @php
                                    $response = Http::get(Config('app.api_url') . 'offtaker/viewCombo');
                                    $partnerType = $response->json();
                                @endphp
                                <div class="input-group">
                                    <select class="form-control select" name="partnerTypeId"
                                        data-placeholder="Pilih Offtaker" data-width="1%">
                                        <option></option>
                                        <optgroup label="Offtaker">
                                            @foreach ($partnerType['data'] as $pType)
                                                <option value="{{ $pType['partnerTypeId'] }}"
                                                    {{ $pType['partnerTypeId'] == $editOfftaker['partnerTypeId'] ? 'selected' : '' }}>
                                                    {{ $pType['partnerType'] }}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <button type="button" class="btn btn-primary "><i class="ph-plus-circle"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Kode Offtaker:</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control" value="{{ $editOfftaker['customerCode'] }}"
                                    name="customerCode" placeholder="Kode Offtaker" required>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Nama Offtaker:</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control" value="{{ $editOfftaker['customerName'] }}"
                                    name="customerName" placeholder="Masukkan Nama Offtaker" required>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Email:</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control" value="{{ $editOfftaker['email'] }}"
                                    name="email" placeholder="Masukkan Email" required>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Nomor Telepon Kantor/Rumah:</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control" value="{{ $editOfftaker['teleponNumber'] }}"
                                    placeholder="Masukkan Nomor Telepon Kantor" name="teleponNumber">
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Faxmile:</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control" value="{{ $editOfftaker['faxNumber'] }}"
                                    placeholder="Masukkan Nomor Faxmile" name="faxNumber">
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Nomor Telepon Seluler:</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control" value="{{ $editOfftaker['mobileNumber'] }}"
                                    placeholder="Masukkan Nomor Telepon Seluler" name="mobileNumber">
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Nomor WhatsApp:</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control" value="{{ $editOfftaker['whatsappNumber'] }}"
                                    placeholder="Masukkan Nomor WhatsApp" name="whatsappNumber">
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Kontak Person:</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control" value="{{ $editOfftaker['contactPerson'] }}"
                                    placeholder="Masukkan Nomor Kontak Person" name="contactPerson">
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Gambar Barang:</label>
                            <div class="col-lg-7">
                                <img id="preview" src="#" alt="Preview" class="mb-2"
                                    style="display: none; max-width: 150px; max-height: 150px;">
                                <input type="file" class="form-control" value="{{ $editOfftaker['customerPhoto'] }}"
                                    name="customerPhoto" id="customerPhoto" onchange="previewImage(this);">
                                <div class="form-text text-muted mt-2">Format File: (*.jpg, *.jpeg, *.png) (Max 2MB)
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11 text-end mb-5">
                                <button type="submit" class="btn btn-primary">Simpan<i
                                        class="ph-check-circle ms-1"></i></button>
                                <button type="button" class="btn btn-danger"
                                    onclick="location.href='{{ url('admin/offtaker') }}'">
                                    Batal<i class="ph-x-circle ms-1"></i>
                                </button>
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
