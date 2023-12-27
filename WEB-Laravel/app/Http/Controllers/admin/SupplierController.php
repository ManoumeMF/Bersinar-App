<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PSpell\Config;

class SupplierController extends Controller
{
    public function index()
    {
        $response = Http::get(Config('app.api_url') . 'supplier/viewAll');
        $supplier = $response->json();
        if (isset($supplier['data']) && is_array($supplier['data']) && count($supplier['data']) > 0) {
            foreach ($supplier['data'] as &$nasabah) {
                $nasabah['supplierDetail'] = $this->getSupplierDetail($nasabah['supplierId']);
            }
        }
        return view('admin.DataMaster.supplier.index', compact('supplier'));
    }

    public function getSupplierDetail($id)
    {
        $response = Http::get(Config('app.api_url') . 'supplier/viewById?id=' . $id);
        $supplierDetail = $response->json()['data'] ?? null;
        return $supplierDetail;
    }

    public function create()
    {
        return view('admin.DataMaster.supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'partnerTypeId' => 'required',
            'supplierCode' => 'required',
            'fullName' => 'required',
            'sex' => 'required',
            'birthPlace' => 'required',
            'birthDate' => 'required',
            'email' => 'required',
            'mobileNumber' => 'required',
            'whatsAppNumber' => 'required',
            'occupationId' => 'required',
            'mothersName' => 'required',
            'responsiblePerson' => 'required',
            'supplierPhoto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        $supplierPhoto = $request->file('supplierPhoto');
        $supplierPhotoName = time() . '.' . $supplierPhoto->getClientOriginalExtension();
        $supplierPhoto->move(public_path('images/supplierPhoto'), $supplierPhotoName);
        $response = Http::post(config('app.api_url') . 'supplier/insert', [
            'partnerTypeId' => (int) $request->input('partnerTypeId'),
            'supplierCode' => $request->input('supplierCode'),
            'fullName' => $request->input('fullName'),
            'sex' => $request->input('sex'),
            'birthPlace' =>  $request->input('birthPlace'),
            'birthDate' => $request->input('birthDate'),
            'email' => $request->input('email'),
            'mobileNumber' => $request->input('mobileNumber'),
            'whatsAppNumber' => $request->input('whatsAppNumber'),
            'occupationId' => (int) $request->input('occupationId'),
            'mothersName' => $request->input('mothersName'),
            'responsiblePerson' => $request->input('responsiblePerson'),
            'supplierPhoto' => $supplierPhotoName,
            'parentSupplierId' => 1,
            'businessUnitId' => 6
        ]);
        if ($response->successful()) {
            return redirect()->route('supplier.index')->with('success', 'Nasabah berhasil ditambahkan');
        } else {
            return redirect()->route('supplier.create')->with('error', 'Gagal menambahkan nasabah');
        }
    }

    public function edit($id)
    {
        $response = Http::get(Config('app.api_url') . 'supplier/viewById?id=' . $id);
        $temp = $response->json();
        $editSupplier = $temp['data'];
        return view('admin.DataMaster.supplier.edit', compact('editSupplier'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'partnerTypeId' => 'required',
            'supplierCode' => 'required',
            'fullName' => 'required',
            'sex' => 'required',
            'birthPlace' => 'required',
            'birthDate' => 'required',
            'email' => 'required',
            'mobileNumber' => 'required',
            'whatsAppNumber' => 'required',
            'occupationId' => 'required',
            'mothersName' => 'required',
            'responsiblePerson' => 'required',
            'supplierPhoto' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $response = Http::get(Config('app.api_url') . 'supplier/viewById?id=' . $id);
        if (!$response->successful()) {
            return back()->withErrors('Gagal mendapatkan data nasabah.')->withInput();
        }

        $currentItem = $response->json()['data'];
        $currentSupplierPhotoName = $currentItem['supplierPhoto'];

        if ($request->hasFile('supplierPhoto')) {
            $supplierPhoto = $request->file('supplierPhoto');
            $supplierPhotoName = time() . '.' . $supplierPhoto->getClientOriginalExtension();
            $supplierPhoto->move(public_path('images/supplierPhoto/'), $supplierPhotoName);

            if (file_exists(public_path('images/supplierPhoto/') . $currentSupplierPhotoName)) {
                unlink(public_path('images/supplierPhoto/') . $currentSupplierPhotoName);
            }
        } else {
            $supplierPhoto = $currentSupplierPhotoName;
        }
        try {
            $response = Http::put(Config('app.api_url') . 'supplier/update', [
                'supplierId' => (int)$id,
                'partnerTypeId' => (int) $request->input('partnerTypeId'),
                'supplierCode' => $request->input('supplierCode'),
                'fullName' => $request->input('fullName'),
                'sex' => $request->input('sex'),
                'birthPlace' =>  $request->input('birthPlace'),
                'birthDate' => $request->input('birthDate'),
                'email' => $request->input('email'),
                'mobileNumber' => $request->input('mobileNumber'),
                'whatsAppNumber' => $request->input('whatsAppNumber'),
                'occupationId' => (int) $request->input('occupationId'),
                'mothersName' => $request->input('mothersName'),
                'responsiblePerson' => $request->input('responsiblePerson'),
                'supplierPhoto' => $supplierPhotoName,
                'parentSupplierId' => 1,
                'businessUnitId' => 6
            ]);
            if ($response->successful()) {
                return redirect()->route('supplier.index')->with('success', 'Nasabah berhasil diupdate.');
            } else {
                return back()->withErrors('Gagal mengupdate Nasabah.')->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memperbarui nasabah');
        }
    }

    public function destroy($id)
    {
        $response = Http::delete(Config('app.api_url') . 'supplier/deleteById?id=' . $id);
        if ($response->successful()) {
            return redirect()->route('supplier.index')->with('success', 'Nasabah berhasil dihapus');
        } else {
            return back()->withErrors('Gagal menghapus nasabah.');
        }
    }
}
