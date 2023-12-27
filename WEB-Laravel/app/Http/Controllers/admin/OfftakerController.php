<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OfftakerController extends Controller
{
    public function index()
    {
        $response = Http::get(Config('app.api_url') . 'offtaker/viewAll');
        $customer = $response->json();
        if (isset($customer['data']) && is_array($customer['data']) && count($customer['data']) > 0) {
            foreach ($customer['data'] as &$offtaker) {
                $offtaker['offtakerDetail'] = $this->getOfftakerDetail($offtaker['customerId']);
            }
        }
        return view('admin.DataMaster.offtaker.index', compact('customer'));
    }

    public function getOfftakerDetail($id)
    {
        $response = Http::get(Config('app.api_url') . 'offtaker/viewById?id=' . $id);
        $offtakerDetail = $response->json()['data'] ?? null;
        return $offtakerDetail;
    }

    public function create()
    {
        return view('admin.DataMaster.offtaker.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'partnerTypeId' => 'required',
            'customerCode' => 'required',
            'customerName' => 'required',
            'email' => 'required',
            'teleponNumber' => 'required',
            'faxNumber' => 'required',
            'mobileNumber' => 'required',
            'whatsappNumber' => 'required',
            'contactPerson' => 'required',
            'customerPhoto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        $customerPhoto = $request->file('customerPhoto');
        $customerPhotoName = time() . '.' . $customerPhoto->getClientOriginalExtension();
        $customerPhoto->move(public_path('images/customerPhoto'), $customerPhotoName);
        $response = Http::post(config('app.api_url') . 'offtaker/insert', [
            'partnerTypeId' => (int)$request->input('partnerTypeId'),
            'customerCode' => $request->input('customerCode'),
            'customerName' => $request->input('customerName'),
            'email' => $request->input('email'),
            'teleponNumber' => $request->input('teleponNumber'),
            'faxNumber' => $request->input('faxNumber'),
            'mobileNumber' => $request->input('mobileNumber'),
            'whatsappNumber' => $request->input('whatsappNumber'),
            'businessUnitId' => 1,
            'contactPerson' => $request->input('contactPerson'),
            'customerPhoto' => $customerPhotoName
        ]);
        if ($response->successful()) {
            return redirect()->route('offtaker.index')->with('success', 'Customer Berhasil Ditambahkan');
        } else {
            return redirect()->route('offtaker.index')->with('error', 'Gagal Menambahkan Customer');
        }
    }

    public function edit($id): View
    {
        $response = Http::get(Config('app.api_url') . 'offtaker/viewById?id=' . $id);
        $temp = $response->json();
        $editOfftaker = $temp['data'];
        return view('admin.DataMaster.offtaker.edit', compact('editOfftaker'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'partnerTypeId' => 'required',
            'customerCode' => 'required',
            'customerName' => 'required',
            'email' => 'required',
            'teleponNumber' => 'required',
            'faxNumber' => 'required',
            'mobileNumber' => 'required',
            'whatsappNumber' => 'required',
            'contactPerson' => 'required',
            'customerPhoto' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);
        $response = Http::get(Config('app.api_url') . 'offtaker/viewById?id=' . $id);
        if (!$response->successful()) {
            return back()->withErrors('Gagal mendapatkan data customer.')->withInput();
        }
        $currentItem = $response->json()['data'];
        $currentcustomerPhotoName = $currentItem['customerPhoto'];
        if ($request->hasFile('customerPhoto')) {
            $customerPhoto = $request->file('customerPhoto');
            $customerPhotoName = time() . '.' . $customerPhoto->getClientOriginalExtension();
            $customerPhoto->move(public_path('images/customerPhoto'), $customerPhotoName);
            if (file_exists(public_path('images/customerPhoto/') . $currentcustomerPhotoName)) {
                unlink(public_path('images/customerPhoto/') . $currentcustomerPhotoName);
            }
        } else {
            $customerPhotoName = $currentcustomerPhotoName;
        }
        try {
            $response = Http::put(config('app.api_url') . 'offtaker/update', [
                'customerId' => (int)$id,
                'partnerTypeId' => (int)$request->input('partnerTypeId'),
                'customerCode' => $request->input('customerCode'),
                'customerName' => $request->input('customerName'),
                'email' => $request->input('email'),
                'teleponNumber' => $request->input('teleponNumber'),
                'faxNumber' => $request->input('faxNumber'),
                'mobileNumber' => $request->input('mobileNumber'),
                'businessUnitId' => 1,
                'whatsappNumber' => $request->input('whatsappNumber'),
                'contactPerson' => $request->input('contactPerson'),
                'customerPhoto' => $customerPhotoName
            ]);
            if ($response->successful()) {
                return redirect()->route('offtaker.index')->with('success', 'Offtaker berhasil diupdate.');
            } else {
                return back()->withErrors('Gagal mengupdate offtaker')->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memperbarui offtaker.')->withInput();
        }
    }

    public function destroy($id)
    {
        $response = Http::delete(config('app.api_url') . 'offtaker/deleteById?id=' . $id);
        if ($response->successful()) {
            return redirect()->route('offtaker.index')->with('success', 'Offtaker berhasil dihapus.');
        } else {
            return back()->withErrors('Gagal menghapus offtaker.');
        }
    }
}
