@extends('layouts.admin.template')

@section('content')
    <!-- Basic layout -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Unit Bisnis</h5>
        </div>
        <div class="card-body border-top">
            <div class="row ">
                <div class="col-lg-9 offset-lg-2">
                    <form action="{{ route('businessUnit.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-lg-2 col-form-label">Perusahaan/Organisasi:</label>
                            <div class="col-lg-9">
                                @php
                                    $response = Http::get(Config('app.api_url') . 'corporate/viewAll');
                                    $corporate = $response->json();
                                @endphp
                                <div class="input-group">
                                    <select class="form-control select" name="corporateId"
                                        aria-label="Default select example" data-placeholder="Pilih Perusahaan/Organisasi"
                                        data-width="1%">
                                        <option></option>
                                        <optgroup label="Perusahaan/Organisasi">
                                            @foreach ($corporate['data'] as $corp)
                                                <option value="{{ $corp['corporateId'] }}">{{ $corp['corporateName'] }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <button type="button" class="btn btn-primary "><i class="ph-plus-circle"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-2 col-form-label">Jenis Unit Bisnis:</label>
                            <div class="col-lg-9">
                                @php
                                    $response = Http::get(Config('app.api_url') . 'businessUnitType/viewAll');
                                    $businessUnitType = $response->json();
                                @endphp
                                <div class="input-group">
                                    <select class="form-control select" name="sbuTypeId" aria-label="Default select example"
                                        data-placeholder="Pilih Jenis Unit Bisnis" data-width="1%">
                                        <option></option>
                                        <optgroup label="Jenis Unit Bisnis">
                                            @foreach ($businessUnitType['data'] as $bUT)
                                                <option value="{{ $bUT['sbuTypeId'] }}">{{ $bUT['businessUnitType'] }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <button type="button" class="btn btn-primary "><i class="ph-plus-circle"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-2 col-form-label">Kode Unit Bisnis:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="businessUnitCode"
                                    placeholder="Masukkan Kode Unit Bisnis" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-2 col-form-label">Nama Unit Bisnis:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="businessUnitName"
                                    placeholder="Masukkan Nama Unit Bisnis" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-2 col-form-label">Nomor NPWP:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="taxId" placeholder="Masukkan Nomor NPWP"
                                    required>
                            </div>
                        </div>
                        {{-- <div class="row mb-3">
                            <label class="col-lg-2 col-form-label">Negara:</label>
                            <div class="col-lg-9">
                                <select class="form-control select" data-placeholder="Pilih Negara"
                                    aria-label="Default select example">
                                    <option></option>
                                    <optgroup label="Negara">
                                        <option value="1">Indonesia</option>
                                        <option value="2">Vietnam</option>
                                        <option value="3">Jepang</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div> --}}
                        <div class="row mb-3">
                            <label class="col-lg-2 col-form-label">Provinsi:</label>
                            <div class="col-lg-9">
                                <select class="form-control select" data-placeholder="Pilih Provinsi" id="province"
                                    name="prov_name" aria-label="Default select example">
                                    <option></option>
                                    <optgroup label="Provinsi">
                                        @foreach ($provincesData as $province)
                                            <option value="{{ $province['prov_id'] }}">{{ $province['prov_name'] }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-2 col-form-label">Kota/Kabupaten:</label>
                            <div class="col-lg-9">
                                <select class="form-control select" data-placeholder="Pilih Kota/Kabupaten" name="city_name"
                                    id="city" aria-label="Default select example">
                                    <option></option>
                                    <optgroup label="Kota/Kabupaten">
                                        <option value=""></option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-2 col-form-label">Kecamatan:</label>
                            <div class="col-lg-9">
                                <select class="form-control select" data-placeholder="Pilih Kecamatan" name="dis_name"
                                    id="district" aria-label="Default select example">
                                    <option></option>
                                    <optgroup label="Kecamatan">
                                        <option value=""></option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <!-- Kelurahan -->
                        <div class="row mb-3">
                            <label class="col-lg-2 col-form-label">Kelurahan:</label>
                            <div class="col-lg-9">
                                <select class="form-control select" name="subdis_name" id="subdistrict">
                                    <option selected>Pilih Kelurahan</option>
                                </select>
                                <input type="hidden" name="subdistrictId" id="valSub">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-2 col-form-label">Alamat:</label>
                            <div class="col-lg-9">
                                <textarea rows="3" cols="3" class="form-control" name="address" placeholder="Masukkan Alamat" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-2 col-form-label">Kode Pos:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="postalCode" placeholder="Kode Pos">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-2 col-form-label">Nomor Telepon:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="phoneNumber"
                                    placeholder="Masukkan Nomor Telepon Kantor">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-2 col-form-label">Nomor Faximile:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="faxNumber"
                                    placeholder="Masukkan Nomor Faximile">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-2 col-form-label">Nomor WhatsApp:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="whatsappNumber"
                                    placeholder="Masukkan Nomor WhatsApp Perusahaan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-2 col-form-label">Email:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="email"
                                    placeholder="Masukkan Email Perusahaan">
                            </div>
                        </div>
                        {{-- <div class="row mb-3">
                            <label class="col-lg-2 col-form-label">Logo Perusahaan:</label>
                            <div class="col-lg-9">
                                <input type="file" name="logo" required>
                            </div>
                        </div> --}}
                        <div class="row mb-3">
                            <label class="col-lg-2 col-form-label">Logo Perusahaan:</label>
                            <div class="col-lg-9">
                                <img id="preview" src="#" alt="Preview"
                                    style="display: none; max-width: 150px; max-height: 150px;">
                                <input type="file" class="form-control mt-2" name="logo" id="logo"
                                    onchange="previewImage(this);">
                                <div class="form-text text-muted">Format File: (*.jpg, *.jpeg, *.png) (Max 2MB)
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 mt-2">
                            <label class="col-lg-2 col-form-label">Mata Uang:</label>
                            <div class="col-lg-9">
                                @php
                                    $response = Http::get(Config('app.api_url') . 'currency/viewAll');
                                    $currency = $response->json();
                                @endphp
                                <select class="form-control select" name="currencyId" id=""
                                    placeholder="Pilih Mata Uang" aria-label="Default select example">
                                    <optgroup label="Pilih Mata Uang">
                                        @foreach ($currency['data'] as $cr)
                                            <option value="{{ $cr['IdCurrency'] }}">{{ $cr['currency'] }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11 text-end">
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
    </div>
    <script>
        $(document).ready(function() {
            $("#province").change(function() {
                var provinceId = $(this).val();
                // Gunakan AJAX untuk mengambil data kota berdasarkan provinsi
                $.get('/admin/cities/viewByProvinceId?id=', {
                    id: provinceId
                }, function(result) {
                    // Perbarui daftar kota sesuai dengan hasil dari permintaan AJAX
                    $("#city")
                        .empty(); // Kosongkan daftar kota/kabupaten sebelum memasukkan yang baru
                    $("#city").append(
                        '<option selected>Pilih Kota/Kabupaten</option>'
                    ); // Tambahkan pilihan default
                    $.each(result.citiesData, function(index, city) {
                        $("#city").append('<option value="' + city.city_id + '">' + city
                            .city_name + '</option>');
                    });
                    // Reset daftar kecamatan dan kelurahan
                    $("#district").html('<option selected>Pilih Kecamatan</option>');
                    // $("#subdistrict").html('<option selected>Pilih Kelurahan</option>');
                }, "json");
            });
            $("#city").change(function() {
                var cityId = $(this).val();
                // Gunakan AJAX untuk mengambil data kecamatan berdasarkan kota/kabupaten
                $.get('/admin/districts/viewByCityId?id=', {
                    id: cityId
                }, function(result) {
                    // Perbarui daftar kecamatan sesuai dengan hasil dari permintaan AJAX
                    $("#district").empty();
                    // Reset pilihan ke "Pilih Kecamatan" setelah daftar kecamatan diperbarui
                    $("#district").append(
                        '<option selected>Pilih Kecamatan</option>'
                    ); // Menyelaraskan pilihan dengan daftar yang baru
                    $.each(result.districtsData, function(index, district) {
                        $("#district").append('<option value="' + district.dis_id + '">' +
                            district.dis_name + '</option>');
                    });
                    $("#subdistrict").html('<option selected>Pilih Kelurahan</option>');
                }, "json");
            });
            $("#district").change(function() {
                var districtId = $(this).val();
                // Gunakan AJAX untuk mengambil data kelurahan berdasarkan kecamatan
                $.get('/admin/subdistricts/viewByDistrictId?id=', {
                    id: districtId
                }, function(result) {
                    $("#subdistrict").empty();
                    $("#subdistrict").append(
                        '<option selected>Pilih Kelurahan</option>'
                    );
                    console.log(result)
                    $.each(result.subdistrictsData, function(index, subdistrict) {
                        $("#subdistrict").append('<option value="' + subdistrict.subdis_id +
                            '">' + subdistrict.subdis_name +
                            '</option>');
                        document.getElementById("valSub").setAttribute('value', subdistrict
                            .subdis_id.toString());
                    });
                }, "json");
            });
        });
    </script>
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
    <!-- /basic layout -->
@endsection
