<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PSpell\Config;

class DepartmentController extends Controller
{
    public function index()
    {
        $response = Http::get(Config('app.api_url') . 'department/viewAll');
        $department = $response->json();
        if (isset($department['data']) && is_array($department['data']) && count($department['data']) > 0) {
            foreach ($department['data'] as &$dT) {
                $dT['businessUnitData'] = $this->getBusinessUnitData($dT['businessUnitId']);
            }
        }
        return view('admin.SettingsAndConfigurations.department.index', compact('department'));
    }

    protected function getBusinessUnitData($businessUnitId)
    {
        $response = Http::get(Config('app.api_url') . 'businessUnit/viewById?id=' . $businessUnitId);
        $businessUnitData = $response->json()['data'] ?? null;
        return $businessUnitData;
    }

    public function create()
    {
        $response = Http::get(Config('app.api_url') . 'businessUnit/viewAll');
        $businessUnitName = $response->json();
        return view('admin.SettingsAndConfigurations.department.create', compact('businessUnitName'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'businessUnitId' => 'required',
            'departmentName' => 'required',
            'description' => 'required'
        ]);
        $response = Http::post(Config('app.api_url') . 'department/insert', [
            'businessUnitId' => (int)$request->input('businessUnitId'),
            'departmentName' => $request->input('departmentName'),
            'description' => $request->input('description')
        ]);
        if ($response->successful()) {
            return redirect()->route('department.index')->with('success', 'Departemen berhasil ditambahkan.');
        } else {
            // Jika status respons adalah selain 201, berarti ada kesalahan
            return redirect()->route('department.index')->with('error', 'Gagal menambahkan Departemen.');
        }
    }


    public function edit($id): View
    {
        $response = Http::get(Config('app.api_url') . 'department/viewById?id=' . $id);
        $temp = $response->json();
        $department = $temp['data'];
        $responseTypes = Http::get(Config('app.api_url') . 'businessUnit/viewAll');
        $businessUnits = $responseTypes->json();
        return view('admin.SettingsAndConfigurations.department.edit', compact('department', 'businessUnits'));
    }


    public function update(Request $request, $id)
    {
        try {
            $response = Http::put(Config('app.api_url') . 'department/update', [
                'departmentId' => (int)$id,
                'businessUnitId' => (int)$request->input('businessUnitId'),
                'departmentName' => $request->input('departmentName'),
                'description' => $request->input('description'),
            ]);
            if ($response->successful()) {
                return redirect()->route('department.index')->with('success', 'Departemen berhasil diupdate.');
            } else {
                return back()->withErrors('Gagal mengupdate Departemen.')->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memperbarui Departemen.')->withInput();
        }
    }


    public function show($id): View
    {
        $response = Http::get(Config('app.api_url') . 'department/viewById?id=' . $id);
        if ($response->successful()) {
            $department = $response->json()['data'];
            $response2 = Http::get(Config('app.api_url') . 'businessUnit/viewById?id=' . $department['businessUnitId']);
            $department['businessUnitData'] = $response2->json()['data'];

            return view('admin.SettingsAndConfigurations.department.show', compact('departement'));
        } else {
            return redirect()->route('department.index')->with('error', 'Departemen tidak ditemukan');
        }
    }


    public function hapus($id)
    {
        $response = Http::delete(Config('app.api_url') . 'department/deleteById?id=' . $id);
        if ($response->successful()) {
            return redirect()->route('department.index')->with('success', 'departemen berhasil dihapus');
        } else {
            return redirect()->route('department.index')->with('error', 'gagal menghapus departemen');
        }
    }
}
