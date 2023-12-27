<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class StatusController extends Controller
{
    public function index()
    {
        $response = Http::get(config('app.api_url') . 'status/viewAll');
        $status = $response->json();
        if (isset($status['data']) && is_array($status['data']) && count($status['data']) > 0) {
            foreach ($status['data'] as &$st) {
                $st['statusDetail'] = $this->getStatusDetail($st['statusId']);
            }
        }

        // $response2 = Http::get(config('app.api_url') . 'status/viewById?id=');
        // $statusDetail = $response->json();
        return view('admin.SettingsAndConfigurations.status.index', compact('status'));
    }

    protected function getStatusDetail($statusId)
    {
        $response = Http::get(Config('app.api_url') . 'status/viewById?id=' . $statusId);
        $statusDetail = $response->json()['data'] ?? null;
        return $statusDetail;
    }


    public function create(): View
    {
        $status = DB::table('statusType')->get();
        return view('admin.SettingsAndConfigurations.status.create', ['status' => $status]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'statusTypeId' => 'required',
            'status' => 'required',
            'description' => 'required',
        ]);
        $response = Http::post(config('app.api_url') . 'status/insert', [
            'statusTypeId' => (int)$request->input('statusTypeId'),
            'status' => $request->input('status'),
            'description' => $request->input('description'),
        ]);
        if ($response->successful()) {
            return redirect()->route('status.index')->with('success', 'Status berhasil ditambahkan');
        } else {
            return redirect()->route('status.index')->with('error', 'Gagal menambahkan Status.');
        }
    }

    public function edit($id): View
    {
        $response = Http::get(Config('app.api_url') . 'status/viewById?id=' . $id);
        $temp = $response->json();
        $status = $temp['data'];
        // $responseTypes = Http::get(Config('app.api_url') . 'statusType/viewAll');
        // $statusTypes = $responseTypes->json();
        // , 'statusTypes'
        return view('admin.SettingsAndConfigurations.status.edit', compact('status'));
    }

    public function update(Request $request, $id)
    {
        try {
            $response = Http::put(config('app.api_url') . 'status/update', [
                'statusId' => (int)$id,
                'statusTypeId' => (int)$request->input('statusTypeId'),
                'status' => $request->input('status'),
                'description' => $request->input('description'),
            ]);
            if ($response->successful()) {
                return redirect()->route('status.index')->with('success', 'Status berhasil diupdate.');
            } else {
                return back()->withErrors('Gagal mengupdate Status')->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memperbarui Status.')->withInput();
        }
    }

    public function show($id)
    {
        $response = Http::get(config('app.api_url') . 'status/viewById?id=' . $id);
        if ($response->successful()) {
            $statusDetail = $response->json()['data'];
            return view('admin.SettingsAndConfigurations.status.detail', compact('statusDetail'));
        } else {
            return redirect()->route('status.index')->with('error', 'Status tidak ditemukan.');
        }
    }


    public function destroy($id)
    {
        $response = Http::delete(Config('app.api_url') . 'status/deleteById?id=' . $id);
        if ($response->successful()) {
            return redirect()->route('status.index')->with('success', 'status berhasil dihapus');
        } else {
            return redirect()->route('status.index')->with('error', 'Gagal menghapus status');
        }
    }
}
