<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class BusinessUnitTypeController extends Controller
{
    public function index()
    {
        $response = Http::get(Config('app.api_url') . 'businessUnitType/viewAll');
        $businessUnitType = $response->json();
        return view('admin.SettingsAndConfigurations.businessTypes.index', compact('businessUnitType'));
    }

    public function create()
    {

        return view('admin.SettingsAndConfigurations.businessTypes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'businessUnitType' => 'required',
            'description' => 'required',
        ]);

        $response = Http::post(Config('app.api_url') . 'businessUnitType/insert', [
            'businessUnitType' => $request->input('businessUnitType'),
            'description' => $request->input('description')
        ]);
        return redirect()->route('businessUnitTypes.index')->with('success', 'Tipe Bisnis Unit berhasil ditambahkan');
        if ($response->successful()) {
            return response()->json(['message' => 'Jenis Unit Bisnis berhasil ditambahkan.'], 200);
        } else {
            return response()->json(['message' => 'Gagal menambahkan Jenis Unit Bisnis.'], 400);
        }
    }

    public function edit($id)
    {
        $response = Http::get(Config('app.api_url') . 'businessUnitType/viewById?id=' . $id);
        $temp = $response->json();
        $businessUnitTypeData = $temp['data'];
        if (!$businessUnitTypeData) {
            return redirect()->route('businessUnitTypes.index')->with('error', 'Jenis Unit Bisnis tidak ditemukan.');
        }
        return view('admin.SettingsAndConfigurations.businessTypes.update', compact('businessUnitTypeData'));
    }

    public function update(Request $request, $id)
    {
        try {
            $response = Http::put(config('app.api_url') . 'businessUnitType/update', [
                "sbuTypeId" => (int)$id,
                'businessUnitType' => $request->input('businessUnitType'),
                'description' => $request->input('description'),
            ]);

            if ($response->successful()) {
                return redirect()->route('businessUnitTypes.index')->with('success', 'Jenis Unit Bisnis berhasil diupdate.');
            } else {
                return back()->withErrors('Gagal mengupdate Jenis Unit Bisnis.')->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memperbarui Jenis Unit Bisnis.')->withInput();
        }
    }

    public function hapus($id)
    {
        $response = Http::delete(config('app.api_url') . 'businessUnitType/deleteById?id=' . $id);
        if ($response->successful()) {
            return redirect()->route('businessUnitTypes.index')->with('success', 'Jenis Unit Bisnis berhasil dihapus.');
        } else {
            return back()->withErrors('Gagal menghapus Jenis Unit Bisnis.');
        }
    }

    public function detail($id)
    {
        $response = Http::get(config('app.api_url') . 'businessUnitType/viewById?id=' . $id);
        if ($response->successful()) {
            $businessUnitType = $response->json()['data'];
            return view('admin.SettingsAndConfigurations.businessTypes.detail', compact('businessUnitType'));
        } else {
            return redirect()->route('businessUnitTypes.index')->with('error', 'Jenis Unit Bisnis tidak ditemukan.');
        }
    }
}
