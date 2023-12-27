<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OccupationController extends Controller
{
    protected $httpClient;

    public function __construct(Http $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function index()
    {
        try {
            $response = $this->httpClient::get(config('app.api_url') . 'occupation/viewAll');
            $occupation = $response->json();
            return view('admin.SettingsAndConfigurations.occupation.index', compact('occupation'));
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat mengambil daftar Pekerjaan: ' . $e->getMessage());
            return redirect()->route('occupation.index')->with('error', 'Terjadi kesalahan saat mengambil daftar Pekerjaan.');
        }
    }

    public function create(): View
    {
        return view('admin.SettingsAndConfigurations.occupation.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'occupationName' => 'required',
            'description' => 'required',
        ]);
        try {
            $response = $this->httpClient::post(config('app.api_url') . 'occupation/insert', [
                'occupationName' => $request->input('occupationName'),
                'description' => $request->input('description'),
            ]);
            if ($response->successful()) {
                return redirect()->route('occupation.index')->with('success', 'Pekerjaan berhasil ditambahkan');
            } else {
                Log::error('Gagal menambahkan Pekerjaan: ' . $response->status() . ' - ' . $response->body());
                return redirect()->route('occupation.create')->with('error', 'Gagal menambahkan Pekerjaan.');
            }
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat menambahkan Pekerjaan: ' . $e->getMessage());
            return redirect()->route('occupation.create')->with('error', 'Terjadi kesalahan saat menambahkan Pekerjaan.');
        }
    }

    public function show($id): View
    {
        try {
            $response = $this->httpClient::get(config('app.api_url') . 'occupation/viewById?id=' . $id);
            if ($response->successful()) {
                $occupation = $response->json()['data'];
                return view('admin.SettingsAndConfigurations.occupation.show', compact('occupation'));
            } else {
                Log::error('Pekerjaan tidak ditemukan: ' . $response->status() . ' - ' . $response->body());
                return redirect()->route('occupation.index')->with('error', 'Pekerjaan tidak ditemukan.');
            }
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat mengambil data Pekerjaan: ' . $e->getMessage());
            return redirect()->route('occupation.index')->with('error', 'Terjadi kesalahan saat mengambil data Pekerjaan.');
        }
    }

    public function edit($id): View
    {
        try {
            $response = $this->httpClient::get(config('app.api_url') . 'occupation/viewById?id=' . $id);
            $occupationData = $response->json()['data'] ?? null;
            if (!$occupationData) {
                Log::error('Pekerjaan tidak ditemukan: ' . $response->status() . ' - ' . $response->body());
                return redirect()->route('occupation.index')->with('error', 'Pekerjaan tidak ditemukan.');
            }
            return view('admin.SettingsAndConfigurations.occupation.edit', compact('occupationData'));
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat mengambil data Pekerjaan: ' . $e->getMessage());
            return redirect()->route('occupation.index')->with('error', 'Terjadi kesalahan saat mengambil data Pekerjaan.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'occupationName' => 'required',
            'description' => 'required',
        ]);
        try {
            $response = $this->httpClient::put(config('app.api_url') . 'occupation/update', [
                'occupationId' => (int)$id,
                'occupationName' => $request->input('occupationName'),
                'description' => $request->input('description'),
            ]);
            if ($response->successful()) {
                return redirect()->route('occupation.index')->with('success', 'Pekerjaan berhasil diupdate.');
            } else {
                Log::error('Gagal mengupdate Pekerjaan: ' . $response->status() . ' - ' . $response->body());
                return back()->withInput()->withErrors('Gagal mengupdate Pekerjaan.');
            }
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat memperbarui Pekerjaan: ' . $e->getMessage());
            return back()->withInput()->withErrors('Terjadi kesalahan saat memperbarui Pekerjaan.');
        }
    }

    public function destroy($id)
    {
        try {
            $response = $this->httpClient::delete(config('app.api_url') . 'occupation/deleteById?id=' . $id);
            if ($response->successful()) {
                return redirect()->route('occupation.index')->with('success', 'Pekerjaan berhasil dihapus.');
            } else {
                Log::error('Pekerjaan gagal dihapus: ' . $response->status() . ' - ' . $response->body());
                return redirect()->route('occupation.index')->with('error', 'Pekerjaan gagal dihapus.');
            }
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat menghapus Pekerjaan: ' . $e->getMessage());
            return redirect()->route('occupation.index')->with('error', 'Terjadi kesalahan saat menghapus Pekerjaan.');
        }
    }
}
