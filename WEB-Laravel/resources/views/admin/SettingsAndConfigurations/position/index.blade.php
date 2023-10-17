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
                        targets: [2]
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
            <h5 class="mb-0">Daftar Jabatan</h5>
            <div class="ms-auto">
                <a class="btn btn-primary" href="{{ route('position.create') }}"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Jabatan</span></a>
            </div>
        </div>
        <table class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>Nama Jabatan</th>
                    <th>Keterangan</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($position['data'] as $pN)
                    <tr>
                        <td>{{ $pN['positionName'] }}</td>
                        <td>{{ $pN['description'] }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex">
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="{{ route('position.detail', ['id' => $pN['positionId']]) }}"
                                            class="dropdown-item text-info">
                                            <i class="ph-list me-2"></i>
                                            Detail
                                        </a>
                                        <a href="{{ route('position.edit', ['id' => $pN['positionId']]) }}"
                                            class="dropdown-item text-secondary">
                                            <i class="ph-pencil me-2"></i>
                                            Edit
                                        </a>
                                        {{-- <a href="#" class="dropdown-item text-danger"
                                            onclick="confirmDelete({{ $pN['positionId'] }})">
                                            <i class="ph-trash me-2"></i>
                                            Hapus
                                        </a> --}}
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- @foreach ($position['data'] as $pN)
        <form id="delete-form-{{ $pN['positionId'] }}" action="{{ route('position.hapus', $pN['positionId']) }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endforeach --}}
    {{-- <script>
        function confirmDeletePosition(positionId) {
            const swalInit = swal.mixin({
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-danger",
                    denyButton: "btn btn-light",
                },
            });
            swalInit
                .fire({
                    title: "Apakah Anda Yakin?",
                    text: "Data yang dihapus tidak dapat dipulihkan kembali!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Hapus",
                    cancelButtonText: "Batal",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: 'jabatan/hapus/' + positionId,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                swalInit.fire({
                                    title: "Hapus Berhasil!",
                                    text: "Data sudah dihapus!",
                                    icon: "success",
                                    showConfirmButton: false,
                                });
                                location.reload();
                            },
                            error: function(data) {
                                Swal.fire("Error!", "Terjadi kesalahan saat menghapus data.", "error");
                            },
                        });
                    }
                });
        }
    </script> --}}
@endsection
