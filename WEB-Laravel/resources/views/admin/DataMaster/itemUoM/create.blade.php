@extends('layouts.admin.template')
@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Satuan Barang</h5>
        </div>
        <div class="card-body border-top">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <form action="{{ route('itemUoM.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Jenis Satuan Barang:</label>
                            <div class="col-lg-8">
                                <select class="form-select" name="uomTypeId" aria-label="Default select example">
                                    <option selected disabled>Pilih Jenis Satuan Barang</option>
                                    @foreach ($uomType['data'] as $item)
                                        <option value="{{ $item['uomTypeId'] }}">
                                            {{ $item['uomType'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-1">
                                <a class="btn btn-primary" href="{{ route('uomType.create') }}">
                                    <i class="ph-plus-circle"></i><span class="d-none d-lg-inline-block"></span>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Satuan Barang:</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" placeholder="Masukkan Satuan Barang"
                                    name="uomItem">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Keterangan:</label>
                            <div class="col-lg-8">
                                <textarea rows="3" cols="3" class="form-control" placeholder="Masukkan Keterangan" name="description"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11 text-end">
                                <button type="submit" class="btn btn-primary">Simpan<i
                                        class="ph-check-circle ms-2"></i></button>
                                <button type="reset" class="btn btn-danger">Batal<i class="ph-x-circle ms-2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
