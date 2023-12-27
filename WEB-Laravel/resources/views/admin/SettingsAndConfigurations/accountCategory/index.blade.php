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
    {{-- CRUD AJAX --}}
    <script>
        // Tambah Account Category
        function addAccountCategory() {
            const notyWarning = new Noty({
                text: "Seluruh field harus diisi sebelum mengirimkan form.",
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
            $("#addAccountCategoryForm").on("submit", function(e) {
                e.preventDefault();
                let accountCategoryValue = $("input[name='accountCategory']").val();
                let descriptionValue = $("textarea[name='description']").val();
                if (accountCategoryValue.trim() !== "" && descriptionValue.trim() !== "") {
                    let formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: 'kategori-rekening/store',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $("#modal_default_tabCreate").modal("hide");
                            $("#addAccountCategoryForm")[0].reset();
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

        // Edit Account Category
        function editAccountCategory(accountCategoryId) {
            $.ajax({
                type: 'GET',
                url: 'kategori-rekening/edit/' + accountCategoryId,
                success: function(data) {
                    $('#editAccountCategoryId').val(data.accountCategoryId);
                    $('#editAccountCategoryForm input[name="occupationName"]').val(data
                        .occupationName);
                    $('#editAccountCategoryForm textarea[name="description"]').val(data
                        .description);
                    $('#modal_edit_' + occupationId).modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
        $('#accountCategoryTable').on('click', '.edit-button', function() {
            const id = $(this).data('id');
            editAccountCategory(id);
        });

        // Update Account Category
        $('#editAccountCategoryForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editAccountCategoryId').val();
            let formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'kategori-rekening/update/' + id,
                data: formData + "&_method=PUT",
                success: function(data) {
                    $('#modal_edit_' + id).modal('hide');
                    $(`#accountCategoryTable tbody tr[data-id="${id}"] td:nth-child(1)`).text($(
                        '#updateAccountCategoryForm input[name="occupationName"]').val());
                    $(`#accountCategoryTable tbody tr[data-id="${id}"] td:nth-child(2)`).text($(
                        '#updateAccountCategoryForm textarea[name="description"]').val());
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        function confirmDeleteAccountCategory(accountCategoryId) {
            const url = 'kategori-rekening/delete/' + accountCategoryId;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            ajaxDelete(url, csrfToken);
            // const swalInit = swal.mixin({
            //     buttonsStyling: false,
            //     customClass: {
            //         confirmButton: "btn btn-primary",
            //         cancelButton: "btn btn-danger",
            //         denyButton: "btn btn-light",
            //     },
            // });
            // swalInit
            //     .fire({
            //         title: "Apakah Anda Yakin?",
            //         text: "Data yang dihapus tidak dapat dipulihkan kembali!",
            //         icon: "warning",
            //         showCancelButton: true,
            //         confirmButtonText: "Hapus",
            //         cancelButtonText: "Batal",
            //     })
            //     .then((result) => {
            //         if (result.isConfirmed) {
            //             $.ajax({
            //                 type: "GET",
            //                 url: 'kategori-rekening/delete/' + accountCategoryId,
            //                 headers: {
            //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //                 },
            //                 success: function(data) {
            //                     swalInit.fire({
            //                         title: "Hapus Berhasil!",
            //                         text: "Data sudah dihapus!",
            //                         icon: "success",
            //                         showConfirmButton: false,
            //                     });
            //                     location.reload();
            //                 },
            //                 error: function(data) {
            //                     Swal.fire("Error!", "Terjadi kesalahan saat menghapus data.", "error");
            //                 },
            //             });
            //         }
            //     });
        }

        $(document).ready(function() {
            addAccountCategory();
        });
    </script>
    <div class="card">
        <div class="card-header d-flex">
            <h5 class="mb-0">Daftar Kategori Rekening</h5>
            <div class="ms-auto">
                {{-- <a class="btn btn-primary" href="{{ route('accountCategory.create') }}"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Kategori Rekening</span></a> --}}
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_default_tabCreate"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Baru</span></button>
            </div>
        </div>
        <table id="accountCategoryTable" class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>Kategori Rekening</th>
                    <th>Keterangan</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($accountCategory['data']) && is_array($accountCategory['data']) && count($accountCategory['data']) > 0)
                    @foreach ($accountCategory['data'] as $aC)
                        <tr>
                            <td>{{ $aC['accountCategory'] }}</td>
                            <td>{{ $aC['description'] }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            {{-- <a href="{{ route('accountCategory.show', ['id' => $aC['accountCategoryId']]) }}"
                                                class="dropdown-item text-info">
                                                <i class="ph-list me-2"></i>
                                                Detail
                                            </a> --}}
                                            <a href="#" class="dropdown-item text-info" data-bs-toggle="modal"
                                                data-bs-target="#modal_detail_{{ $aC['accountCategoryId'] }}">
                                                <i class="ph-list me-2"></i>
                                                Detail
                                            </a>
                                            {{-- <a href="{{ route('accountCategory.edit', ['id' => $aC['accountCategoryId']]) }}"
                                                class="dropdown-item text-secondary">
                                                <i class="ph-pencil me-2"></i>
                                                Edit
                                            </a> --}}
                                            <a href="#" class="dropdown-item text-secondary edit-occupation"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal_edit_{{ $aC['accountCategoryId'] }}"
                                                data-occupation-id="{{ $aC['accountCategoryId'] }}">
                                                <i class="ph-pencil me-2"></i>
                                                Edit
                                            </a>
                                            <a href="#" class="dropdown-item text-danger"
                                                onclick="confirmDeleteAccountCategory({{ $aC['accountCategoryId'] }})">
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

        {{-- Tambah Account Category --}}
        <div id="modal_default_tabCreate" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kategori Rekening</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="addAccountCategoryForm">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Kategori Rekening:</label>
                                    <div class="col-lg-7">
                                        <input type="text" name="accountCategory" class="form-control"
                                            placeholder="Masukkan Kategori Rekening">
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

        {{-- Edit Account Category --}}
        @if (isset($accountCategory['data']) && is_array($accountCategory['data']) && count($accountCategory['data']) > 0)
            @foreach ($accountCategory['data'] as $aC)
                <div id="modal_edit_{{ $aC['accountCategoryId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Kategori Rekening</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="editAccountCategoryForm_{{ $aC['accountCategoryId'] }}"
                                action="{{ route('accountCategory.update', ['id' => $aC['accountCategoryId']]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Kategori Rekening:</label>
                                            <div class="col-lg-7">
                                                <input type="text" name="accountCategory" class="form-control"
                                                    value="{{ $aC['accountCategory'] }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Keterangan:</label>
                                            <div class="col-lg-7">
                                                <textarea rows="3" cols="3" name="description" class="form-control">{{ $aC['description'] }}</textarea>
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

        {{-- Detail Account Category --}}
        @if (isset($accountCategory['data']) && is_array($accountCategory['data']) && count($accountCategory['data']) > 0)
            @foreach ($accountCategory['data'] as $aC)
                <div id="modal_detail_{{ $aC['accountCategoryId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Kategori Rekening</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row mb-2">
                                        <label for="detail_accountCategory_name" class="col-lg-4 col-form-label">Kategori
                                            Rekening:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_accountCategory_name"
                                                class="col-form-label">{{ $aC['accountCategory'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_accountCategory_description"
                                            class="col-lg-4 col-form-label">Keterangan:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_accountCategory_description"
                                                class="col-form-label">{{ $aC['description'] }}</label>
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
    @if (isset($accountCategory['data']) && is_array($accountCategory['data']) && count($accountCategory['data']) > 0)
        @foreach ($accountCategory['data'] as $aC)
            <form id="delete-form-{{ $aC['accountCategoryId'] }}"
                action="{{ route('accountCategory.delete', $aC['accountCategoryId']) }}" method="POST"
                style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @else
    @endif
@endsection
