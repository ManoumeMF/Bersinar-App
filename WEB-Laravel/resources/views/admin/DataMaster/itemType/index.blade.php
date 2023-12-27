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
                        search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacitemtype-50"></i></div></div>',
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

    <script>
        // Tambah itemType
        function addItemType() {
            const notyWarning = new Noty({
                text: "Kedua field harus diisi sebelum mengirimkan form.",
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

            $("#addItemTypeForm").on("submit", function(e) {
                e.preventDefault();
                let itemTypeNameValue = $("input[name='itemType']").val();
                let descriptionValue = $("textarea[name='description']").val();

                if (itemTypeNameValue.trim() !== "" && descriptionValue.trim() !== "") {
                    let formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: 'jenis-barang',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $("#modal_default_tabCreate").modal("hide");
                            $("#addItemTypeForm")[0].reset();
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

        // Edit itemType
        function editItemType(itemTypeId) {
            $.ajax({
                type: 'GET',
                url: 'jenis-barang/edit/' + itemTypeId,
                success: function(data) {
                    $('#editItemTypeId').val(data.itemTypeId);
                    $('#editItemTypeForm input[name="itemType"]').val(data
                        .itemType);
                    $('#editItemTypeForm textarea[name="description"]').val(data
                        .description);
                    $('#modal_edit_' + itemTypeId).modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
        $('#itemTypeTable').on('click', '.edit-button', function() {
            const id = $(this).data('id');
            editItemType(id);
        });

        // Update itemType
        $('#editItemTypeForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editItemTypeId').val();
            let formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'jenis-barang/update/' + id,
                data: formData + "&_method=PUT",
                success: function(data) {
                    $('#modal_edit_' + id).modal('hide');
                    $(`#itemTypeTable tbody tr[data-id="${id}"] td:nth-child(1)`).text($(
                        '#updateItemTypeForm input[name="itemType"]').val());
                    $(`#itemTypeTable tbody tr[data-id="${id}"] td:nth-child(2)`).text($(
                        '#updateItemTypeForm textarea[name="description"]').val());
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        // Hapus itemType
        function confirmDeleteItemType(itemTypeId) {
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
                            url: 'jenis-barang/delete/' + itemTypeId,
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
        $(document).ready(function() {
            addItemType();
        });
    </script>
    <div class="card">
        <div class="card-header d-flex">
            <h5 class="mb-0">Daftar Jenis Barang</h5>
            <div class="ms-auto">
                {{-- <a class="btn btn-primary" href="{{ route('itemType.create') }}"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Jenis Barang</span></a> --}}
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_default_tabCreate"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Jenis Barang</span></button>
            </div>
        </div>
        <table id="itemTypeTable" class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>Jenis Barang</th>
                    <th>Keterangan</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($itemType['data']) && is_array($itemType['data']) && count($itemType['data']) > 0)
                    @foreach ($itemType['data'] as $itemtype)
                        <tr>
                            <td>{{ $itemtype['itemType'] }}</td>
                            <td>{{ $itemtype['description'] }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item text-info" data-bs-toggle="modal"
                                                data-bs-target="#modal_detail_{{ $itemtype['itemTypeId'] }}">
                                                <i class="ph-list me-2"></i>
                                                Detail
                                            </a>
                                            <a href="#" class="dropdown-item text-secondary edit-blood-type"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal_edit_{{ $itemtype['itemTypeId'] }}"
                                                data-item-type-id="{{ $itemtype['itemTypeId'] }}">
                                                <i class="ph-pencil me-2"></i>
                                                Edit
                                            </a>
                                            <a href="#" onclick="confirmDeleteItemType({{ $itemtype['itemTypeId'] }})"
                                                class="dropdown-item text-danger">
                                                <i class="ph-trash me-2"></i>
                                                Hapus
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                    @endforeach
                @else
                @endif
            </tbody>
        </table>

        {{-- Create Modal --}}
        <div id="modal_default_tabCreate" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Jenis Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="addItemTypeForm">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Jenis Barang:</label>
                                    <div class="col-lg-7">
                                        <input type="text" name="itemType" class="form-control"
                                            placeholder="Masukkan Jenis Barang">
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

        {{-- Edit Modal --}}
        @if (isset($itemType['data']) && is_array($itemType['data']) && count($itemType['data']) > 0)
            @foreach ($itemType['data'] as $itemtype)
                <div id="modal_edit_{{ $itemtype['itemTypeId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Jenis Barang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="editItemTypeForm_{{ $itemtype['itemTypeId'] }}"
                                action="{{ route('itemType.update', ['id' => $itemtype['itemTypeId']]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Jenis Barang:</label>
                                            <div class="col-lg-7">
                                                <input type="text" name="itemType" class="form-control"
                                                    value="{{ $itemtype['itemType'] }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Keterangan:</label>
                                            <div class="col-lg-7">
                                                <textarea rows="3" cols="3" name="description" class="form-control">{{ $itemtype['description'] }}</textarea>
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

        {{-- Detail Modal --}}
        @if (isset($itemType['data']) && is_array($itemType['data']) && count($itemType['data']) > 0)
            @foreach ($itemType['data'] as $itemtype)
                <div id="modal_detail_{{ $itemtype['itemTypeId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Jenis Barang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row mb-2">
                                        <label for="detail_itemType_name" class="col-lg-4 col-form-label">Jenis
                                            Barang:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_itemType_name"
                                                class="col-form-label">{{ $itemtype['itemType'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_itemType_description"
                                            class="col-lg-4 col-form-label">Keterangan:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_itemType_description"
                                                class="col-form-label">{{ $itemtype['description'] }}</label>
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
    @if (isset($itemType['data']) && is_array($itemType['data']) && count($itemType['data']) > 0)
        @foreach ($itemType['data'] as $itemtype)
            <form id="delete-form-{{ $itemtype['itemTypeId'] }}"
                action="{{ route('itemType.delete', ['id' => $itemtype['itemTypeId']]) }}" method="POST"
                style="display: none">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @else
    @endif
@endsection
