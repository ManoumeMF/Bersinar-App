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
            <h5 class="mb-0">Tambah Perusahaan/Institusi</h5>
        </div>
        <div class="card-body border-top">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <form action="{{ route('corporate.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Kode Perusahaan/Institusi -->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Kode Perusahaan/Institusi:</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="corporateCode"
                                    placeholder="Masukkan Kode Perusahaan/Institusi" required>
                            </div>
                        </div>
                        <!-- Nama Perusahaan/Institusi -->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Nama Perusahaan/Institusi:</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="corporateName"
                                    placeholder="Masukkan Nama Perusahaan/Institusi" required>
                            </div>
                        </div>
                        <!-- Nomor NPWP -->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Nomor NPWP:</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="taxId" placeholder="Masukkan Nomor NPWP"
                                    required>
                            </div>
                        </div>
                        <!-- Negara -->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Negara:</label>
                            <div class="col-lg-8">
                                <select class="form-select" name="country">
                                    <option selected>Pilih Negara</option>
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
                                    <option selected>Pilih Provinsi</option>
                                    @foreach ($provincesData as $province)
                                        <option value="{{ $province['prov_id'] }}">{{ $province['prov_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Kota/Kabupaten -->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Kota/Kabupaten:</label>
                            <div class="col-lg-8">
                                <select class="form-select" name="city_name" id="city">
                                    <option selected>Pilih Kota/ Kabupaten</option>
                                </select>
                            </div>
                        </div>
                        <!-- Kecamatan -->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Kecamatan:</label>
                            <div class="col-lg-8">
                                <select class="form-select" name="dis_name" id="district">
                                    <option selected>Pilih Kecamatan</option>
                                </select>
                            </div>
                        </div>
                        <!-- Kelurahan -->
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Kelurahan:</label>
                            <div class="col-lg-8">
                                <select class="form-select" name="subdis_name" id="subdistrict">
                                    <option selected>Pilih Kelurahan</option>
                                </select>
                                <input type="hidden" name="subdistrictId" id="valSub">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Alamat:</label>
                            <div class="col-lg-8">
                                <textarea class="form-control" name="address" placeholder="Masukkan Alamat" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Kode Pos:</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="postalCode" placeholder="Kode Pos"
                                    required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Nomor Telepon:</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="phoneNumber"
                                    placeholder="Masukkan Nomor Telpon Kantor" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Nomor Faximile:</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="faxNumber"
                                    placeholder="Masukkan Nomor Faximile" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Nomor WhatsApp:</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="whatsAppNumber"
                                    placeholder="Masukkan Nomor Telpon Kantor" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Email:</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="email"
                                    placeholder="Masukkan Email Perusahaan" required>
                            </div>
                        </div>
                        {{-- <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Logo Perusahaan:</label>
                            <div class="col-lg-8">
                                <input type="file" name="logo" required>
                            </div>
                        </div> --}}
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Logo Perusahaan:</label>
                            <div class="col-lg-8">
                                <img id="preview" src="#" alt="Preview"
                                    style="display: none; max-width: 150px; max-height: 150px;">
                                <input type="file" class="form-control mt-2" name="logo" id="logo"
                                    onchange="previewImage(this);">
                                <div class="form-text text-muted">Format File: (*.jpg, *.jpeg, *.png) (Max 2MB)
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 mt-2">
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
@endsection
