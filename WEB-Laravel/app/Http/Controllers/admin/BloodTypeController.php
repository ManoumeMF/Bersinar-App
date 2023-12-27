<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;


class BloodTypeController extends Controller
{
    protected $httpClient;
    public function __construct(Http $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function index()
    {
        $response = Http::get(Config('app.api_url') . 'bloodType/viewAll');
        $bloodTypes = $response->json();
        return view('admin.SettingsAndConfigurations.bloodTypes.index', compact('bloodTypes'));
    }


    public function create(): View
    {
        return view('admin.SettingsAndConfigurations.bloodTypes.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'bloodTypeName' => 'required',
            'description' => 'required',
        ]);
        $response = Http::post(Config('app.api_url') . 'bloodType/insert', [
            'bloodTypeName' => $request->input('bloodTypeName'),
            'description' => $request->input('description')
        ]);
        if ($response->successful()) {
            return response()->json(['message' => 'Golongan Darah berhasil ditambahkan.'], 200);
        } else {
            return response()->json(['message' => 'Gagal menambahkan Golongan Darah.'], 400);
        }
    }

    public function edit($id)
    {
        $response = Http::get(Config('app.api_url') . 'bloodType/viewById?id=' . $id);
        $temp = $response->json();
        $bloodTypeData = $temp['data'][0];
        if (!$bloodTypeData) {
            return redirect()->route('bloodType.index')->with('error', 'Golongan Darah tidak ditemukan.');
        }
        return view('admin.SettingsAndConfigurations.bloodTypes.edit', compact('bloodTypeData'));
    }


    public function update(Request $request, $id)
    {
        try {
            $response = Http::put(config('app.api_url') . 'bloodType/update', [
                "bloodTypeId" => (int)$id,
                'bloodTypeName' => $request->input('bloodTypeName'),
                'description' => $request->input('description'),
            ]);
            if ($response->successful()) {
                return redirect()->route('bloodType.index')->with('success', 'Golongan Darah berhasil diupdate.');
            } else {
                return back()->withErrors('Gagal mengupdate Golongan Darah.')->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memperbarui Golongan Darah.')->withInput();
        }
    }

    public function hapus($id)
    {
        $response = Http::delete(config('app.api_url') . 'bloodType/deleteById?id=' . $id);
        if ($response->successful()) {
            return redirect()->route('bloodType.index')->with('success', 'Golongan Darah berhasil dihapus.');
        } else {
            return back()->withErrors('Gagal menghapus Golongan Darah.');
        }
    }

    // public function show($id)
    // {
    //     $response = Http::get(Config('app.api_url') . 'bloodType/viewById?id=' . $id);
    //     if ($response->successful()) {
    //         $bloodType = $response->json()['data'][0];
    //         return view('admin.SettingsAndConfigurations.bloodTypes.show', compact('bloodType'));
    //     } else {
    //         return redirect()->route('bloodType.index')->with('error', 'Golongan Darah tidak ditemukan.');
    //     }
    // }
}
