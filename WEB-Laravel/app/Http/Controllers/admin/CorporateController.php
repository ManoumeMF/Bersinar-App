<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use PSpell\Config;

class CorporateController extends Controller
{
    public function index(): View
    {
        $response = Http::get(config('app.api_url') . 'corporate/viewAll');
        $corporate = $response->json();
        return view('admin.SettingsAndConfigurations.corporate.index', compact('corporate'));
    }

    public function create()
    {
        $response = Http::get(config('app.api_url') . 'provinces/viewAll');
        $provincesData = $response->successful() ? $response->json()['data'] : [];

        // Inisialisasi data kota, kecamatan, dan kelurahan kosong
        $citiesData = [];
        $districtsData = [];
        $subdistrictsData = [];

        return view('admin.SettingsAndConfigurations.corporate.create', compact('provincesData', 'citiesData', 'districtsData', 'subdistrictsData'));
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

        $request->validate([
            'corporateCode' => 'required',
            'corporateName' => 'required',
            'taxId' => 'required',
            'prov_name' => 'required',
            'city_name' => 'required',
            'dis_name' => 'required',
            'subdis_name' => 'required',
            'address' => 'required',
            'postalCode' => 'required',
            'phoneNumber' => 'required',
            'faxNumber' => 'required',
            'whatsAppNumber' => 'required',
            'email' => 'required',
            //  $logo = 'logo',
            // implode(stringValue($logo)),
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'currencyId' => 'required'
        ]);

        // return $request;

        $logo = $request->file('logo');
        $logoName = time() . '.' . $logo->getClientOriginalExtension();
        $logo->move(public_path('images'), $logoName);

        $response = Http::post(config('app.api_url') . 'corporate/insert', [
            'corporateCode' => $request->corporateCode,
            'corporateName' => $request->corporateName,
            'taxId' => (int)$request->taxId,
            'prov_name' => $request->prov_name,
            'city_name' => $request->city_name,
            'dis_name' => $request->dis_name,
            'subdis_name' => $request->subdis_name,
            'subdistrictId' => (int)$request->subdistrictId,
            'address' => $request->address,
            'postalCode' => $request->postalCode,
            'phoneNumber' => (int)$request->phoneNumber,
            'faxNumber' => (int)$request->faxNumber,
            'whatsAppNumber' => (int)$request->whatsAppNumber,
            'email' => $request->email,
            'logo' => $logoName,
            'currencyId' => (int)$request->currencyId
        ]);
        if ($response->successful()) {
            return redirect()->route('corporate.index')->with('success', 'Perusahaan/Institusi Berhasil Ditambahkan');
        } else {
            return redirect()->route('corporate.index')->with('error', 'Gagal Menambahkan Perusahaan/Institusi');
        }
    }
    public function edit($id)
    {
        $response = Http::get(Config('app.api_url') . 'corporate/viewById?id=' . $id);
        $temp = $response->json();
        $corporate = $temp['data'];


        return view('admin.SettingsAndConfigurations.corporate.edit', compact('corporate'));
    }
    public function update(Request $request, $id)
    {
        $response = Http::get(Config('app.api_url') . 'corporate/viewById?id=' . $id);
        if (!$response->successful()) {
            return back()->withErrors('Gagal mendapatkan data Perusahaan.')->withInput();
        }

        $currentCorporate = $response->json()['data'];
        $currentlogoName = $currentCorporate['logo'];
        return $request;
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images'), $logoName);

            if (file_exists(public_path('images/') . $currentlogoName)) {
                unlink(public_path('images/') . $currentlogoName);
            }
        } else {
            $logoName = $currentlogoName;
        }
        try {
            $response = Http::put(Config('app.api_url') . 'corporate/update', [
                'corporateId' => (int)$id,
                'corporateCode' => $request->corporateCode,
                'corporateName' => $request->corporateName,
                'taxId' => (int)$request->taxId,
                'prov_name' => $request->prov_name,
                'city_name' => $request->city_name,
                'dis_name' => $request->dis_name,
                'subdis_name' => $request->subdis_name,
                'subdistrictId' => (int)$request->subdistrictId,
                'address' => $request->address,
                'postalCode' => $request->postalCode,
                'phoneNumber' => (int)$request->phoneNumber,
                'faxNumber' => (int)$request->faxNumber,
                'whatsappNumber' => (int)$request->whatsappNumber,
                'email' => $request->email,
                'logo' => $logoName,
                'currencyId' => (int)$request->currencyId
            ]);
            // return dd($response);
            if ($response->successful()) {
                return redirect()->route('corporate.index')->with('success', 'Perusahaan berhasil diupdate.');
            } else {
                return back()->withErrors('Gagal mengupdate Perusahaan.')->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memperbarui Perusahaan.')->withInput();
        }
    }


    public function show($id)
    {
        $response = Http::get(config('app.api_url') . 'corporate/viewById', ['id' => $id]);

        if ($response->successful()) {
            $corporate = $response->json()['data'];
            return view('admin.SettingsAndConfigurations.corporate.show', compact('corporate'));
        } else {
            return redirect()->route('corporate.index')->with('error', 'Perusahaan/Institusi tidak ditemukan');
        }
    }
    public function hapus($id)
    {
        $response = Http::delete(config('app.api_url') . 'corporate/deleteById?id=' . $id);
        if ($response->successful()) {
            return redirect()->route('corporate.index')->with('success', 'Perusahaan berhasil dihapus.');
        } else {
            return back()->withErrors('Gagal menghapus Perusahaan.');
        }
    }
}
