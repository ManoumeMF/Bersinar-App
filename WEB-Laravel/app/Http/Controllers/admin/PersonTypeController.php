<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use PSpell\Config;

class PersonTypeController extends Controller
{

    public function index()
    {
        $response = Http::get(Config('app.api_url') . 'personType/viewAll');
        $personType = $response->json();
        return view('admin.SettingsAndConfigurations.personType.index', compact('personType'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'personType' => 'required',
            'description' => 'required',
        ]);

        $response = Http::post(Config('app.api_url') . 'personType/insert', [
            'personType' => $request->input('personType'),
            'description' => $request->input('description')
        ]);

        if ($response->successful()) {
            return response()->json(['message' => 'Jenis orang berhasil ditambahkan.'], 200);
        } else {
            return response()->json(['message' => 'Gagal menambahkan jenis orang.'], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $response = Http::put(config('app.api_url') . 'personType/update', [
                "personTypeId" => (int)$id,
                'personType' => $request->input('personType'),
                'description' => $request->input('description')
            ]);
            if ($response->successful()) {
                return redirect()->route('personType.index')->with('success', 'jenis orang berhasil diupdate.');
            } else {
                return back()->withErrors('Gagal mengupdate jenis orang.')->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memperbarui jenis orang.')->withInput();
        }
    }

    public function edit($id)
    {
        $response = Http::get(Config('app.api_url') . 'personType/viewById?id=' . $id);
        $temp = $response->json();
        $personTypeData = $temp['data'][0];
        if (!$personTypeData) {
            return redirect()->route('personType.index')->with('error', 'Agama tidak ditemukan.');
        }
        return view('admin.SettingsAndConfigurations.personType.edit', compact('personTypeData'));
    }


    public function show($id)
    {
        $personType = DB::table('personType')->where('personTypeId', $id)->first();
        return response()->json([
            'personType' => $personType->personType,
            'description' => $personType->description,
        ]);
    }

    public function delete($id)
    {
        $response = Http::delete(config('app.api_url') . 'personType/deleteById?id=' . $id);
        if ($response->successful()) {
            return redirect()->route('personType.index')->with('success', 'Jenis orang berhasil dihapus.');
        } else {
            return back()->withErrors('Gagal menghapus jenis orang.');
        }
    }
}
