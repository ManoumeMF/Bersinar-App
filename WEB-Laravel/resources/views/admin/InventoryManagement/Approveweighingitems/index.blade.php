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
    $(document).ready(function () { 

    // Denotes total number of rows 
    var rowIdx = 0; 

    // jQuery button click event to add a row 
    $("#addBarang").on("click", function () { 

    // Adding a row inside the tbody. 
    $("#tblBarang tbody").append('<tr>'
            +'<td>'
                +'<div class="input-group">'
                +'<select data-placeholder="Pilih Barang" class="form-control form-control-sm select" data-container-css-class="select-sm" >'
                    +'<option></option>'
                        +'<option value="1">Reguler</option>'
                        +'<option value="2">Prioritas</option>'
                        +'<option value="3">VVIP</option>'
                    +'</select>'
                +'</div>'
            +'</td>'
            +'<td>'
                +'<div class="input-group">'
                +'<select data-placeholder="Pilih Satuan Barang" class="form-control form-control-sm select" data-container-css-class="select-sm">'
                    +'<option></option>'
                        +'<option value="1">Reguler</option>'
                        +'<option value="2">Prioritas</option>'
                        +'<option value="3">VVIP</option>'
                    +'</select>'
                +'</div>'
            +'</td>'
            +'<td>'
                +'<input style="text-align: right" type="text" class="form-control" placeholder="10.00">'
            +'</td>'
            +'<td  style="text-align: center">'
                +'<a href="#"class="btn btn-flat-danger btn-icon w-24px h-24px rounded-pill" id="delBarang"><i class="ph-x ph-sm"></i></a>'
            +'</td>'
        +'</tr>');
        $('.select').select2();
       
    }); 

    $(document).on('click', '#delBarang', function () {
     $(this).closest('tr').remove();
     return false;
    });

    
});


</script>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Penimbangan Barang</h5>
        </div>
        <div class="card-body border-top">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <form action="#">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">No. Penimbangan Barang:</label>
                            <div class="col-sm-3">
                                {{-- <input type="text" class="form-control" value="BSR/PNB/2023.10/00001" readonly> --}}
                                <input style="padding-top: 8px" type="text" class="form-control-plaintext" readonly
                                    value="BSR/PNB/2023.10/00001">
                            </div>
                            <label for="tanggal_kirim" class="col-sm-2 offset-1 col-form-label">Tanggal Jemput
                                Barang:</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input id="tanggal-kirim" type="text" class="form-control datepicker-autohide"
                                        placeholder="Pilih Tanggal Jemput">
                                    <span class="input-group-text">
                                        <i class="ph-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label for="supplier" class="col-sm-4 col-form-label">No. Surat Jalan:</label>
                                    <div class="col-sm-3">
                                        {{-- <input type="text" class="form-control" value="BSR/PNB/2023.10/00001" readonly> --}}
                                        <input style="padding-top: 8px" type="text" class="form-control-plaintext" readonly
                                            value="BSR/PNB/2023.10/00001">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="supplier" class="col-sm-4 col-form-label">Nasabah:</label>
                                    <div class="col-sm-3">
                                        {{-- <input type="text" class="form-control" value="BSR/PNB/2023.10/00001" readonly> --}}
                                        <input style="padding-top: 8px" type="text" class="form-control-plaintext" readonly
                                            value="Jhoe Doe">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="supplier" class="col-sm-4 col-form-label">Tanggal Penimbangan:</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <input id="2" type="text" class="form-control datepicker-autohide2"
                                                placeholder="Pilih Tanggal Penimbangan">
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
                                        <textarea rows="4" cols="50" class="form-control" placeholder="Ada Perubahan"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" id="addBarang"><i
                                    class="ph-plus-circle"></i><span class="d-none d-lg-inline-block ms-2">Tambah
                                    Barang</span>
                            </button>
                        </div>
                        <div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-xs mt-2" id="tblBarang">
                                    <thead class="text-center">
                                        <tr>
                                            <th class="col-md-5">Nama Barang</th>
                                            <th class="col-md-3">Satuan Barang</th>
                                            <th class="col-md-3">Jumlah</th>
                                            <th class="col-md-1">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text">

                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end mt-2">
                                <div class="table-responsive">
                                    <table class="summary-table">
                                        <tbody>
                                            <tr>
                                                <td><strong>Grand Total</strong></td>
                                                <td>Rp.650.000</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12 text-center mb-3">
                                    <button type="submit" class="btn btn-primary">Simpan<i
                                            class="ph-check-circle ms-2"></i></button>
                                    <button type="reset" class="btn btn-danger">Batal<i
                                            class="ph-x-circle ms-2"></i></button>
                                </div>
                            </div>
                            {{-- </div> --}}
                        </div>
                    </form>
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
            width: 400px;
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
