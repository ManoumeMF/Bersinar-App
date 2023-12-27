<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReligionController extends Controller
{
    public function index()
    {
        $response = Http::get(Config('app.api_url') . 'religion/viewAll');
        $religion = $response->json();
        return view('admin.SettingsAndConfigurations.religion.index', compact('religion'));
    }

    public function create()
    {
        return view('admin.SettingsAndConfigurations.religion.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'religionName' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        try {
            $response = Http::post(config('app.api_url') . 'religion/insert', $validatedData);
            if ($response->successful()) {
                return response()->json(['message' => 'Agama berhasil ditambahkan.'], 200);
            } else {
                Log::error('Error inserting religion: ' . $response->body());
                return response()->json(['message' => 'Gagal menambahkan Agama.'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Exception in inserting religion: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan pada server.'], 500);
        }
    }

    public function edit($id)
    {
        $response = Http::get(Config('app.api_url') . 'religion/viewById?id=' . $id);
        $temp = $response->json();
        $religionData = $temp['data'][0];
        if (!$religionData) {
            return redirect()->route('religion.index')->with('error', 'Agama tidak ditemukan.');
        }
        return view('admin.SettingsAndConfigurations.religion.edit', compact('religionData'));
    }

    public function update(Request $request, $id)
    {
        try {
            $response = Http::put(config('app.api_url') . 'religion/update', [
                "religionId" => (int)$id,
                'religionName' => $request->input('religionName'),
                'description' => $request->input('description')
            ]);
            if ($response->successful()) {
                return redirect()->route('religion.index')->with('success', 'Agama berhasil diupdate.');
            } else {
                return back()->withErrors('Gagal mengupdate Agama.')->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memperbarui Agama.')->withInput();
        }
    }

    public function hapus($id)
    {
        $response = Http::delete(config('app.api_url') . 'religion/deleteById?id=' . $id);
        if ($response->successful()) {
            return redirect()->route('religion.index')->with('success', 'Agama berhasil dihapus.');
        } else {
            return back()->withErrors('Gagal menghapus Agama.');
        }
    }
}
