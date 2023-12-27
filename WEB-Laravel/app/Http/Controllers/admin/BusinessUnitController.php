<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

class BusinessUnitController extends Controller
{
    public function index(): View
    {
        $response = Http::get(config('app.api_url') . 'businessUnit/viewAll');
        $businessUnits = $response->json();
        // if (isset($businessUnits['data']) && is_array($businessUnits['data']) && count($businessUnits['data']) > 0) {
        //     foreach ($businessUnits['data'] as &$bu) {
        //         $bu['corporateData'] = $this->getCorporateData($bu['corporateId']);
        //     }
        // }
        return view('admin.SettingsAndConfigurations.businessUnit.index', compact('businessUnits'));
    }

    public function getVieById(){



    }

    // public function getCorporateData($corporateId)
    // {
    //     $response = Http::get(Config('app.api_url') . 'corporate/viewById?id=' . $corporateId);
    //     $corporateData = $response->json()['data'] ?? null;
    //     return $corporateData;
    // }

    public function create()
    {

        $response = Http::get(config('app.api_url') . 'provinces/viewAll');
        $provincesData = $response->successful() ? $response->json()['data'] : [];

        // Inisialisasi data kota, kecamatan, dan kelurahan kosong
        $citiesData = [];
        $districtsData = [];
        $subdistrictsData = [];
        return view('admin.SettingsAndConfigurations.businessUnit.create', compact('provincesData'));
    }

    public function getCitiesByProvinceId(Request $request)
    {
        $provinceId = $request->input('id');

        // Lakukan permintaan ke API untuk mengambil data kota berdasarkan $provinceId
        $response = Http::get(config('app.api_url') . "cities/viewByProvinceId?id=$provinceId");

        // Proses data yang diterima dari API jika perlu
        $citiesData = $response->successful() ? $response->json()['data'] : [];

        // Kembalikan data dalam format JSON
        return response()->json(['citiesData' => $citiesData]);
    }

    public function getDistrictsByCityId(Request $request)
    {
        $cityId = $request->input('id');

        // Lakukan permintaan ke API untuk mengambil data kecamatan berdasarkan $cityId
        $response = Http::get(config('app.api_url') . "districts/viewByCityId?id=$cityId");
        // Proses data yang diterima dari API jika perlu
        $districtsData = $response->successful() ? $response->json()['data'] : [];

        // Kembalikan data dalam format JSON
        return response()->json(['districtsData' => $districtsData]);
    }

    public function getSubdistrictsByDistrictId(Request $request)
    {
        $districtId = $request->input('id');

        // Lakukan permintaan ke API untuk mengambil data kelurahan berdasarkan $districtId
        $response = Http::get(config('app.api_url') . "subdistricts/viewByDistrictId?id=$districtId");

        // Proses data yang diterima dari API jika perlu
        $subdistrictsData = $response->successful() ? $response->json()['data'] : [];

        // Kembalikan data dalam format JSON
        return response()->json(['subdistrictsData' => $subdistrictsData]);
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'corporateId' => 'required',
            'sbuTypeId' => 'required',
            'businessUnitCode' => 'required',
            'taxId' => 'required',
            'businessUnitName' => 'required',
            'prov_name' => 'required',
            'city_name' => 'required',
            'dis_name' => 'required',
            'subdis_name' => 'required',
            'address' => 'required',
            'postalCode' => 'required',
            'phoneNumber' => 'required',
            'faxNumber' => 'required',
            'whatsappNumber' => 'required',
            'email' => 'required',
            'currencyId' => 'required'
        ]);

        $response = Http::post(config('app.api_url') . 'businessUnit/insert', [
            'corporateId' => (int)$request->corporateId,
            'sbuTypeId' => (int)$request->sbuTypeId,
            'businessUnitCode' => $request->businessUnitCode,
            'taxId' => (int)$request->taxId,
            'businessUnitName' => $request->businessUnitName,
            'prov_name' => $request->prov_name,
            'city_name' => $request->city_name,
            'dis_name' => $request->dis_name,
            'subdis_name' => $request->subdis_name,
            'subdistrictId' => (int)$request->subdistrictId,
            'address' => $request->address,
            'postalCode' => $request->postalCode,
            'phoneNumber' => $request->phoneNumber,
            'whatsappNumber' => $request->whatsappNumber,
            'faxNumber' => (int)$request->faxNumber,
            'email' => $request->email,
            'currencyId' => (int)$request->currencyId
        ]);

        if ($response->successful()) {
            return redirect()->route('businessUnit.index')->with('success', 'Unit Bisnis Berhasil Ditambahkan');
        } else {
            return redirect()->route('businessUnit.index')->with('error', 'Gagal Menambahkan Unit Bisnis');
        }
    }




    public function edit()
    {
    }

    public function update()
    {
    }

    public function destroy($id)
    {
        $response = Http::delete(Config('app.api_url') . 'businessUnit/deleteById?id=' . $id);
        if ($response->successful()) {
            return redirect()->route('businessUnit.index')->with('success', 'bisnis unit berhasil dihapus');
        } else {
            return redirect()->route('businessUnit.index')->with('error', 'Gagal menghapus bisnis unit');
        }
    }
}
