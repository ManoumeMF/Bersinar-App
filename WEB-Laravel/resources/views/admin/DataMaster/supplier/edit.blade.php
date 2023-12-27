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
            <h5 class="mb-0">Edit Nasabah</h5>
        </div>
        <div class="card-body border-top">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <form action="{{ route('supplier.update', ['id' => $editSupplier['supplierId']]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Jenis Nasabah:</label>
                            <div class="col-lg-7">
                                @php
                                    $response = Http::get(Config('app.api_url') . 'supplier/viewCombo');
                                    $partnerTypeCbo = $response->json();
                                @endphp
                                <div class="input-group">
                                    <select class="form-control select" name="partnerTypeId" data-width="1%">
                                        <option></option>
                                        <optgroup label="Kategori Nasabah">
                                            @foreach ($partnerTypeCbo['data'] as $pCb)
                                                <option value="{{ $pCb['partnerTypeId'] }}"
                                                    {{ $pCb['partnerTypeId'] == $editSupplier['partnerTypeId'] ? 'selected' : '' }}>
                                                    {{ $pCb['partnerType'] }}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <button type="button" class="btn btn-primary "><i class="ph-plus-circle"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Kode Nasabah:</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control" value="{{ $editSupplier['supplierCode'] }}"
                                    name="supplierCode" required>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Nama Lengkap:</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control" value="{{ $editSupplier['fullName'] }}"
                                    name="fullName" required>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Jenis Kelamin:</label>
                            <div class="col-lg-7">
                                <div class="form-check-horizontal">
                                    @php
                                        $sex = $editSupplier['sex'];
                                    @endphp
                                    <label class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="sex" value="Laki-laki"
                                            {{ $sex === 'Laki-laki' ? 'checked' : '' }}>
                                        <span class="form-check-label">Laki-laki</span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="sex" value="Perempuan"
                                            {{ $sex === 'Perempuan' ? 'checked' : '' }}>
                                        <span class="form-check-label">Perempuan</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Tempat, Tanggal Lahir:</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" value="{{ $editSupplier['birthPlace'] }}"
                                    name="birthPlace">
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ph-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control datepicker-autohide"
                                        value="{{ $editSupplier['birthDate'] }}" name="birthDate">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Email:</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control" value="{{ $editSupplier['email'] }}"
                                    name="email">
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Nomor Telepon:</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control" value="{{ $editSupplier['mobileNumber'] }}"
                                    name="mobileNumber">
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">WhatsApp:</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control" value="{{ $editSupplier['whatsAppNumber'] }}"
                                    name="whatsAppNumber">
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Pekerjaan:</label>
                            <div class="col-lg-7">
                                @php
                                    $response = Http::get(Config('app.api_url') . 'occupation/viewAll');
                                    $occupationData = $response->json();
                                @endphp
                                <div class="input-group">
                                    <select data-placeholder="Pilih Pekerjaan" name="occupationId"
                                        class="form-control select" data-width="1%">
                                        <option></option>
                                        <optgroup label="Pekerjaan">
                                            @foreach ($occupationData['data'] as $oD)
                                                <option value="{{ $oD['occupationId'] }}"
                                                    {{ $oD['occupationId'] == $editSupplier['occupationId'] ? 'selected' : '' }}>
                                                    {{ $oD['occupationName'] }}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <button type="button" class="btn btn-primary "><i class="ph-plus-circle"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Nama Ibu Kandung:</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control" value="{{ $editSupplier['mothersName'] }}"
                                    name="mothersName">
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Penanggung Jawab:</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control"
                                    value="{{ $editSupplier['responsiblePerson'] }}" name="responsiblePerson">
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label class="col-lg-3 col-form-label">Foto Nasabah:</label>
                            <div class="col-lg-7">
                                <img id="preview" src="#" alt="Preview"
                                    style="display: none; max-width: 200px; max-height: 200px;">
                                <input type="file" class="form-control" name="supplierPhoto" id="supplierPhoto"
                                    onchange="previewImage(this);">
                                <div class="form-text text-muted">Format File: (*.jpg, *.jpeg, *.png) (Max 2MB)
                                </div>
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
