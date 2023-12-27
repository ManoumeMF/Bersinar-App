<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

class ItemUoMController extends Controller
{
    public function index(): View
    {
        $response = Http::get(Config('app.api_url') . 'itemUoM/viewAll');
        $itemUoM = $response->json();
        if (isset($itemUoM['data']) && is_array($itemUoM['data']) && count($itemUoM['data']) >0) {
            foreach ($itemUoM['data'] as &$IU){
                $IU['uomTypeData'] = $this->getUomTypeData($IU['uomTypeId']);
            }
        }
        return view('admin.DataMaster.itemUoM.index', compact('itemUoM'));
    }

    protected function getUomTypeData($uomTypeId){
        $response = Http::get(Config('app.api_url') . 'uomType/viewById?id=' . $uomTypeId);
        $uomTypeData = $response->json()['data'] ?? null;
        return $uomTypeData;
    }



    public function create()
    {
        $response = Http::get(Config('app.api_url') . 'uomType/viewAll');
        $uomType = $response->json();

        return view('admin.DataMaster.itemUoM.create', compact('uomType'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'uomTypeId' => 'required',
            'uomItem' => 'required',
            'description' => 'required',
        ]);
        $response = Http::post(Config('app.api_url') . 'itemUoM/insert', [
            'uomTypeId' => (int)$request->input('uomTypeId'),
            'uomItem' => $request->input('uomItem'),
            'description' => $request->input('description'),
        ]);
        if ($response->successful()) {
            return redirect()->route('itemUoM.index')->with('success', 'Satuan Barang berhasil ditambahkan.');
        } else {
            return redirect()->route('itemUoM.index')->with('error', 'Gagal menambahkan Satuan Barang.');
        }
    }

    public function edit($id): View
    {
        $response = Http::get(Config('app.api_url') . 'itemUoM/viewById?id=' . $id);
        $temp = $response->json();
        $itemUoM = $temp['data'];
        $responseTypes = Http::get(Config('app.api_url') . 'uomType/viewAll');
        $uomTypes = $responseTypes->json();
        // return dd($uomTypes);
        return view('admin.DataMaster.itemUoM.edit', compact('itemUoM','uomTypes'));
    }

    public function update(Request $request, $id)
    {
        try {
            $response = Http::put(config('app.api_url') . 'itemUoM/update', [
                'itemUoMId'=>(int)$id,
                'uomTypeId' => (int)$request->input('uomTypeId'),
                'uomItem' => $request->input('uomItem'),
                'description' => $request->input('description'),
            ]);
            if ($response->successful()) {
                return redirect()->route('itemUoM.index')->with('success', 'Satuan Barang berhasil diupdate.');
            } else {
                return back()->withErrors('Gagal mengupdate Satuan Barang.')->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memperbarui Satuan Barang.')->withInput();
        }

    }
    public function show($id): View
    {
        $response = Http::get(Config('app.api_url').'itemUoM/viewById?id=' .$id);
        if ($response->successful()) {
            $itemUoM = $response->json()['data'];
            $response2 = Http::get(Config('app.api_url').'uomType/viewById?id=' .$itemUoM['uomTypeId']);
            $itemUoM['uomTypeData'] = $response2->json()['data'];

            // return dd($itemUoM);
           return view('admin.DataMaster.itemUoM.show', compact('itemUoM'));
        }else {
            return redirect()->route('itemUoM.index')->with('error', 'Satuan Barang tidak ditemukan.');
        }

    }

    public function hapus($id)
    {
        $response = Http::delete(Config('app.api_url').'itemUoM/deleteById?id=' .$id);
        if ($response->successful()) {
            return redirect()->route('itemUoM.index')->with('success', 'Satuan Barang berhasil dihapus.');
        }
         else {
            return redirect()->route('itemUoM.index')->with('error', 'Gagal menghapus Satuan Barang.');
        }
    }
}
