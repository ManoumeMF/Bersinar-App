@extends('layouts.admin.template')
@section('content')
    <script>
        const DatatableBasic = function() {


            //
            // Setup module components
            //

            // Basic Datatable examples
            const _componentDatatableBasic = function() {
                if (!$().DataTable) {
                    console.warn('Warning - datatables.min.js is not loaded.');
                    return;
                }

                // Setting datatable defaults
                $.extend($.fn.dataTable.defaults, {
                    autoWidth: false,
                    columnDefs: [{
                        orderable: false,
                        width: 100,
                        targets: [3]
                    }],
                    dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                    language: {
                        search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                        searchPlaceholder: 'Type to filter...',
                        lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                        paginate: {
                            'first': 'First',
                            'last': 'Last',
                            'next': document.dir == "rtl" ? '&larr;' : '&rarr;',
                            'previous': document.dir == "rtl" ? '&rarr;' : '&larr;'
                        }
                    }
                });

                // Basic datatable
                $('.datatable-basic').DataTable();

                // Alternative pagination
                $('.datatable-pagination').DataTable({
                    pagingType: "simple",
                    language: {
                        paginate: {
                            'next': document.dir == "rtl" ? 'Next &larr;' : 'Next &rarr;',
                            'previous': document.dir == "rtl" ? '&rarr; Prev' : '&larr; Prev'
                        }
                    }
                });

                // Datatable with saving state
                $('.datatable-save-state').DataTable({
                    stateSave: true
                });

                // Scrollable datatable
                const table = $('.datatable-scroll-y').DataTable({
                    autoWidth: true,
                    scrollY: 300
                });

                // Resize scrollable table when sidebar width changes
                $('.sidebar-control').on('click', function() {
                    table.columns.adjust().draw();
                });
            };


            //
            // Return objects assigned to module
            //

            return {
                init: function() {
                    _componentDatatableBasic();
                }
            }
        }();


        // Initialize module
        // ------------------------------

        document.addEventListener('DOMContentLoaded', function() {
            DatatableBasic.init();
        });
    </script>
    {{-- CRUD AJAX --}}
    <script>
        // Tambah PaymentType
        function addPaymentType() {
            const notyWarning = new Noty({
                text: "Semua field harus diisi sebelum mengirimkan form.",
                type: "warning",
                progressBar: false,
                layout: 'topCenter',
            });
            const notyError = new Noty({
                text: "Terjadi kesalahan saat mengirimkan data.",
                type: "error",
                progressBar: false,
                layout: 'topCenter',
            });
            $("#addPaymentTypeForm").on("submit", function(e) {
                e.preventDefault();
                let paymentTypeCodeValue = $("input[name='paymentTypeCode']").val();
                let paymentTypeNameValue = $("input[name='paymentTypeName']").val();
                let isAgingValue = $("input[name='isAging']").val();
                let descriptionValue = $("textarea[name='description']").val();
                if (paymentTypeCodeValue.trim() !== "" && paymentTypeNameValue.trim() !== "" && isAgingValue
                    .trim() !== "" && descriptionValue
                    .trim() !== "") {
                    let formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: 'tipe-pembayaran/store',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $("#modal_default_tabCreate").modal("hide");
                            $("#addPaymentTypeForm")[0].reset();
                            location.reload();
                        },
                        error: function(data) {
                            notyError.setText(data.responseText ||
                                "Terjadi kesalahan saat mengirimkan data.");
                            notyError.show();
                        },
                    });
                } else {
                    notyWarning.show();
                }
            });
        }

        // Edit PaymentType
        function editPaymentType(idPaymentType) {
            $.ajax({
                type: 'GET',
                url: 'tipe-pembayaran/edit/' + idPaymentType,
                success: function(data) {
                    $('#editPaymentTypeId').val(data.idPaymentType);
                    $('#editPaymentTypeForm input[name="paymentTypeCode"]').val(data
                        .paymentTypeCode);
                    $('#editPaymentTypeForm input[name="paymentTypeName"]').val(data
                        .paymentTypeName);
                    if (data.isAging === 1) {
                        $('#editPaymentTypeForm input[name="isAging"]').prop('checked', true);
                    } else {
                        $('#editPaymentTypeForm input[name="isAging"]').prop('checked', false);
                    }
                    $('#editPaymentTypeForm textarea[name="description"]').val(data
                        .description);
                    $('#modal_edit_' + idPaymentType).modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
        $('#paymentTypeTable').on('click', '.edit-button', function() {
            const id = $(this).data('id');
            editPaymentType(id);
        });

        // Update PaymentType
        $('#editPaymentTypeForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editPaymentTypeId').val();
            const isAging = $('#editPaymentTypeForm input[name="isAging"]').prop('checked') ? 1 : 0;
            let formData = $(this).serialize();
            formData += `&isAging=${isAging}`;
            $.ajax({
                type: 'POST',
                url: 'tipe-pembayaran/update/' + id,
                data: formData + "&_method=PUT",
                success: function(data) {
                    $('#modal_edit_' + id).modal('hide');
                    $(`#paymentTypeTable tbody tr[data-id="${id}"] td:nth-child(1)`).text($(
                        '#updatePaymentTypeForm input[name="paymentTypeCode"]').val());
                    $(`#paymentTypeTable tbody tr[data-id="${id}"] td:nth-child(2)`).text($(
                        '#updatePaymentTypeForm input[name="paymentTypeName"]').val());
                    $(`#paymentTypeTable tbody tr[data-id="${id}"] td:nth-child(3)`).checkbox($(
                        '#updatePaymentTypeForm input[name="isAging"]').val());
                    $(`#paymentTypeTable tbody tr[data-id="${id}"] td:nth-child(4)`).text($(
                        '#updatePaymentTypeForm textarea[name="description"]').val());
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });



        // Delete PaymentType
        function confirmDeletePaymentType(idPaymentType) {
            const url = 'tipe-pembayaran/destroy/' + idPaymentType;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            ajaxDelete(url, csrfToken);
        }
        // function confirmDeletePaymentType(idPaymentType) {
        //     const swalInit = swal.mixin({
        //         buttonsStyling: false,
        //         customClass: {
        //             confirmButton: "btn btn-primary",
        //             cancelButton: "btn btn-danger",
        //             denyButton: "btn btn-light",
        //         },
        //     });
        //     swalInit
        //         .fire({
        //             title: "Apakah Anda Yakin?",
        //             text: "Data yang dihapus tidak dapat dipulihkan kembali!",
        //             icon: "warning",
        //             showCancelButton: true,
        //             confirmButtonText: "Hapus",
        //             cancelButtonText: "Batal",
        //         })
        //         .then((result) => {
        //             if (result.isConfirmed) {
        //                 $.ajax({
        //                     type: "GET",
        //                     url: 'tipe-pembayaran/destroy/' + idPaymentType,
        //                     headers: {
        //                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                     },
        //                     success: function(data) {
        //                         swalInit.fire({
        //                             title: "Hapus Berhasil!",
        //                             text: "Data sudah dihapus!",
        //                             icon: "success",
        //                             showConfirmButton: false,
        //                         });
        //                         location.reload();
        //                     },
        //                     error: function(data) {
        //                         Swal.fire("Error!", "Terjadi kesalahan saat menghapus data.", "error");
        //                     },
        //                 });
        //             }
        //         });
        // }

        $(document).ready(function() {
            addPaymentType();
        });
    </script>
    <div class="card">
        <div class="card-header d-flex">
            <h5 class="mb-0">Daftar Tipe Pembayaran</h5>
            <div class="ms-auto">
                {{-- <a class="btn btn-primary" href="{{ route('paymentTypes.create') }}"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Baru</span></a> --}}
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_default_tabCreate"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Baru</span></button>
            </div>
        </div>
        <table id="paymentTypeTable" class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>Kode Jenis Pembayaran</th>
                    <th>Jenis Pembayaran</th>
                    <th>Keterangan</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($paymentType['data']) && is_array($paymentType['data']) && count($paymentType['data']) > 0)
                    @foreach ($paymentType['data'] as $pType)
                        <tr>
                            <td>{{ $pType['paymentTypeCode'] }}</td>
                            <td>{{ $pType['paymentTypeName'] }}</td>
                            <td>{{ $pType['description'] }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            {{-- <a href="{{ route('paymentTypes.show', ['id' => $pType['idPaymentType']]) }}"
                                                class="dropdown-item text-info">
                                                <i class="ph-list me-2"></i>
                                                Detail
                                            </a> --}}
                                            <a href="#" class="dropdown-item text-info" data-bs-toggle="modal"
                                                data-bs-target="#modal_detail_{{ $pType['idPaymentType'] }}">
                                                <i class="ph-list me-2"></i>
                                                Detail
                                            </a>
                                            <a href="#" class="dropdown-item text-secondary edit-occupation"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal_edit_{{ $pType['idPaymentType'] }}"
                                                data-occupation-id="{{ $pType['idPaymentType'] }}">
                                                <i class="ph-pencil me-2"></i>
                                                Edit
                                            </a>
                                            <a href="#" class="dropdown-item text-danger"
                                                onclick="confirmDeletePaymentType({{ $pType['idPaymentType'] }})">
                                                <i class="ph-trash me-2"></i>
                                                Hapus
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                @endif
            </tbody>
        </table>

        {{-- Tambah Tipe Pembayaran --}}
        <div id="modal_default_tabCreate" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Tipe Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="addPaymentTypeForm">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Kode Tipe Pembayaran:</label>
                                    <div class="col-lg-7">
                                        <input type="text" name="paymentTypeCode" class="form-control"
                                            placeholder="Masukkan Kode Tipe Pembayaran">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Tipe Pembayaran:</label>
                                    <div class="col-lg-7">
                                        <input type="text" name="paymentTypeName" class="form-control"
                                            placeholder="Masukkan Tipe Pembayaran">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-lg-4 col-form-label">Aging:</label>
                                    <div class="col-lg-7" style="padding-top: 9px">
                                        <input type="checkbox" class="form-check-input" id="cc_li_c" name="isAging">
                                        <label class="form-check-label" for="cc_li_c">Checked</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Keterangan:</label>
                                    <div class="col-lg-7">
                                        <textarea rows="3" cols="3" name="description" class="form-control" placeholder="Masukkan Keterangan"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Edit Tipe Pembayaran --}}
        @if (isset($paymentType['data']) && is_array($paymentType['data']) && count($paymentType['data']) > 0)
            @foreach ($paymentType['data'] as $pType)
                <div id="modal_edit_{{ $pType['idPaymentType'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Tipe Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="editPaymentTypeForm_{{ $pType['idPaymentType'] }}"
                                action="{{ route('paymentTypes.update', ['id' => $pType['idPaymentType']]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Kode Tipe Pembayaran:</label>
                                            <div class="col-lg-7">
                                                <input type="text" name="paymentTypeCode" class="form-control"
                                                    value="{{ $pType['paymentTypeCode'] }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Tipe Pembayaran:</label>
                                            <div class="col-lg-7">
                                                <input type="text" name="paymentTypeName" class="form-control"
                                                    value="{{ $pType['paymentTypeName'] }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-lg-4 col-form-label">Aging:</label>
                                            <div class="col-lg-7" style="padding-top: 9px">
                                                <input type="checkbox" class="form-check-input" id="cc_li_c"
                                                    name="isAging" @if ($pType['isAging'] == 1) checked @endif>
                                                <label class="form-check-label" for="cc_li_c">Checked</label>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Keterangan:</label>
                                            <div class="col-lg-7">
                                                <textarea rows="3" cols="3" name="description" class="form-control">{{ $pType['description'] }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
        @endif

        {{-- Detail Tipe Pembayaran --}}
        @if (isset($paymentType['data']) && is_array($paymentType['data']) && count($paymentType['data']) > 0)
            @foreach ($paymentType['data'] as $pType)
                <div id="modal_detail_{{ $pType['idPaymentType'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Tipe Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row mb-2">
                                        <label for="detail_paymentType_code" class="col-lg-5 col-form-label">Kode Jenis
                                            Pembayaran:</label>
                                        <div class="col-lg-6">
                                            <label id="detail_paymentType_code"
                                                class="col-form-label">{{ $pType['paymentTypeCode'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_paymentType_name" class="col-lg-5 col-form-label">Jenis
                                            Pembayaran:</label>
                                        <div class="col-lg-6">
                                            <label id="detail_paymentType_name"
                                                class="col-form-label">{{ $pType['paymentTypeName'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_paymentType_description"
                                            class="col-lg-5 col-form-label">Keterangan:</label>
                                        <div class="col-lg-6">
                                            <label id="detail_paymentType_description"
                                                class="col-form-label">{{ $pType['description'] }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
        @endif
    </div>
    @if (isset($paymentType['data']) && is_array($paymentType['data']) && count($paymentType['data']) > 0)
        @foreach ($paymentType['data'] as $pType)
            <form id="delete-form-{{ $pType['idPaymentType'] }}"
                action="{{ route('paymentTypes.destroy', $pType['idPaymentType']) }}" method="POST"
                style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @else
    @endif
    <script></script>
@endsection
