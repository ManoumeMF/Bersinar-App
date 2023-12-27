<!-- resources/views/admin/DataMaster/kategoriBarang/show.blade.php -->

@extends('layouts.admin.template')

@section('content')
    <!-- Basic layout -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Detail Kategori Barang</h5>
        </div>

        <div class="card-body border-top">
            <div class="row">
                <div class="card-body">
                    <form action="#">
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label fw-semibold">Jenis Barang :</label>
                            <div class="col-lg-9">
                                <label class="col-lg-9 col-form-label">
                                    {{ $itemCategory['itemCategoryId'] ? $itemCategory['itemTypeData']['itemType'] : 'Jenis Barang Tidak Ditemukan' }}
                                </label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label fw-semibold">Kategori Barang:</label>
                            <div class="col-lg-9">
                                <label class="col-lg-9 col-form-label">
                                    {{ $itemCategory['itemCategoryName'] }}
                                </label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label fw-semibold">Keterangan:</label>
                            <div class="col-lg-9">
                                <label class="col-lg-9 col-form-label">
                                    {{ $itemCategory['description'] }}
                                </label>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('itemCategory.index') }}" class="btn btn-primary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /basic layout -->
@endsection
