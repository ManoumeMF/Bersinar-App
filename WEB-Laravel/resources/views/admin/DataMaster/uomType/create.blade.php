@extends('layouts.admin.template')

@section('content')
    <!-- Basic layout -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Jenis Satuan Barang</h5>
        </div>
        <div class="card-body border-top">
            <div class="row">
                <div class="col-lg-9 offset-lg-1">
                    <form action="{{route('uomType.store')}}" method="post">
                        {{ csrf_field() }}
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Nama Jenis Satuan Barang:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" placeholder="Masukkan Jenis Satuan Barang" required name="uomType">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Keterangan:</label>
                            <div class="col-lg-9">
                                <textarea rows="3" cols="3" class="form-control" placeholder="Masukkan Keterangan" required name="description"></textarea>
                            </div>
                        </div>
                        <div class="text-end">
                            <a href="{{route('uomType.index')}}">
                                <button type="submit" class="btn btn-primary">Simpan<i
                                    class="ph-check-circle ms-2"></i></button>
                            </a>
                            <button type="reset" class="btn btn-danger">Batal<i class="ph-x-circle ms-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
