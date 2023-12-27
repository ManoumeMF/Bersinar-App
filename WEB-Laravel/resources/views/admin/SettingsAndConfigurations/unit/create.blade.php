@extends('layouts.admin.template')

@section('content')
    <!-- Basic layout -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Unit</h5>
        </div>

        <div class="card-body border-top">
            <div class="row">
                <div class="col-lg-9 offset-lg-1">
                    <form action="#">
                        {{-- <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Unit Bisnis:</label>
                            <div class="col-lg-8">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Pilih Unit Bisnis</option>
                                    <option value="1">Sumatera Utara</option>
                                    <option value="2">DKI Jakarta</option>
                                    <option value="3">Sulawesi Barat</option>
                                </select>                            </div>

                            <div class="col-lg-1">
                                <a class="btn btn-primary" href="{{route('businessUnit.create')}}"><i class="ph-plus-circle"></i><span
                                    class="d-none d-lg-inline-block"></span></a>
                            </div>
                        </div> --}}
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Nama Departemen:</label>
                            <div class="col-lg-8">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Pilih Departemen</option>
                                    <option value="1">Sumatera Utara</option>
                                    <option value="2">DKI Jakarta</option>
                                    <option value="3">Sulawesi Barat</option>
                                </select>
                            </div>

                            <div class="col-lg-1">
                                <a class="btn btn-primary" href="{{route('department.create')}}"><i class="ph-plus-circle"></i><span
                                    class="d-none d-lg-inline-block"></span></a>
                            </div>
                        </div>




                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Nama Unit</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" placeholder="Masukkan Nama Unit">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Keterangan:</label>
                            <div class="col-lg-8">
                                <textarea rows="3" cols="3" class="form-control" placeholder="Masukkan Keterangan"></textarea>
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
    <!-- /basic layout -->
@endsection
