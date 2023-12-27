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

<div class="card">
						<div class="card-header d-flex">
							<h5 class="mb-0">Daftar Currency</h5>
							<div class="ms-auto">
                        		<a class="btn btn-primary" href="{{ route('currency.create') }}"><i class="ph-plus-circle"></i><span class="d-none d-lg-inline-block ms-2">Tambah Currency</span></a>
                    		</div>
						</div>

						<table border="2" class="table table-bordered datatable-save-state">
							<thead>
								<tr>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Job Title</th>
									<th>DOB</th>
									<th>Status</th>
									<th class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Marth</td>
									<td><a href="#">Enright</a></td>
									<td>Traffic Court Referee</td>
									<td>22 Jun 1972</td>
									<td><span class="badge bg-success bg-opacity-10 text-success">Active</span></td>
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
									<td>Jackelyn</td>
									<td>Weible</td>
									<td><a href="#">Airline Transport Pilot</a></td>
									<td>3 Oct 1981</td>
									<td><span class="badge bg-secondary bg-opacity-10 text-secondary">Inactive</span></td>
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
									<td>19 Apr 1969</td>
									<td><span class="badge bg-danger bg-opacity-10 text-danger">Suspended</span></td>
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
									<td>13 Dec 1977</td>
									<td><span class="badge bg-info bg-opacity-10 text-info">Pending</span></td>
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
									<td>Sharan</td>
									<td>Leland</td>
									<td>Aviation Tactical Readiness Officer</td>
									<td>30 Dec 1991</td>
									<td><span class="badge bg-secondary bg-opacity-10 text-secondary">Inactive</span></td>
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
									<td>17 Oct 1987</td>
									<td><span class="badge bg-info bg-opacity-10 text-info">Pending</span></td>
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
									<td>11 Nov 1983</td>
									<td><span class="badge bg-danger bg-opacity-10 text-danger">Suspended</span></td>
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
									<td>1 Nov 1961</td>
									<td><span class="badge bg-danger bg-opacity-10 text-danger">Suspended</span></td>
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
									<td>18 Dec 1960</td>
									<td><span class="badge bg-success bg-opacity-10 text-success">Active</span></td>
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
									<td>10 Jan 1980</td>
									<td><span class="badge bg-secondary bg-opacity-10 text-secondary">Inactive</span></td>
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
									<td>21 Dec 1968</td>
									<td><span class="badge bg-info bg-opacity-10 text-info">Pending</span></td>
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
									<td>Roland</td>
									<td>Salmos</td>
									<td><a href="#">Senior Program Developer</a></td>
									<td>5 Jun 1986</td>
									<td><span class="badge bg-secondary bg-opacity-10 text-secondary">Inactive</span></td>
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
									<td>Coy</td>
									<td>Wollard</td>
									<td>Customer Service Operator</td>
									<td>12 Oct 1982</td>
									<td><span class="badge bg-success bg-opacity-10 text-success">Active</span></td>
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
									<td>Maxwell</td>
									<td>Maben</td>
									<td>Regional Representative</td>
									<td>25 Feb 1988</td>
									<td><span class="badge bg-danger bg-opacity-10 text-danger">Suspended</span></td>
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
									<td>Cicely</td>
									<td>Sigler</td>
									<td><a href="#">Senior Research Officer</a></td>
									<td>15 Mar 1960</td>
									<td><span class="badge bg-info bg-opacity-10 text-info">Pending</span></td>
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
