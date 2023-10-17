@extends('layouts.admin.template')

@section('content')

<style>
	.Filter {
		padding-top: 10px;
		/* margin-top: 20px */
		margin-right: 10px;
	}
</style>

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

<div class="card">
<<<<<<< HEAD:resources/views/admin/paymentTypes/index.blade.php
    <div class="card-header d-flex">
        <h5 class="mb-0">Daftar Tipe Pembayaran</h5>
        <div class="ms-auto">
            <a class="btn btn-primary" href="{{ route('company.create') }}"><i class="ph-plus-circle"></i><span class="d-none d-lg-inline-block ms-2">Tambah Tipe Pembayaran</span></a>
        </div>
    </div>

    <table class="table datatable-save-state">
        <thead>
            <tr>
                <th>Kode Tipe Pembayaran</th>
                <th>Jenis    Pembayaran</th>
                <th>Keterangan</th>
                <th class="text-center">Tindakan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Marth</td>
                <td><a href="#">Enright</a></td>
                <td>Traffic Court Referee</td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <div class="dropdown">
                            <a href="#" class="text-body" data-bs-toggle="dropdown">
                                <i class="ph-list"></i>
                            </a>
=======
						<div class="card-header d-flex">
							<h5 class="mb-0">Daftar Country</h5>
							<div class="ms-auto">
                        		<a class="btn btn-primary" href="{{ route('country.create') }}"><i class="ph-plus-circle"></i><span class="d-none d-lg-inline-block ms-2">Tambah Country</span></a>
                    		</div>
						</div>

						<table border="2" class="table table-bordered datatable-save-state">
							<thead>
								<tr>
									<th>Kode Jenis Pembayaran</th>
									<th>Jenis Pemabayaran</th>
									<th>Keterangan</th>
									<th class="text-center">Tindakan</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Marth</td>
									<td><a href="#">Enright</a></td>
									<td>Traffic Court Referee</td>
									<td class="text-center">
										<div class="d-inline-flex">
											<div class="dropdown">
												<a href="#" class="text-body" data-bs-toggle="dropdown">
													<i class="ph-list"></i>
												</a>
>>>>>>> a575c9fe3fa288d788be0c58d170050464b1a0ef:resources/views/admin/SettingsAndConfigurations/country/index.blade.php

                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item text-info">
                                    <i class="ph-list me-2"></i>
                                    Detail
                                </a>
                                <a href="#" class="dropdown-item text-secondary">
                                    <i class="ph-pencil me-2"></i>
                                    Edit
                                </a>
                                <a href="#" class="dropdown-item text-danger">
                                    <i class="ph-trash me-2"></i>
                                    Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Jackelyn</td>
                <td>Weible</td>
                <td><a href="#">Airline Transport Pilot</a></td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <div class="dropdown">
                            <a href="#" class="text-body" data-bs-toggle="dropdown">
                                <i class="ph-list"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item text-info">
                                    <i class="ph-list me-2"></i>
                                    Detail
                                </a>
                                <a href="#" class="dropdown-item text-secondary">
                                    <i class="ph-pencil me-2"></i>
                                    Edit
                                </a>
                                <a href="#" class="dropdown-item text-danger">
                                    <i class="ph-trash me-2"></i>
                                    Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Aura</td>
                <td>Hard</td>
                <td>Business Services Sales Representative</td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <div class="dropdown">
                            <a href="#" class="text-body" data-bs-toggle="dropdown">
                                <i class="ph-list"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item text-info">
                                    <i class="ph-list me-2"></i>
                                    Detail
                                </a>
                                <a href="#" class="dropdown-item text-secondary">
                                    <i class="ph-pencil me-2"></i>
                                    Edit
                                </a>
                                <a href="#" class="dropdown-item text-danger">
                                    <i class="ph-trash me-2"></i>
                                    Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Nathalie</td>
                <td><a href="#">Pretty</a></td>
                <td>Drywall Stripper</td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <div class="dropdown">
                            <a href="#" class="text-body" data-bs-toggle="dropdown">
                                <i class="ph-list"></i>
                            </a>

<<<<<<< HEAD:resources/views/admin/paymentTypes/index.blade.php
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item text-info">
                                    <i class="ph-list me-2"></i>
                                    Detail
                                </a>
                                <a href="#" class="dropdown-item text-secondary">
                                    <i class="ph-pencil me-2"></i>
                                    Edit
                                </a>
                                <a href="#" class="dropdown-item text-danger">
                                    <i class="ph-trash me-2"></i>
                                    Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
