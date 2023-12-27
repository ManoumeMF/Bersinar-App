@extends('layouts.admin.template')
@section('content')
    <script>
        $(document).ready(function() {
            var rowIdx = 0;
            $("#addBarang").on("click", function() {
                $("#tblBarang tbody").append('<tr>' +
                    '<td>' +
                    '</td>' +
                    '<td>' +
                    '</td>' +
                    '<td>' +
                    '</td>' +
                    '<td>' +
                    '<input style="text-align: right" type="text" class="form-control " placeholder="0">' +
                    '</td>' +
                    '<td>' +
                    '<input style="text-align: right" type="text" class="form-control " placeholder="">' +
                    '</td>' +
                    '<td style="text-align: center">' +
                    '<a href="#"class="btn btn-flat-danger btn-icon w-24px h-24px rounded-pill" id="delBarang"><i class="ph-x ph-sm"></i></a>' +
                    '</td>' +
                    +'</tr>');
                $('.select').select2();
            });
            $(document).on('click', '#delBarang', function() {
                $(this).closest('tr').remove();
                return false;
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

            const dpAutoHideElement2 = document.querySelector('.datepicker-autohide2');
            if (dpAutoHideElement2) {
                const dpAutoHide = new Datepicker(dpAutoHideElement2, {
                    container: '.content-inner',
                    buttonClass: 'btn',
                    prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                    nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                    autohide: true
                });
            }

            const dpAutoHideElement3 = document.querySelector('.datepicker-autohide3');
            if (dpAutoHideElement3) {
                const dpAutoHide = new Datepicker(dpAutoHideElement3, {
                    container: '.content-inner',
                    buttonClass: 'btn',
                    prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                    nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                    autohide: true
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
            <h5 class="mb-0">Tambah Penyesuaian Stok Barang</h5>
        </div>
        <div class="card-body border-top">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <form action="#">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">No. Penyesuaian Stok Barang:</label>
                            <div class="col-sm-6">
                                 <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Masukkan No. Penyesuaian Stok Barang">
                                   
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Tanggal Penyesuaian Stok Barang:</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input id="tanggal-pembelian" type="text"
                                        class="form-control datepicker-autohide2" placeholder="23-03-2023">
                                    <span class="input-group-text">
                                        <i class="ph-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Waktu Penyesuaian Stok Barang:</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" class="form-control timepicker-autohide " value="09 : 00 AM">
                                    <span class="input-group-text"><i class="ph-clock"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Diproses Oleh:</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <select data-placeholder="Petugas" class="form-control select">
                                        <option></option>
                                        <option value="1">Mudah Pecah</option>
                                        <option value="2">Organik</option>
                                        <option value="3">Anorganik</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Berdasarkan Barang:</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <select data-placeholder="Pilih Barang" class="form-control select">
                                        <option></option>
                                        <option value="1">Mudah Pecah</option>
                                        <option value="2">Organik</option>
                                        <option value="3">Anorganik</option>
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
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" id="addBarang"><i class="ph-plus-circle"></i><span
                            class="d-none d-lg-inline-block ms-2">Tambah Barang</span>
                    </button>
                </div>
                <div>

                    <div class="table-responsive">
                        <table class="table table-bordered mt-2" id="tblBarang">
                            <thead class="text-center">
                                <tr>
                                    {{-- <th class="col-md-5">Nama Barang</th>
                                                <th class="col-md-3">Satuan Barang</th>
                                                <th class="col-md-3">Jumlah</th>
                                                <th class="col-md-1">Aksi</th> --}}

                                    <th>Tempat Penyimpanan</th>
                                    <th>Nama Barang</th>
                                    <th>Stok</th>
                                    <th>Penyesuaian</th>
                                    <th>Alasan Penyesuaian</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text">

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
    </div>
    </div>
@endsection
