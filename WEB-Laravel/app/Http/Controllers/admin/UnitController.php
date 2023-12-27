<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PSpell\Config;

class UnitController extends Controller
{
    public function index()
    {
        $response = Http::get(config('app.api_url') . 'unit/viewAll');
        $unit = $response->json();
        // if (isset($unit['data']) && is_array($unit['data']) && count($unit['data']) > 0) {
        //     foreach ($unit['data'] as &$ut) {
        //         $ut[' businessUnitData'] = $this->getBusinessUnitData($ut['businessUnitName']);
        //         $ut['departmentData'] = $this->getDepartmentData($ut['departmentName']);
        //     }
        // }
        // dd($unit);
        $response2 = Http::get(config('app.api_url') . 'unit/viewById?id=');
        $unitDetail = $response->json();
        return view('admin.SettingsAndConfigurations.unit.index', compact('unit', 'unitDetail'));
    }
    // protected function getBusinessUnitData($businessUnitId)
    // {
    //     $response = Http::get(Config('app.api_url') . 'businessUnit/viewById?id=' . $businessUnitId);
    //     $businessUnitData = $response->json()['data'] ?? null;
    //     return $businessUnitData;
    // }
    // protected function getDepartmentData($departmentId)
    // {
    //     $response = Http::get(config('app.api_url') . 'department/viewById?=id' . $departmentId);
    //     $departmentData = $response->json()['data'] ?? null;
    //     return $departmentData;
    // }

    public function create()
    {
        $response = Http::get(Config('app.api_url') . 'businessUnit/viewAll');
        $businessUnit = $response->json();
        $response2 = Http::get(Config('app.api_url') . 'department/viewAll');
        $department = $response2->json();
        return view('admin.SettingsAndConfigurations.unit.create', compact('businessUnit', 'department'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'businessUnitId' => 'required',
            'departmentId' => 'required',
            'parentUnit' => 'required',
            'unitName' => 'required',
            'description' => 'required'
        ]);
        $response = Http::post(Config('app.api_url') . 'unit/insert', [
            'businessUnitId' => (int) $request->input('businessUnitId'),
            'departmentId' => (int) $request->input('departmentId'),
            'parentUnit' => (int) $request->input('parentUnit'),
            'unitName' => $request->input('unitName'),
            'description' => $request->input('description')
        ]);
        if ($response->successful()) {
            return redirect()->route('unit.index')->with('success', 'Unit berhasil ditambahkan.');
        } else {
            return redirect()->route('unit.index')->with('error', 'Gagal menambahkan Unit.');
        }
    }

    public function edit($id): View
    {
        $response = Http::get(Config('app.api_url') . 'unit/viewById?id=' . $id);
        $temp = $response->json();
        $unit = $temp['data'];
        // $responseTypes = Http::get(Config('app.api_url') . 'unit/viewAll');
        // $statusTypes = $responseTypes->json();
        // , 'statusTypes'
        return view('admin.SettingsAndConfigurations.unit.edit', compact('unit'));
    }

    public function update(Request $request, $id)
    {
        try {
            $response = Http::put(config('app.api_url') . 'unit/update', [
                'unitId' => (int) $id,
                'businessUnitId' => (int) $request->input('businessUnitId'),
                'departmentId' => (int) $request->input('departmentId'),
                'parentUnit' => (int) $request->input('parentUnit'),
                'unitName' => $request->input('unitName'),
                'description' => $request->input('description')
            ]);
            if ($response->successful()) {
                return redirect()->route('unit.index')->with('success', 'Unit berhasil diupdate.');
            } else {
                return back()->withErrors('Gagal mengupdate Unit')->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memperbarui Unit.')->withInput();
        }
    }

    public function destroy($id)
    {
        $response = Http::delete(Config('app.api_url') . 'unit/deleteById?id=' . $id);
        if ($response->successful()) {
            return redirect()->route('unit.index')->with('success', 'Unit berhasil dihapus');
        } else {
            return redirect()->route('unit.index')->with('error', 'Gagal menghapus Unit');
        }
    }
}
