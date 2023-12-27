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

    <script>
        $(document).ready(function() {
            var rowIdx = 0;
            $("#addBarang").on("click", function() {
                $("#tblBarang tbody").append('<tr>' +
                    '<td>' +
                    '<div class="row-sm-3">' +
                    '<div class="input-group">' +
                    ' <select data-placeholder="P17 - Plastik kresek"class="form-control select">' +
                    '<option></option>' +
                    '<option value="1">Mudah Pecah</option>' +
                    '<option value="2">Organik</option>' +
                    '<option value="3">Anorganik</option>' +
                    '</select>' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '<td>' +
                    '<div class="row-sm-3">' +
                    '<div class="input-group">' +
                    '<select data-placeholder="Kilogram" class="form-control select">' +
                    '<option></option>' +
                    '<option value="1">Mudah Pecah</option>' +
                    '<option value="2">Organik</option>' +
                    '<option value="3">Anorganik</option>' +
                    '</select>' +
                    '</td>' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '<td>' +
                    '<div class="row-sm-3">' +
                    '<input type="text" class="form-control" value="20.00">' +
                    '</div>' +
                    '</td>' +
                    '<td>' +
                    '<div class="row-sm-3">' +
                    '<input type="text" class="form-control" value="3000.00">' +
                    '</div>' +
                    '</td>' +
                    '<td>' +
                    '<div class="d-flex align-items-center">' +
                    '<div class="row-3">' +
                    '<label class="percent-symbol">&#37;</label>' +
                    '<input type="checkbox" style="width: 20px; height: 20px;">' +
                    '</div>' +
                    '<div class="col-7">' +
                    '<input type="text" class="form-control ms-2" value="00,00">' +
                    ' </div>' +
                    '</div>' +
                    '</td>' +
                    '<td>' +
                    '<div class="d-flex align-items-center">' +
                    '<div class="row-3">' +
                    '<label class="percent-symbol">&#37;</label>' +
                    '<input id="2" type="checkbox"style="width: 20px; height: 20px;">' +
                    '</div>' +
                    '<div class="col-7">' +
                    '<input type="text" class="form-control ms-2" value="00,00">' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '<td>' +
                    '<div class="row-sm-3">' +
                    '<input type="text" class="form-control" value="650000">' +
                    '</div>' +
                    '</td>' +
                    '<td  style="text-align: center">' +
                    '<a href="#"class="btn btn-flat-danger btn-icon w-24px h-24px rounded-pill" id="delBarang"><i class="ph-x ph-sm"></i></a>' +
                    '</td>' +
                    '</tr>');
                $('.select').select2();
            });
            $(document).on('click', '#delBarang', function() {
                $(this).closest('tr').remove();
                return false;
            });

        });
    </script>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Sales Order</h5>
        </div>
        <div class="card-body border-top">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <form action="#">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">No. Sales Order:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" value="BSR/PNB/2023.10/00001" readonly>
                            </div>
                            <label for="tanggal_kirim" class="col-sm-2 offset-1 col-form-label">Tipe Pembayaran:</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <select data-placeholder="Pilih Tipe Pembayaran" class="form-control select">
                                        <option></option>
                                        <option value="1">Mudah Pecah</option>
                                        <option value="2">Organik</option>
                                        <option value="3">Anorganik</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Offtaker:</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <select data-placeholder="Pilih Offtaker" class="form-control select">
                                        <option></option>
                                        <option value="1">Mudah Pecah</option>
                                        <option value="2">Organik</option>
                                        <option value="3">Anorganik</option>
                                    </select>
                                </div>
                            </div>
                            <label for="tanggal_kirim" class="col-sm-2 offset-1 col-form-label">Mata Uang:</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <select data-placeholder="Pilih Mata Uang" class="form-control select">
                                        <option></option>
                                        <option value="1">Mudah Pecah</option>
                                        <option value="2">Organik</option>
                                        <option value="3">Anorganik</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label for="supplier" class="col-sm-4 col-form-label">Tanggal Dibuat SO:</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <input id="tanggal-pembelian" type="text"
                                                class="form-control datepicker-autohide" placeholder="20-03-2023">
                                            <span class="input-group-text">
                                                <i class="ph-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="supplier" class="col-sm-4 col-form-label">Tanggal Kirim SO:</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <input id="tanggal-pembelian" type="text"
                                                class="form-control datepicker-autohide2" placeholder="20-03-2023">
                                            <span class="input-group-text">
                                                <i class="ph-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="supplier" class="col-sm-4 col-form-label">Tanggal kirim Barang:</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <input id="tanggal-pembelian" type="text"
                                                class="form-control datepicker-autohide3" placeholder="20-03-2023">
                                            <span class="input-group-text">
                                                <i class="ph-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="keterangan" class="col-sm-4 col-form-label">Keterangan:</label>
                                    <div class="col-sm-6">
                                        <textarea rows="4" cols="50" class="form-control" placeholder="Masukkan Keterangan"></textarea>
                                    </div>
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

                                        <th>Nama Barang</th>
                                        <th>Satuan Barang</th>
                                        <th>Jumlah</th>
                                        <th>Harga Satuan</th>
                                        <th>Diskon</th>
                                        <th>Pajak</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">

                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-2">
                            <div class="table-responsive">
                                <table class="summary-table">
                                    <tbody>
                                        <tr>
                                            <td><strong>Sub Total</strong></td>
                                            <td>Rp.650.000</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Diskon</strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <label class="percent-symbol">&#37;</label>
                                                    <input type="checkbox" style="width: 20px; height: 20px;">
                                                    <input type="text" class="form-control ms-2" value="00,00"
                                                        style="width: 70px;">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pajak</strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <label class="percent-symbol">&#37;</label>
                                                    <input type="checkbox" style="width: 20px; height: 20px;">
                                                    <input type="text" class="form-control ms-2" value="00,00"
                                                        style="width: 70px;">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Ongkos Kirim</strong></td>
                                            <td>
                                                <input type="text" class="form-control" value="0,00" readonly
                                                    style="width: 70px;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Grand Total</strong></td>
                                            <td>Rp.650.000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 text-end mb-3">
                                <button type="submit" class="btn btn-primary">Simpan<i
                                        class="ph-check-circle ms-2"></i></button>
                                <button type="reset" class="btn btn-danger">Batal<i
                                        class="ph-x-circle ms-2"></i></button>
                            </div>
                        </div>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .summary-table td:nth-child(1) {
            width: 130px;
            text-align: right;
            padding-right: 15px;
            padding-top: 15px;
        }

        .summary-table td:nth-child(2) {
            width: 340px;
            text-align: left;
            padding-left: 100px;
            padding-top: 15px;
        }

        .table-responsive {
            max-width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        @media only screen and (max-width: 768px) {
            .summary-table td:nth-child(1) {
                width: auto;
                padding-right: 8px;
            }

            .summary-table td:nth-child(2) {
                width: auto;
                padding-left: 8px;
            }
        }
    </style>
@endsection
