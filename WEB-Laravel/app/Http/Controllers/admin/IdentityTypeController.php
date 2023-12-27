<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class IdentityTypeController extends Controller
{
    public function index()
    {
        $response = Http::get(Config('app.api_url') . 'identityType/viewAll');
        $identityType = $response->json();
        return view('admin.SettingsAndConfigurations.identityTypes.index', compact('identityType'));
    }

    // public function index()
    // {
    //     try {
    //         $cacheDuration = 60;
    //         $identityType = Cache::remember('identityType', $cacheDuration, function () {
    //             $response = Http::get(config('app.api_url') . 'identityType/viewAll');
    //             if ($response->successful()) {
    //                 return $response->json();
    //             } else {
    //                 return null;
    //             }
    //         });
    //         if ($identityType) {
    //             return view('admin.SettingsAndConfigurations.identityTypes.index', compact('identityType'));
    //         } else {
    //             return back()->withError('Failed to fetch identity types from API.')->withInput();
    //         }
    //     } catch (\Exception $e) {
    //         return back()->withError('An error occurred: ' . $e->getMessage())->withInput();
    //     }
    // }


    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'identityType' => 'required',
    //         'description' => 'required',
    //     ]);
    //     $response = Http::post(Config('app.api_url') . 'identityType/insert', [
    //         'identityType' => $request->input('identityType'),
    //         'description' => $request->input('description')
    //     ]);

    //     if ($response->successful()) {
    //         return redirect()->route('identityType.index')->with('success', 'Jenis Identitas berhasil diupdate.');
    //     } else {
    //         return back()->withErrors('Gagal mengupdate Jenis Identitas.')->withInput();
    //     }
    // }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'identityType' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        try {
            $response = Http::post(config('app.api_url') . 'identityType/insert', $validatedData);
            if ($response->successful()) {
                return response()->json(['message' => 'Jenis identitas berhasil ditambahkan.'], 200);
            } else {
                Log::error('Error inserting identityType: ' . $response->body());
                return response()->json(['message' => 'Gagal menambahkan jenis identitas.'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Exception in inserting identityType: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan pada server.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $response = Http::put(config('app.api_url') . 'identityType/update', [
                "identityTypeId" => (int)$id,
                'identityType' => $request->input('identityType'),
                'description' => $request->input('description')
            ]);
            if ($response->successful()) {
                return redirect()->route('identityType.index')->with('success', 'Jenis identitas berhasil diupdate.');
            } else {
                return back()->withErrors('Gagal mengupdate jenis identitas.')->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memperbarui jenis identitas.')->withInput();
        }
    }

    // public function edit($id): View
    // {
    //     $response = Http::get(Config('app.api_url') . 'identityType/viewById?id=' . $id);

    //     if (!$identityType) {
    //         return redirect()->route('identityType.index')->with('error', 'Jenis identitas tidak ditemukan.');
    //     }

    //     return view('admin.SettingsAndConfigurations.identityTypes.edit', compact('identityType'));
    // }
    public function edit($id)
    {
        try {
            $response = Http::get(Config('app.api_url') . 'identityType/viewById', ['id' => $id]);

            if ($response->failed()) {
                throw new Exception('Gagal mengambil data dari API.');
            }

            $identityTypeData = $response->json('data.0');

            if (!$identityTypeData) {
                return redirect()->route('identityType.index')->with('error', 'Jenis identitas tidak ditemukan.');
            }

            return view('admin.SettingsAndConfigurations.identityTypes.index', compact('identityTypeData'));
        } catch (Exception $e) {
            return redirect()->route('identityType.index')->with('error', 'Terjadi kesalahan saat mengambil data.');
        }
    }


    public function hapus($id)
    {
        $response = Http::delete(config('app.api_url') . 'identityType/deleteById?id=' . $id);
        if ($response->successful()) {
            return redirect()->route('identityType.index')->with('success', 'Jenis Identitas berhasil dihapus.');
        } else {
            return back()->withErrors('Gagal menghapus Jenis Identitas.');
        }
    }


    public function show($id): View
    {
        $identityType = DB::table('identityType')->where('identityTypeId', $id)->first();

        if (!$identityType) {
            return redirect()->route('identityType.index')->with('error', 'Jenis identitas tidak ditemukan.');
        }

        return view('admin.SettingsAndConfigurations.identityTypes.show', compact('identityType'));
    }
}
