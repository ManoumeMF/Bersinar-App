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
            <h5 class="mb-0">Daftar Nasabah</h5>
            <div class="ms-auto">
                <a class="btn btn-primary" href="{{ route('supplier.create') }}"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Nasabah</span></a>
            </div>
        </div>
        <table class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>Kode Nasabah</th>
                    <th>Nama Nasabah</th>
                    <th>Jenis Nasabah</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>WhatsAppNumber</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($supplier['data'] as $nasabah)
                    <tr>
                        <td>{{ $nasabah['supplierCode'] }}</td>
                        <td>{{ $nasabah['supplierName'] }}</td>
                        <td>{{ $nasabah['partnerType'] }}</td>
                        <td>{{ $nasabah['supplierAddress'] }}</td>
                        <td>{{ $nasabah['mobileNumber'] }}</td>
                        <td>{{ $nasabah['whatsAppNumber'] }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex">
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#" class="dropdown-item text-info" data-bs-toggle="modal"
                                            data-bs-target="#modal_detail_{{ $nasabah['supplierId'] }}">
                                            <i class="ph-list me-2"></i>
                                            Detail
                                        </a>
                                        <a href="{{ route('supplier.edit', ['id' => isset($nasabah['supplierId']) ? $nasabah['supplierId'] : null]) }}"
                                            class="dropdown-item text-secondary">
                                            <i class="ph-pencil me-2"></i>
                                            Edit
                                        </a>
                                        <a href="#" class="dropdown-item text-danger"
                                            onclick="confirmDeleteSupplier({{ $nasabah['supplierId'] }})">
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
        {{-- Detail Modal --}}
        @if (isset($supplier['data']) && is_array($supplier['data']) && count($supplier['data']) > 0)
            @foreach ($supplier['data'] as $nasabah)
                <div id="modal_detail_{{ $nasabah['supplierId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row mb-1">
                                        <label for="detail_partnerType" class="col-lg-4 col-form-label">
                                            Jenis Nasabah:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_partnerType"
                                                class="col-form-label">{{ $nasabah['supplierDetail']['partnerTypeId'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_supplierCode" class="col-lg-4 col-form-label">
                                            Kode Nasabah:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_supplierCode"
                                                class="col-form-label">{{ $nasabah['supplierDetail']['supplierCode'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_fullName" class="col-lg-4 col-form-label">
                                            Nama Lengkap:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_fullName"
                                                class="col-form-label">{{ $nasabah['supplierDetail']['fullName'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_sex" class="col-lg-4 col-form-label">Jenis Kelamin:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_sex"
                                                class="col-form-label">{{ $nasabah['supplierDetail']['sex'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_birthPlace" class="col-lg-4 col-form-label">Tempat/Tgl
                                            Lahir:</label>
                                        <div class="col-lg-7">
                                            @php
                                                $birthPlace = $nasabah['supplierDetail']['birthPlace'];
                                                $birthDate = date('Y-m-d', strtotime($nasabah['supplierDetail']['birthDate']));
                                            @endphp
                                            <label id="detail_birthPlace" class="col-form-label">{{ $birthPlace }},
                                                {{ $birthDate }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_email"
                                            class="col-lg-4 col-form-label">Email:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_email"
                                                class="col-form-label">{{ $nasabah['supplierDetail']['email'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_mobileNumber" class="col-lg-4 col-form-label">Nomor Telepon:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_mobileNumber"
                                                class="col-form-label">{{ $nasabah['supplierDetail']['mobileNumber'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_whatsAppNumber" class="col-lg-4 col-form-label">WhatsApp:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_whatsAppNumber"
                                                class="col-form-label">{{ $nasabah['supplierDetail']['whatsAppNumber'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_supplierPhoto" class="col-lg-4 col-form-label">Foto Nasabah:</label>
                                        <div class="col-lg-7">
                                            <img src="{{ asset('images/supplierPhoto/' . $nasabah['supplierDetail']['supplierPhoto']) }}"
                                                alt="Foto Nasabah" style="max-width: 25%; height: auto;">
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
    <!-- /striped rows -->
    <script>
        function confirmDeleteSupplier(supplierId) {
            const url = 'nasabah/hapus/' + supplierId;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            ajaxDelete(url, csrfToken);
        }
    </script>
@endsection
