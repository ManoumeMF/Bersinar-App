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
    <script>
        // Tambah PartnerType
        function addPartnerType() {
            const notyWarning = new Noty({
                text: "Ketiga field harus diisi sebelum mengirimkan form.",
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
            $("#addPartnerTypeForm").on("submit", function(e) {
                e.preventDefault();
                let ParentValue = $("select[name='parentId']").val();
                let PartnerTypeValue = $("input[name='partnerType']").val();
                let descriptionValue = $("textarea[name='description']").val();
                if (ParentValue.trim() !== "" && PartnerTypeValue.trim() !== "" && descriptionValue.trim() !==
                    "") {
                    // $('#loadingIndicator').show();
                    let formData = $(this).serialize();
                    // console.log(formData);
                    $.ajax({
                        type: "POST",
                        url: 'jenis-partner',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            // $('#loadingIndicator').hide();
                            // console.log(data);
                            $("#modal_default_tabCreate").modal("hide");
                            $("#addPartnerTypeForm")[0].reset();
                            location.reload();
                        },
                        error: function(data) {
                            // $('#loadingIndicator').hide();
                            console.log(data);
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

        // Edit partnertype
        function editPartnerType(partnerTypeId) {
            $.ajax({
                type: 'GET',
                url: 'jenis-partner/edit/' + partnerTypeId,
                success: function(data) {
                    console.log(data);
                    $('#editpartnerTypeId').val(data.partnerTypeId);
                    $('#editPartnerTypeForm_ select[name="parentId"]').val(data.parentId);
                    $('#editPartnerTypeForm_ input[name="partnerType"]').val(data
                        .partnerType);
                    $('#editPartnerTypeForm_ textarea[name="description"]').val(data
                        .description);
                    $('#modal_edit_' + partnerTypeId).modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
        $('#partnerTypeTable').on('click', '.edit-button', function() {
            const id = $(this).data('id');
            editpartnerType(id);
        });

        // Update partnertype
        $('#editpartnerTypeForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editpartnerTypeId').val();
            let formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'jenis-partner/update/' + id,
                data: formData + "&_method=PUT",
                success: function(data) {
                    $('#modal_edit_' + id).modal('hide');
                    $(`#partnerTypeTable tbody tr[data-id="${id}"] td:nth-child(1)`).text($(
                        '#updatepartnerTypeForm select[name="parentId"]').val());
                    $(`#partnerTypeTable tbody tr[data-id="${id}"] td:nth-child(2)`).text($(
                        '#updatepartnerTypeForm input[name="partnerType"]').val());
                    $(`#partnerTypeTable tbody tr[data-id="${id}"] td:nth-child(3)`).text($(
                        '#updatepartnerTypeForm textarea[name="description"]').val());
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        // Hapus partnertype
        function confirmDeletepartnerType(partnerTypeId) {
            const url = 'jenis-partner/delete/' + partnerTypeId;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            ajaxDelete(url, csrfToken);
        }
        $(document).ready(function() {
            addPartnerType();
        });
    </script>
    <script>
        $(document).ready(function() {
            // Your existing Select2 initialization
            $('.select').each(function() {
                $(this).select2({
                    dropdownParent: $(this).closest('.modal')
                });
            });
        });
    </script>
    <div class="card">
        <div class="card-header d-flex">
            <h5 class="mb-0">Daftar Jenis Partner</h5>
            <div class="ms-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal_default_tabCreate"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Baru</span></button>
            </div>
        </div>
        <table id="partnerTypeTable" class="table datatable-basic table-striped">
            <thead>
                <tr>
                    <th>Parent</th>
                    <th>Jenis Partner</th>
                    <th>Keterangan</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($partnerTypes['data'] as $pt)
                    <tr>
                        <td>
                            {{ $pt['parent'] }}
                        </td>
                        <td>{{ $pt['partnerType'] }}</td>
                        <td>{{ $pt['description'] }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex">
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#" class="dropdown-item text-info" data-bs-toggle="modal"
                                            data-bs-target="#modal_detail_{{ $pt['partnerTypeId'] }}">
                                            <i class="ph-list me-2"></i>
                                            Detail
                                        </a>
                                        <a href="#" class="dropdown-item text-secondary edit-partnerType"
                                            data-bs-toggle="modal" data-bs-target="#modal_edit_{{ $pt['partnerTypeId'] }}"
                                            data-itemCategory-id="{{ $pt['partnerTypeId'] }}">
                                            <i class="ph-pencil me-2"></i>
                                            Edit
                                        </a>
                                        <a href="#" class="dropdown-item text-danger"
                                            onclick="confirmDeletepartnerType({{ $pt['partnerTypeId'] }})">
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

        {{-- Create Modal --}}
        <div id="modal_default_tabCreate" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Jenis Partner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="addPartnerTypeForm">
                        @csrf
                        <div class="modal-body">
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Parent:</label>
                                    <div class="col-lg-7">
                                        <select class="form-control select" data-placeholder="Pilih Parent"
                                            aria-label="Default select example" name="parentId">
                                            <option></option>
                                            @php
                                                $response = Http::get(Config('app.api_url') . 'partnerType/viewAll');
                                                $partnerType = $response->json();
                                            @endphp
                                            <optgroup label = "Pilih Parent">
                                                @foreach ($partnerType['data'] as $parent)
                                                    <option value="{{ $parent['partnerTypeId'] }}">{{ $parent['parent'] }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-lg-4 col-form-label">Jenis Partner:</label>
                                    <div class="col-lg-7">
                                        <input name="partnerType" class="form-control"
                                            placeholder="Masukkan Keterangan"></textarea>
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
        @if (isset($partnerTypes['data']) && is_array($partnerTypes['data']) && count($partnerTypes['data']) > 0)
            @foreach ($partnerTypes['data'] as $pt)
                <div id="modal_edit_{{ $pt['partnerTypeId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Jenis Partner</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="editPartnerTypeForm_{{ $pt['partnerTypeId'] }}"
                                action="{{ route('partnerTypes.update', ['id' => $pt['partnerTypeId']]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Pilih Parent:</label>
                                            <div class="col-lg-7">
                                                <select class="form-control select" data-placeholder="Pilih Jenis Barang"
                                                    aria-label="Default select example" name="parentId">
                                                    <option></option>
                                                    @php
                                                        $response = Http::get(Config('app.api_url') . 'partnerType/viewAll');
                                                        $parentType = $response->json();
                                                    @endphp
                                                    <optgroup label="Parent">
                                                        @foreach ($parentType['data'] as $pT)
                                                            <option value="{{ $pT['parentId'] }}"
                                                                {{ $pT['parent'] == $pt['parent'] ? 'selected' : '' }}>
                                                                {{ $pT['parent'] }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Jenis Partner:</label>
                                            <div class="col-lg-7">
                                                <input type="text" name="partnerType" class="form-control"
                                                    value="{{ $pt['partnerType'] }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-lg-4 col-form-label">Keterangan:</label>
                                            <div class="col-lg-7">
                                                <textarea rows="3" cols="3" name="description" class="form-control">{{ $pt['description'] }}</textarea>
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
        @if (isset($partnerTypes['data']) && is_array($partnerTypes['data']) && count($partnerTypes['data']) > 0)
            @foreach ($partnerTypes['data'] as $pt)
                <div id="modal_detail_{{ $pt['partnerTypeId'] }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Jenis Partner</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row mb-2">
                                        <label for="detail_parentId_name" class="col-lg-4 col-form-label">Jenis Parent
                                            :</label>
                                        <div class="col-lg-7">
                                            <label id="detail_parentId_name" class="col-form-label">
                                                {{ $pt['parent'] }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_partnerType_name" class="col-lg-4 col-form-label">Kategori
                                            Barang:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_partnerType_name"
                                                class="col-form-label">{{ $pt['partnerType'] }}</label>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="detail_partnerType_description"
                                            class="col-lg-4 col-form-label">Keterangan:</label>
                                        <div class="col-lg-7">
                                            <label id="detail_partnerType_description"
                                                class="col-form-label">{{ $pt['description'] }}</label>
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
@endsection
