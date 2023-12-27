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
                        targets: [6]
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
    <div class="card">
        <div class="card-header d-flex">
            <h5 class="mb-0">Daftar Offtaker</h5>
            <div class="ms-auto">
                <a class="btn btn-primary" href="{{ route('offtaker.create') }}"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Offtaker</span></a>
            </div>
        </div>
        <table class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>Kode Pabrik/Lapak/Offtaker</th>
                    <th>Nama Pabrik/Lapak/Offtaker</th>
                    <th>Jenis Pabrik/Lapak/Offtaker</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>WhatsApp Number</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customer['data'] as $offtaker)
                    <tr>
                        <td>{{ $offtaker['customerCode'] }}</td>
                        <td>{{ $offtaker['customerName'] }}</td>
                        <td>{{ $offtaker['partnerType'] }}</td>
                        <td>{{ $offtaker['customerAddress'] }}</td>
                        <td>{{ $offtaker['teleponNumber'] }}</td>
                        <td>{{ $offtaker['whatsappNumber'] }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex">
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#" class="dropdown-item text-info detail-link" data-bs-toggle="modal"
                                            data-bs-target="#modal_detail_{{ $offtaker['customerId'] }}"
                                            data-status-id="{{ $offtaker['customerId'] }}">
                                            <i class="ph-list me-2"></i>
                                            Detail
                                        </a>
                                        <a href=""
                                            class="dropdown-item text-secondary">
                                            <i class="ph-pencil me-2"></i>
                                            Edit
                                        </a>
                                        <a href="#" class="dropdown-item text-danger"
                                            onclick="confirmDeleteOfftaker({{ $offtaker['customerId'] }})">
                                            <i class="ph-trash me-2"></i>
                                            Hapus
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- Detail Modal --}}
    @if (isset($customer['data']) && is_array($customer['data']) && count($customer['data']) > 0)
        @foreach ($customer['data'] as $offtaker)
            <div id="modal_detail_{{ $offtaker['customerId'] }}" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Offtaker</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row mb-2">
                                    <label for="detail_customerCode" class="col-lg-4 col-form-label">Kode Offtaker
                                        :</label>
                                    <div class="col-lg-7">
                                        <label id="detail_customerCode" class="col-form-label">
                                            {{ $offtaker['offtakerDetail']['customerCode'] }}
                                        </label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="detail_customerName" class="col-lg-4 col-form-label">Nama Offtaker
                                        :</label>
                                    <div class="col-lg-7">
                                        <label id="detail_customerName" class="col-form-label">
                                            {{ $offtaker['offtakerDetail']['customerName'] }}
                                        </label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="detail_email" class="col-lg-4 col-form-label">Email
                                        :</label>
                                    <div class="col-lg-7">
                                        <label id="detail_email" class="col-form-label">
                                            {{ $offtaker['offtakerDetail']['email'] }}
                                        </label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="detail_partnerType" class="col-lg-4 col-form-label">Jenis Offtaker
                                        :</label>
                                    <div class="col-lg-7">
                                        <label id="detail_partnerType" class="col-form-label">
                                            {{ $offtaker['offtakerDetail']['partnerType'] }}
                                        </label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="detail_teleponNumber" class="col-lg-4 col-form-label">Telepon:</label>
                                    <div class="col-lg-7">
                                        <label id="detail_teleponNumber"
                                            class="col-form-label">{{ $offtaker['offtakerDetail']['teleponNumber'] }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="detail_whatsappNumber" class="col-lg-4 col-form-label">WhatsApp
                                        Number:</label>
                                    <div class="col-lg-7">
                                        <label id="detail_whatsappNumber"
                                            class="col-form-label">{{ $offtaker['offtakerDetail']['whatsappNumber'] }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="detail_faxNumber" class="col-lg-4 col-form-label">
                                        FaxNumber:</label>
                                    <div class="col-lg-7">
                                        <label id="detail_faxNumber"
                                            class="col-form-label">{{ $offtaker['offtakerDetail']['faxNumber'] }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="detail_mobileNumber" class="col-lg-4 col-form-label">Mobile
                                        Number:</label>
                                    <div class="col-lg-7">
                                        <label id="detail_mobileNumber"
                                            class="col-form-label">{{ $offtaker['offtakerDetail']['whatsappNumber'] }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="detail_unitBisnis" class="col-lg-4 col-form-label">Unit Bisnis
                                        :</label>
                                    <div class="col-lg-7">
                                        <label id="detail_unitBisnis"
                                            class="col-form-label">{{ $offtaker['offtakerDetail']['businessUnitId'] }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="detail_kontakPerson" class="col-lg-4 col-form-label">Kontak Person
                                        :</label>
                                    <div class="col-lg-7">
                                        <label id="detail_kontakPerson"
                                            class="col-form-label">{{ $offtaker['offtakerDetail']['contactPerson'] }}</label>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="detail_gambar" class="col-lg-4 col-form-label">Gambar Barang:</label>
                                    <div class="col-lg-7">
                                        <img src="{{ asset('images/customerPhoto/' . $offtaker['offtakerDetail']['customerPhoto']) }}"
                                            alt="Gambar Barang" style="max-width: 25%; height: auto;">
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
    <script>
        function confirmDeleteOfftaker(customerId) {
            const url = 'offtaker/hapus/' + customerId;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            ajaxDelete(url, csrfToken);
        }
    </script>
@endsection
