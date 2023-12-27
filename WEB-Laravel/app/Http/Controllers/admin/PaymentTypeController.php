<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PaymentTypeController extends Controller
{

    public function index()
    {
        $response = Http::get(Config('app.api_url') . 'paymentType/viewAll');
        $paymentType = $response->json();
        return view('admin.SettingsAndConfigurations.paymentTypes.index', compact('paymentType'));
    }


    public function create()
    {
        return view('admin.SettingsAndConfigurations.paymentTypes.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'paymentTypeCode' => 'required',
            'paymentTypeName' => 'required',
            'description' => 'required',
        ]);
        $isAging = $request->has('isAging') ? 1 : 0;
        $response = Http::post(Config('app.api_url') . 'paymentType/insert', [
            'paymentTypeCode' => $request->input('paymentTypeCode'),
            'paymentTypeName' => $request->input('paymentTypeName'),
            'isAging' => $isAging,
            'description' => $request->input('description'),
        ]);
        return redirect()->route('paymentTypes.index')->with('success', 'Tipe Pembayaran berhasil ditambahkan');
        if ($response->successful()) {
            return response()->json(['message' => 'Tipe Pembayaran berhasil ditambahkan.'], 200);
        } else {
            return response()->json(['message' => 'Gagal menambahkan Tipe Pembayaran.'], 400);
        }
    }


    public function show($id)
    {
        $response = Http::get(config('app.api_url') . 'paymentType/viewById?id=' . $id);
        if ($response->successful()) {
            $paymentType = $response->json()['data'];
            return view('admin.SettingsAndConfigurations.paymentTypes.show', compact('paymentType'));
        } else {
            return redirect()->route('paymentTypes.index')->with('error', 'Tipe Pembayaran tidak ditemukan.');
        }
    }


    public function edit($id)
    {
        $response = Http::get(config('app.api_url') . 'paymentType/viewById?id=' . $id);
        $temp = $response->json();
        $paymentTypeData = $temp['data'];
        if (!$paymentTypeData) {
            return redirect()->route('paymentTypes.index')->with('error', 'Tipe Pembayaran tidak ditemukan.');
        }
        return view('admin.SettingsAndConfigurations.paymentTypes.update', compact('paymentTypeData'));
    }


    public function update(Request $request, $id)
    {
        try {
            $isAging = $request->has('isAging') ? 1 : 0;
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->put(config('app.api_url') . 'paymentType/update', [
                "idPaymentType" => (int)$id,
                'paymentTypeCode' => $request->input('paymentTypeCode'),
                'paymentTypeName' => $request->input('paymentTypeName'),
                'isAging' => $isAging,
                'description' => $request->input('description'),
            ]);

            if ($response->successful()) {
                return redirect()->route('paymentTypes.index')->with('success', 'Tipe Pembayaran berhasil diupdate.');
            } else {
                return back()->withErrors('Gagal mengupdate Tipe Pembayaran.')->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memperbarui Tipe Pembayaran.')->withInput();
        }
    }



    public function destroy($id)
    {
        $response = Http::delete(config('app.api_url') . 'paymentType/deleteById?id=' . $id);
        if ($response->successful()) {
            return redirect()->route('paymentTypes.index')->with('success', 'Tipe Pembayaran berhasil dihapus.');
        } else {
            return back()->withErrors('Gagal menghapus Tipe Pembayaran.');
        }
    }
}
