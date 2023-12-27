@extends('layouts.admin.template')

@section('content')
    <!-- Basic layout -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Edit Kategori Barang</h5>
        </div>

        <div class="card-body border-top">
            <div class="row">
                <div class="col-lg-9 offset-lg-1">
                    <form action="{{ route('itemCategory.update', ['id' => $itemCategory['itemCategoryId']]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Jenis Barang:</label>
                            <div class="col-lg-9">
                                <select class="form-select" name="itemTypeId" aria-label="Default select example">
                                    <option selected disabled>Pilih Jenis Barang</option>
                                    @foreach ($itemTypes['data'] as $ity)
                                        <option value="{{ $ity['itemTypeId'] }}"
                                            {{ $ity['itemTypeId'] == $itemCategory['itemTypeId'] ? 'selected' : '' }}>
                                            {{ $ity['itemType'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Kategori Barang:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="itemCategoryName"
                                    value="{{ $itemCategory['itemCategoryName'] }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Keterangan:</label>
                            <div class="col-lg-9">
                                <textarea rows="3" cols="3" class="form-control" name="description">{{ $itemCategory['description'] }}</textarea>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Simpan<i
                                    class="ph-check-circle ms-2"></i></button>
                            <button type="cancel" class="btn btn-danger">Batal<i class="ph-x-circle ms-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
