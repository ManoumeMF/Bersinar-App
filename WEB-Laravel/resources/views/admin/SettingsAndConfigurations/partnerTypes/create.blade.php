@extends('layouts.admin.template')

@section('content')
    <!-- Basic layout -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Jenis Partner</h5>
        </div>
        <div class="card-body border-top">
            <div class="row justify-content-center">
                <div class="col-lg-9 ">
                    <form method="post" action="{{ route('partnerTypes.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Parent:</label>
                            <div class="col-lg-8">
                                <select name="parent_id" class="form-select" aria-label="Default select example">
                                    <option value="">Pilih Parent</option>
                                    @foreach ($parents['data'] as $parent)
                                        <option value="{{ $parent['partnerType'] }}">{{ $parent['partnerType'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Jenis Partner:</label>
                            <div class="col-lg-8">
                                <input type="text" name="jenis_partner" class="form-control" placeholder="Masukkan Jenis Partner">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Keterangan:</label>
                            <div class="col-lg-8">
                                <textarea name="keterangan" rows="3" cols="3" class="form-control" placeholder="Masukkan Keterangan"></textarea>
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
