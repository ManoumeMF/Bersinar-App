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
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Penerimaan Barang</h5>
        </div>
        <div class="card-body border-top">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <form action="#">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Tanggal Terima:</label>
                            {{-- <div class="col-sm-6">
                                <div class="input-group">
                                    <input id="tanggal-kirim" type="text" class="form-control datepicker-autohide"
                                        placeholder="31 - 10 - 2023">
                                    <span class="input-group-text">
                                        <i class="ph-calendar"></i>
                                    </span>
                                </div>
                            </div> --}}
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input id="tanggal-kirim" type="text" class="form-control datepicker-autohide"
                                        placeholder="31 - 10 - 2023">
                                    <span class="input-group-text">
                                        <i class="ph-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Waktu Terima:</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" class="form-control timepicker-autohide " value="09 : 00 AM">
                                    <span class="input-group-text"><i class="ph-clock"></i></span>
                                </div>
                            </div>
                            {{-- <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" class="form-control timepicker-autohide " value="09 : 00 AM">
                                    <span class="input-group-text"><i class="ph-clock"></i></span>
                                </div>
                            </div> --}}
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">No. Surat Jalan:</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <select data-placeholder="Pilih No. Surat Jalan" class="form-control select">
                                        <option></option>
                                        <option value="1">Mudah Pecah</option>
                                        <option value="2">Organik</option>
                                        <option value="3">Anorganik</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Pilih No. Penimbangan:</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <select data-placeholder="Pilih No. Penimbangan" class="form-control select">
                                        <option></option>
                                        <option value="1">Mudah Pecah</option>
                                        <option value="2">Organik</option>
                                        <option value="3">Anorganik</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Nasabah:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="Jhoe Doe" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Diterima Oleh:</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <select data-placeholder="Pilih Penerima" class="form-control select">
                                        <option></option>
                                        <option value="1">Jhoe Doe Manik</option>
                                        <option value="2">Parningotan Manurung</option>
                                        <option value="3">Binsar Silaen</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Diserahkan Oleh:</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <select data-placeholder="Pilih Petugas" class="form-control select">
                                        <option></option>
                                        <option value="1">Jhoe Doe Manik</option>
                                        <option value="2">Parningotan Manurung</option>
                                        <option value="3">Binsar Silaen</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="keterangan" class="col-sm-3 col-form-label">Keterangan:</label>
                            <div class="col-sm-6">
                                <textarea rows="4" cols="100" class="form-control" placeholder="Masukkan Keterangan"></textarea>
                            </div>
                        </div>
                </div>
                </form>
                <div>

                    <div class="table-responsive">
                        <table class="table table-bordered mt-2">
                            <thead class="text-center">
                                <tr>
                                    {{-- <th class="col-md-5">Nama Barang</th>
                                                <th class="col-md-3">Satuan Barang</th>
                                                <th class="col-md-3">Jumlah</th>
                                                <th class="col-md-1">Aksi</th> --}}
                                    <th>Nama Barang</th>
                                    <th>Satuan Barang</th>
                                    <th>Total Penimbangan</th>
                                    <th>Sisa Penimbangan</th>
                                    <th>Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td>Nama Barang - 1</td>
                                    <td>Kilogram</td>
                                    <td>34.00</td>
                                    <td>34.00</td>
                                    <td>
                                        <input style="text-align: right" type="text" class="form-control "
                                            placeholder="34.00">
                                    </td>
                                    <td>
                                        <a class="badge bg-danger" href="#"><i class="ph ph-x-circle"></i><span
                                                class="d-none d-sm-inline-block"></span></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 text-end mb-3">
                            <button type="submit" class="btn btn-primary">Simpan<i
                                    class="ph-check-circle ms-2"></i></button>
                            <button type="reset" class="btn btn-danger">Batal<i class="ph-x-circle ms-2"></i></button>
                        </div>
                    </div>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
        </table>
    </div>
@endsection
