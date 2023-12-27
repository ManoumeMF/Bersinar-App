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

    {{-- CRUD AJAX --}}
    <script>
        // Delete Departemen
        function confirmDeleteBusinessUnit(businessUnitId) {
            const url = 'bisnis-unit/hapus/' + businessUnitId;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            ajaxDelete(url, csrfToken);
        }
    </script>
    <div class="card">
        <div class="card-header d-flex">
            <h5 class="mb-0">Daftar Unit Bisnis</h5>
            <div class="ms-auto">
                <a class="btn btn-primary" href="{{ route('businessUnit.create') }}"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Unit Bisnis</span></a>
            </div>
        </div>
        <table class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>Kode Unit Bisnis</th>
                    <th>Unit Bisnis</th>
                    <th>Alamat</th>
                    <th>No.Telepon</th>
                    <th>Email</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($businessUnits['data']) && is_array($businessUnits['data']) && count($businessUnits['data']) > 0)
                    @foreach ($businessUnits['data'] as $bu)
                        <tr>
                            <td>{{ $bu['businessUnitCode'] }}</td>
                            <td>{{ $bu['businessUnitName'] }}</td>
                            <td>{{ $bu['address'] }}</td>
                            <td>{{ $bu['phoneNumber'] }}</td>
                            <td>{{ $bu['email'] }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            {{-- <a href="#" class="dropdown-item text-info">
                                                <i class="ph-list me-2"></i>
                                                Detail
                                            </a> --}}
                                            <a href="#" class="dropdown-item text-info" data-bs-toggle="modal"
                                                data-bs-target="#modal_large_{{ $bu['businessUnitId'] }}">
                                                <i class="ph-list me-2"></i>
                                                Detail
                                            </a>
                                            <a href="#" class="dropdown-item text-secondary">
                                                <i class="ph-pencil me-2"></i>
                                                Edit
                                            </a>
                                            <a href="#" class="dropdown-item text-danger"
                                                onclick="confirmDeleteBusinessUnit({{ $bu['businessUnitId'] }})">
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

        {{-- Detail Modal --}}
        @if (isset($businessUnits['data']) && is_array($businessUnits['data']) && count($businessUnits['data']) > 0)
            @foreach ($businessUnits['data'] as $bu)
                <div id="modal_large_{{ $bu['businessUnitId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Unit Bisnis</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row mb-2">
                                        <label for="detail_corporate_name"
                                            class="col-lg-4 col-form-label">Perusahaan/Institusi:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_corporate_name"
                                                class="col-form-label">{{ $bu['corporateId']}}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_businessUnit_name" class="col-lg-4 col-form-label">Kode Unit
                                            Bisnis:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_businessUnit_name"
                                                class="col-form-label">{{ $bu['businessUnitName'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_businessUnit_address" class="col-lg-4 col-form-label">Alamat</label>
                                        <div class="col-lg-7">
                                            <label id="detail_businessUnit_address"
                                                class="col-form-label">{{ $bu['address'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_businessUnit_email"
                                            class="col-lg-4 col-form-label">Keterangan:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_businessUnit_email"
                                                class="col-form-label">{{ $bu['email'] }}</label>
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
    @if (isset($businessUnits['data']) && is_array($businessUnits['data']) && count($businessUnits['data']) > 0)
        @foreach ($businessUnits['data'] as $bu)
            <form id="delete-form-{{ $bu['businessUnitId'] }}"
                action="{{ route('businessUnit.delete', $bu['businessUnitId']) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @else
    @endif
@endsection
