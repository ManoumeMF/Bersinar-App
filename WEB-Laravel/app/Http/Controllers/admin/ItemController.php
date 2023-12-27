<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ItemController extends Controller
{
    public function index()
    {
        $response = Http::get(Config('app.api_url') . 'item/viewAll');
        $item = $response->json();
        if (isset($item['data']) && is_array($item['data']) && count($item['data']) > 0) {
            foreach ($item['data'] as &$barang) {
                $barang['itemDetail'] = $this->getItemDetail($barang['itemId']);
            }
        }
        return view('admin.DataMaster.item.index', compact('item'));
    }

    public function getItemDetail($id)
    {
        $response = Http::get(Config('app.api_url') . 'item/viewById?id=' . $id);
        $itemDetail = $response->json()['data'] ?? null;
        return $itemDetail;
    }

    public function create()
    {
        return view('admin.DataMaster.item.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'businessUnitId' => 'required',
            'itemCode' => 'required',
            'itemName' => 'required',
            'itemCategoryId' => 'required',
            'itemUoMId' => 'required',
            'specification' => 'required',
            'barcode' => 'required',
            'description' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        $gambar = $request->file('gambar');
        $gambarName = time() . '.' . $gambar->getClientOriginalExtension();
        $gambar->move(public_path('images/itemImage'), $gambarName);
        $response = Http::post(config('app.api_url') . 'item/insert', [
            'businessUnitId' => (int)$request->input('businessUnitId'),
            'itemCode' => $request->input('itemCode'),
            'itemName' => $request->input('itemName'),
            'itemCategoryId' => (int) $request->input('itemCategoryId'),
            'itemUoMId' =>  (int) $request->input('itemUoMId'),
            'specification' =>  $request->input('specification'),
            'barcode' => $request->input('barcode'),
            'description' => $request->input('description'),
            'gambar' => $gambarName
        ]);
        if ($response->successful()) {
            return redirect()->route('item.index')->with('success', 'Barang Berhasil Ditambahkan');
        } else {
            return redirect()->route('item.index')->with('error', 'Gagal Menambahkan Barang');
        }
    }


    public function show(string $id)
    {
        //
    }


    public function edit($id)
    {
        $response = Http::get(Config('app.api_url') . 'item/viewById?id=' . $id);
        $temp = $response->json();
        $editItem = $temp['data'];
        return view('admin.DataMaster.item.edit', compact('editItem'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'businessUnitId' => 'required',
            'itemCode' => 'required',
            'itemName' => 'required',
            'itemCategoryId' => 'required',
            'itemUoMId' => 'required',
            'specification' => 'required',
            'barcode' => 'required',
            'description' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $response = Http::get(Config('app.api_url') . 'item/viewById?id=' . $id);
        if (!$response->successful()) {
            return back()->withErrors('Gagal mendapatkan data item.')->withInput();
        }

        $currentItem = $response->json()['data'];
        $currentGambarName = $currentItem['gambar'];

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarName = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('images'), $gambarName);

            if (file_exists(public_path('images/') . $currentGambarName)) {
                unlink(public_path('images/') . $currentGambarName);
            }
        } else {
            $gambarName = $currentGambarName;
        }

        try {
            $response = Http::put(Config('app.api_url') . 'item/update', [
                "itemId" => (int)$id,
                'businessUnitId' => (int) $request->input('businessUnitId'),
                'itemCode' => $request->input('itemCode'),
                'itemName' => $request->input('itemName'),
                'itemCategoryId' => (int) $request->input('itemCategoryId'),
                'itemUoMId' =>  (int) $request->input('itemUoMId'),
                'specification' =>  $request->input('specification'),
                'barcode' => $request->input('barcode'),
                'description' => $request->input('description'),
                'gambar' => $gambarName
            ]);
            if ($response->successful()) {
                return redirect()->route('item.index')->with('success', 'Item berhasil diupdate.');
            } else {
                return back()->withErrors('Gagal mengupdate item.')->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memperbarui item.')->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $response = Http::delete(config('app.api_url') . 'item/deleteById?id=' . $id);
        if ($response->successful()) {
            return redirect()->route('item.index')->with('success', 'Barang berhasil dihapus.');
        } else {
            return back()->withErrors('Gagal menghapus Barang.');
        }
    }
}
