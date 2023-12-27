<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PartnerTypesController extends Controller
{
    public function index()
    {
        $response = Http::get(Config('app.api_url') . 'partnerType/viewAll');
        $partnerTypes = $response->json();
        // if (isset($partnerTypes['data']) && is_array($partnerTypes['data']) && count($partnerTypes['data']) > 0) {
        //     foreach ($partnerTypes['data'] as &$pt) {
        //         $pt['PartnerTypeData'] = $this->getPartnerTypeData($pt['partnerTypeId']);
        //     }
        // }
        return view('admin.SettingsAndConfigurations.partnerTypes.index', compact('partnerTypes'));
    }


    // public function getPartnerTypeData($parent)
    // {
    //     $response = Http::get(Config('app.api_url') . 'partnerType/viewById?id=' . $parent);
    //     $PartnerTypeData = $response->json()['data'] ?? null;
    //     return $PartnerTypeData;
    // }


    public function create()
    {
        $parents = Http::get(Config('app.api_url') . 'partnerType/viewAll');
        return view('admin.SettingsAndConfigurations.partnerTypes.create', ['parents' => $parents]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'parentId' => 'required',
            'partnerType' => 'required',
            'description' => 'required'
        ]);
        $response = Http::post(Config('app.api_url') . 'partnerType/insert', [
            'parentId' => (int)$request->input('parentId'),
            'partnerType' => $request->input('partnerType'),
            'description' => $request->input('description')
        ]);
        if ($response->successful()) {
            return redirect()->route('partnerTypes.index')->with('success', 'Kategori Barang berhasil ditambahkan');
        } else {
            return redirect()->route('partnerTypes.index')->with('error', 'Gagal menambahkan Kategori Barang.');
        }
    }

    // public function show($id): View
    // {
    //     $partnerType = DB::table('partnerType')
    //         ->select('partnerType', 'description', 'parentId') // Menggunakan 'parentId' untuk mengambil parent_id
    //         ->where('partnerTypeId', $id)
    //         ->first();

    //     if (!$partnerType) {
    //         return redirect()->route('partnerTypes.index')->with('error', 'Data jenis partner tidak ditemukan.');
    //     }

    //     // Jika Anda ingin menampilkan informasi parent, tambahkan kode berikut:
    //     $parentType = DB::table('partnerType')
    //         ->select('partnerType')
    //         ->where('partnerTypeId', $partnerType->parentId) // Menggunakan 'parentId' untuk mencocokkan parent_id
    //         ->first();

    //     return view('admin.SettingsAndConfigurations.partnerTypes.show', compact('partnerType', 'parentType'));
    // }

    public function edit($id)
    {
        // $response = Http::get(Config('app.api_url') . 'partnerType/viewById?id=' . $id);
        // $temp = $response->json();
        // $partnerTypes = $temp['data'];
        // $responseTypes = Http::get(Config('app.api_url') . 'partnerType/viewAll');
        // $parentData = $responseTypes->json();
        // return view('admin.SettingsAndConfigurations.partnerTypes.edit', compact('partnerTypes', 'parentData'));
        $response = Http::get(Config('app.api_url') . 'partnerType/viewById?id=' . $id);
        $partnerTypes = $response->json();
        return view('admin.SettingsAndConfigurations.partnerTypes.edit', compact('partnerTypes'));
    }

    public function update(Request $request, $id)
    {
        try {
            $response = Http::put(config('app.api_url') . 'partnerType/update', [
                'partnerTypeId' => (int)$id,
                'parentId' => (int)$request->input('parentId'),
                'partnerType' => $request->input('partnerType'),
                'description' => $request->input('description'),
            ]);
            if ($response->successful()) {
                return redirect()->route('partnerTypes.index')->with('success', 'Jenis Partner berhasil diupdate.');
            } else {
                return back()->withErrors('Gagal mengupdate Jenis Partner')->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memperbarui Jenis Partner.')->withInput();
        }
    }

    public function hapus($id)
    {
        $response = Http::delete(Config('app.api_url') . 'partnerType/deleteById?id=' . $id);
        if ($response->successful()) {
            return redirect()->route('partnerTypes.index')->with('success', 'Jenis Partner berhasil dihapus');
        } else {
            return redirect()->route('partnerTypes.index')->with('error', 'Gagal menghapus jenis partner');
        }
    }
}
