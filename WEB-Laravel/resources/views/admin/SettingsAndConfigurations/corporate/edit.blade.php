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
            <h5 class="mb-0">Edit Perusahaan/Institusi</h5>
        </div>
        <div class="card-body border-top">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <form action="{{ route('corporate.update', ['id' => $corporate['corporateId']]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Kode Perusahaan/Institusi -->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Kode Perusahaan/Institusi:</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="corporateCode"
                                    value="{{ $corporate['corporateCode'] }}" required>
                            </div>
                        </div>
                        <!-- Nama Perusahaan/Institusi -->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Nama Perusahaan/Institusi:</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="corporateName"
                                    value="{{ $corporate['corporateName'] }}" required>
                            </div>
                        </div>
                        <!-- Nomor NPWP -->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Nomor NPWP:</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="taxId" value="{{ $corporate['taxId'] }}"
                                    required>
                            </div>
                        </div>
                        <!-- Negara -->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Negara:</label>
                            <div class="col-lg-8">
                                <select class="form-select" name="country">
                                    <option value="1">Indonesia</option>
                                    <!-- ...other options... -->
                                </select>
                            </div>
                        </div>
                        <!-- Provinsi -->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Provinsi:</label>
                            <div class="col-lg-8">
                                <select class="form-select" name="prov_name" id="province">
                                    <option></option>
                                    @php
                                        $response = Http::get(Config('app.api_url') . 'provinces/viewAll');
                                        $provincesData = $response->json();
                                    @endphp
                                    <optgroup label="Provinsi">
                                        @foreach ($provincesData['data'] as $province)
                                            <option value="{{ $province['prov_id'] }}"
                                                {{ $corporate['prov_name'] == $province['prov_name'] ? 'selected' : '' }}>
                                                {{ $province['prov_name'] }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <!-- Kota/Kabupaten -->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Kota/Kabupaten:</label>
                            <div class="col-lg-8">
                                <select class="form-select" name="city_name" id="city">
                                    <option></option>
                                    @php
                                        $response = Http::get(Config('app.api_url') . 'cities/viewAll');
                                        $citiesData = $response->json();
                                    @endphp
                                    <optgroup label="Kota/Kabupaten">
                                        @foreach ($citiesData['data'] as $city)
                                            <option value="{{ $city['city_id'] }}"
                                                {{ $corporate['city_name'] == $city['city_name'] ? 'selected' : '' }}>
                                                {{ $city['city_name'] }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <!-- Kecamatan -->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Kecamatan:</label>
                            <div class="col-lg-8">
                                <select class="form-select" name="dis_name" id="district">
                                    <option></option>
                                    @php
                                        $response = Http::get(Config('app.api_url') . 'districts/viewAll');
                                        $districtsData = $response->json();
                                    @endphp
                                    <optgroup label="Kota/Kabupaten">
                                        @foreach ($districtsData['data'] as $districts)
                                            <option value="{{ $districts['dis_id'] }}"
                                                {{ $corporate['dis_name'] == $districts['dis_name'] ? 'selected' : '' }}>
                                                {{ $districts['dis_name'] }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <!-- Kelurahan -->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Kelurahan:</label>
                            <div class="col-lg-8">
                                <select class="form-select" name="subdis_name" id="subdistrict">
                                    <option></option>
                                    @php
                                        $response = Http::get(Config('app.api_url') . 'subdistricts/viewAll');
                                        $subdistrictsData = $response->json();
                                    @endphp
                                    <optgroup label="Kota/Kabupaten">
                                        @foreach ($subdistrictsData['data'] as $subdistricts)
                                            <option value="{{ $subdistricts['subdis_id'] }}"
                                                {{ $corporate['subdis_name'] == $subdistricts['subdis_name'] ? 'selected' : '' }}>
                                                {{ $subdistricts['subdis_name'] }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                <input type="hidden" name="subdistrictId" id="valSub">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Alamat:</label>
                            <div class="col-lg-8">
                                <textarea class="form-control" name="address" required>{{ $corporate['address'] }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Kode Pos:</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="postalCode"
                                    value="{{ $corporate['postalCode'] }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Nomor Telepon:</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="phoneNumber"
                                    value="{{ $corporate['phoneNumber'] }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Nomor Faximile:</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="faxNumber"
                                    value="{{ $corporate['faxNumber'] }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Nomor WhatsApp:</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="whatsappNumber"
                                    value="{{ $corporate['whatsAppNumber'] }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Email:</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="email"
                                    value="{{ $corporate['email'] }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Logo Perusahaan:</label>
                            <div class="col-lg-8">
                                <input type="file" name="logo" value="{{ $corporate['logo'] }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Mata Uang:</label>
                            <div class="col-lg-8">
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
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn btn-danger">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // document.getElementById("valSub").setAttribute('value', $subdistrictsData['data'].['subdis_id'].toString);
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
@endsection
