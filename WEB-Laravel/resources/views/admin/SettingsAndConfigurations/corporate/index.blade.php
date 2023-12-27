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
                        targets: [5]
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
    {{-- <script>
            function editCorporate(corporateId) {
                $.ajax({
                    type: 'GET',
                    url: 'golongan-darah/edit/' + bloodTypeId,
                    success: function(data) {
                        $('#editBloodTypeId').val(data.bloodTypeId);
                        $('#editBloodTypeForm input[name="bloodTypeName"]').val(data
                            .bloodTypeName);
                        $('#editBloodTypeForm textarea[name="description"]').val(data
                            .description);
                        $('#modal_edit_' + bloodTypeId).modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }
            $('#bloodTypeTable').on('click', '.edit-button', function() {
                const id = $(this).data('id');
                editBloodType(id);
            });

            // Update bloodtype
            $('#editBloodTypeForm').on('submit', function(e) {
                e.preventDefault();
                const id = $('#editBloodTypeId').val();
                let formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: 'golongan-darah/update/' + id,
                    data: formData + "&_method=PUT",
                    success: function(data) {
                        $('#modal_edit_' + id).modal('hide');
                        $(`#bloodTypeTable tbody tr[data-id="${id}"] td:nth-child(1)`).text($(
                            '#updateBloodTypeForm input[name="bloodTypeName"]').val());
                        $(`#bloodTypeTable tbody tr[data-id="${id}"] td:nth-child(2)`).text($(
                            '#updateBloodTypeForm textarea[name="description"]').val());
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            });

            // Hapus bloodtype
            function confirmDeleteBloodType(bloodTypeId) {
                const url = 'golongan-darah/delete/' + bloodTypeId;
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                ajaxDelete(url, csrfToken);
            }
            $(document).ready(function() {
                addBloodType();
            });
        </script> --}}
    <div class="card">
        <div class="card-header d-flex">
            <h5 class="mb-0">Daftar Perusahaan/Institusi</h5>
            <div class="ms-auto">
                <a class="btn btn-primary" href="{{ route('corporate.create') }}"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Baru</span></a>
            </div>
        </div>
        <table class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>Kode Perusahaan/Institusi</th>
                    <th>Perusahaan/Institusi</th>
                    <th>Alamat</th>
                    <th>No.Telepon</th>
                    <th>Email</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($corporate['data']) && is_array($corporate['data']) && count($corporate['data']) > 0)
                    @foreach ($corporate['data'] as $perusahaan)
                        <tr>
                            <td>{{ $perusahaan['corporateCode'] }}</td>
                            <td>{{ $perusahaan['corporateName'] }}</td>
                            <td>{{ $perusahaan['address'] }}</td>
                            <td>{{ $perusahaan['phoneNumber'] }}</td>
                            <td>{{ $perusahaan['email'] }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item text-info" data-bs-toggle="modal"
                                                data-bs-target="#modal_detail_{{ $perusahaan['corporateId'] }}">
                                                <i class="ph-list me-2"></i>
                                                Detail
                                            </a>
                                            <a href="{{ route('corporate.edit', ['id' => isset($perusahaan['corporateId']) ? $perusahaan['corporateId'] : null]) }}"
                                                class="dropdown-item text-secondary">
                                                <i class="ph-pencil me-2"></i>
                                                Edit
                                            </a>
                                            <a href="#" class="dropdown-item text-danger"
                                            onclick="confirmDeleteCorporate({{ $perusahaan['corporateId'] }})">
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
        @if (isset($corporate['data']) && is_array($corporate['data']) && count($corporate['data']) > 0)
            @foreach ($corporate['data'] as $perusahaan)
                <div id="modal_detail_{{ $perusahaan['corporateId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row mb-1">
                                        <label for="detail_corporate_code" class="col-lg-4 col-form-label">Kode
                                            Perusahaan/Institusi:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_corporate_code"
                                                class="col-form-label">{{ $perusahaan['corporateCode'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_corporate_name" class="col-lg-4 col-form-label">Nama
                                            Perusahaan/Institusi:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_corporate_name"
                                                class="col-form-label">{{ $perusahaan['corporateName'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_corporate_taxId" class="col-lg-4 col-form-label">Kode
                                            NPWP:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_corporate_taxId"
                                                class="col-form-label">{{ $perusahaan['taxId'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_corporate_country"
                                            class="col-lg-4 col-form-label">Negara:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_corporate_country" class="col-form-label">Indonesia</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_corporate_prov" class="col-lg-4 col-form-label">Provinsi:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_corporate_prov"
                                                class="col-form-label">{{ $perusahaan['prov_name'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_corporate_city"
                                            class="col-lg-4 col-form-label">Kota/Kabupaten:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_corporate_city"
                                                class="col-form-label">{{ $perusahaan['city_name'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_corporate_subdis"
                                            class="col-lg-4 col-form-label">Kecamatan:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_corporate_subdis"
                                                class="col-form-label">{{ $perusahaan['subdis_name'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_corporate_address"
                                            class="col-lg-4 col-form-label">Alamat:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_corporate_address"
                                                class="col-form-label">{{ $perusahaan['address'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_corporate_postalCode" class="col-lg-4 col-form-label">Kode
                                            Pos:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_corporate_postalCode"
                                                class="col-form-label">{{ $perusahaan['postalCode'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_corporate_phone" class="col-lg-4 col-form-label">No.
                                            Telepon:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_corporate_phone"
                                                class="col-form-label">{{ $perusahaan['phoneNumber'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_corporate_fax" class="col-lg-4 col-form-label">No.
                                            Faximile:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_corporate_fax"
                                                class="col-form-label">{{ $perusahaan['faxNumber'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_corporate_wa" class="col-lg-4 col-form-label">No.
                                            WhatsApp:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_corporate_wa"
                                                class="col-form-label">{{ $perusahaan['whatsAppNumber'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_corporate_email" class="col-lg-4 col-form-label">Email:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_corporate_email"
                                                class="col-form-label">{{ $perusahaan['email'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_corporate_logo" class="col-lg-4 col-form-label">Logo
                                            Perusahaan:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_corporate_logo"
                                                class="col-form-label">{{ $perusahaan['logo'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="detail_corporate_currency" class="col-lg-4 col-form-label">Mata
                                            Uang:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_corporate_currency"
                                                class="col-form-label">{{ $perusahaan['currencyId'] }}</label>
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
    <script>
        function confirmDeleteCorporate(corporateId) {
            const url = 'perusahaan-institusi/hapus/' + corporateId;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            ajaxDelete(url, csrfToken);
        }
    </script>
@endsection