=======
												<div class="dropdown-menu dropdown-menu-end">
													<a href="#" class="dropdown-item text-info">
														<i class="ph-list me-2"></i>
														Detail
													</a>
													<a href="#" class="dropdown-item text-secondary">
														<i class="ph-pencil me-2"></i>
														Edit
													</a>
													<a href="#" class="dropdown-item text-danger">
														<i class="ph-trash me-2"></i>
														Hapus
													</a>
												</div>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td>Sharan</td>
									<td>Leland</td>
									<td>Aviation Tactical Readiness Officer</td>
									<td class="text-center">
										<div class="d-inline-flex">
											<div class="dropdown">
												<a href="#" class="text-body" data-bs-toggle="dropdown">
													<i class="ph-list"></i>
												</a>

												<div class="dropdown-menu dropdown-menu-end">
													<a href="#" class="dropdown-item text-info">
														<i class="ph-list me-2"></i>
														Detail
													</a>
													<a href="#" class="dropdown-item text-secondary">
														<i class="ph-pencil me-2"></i>
														Edit
													</a>
													<a href="#" class="dropdown-item text-danger">
														<i class="ph-trash me-2"></i>
														Hapus
													</a>
												</div>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td>Maxine</td>
									<td><a href="#">Woldt</a></td>
									<td><a href="#">Business Services Sales Representative</a></td>
									<td class="text-center">
										<div class="d-inline-flex">
											<div class="dropdown">
												<a href="#" class="text-body" data-bs-toggle="dropdown">
													<i class="ph-list"></i>
												</a>

												<div class="dropdown-menu dropdown-menu-end">
													<a href="#" class="dropdown-item text-info">
														<i class="ph-list me-2"></i>
														Detail
													</a>
													<a href="#" class="dropdown-item text-secondary">
														<i class="ph-pencil me-2"></i>
														Edit
													</a>
													<a href="#" class="dropdown-item text-danger">
														<i class="ph-trash me-2"></i>
														Hapus
													</a>
												</div>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td>Sylvia</td>
									<td><a href="#">Mcgaughy</a></td>
									<td>Hemodialysis Technician</td>
									<td class="text-center">
										<div class="d-inline-flex">
											<div class="dropdown">
												<a href="#" class="text-body" data-bs-toggle="dropdown">
													<i class="ph-list"></i>
												</a>

												<div class="dropdown-menu dropdown-menu-end">
													<a href="#" class="dropdown-item text-info">
														<i class="ph-list me-2"></i>
														Detail
													</a>
													<a href="#" class="dropdown-item text-secondary">
														<i class="ph-pencil me-2"></i>
														Edit
													</a>
													<a href="#" class="dropdown-item text-danger">
														<i class="ph-trash me-2"></i>
														Hapus
													</a>
												</div>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td>Lizzee</td>
									<td><a href="#">Goodlow</a></td>
									<td>Technical Services Librarian</td>
									<td class="text-center">
										<div class="d-inline-flex">
											<div class="dropdown">
												<a href="#" class="text-body" data-bs-toggle="dropdown">
													<i class="ph-list"></i>
												</a>

												<div class="dropdown-menu dropdown-menu-end">
													<a href="#" class="dropdown-item text-info">
														<i class="ph-list me-2"></i>
														Detail
													</a>
													<a href="#" class="dropdown-item text-secondary">
														<i class="ph-pencil me-2"></i>
														Edit
													</a>
													<a href="#" class="dropdown-item text-danger">
														<i class="ph-trash me-2"></i>
														Hapus
													</a>
												</div>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td>Kennedy</td>
									<td>Haley</td>
									<td>Senior Marketing Designer</td>
									<td class="text-center">
										<div class="d-inline-flex">
											<div class="dropdown">
												<a href="#" class="text-body" data-bs-toggle="dropdown">
													<i class="ph-list"></i>
												</a>

												<div class="dropdown-menu dropdown-menu-end">
													<a href="#" class="dropdown-item text-info">
														<i class="ph-list me-2"></i>
														Detail
													</a>
													<a href="#" class="dropdown-item text-secondary">
														<i class="ph-pencil me-2"></i>
														Edit
													</a>
													<a href="#" class="dropdown-item text-danger">
														<i class="ph-trash me-2"></i>
														Hapus
													</a>
												</div>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td>Chantal</td>
									<td><a href="#">Nailor</a></td>
									<td>Technical Services Librarian</td>
									<td class="text-center">
										<div class="d-inline-flex">
											<div class="dropdown">
												<a href="#" class="text-body" data-bs-toggle="dropdown">
													<i class="ph-list"></i>
												</a>

												<div class="dropdown-menu dropdown-menu-end">
													<a href="#" class="dropdown-item text-info">
														<i class="ph-list me-2"></i>
														Detail
													</a>
													<a href="#" class="dropdown-item text-secondary">
														<i class="ph-pencil me-2"></i>
														Edit
													</a>
													<a href="#" class="dropdown-item text-danger">
														<i class="ph-trash me-2"></i>
														Hapus
													</a>
												</div>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td>Delma</td>
									<td>Bonds</td>
									<td>Lead Brand Manager</td>
									<td class="text-center">
										<div class="d-inline-flex">
											<div class="dropdown">
												<a href="#" class="text-body" data-bs-toggle="dropdown">
													<i class="ph-list"></i>
												</a>

												<div class="dropdown-menu dropdown-menu-end">
													<a href="#" class="dropdown-item text-info">
														<i class="ph-list me-2"></i>
														Detail
													</a>
													<a href="#" class="dropdown-item text-secondary">
														<i class="ph-pencil me-2"></i>
														Edit
													</a>
													<a href="#" class="dropdown-item text-danger">
														<i class="ph-trash me-2"></i>
														Hapus
													</a>
												</div>
											</div>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
@endsection
>>>>>>> a575c9fe3fa288d788be0c58d170050464b1a0ef:resources/views/admin/SettingsAndConfigurations/country/index.blade.php
