<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use PSpell\Config;

class ItemCategoryController extends Controller
{
    public function index()
    {
        $response = Http::get(Config('app.api_url') . 'itemCategory/viewAll');
        $itemCategory = $response->json();
        if (isset($itemCategory['data']) && is_array($itemCategory['data']) && count($itemCategory['data']) > 0) {
            foreach ($itemCategory['data'] as &$iC) {
                $iC['itemTypeData'] = $this->getItemTypeData($iC['itemTypeId']);
            }
        }
        return view('admin.DataMaster.itemCategory.index', compact('itemCategory'));
    }


    protected function getItemTypeData($itemTypeId)
    {
        $response = Http::get(Config('app.api_url') . 'itemType/viewById?id=' . $itemTypeId);
        $itemTypeData = $response->json()['data'] ?? null;
        return $itemTypeData;
    }

    public function create()
    {
        $response = Http::get(Config('app.api_url') . 'itemType/viewAll');
        $itemType = $response->json();

        return view('admin.DataMaster.itemCategory.create', compact('itemType'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'itemTypeId' => 'required',
            'itemCategoryName' => 'required',
            'description' => 'required',
        ]);
        $response = Http::post(config('app.api_url') . 'itemCategory/insert', [
            'itemTypeId' => (int)$request->input('itemTypeId'),
            'itemCategoryName' => $request->input('itemCategoryName'),
            'description' => $request->input('description'),
        ]);
        if ($response->successful()) {
            return redirect()->route('itemCategory.index')->with('success', 'Kategori Barang berhasil ditambahkan');
        } else {
            return redirect()->route('itemCategory.index')->with('error', 'Gagal menambahkan Kategori Barang.');
        }
    }

    public function edit($id): View
    {
        $response = Http::get(Config('app.api_url') . 'itemCategory/viewById?id=' . $id);
        $temp = $response->json();
        $itemCategory = $temp['data'];
        $responseTypes = Http::get(Config('app.api_url') . 'itemType/viewAll');
        $itemTypes = $responseTypes->json();
        return view('admin.DataMaster.itemCategory.edit', compact('itemCategory', 'itemTypes'));
    }

    public function update(Request $request, $id)
    {
        try {
            $response = Http::put(config('app.api_url') . 'itemCategory/update', [
                'itemCategoryId' => (int)$id,
                'itemTypeId' => (int)$request->input('itemTypeId'),
                'itemCategoryName' => $request->input('itemCategoryName'),
                'description' => $request->input('description'),
            ]);
            if ($response->successful()) {
                return redirect()->route('itemCategory.index')->with('success', 'Kategori Barang berhasil diupdate.');
            } else {
                return back()->withErrors('Gagal mengupdate Satuan Barang')->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memperbarui Kategori Barang.')->withInput();
        }
    }

    public function show($id): View
    {
        $response = Http::get(Config('app.api_url') . 'itemCategory/viewById?id=' . $id);
        if ($response->successful()) {
            $itemCategory = $response->json()['data'];
            $response2 = Http::get(Config('app.api_url') . 'itemType/viewById?id=' . $itemCategory['itemTypeId']);
            $itemCategory['itemTypeData'] = $response2->json()['data'];
            return view('admin.DataMaster.itemCategory.show', compact('itemCategory'));
            // return dd($itemCategory);
        } else {
            return redirect()->route('itemCategory.index')->with('error', 'Kategori Barang tidak ditemukan.');
        }
    }

    public function hapus($id)
    {
        $response = Http::delete(Config('app.api_url') . 'itemCategory/deleteById?id=' . $id);
        if ($response->successful()) {
            return redirect()->route('itemCategory.index')->with('success', 'Kategori Barang berhasil dihapus');
        } else {
            return redirect()->route('itemCategory.index')->with('error', 'Gagal menghapus kategori barang');
        }
    }
}
