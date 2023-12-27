<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UomTypeController extends Controller
{
    public function index()
    {
        $response = Http::get(Config('app.api_url') . 'uomType/viewAll');
        $uomType = $response->json();
        return view('admin.DataMaster.uomType.index', compact('uomType'));
    }

    public function create()
    {
        return view('admin.DataMaster.uomType.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'uomType' => 'required',
            'description' => 'required',
        ]);
        $response = Http::post(Config('app.api_url') . 'uomType/insert', [
            'uomType' => $request->input('uomType'),
            'description' => $request->input('description'),
        ]);
        return redirect()->route('uomType.index')->with('success', 'Jenis Satuan Barang berhasil ditambahkan');
        if ($response->successful()) {
            return response()->json(['message' => 'Jenis Satuan Barang berhasil ditambahkan.'], 200);
        } else {
            return response()->json(['message' => 'Gagal menambahkan Jenis Satuan Barang.'], 400);
        }
    }

    public function edit($id)
    {
        $response = Http::get(Config('app.api_url') . 'uomType/viewById?id=' . $id);
        $temp = $response->json();
        $uomTypeData = $temp['data']['0'];
        if (!$uomTypeData) {
            return redirect()->route('uomType.index')->with('error', 'Golongan Darah tidak ditemukan.');
        }
        return view('admin.DataMaster.uomType.update', compact('uomTypeData'));
    }

    public function update(Request $request, $id)
    {
        try {
            $response = Http::put(config('app.api_url') . 'uomType/update', [
                'uomTypeId' => (int)$id,
                'uomType' => $request->input('uomType'),
                'description' => $request->input('description'),
            ]);
            if ($response->successful()) {
                return redirect()->route('uomType.index')->with('success', 'Jenis Satuan Barang berhasil diupdate.');
            } else {
                return back()->withErrors('Gagal mengupdate Jenis Satuan Barang.')->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memperbarui Jenis Satuan Barang.')->withInput();
        }
    }

    public function hapus($id)
    {
        // try {
        $response = Http::delete(config('app.api_url') . 'uomType/deleteById?id=' . $id);
        if ($response->successful()) {
            return redirect()->route('uomType.index')->with('success', 'Jenis Satuan Barang berhasil dihapus');
        } else {
            return redirect()->route('uomType.index')->with('error', 'Jenis Satuan Barang gagal dihapus');
        }
        // } catch (\Exception $e) {
        //     return redirect()->route('uomType.index')->with('error', 'Jenis Satuan Barang gagal dihapus');
        // }
    }
    public function show($id)
    {
        $response = Http::get(Config('app.api_url') . 'uomType/viewById?id=' . $id);
        if ($response->successful()) {
            $uomType = $response->json()['data'][0];
            return view('admin.DataMaster.uomType.detail', compact('uomType'));
        } else {
            return redirect()->route('uomType.index')->with('error', 'Jenis Satuan Barang tidak ditemukan.');
        }
    }
}
