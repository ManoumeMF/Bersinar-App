<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\View\View;

class AssignmentLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::get(Config('app.api_url') . 'assignmentLetter/viewAll');
        $assignmentletter = $response->json();
        return view('admin.InventoryManagement.AssignmentLetter.index', compact('assignmentletter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // private function generateAssignmentLetterCode($buCode, $trxCode)
    // {
    //     // Ambil nilai terakhir dari kolom weighingNumCode menggunakan Query Builder
    //     $lastWeighingNumCode = DB::table('weighing')
    //         ->whereRaw('SUBSTRING(weighingNumCode, 1, 3) = ?', ['BSB'])
    //         ->whereRaw('SUBSTRING(weighingNumCode, 4, 1) = ?', ['/'])
    //         ->whereRaw('SUBSTRING(weighingNumCode, 5, 3) = ?', ['PNB'])
    //         ->whereRaw('SUBSTRING(weighingNumCode, 8, 1) = ?', ['/'])
    //         ->whereRaw('SUBSTRING(weighingNumCode, 9, 4) = ?', [date('Y')])
    //         ->whereRaw('SUBSTRING(weighingNumCode, 13, 1) = ?', ['.'])
    //         ->whereRaw('SUBSTRING(weighingNumCode, 14, 2) = ?', [date('m')])
    //         ->max('weighingNumCode');

    //     // Lakukan pengolahan data untuk menghasilkan nomor surat jalan baru
    //     $tamp = (int) substr($lastWeighingNumCode, -5) + 1;
    //     $tamp = str_pad($tamp, 5, '0', STR_PAD_LEFT);

    //     return $buCode . '/' . $trxCode . '/' . now()->format('Y.m') . '/' . $tamp;
    // }

    public function create()
    {
        $response = Http::get(Config('app.api_url') . 'businessUnit/viewAll');
        $businessUnitName = $response->json();
        // $assigmentLetterNum = $this->generateAssignmentLetterCode('BSR', 'SJL');
        return view('admin.InventoryManagement.AssignmentLetter.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'businessUnitId' => 'required',
            'assignmentLetterNum' => 'required',
            'dateCreated' => 'required',
            'expiredDate' => 'required',
            'assignedTo' => 'required',
            'vehicleTypeId' => 'required',
            'vehicleRegistrationNumber' => 'required',
            'needFor' => 'required',
            'createBy' => 'required'
        ]);

        $response = Http::post(Config('app.api_url') . 'assignmentLetter/insert', [
            'businessUnitId' => (int)$request->businessUnitId,
            'assignmentLetterNum' => $request->assignmentLetterNum,
            'dateCreated' => $request->dateCreated,
            'expiredDate' => $request->expiredDate,
            'assignedTo' => (int)$request->assignedTo,
            'vehicleTypeId' => (int)$request->vehicleTypeId,
            'vehicleRegistrationNumber' => $request->vehicleRegistrationNumber,
            'needFor' => $request->needFor,
            'createBy' => (int)$request->createBy
        ]);
        if ($response->successful()) {
            return redirect()->route('assignment.index')->with('success', 'Surat Jalan berhasil ditambahkan.');
        } else {
            // Jika status respons adalah selain 201, berarti ada kesalahan
            return redirect()->route('assignment.index')->with('error', 'Gagal menambahkan Surat Jalan.');
        }
    }
    protected function getBusinessUnitData($businessUnitId)
    {
        $response = Http::get(Config('app.api_url') . 'businessUnit/viewById?id=' . $businessUnitId);
        $businessUnitData = $response->json()['data'] ?? null;
        return $businessUnitData;
    }
    public function show($id): View
    {
        $response = Http::get(Config('app.api_url') . 'assignmentLetter/viewById?id=' . $id);
        if ($response->successful()) {
            $assignmentletter = $response->json()['data'];
            $response2 = Http::get(Config('app.api_url') . 'businessUnit/viewById?id=' . $assignmentletter['businessUnitId']);
            $assignmentletter['businessUnitData'] = $response2->json()['data'];

            return view('admin.InventoryManagement.AssignmentLetter.show', compact('assignmentletter'));
        } else {
            return redirect()->route('assignment.index')->with('error', 'Surat Jalan tidak ditemukan');
        }
    }

    public function edit($id): View
    {
        $response = Http::get(Config('app.api_url') . 'assignmentLetter/viewById?id=' . $id);
        $temp = $response->json();
        $assignmentletter = $temp['data'];
        $response2 = Http::get(Config('app.api_url') . 'businessUnit/viewAll');
        $businessUnit = $response2->json();
        $response3 = Http::get(Config('app.api_url') . 'vehicleType/viewAll');
        $vehicleType = $response3->json();
        $response4 = Http::get(Config('app.api_url') . 'employeePersonal/viewAll');
        $employeePersonal = $response4->json();
        return view('admin.SettingsAndConfigurations.AssignmentLetter.edit', compact('assignmentletter', 'businessUnit', 'vehicleType', 'employeePersonal'));
    }


    public function update(Request $request, $id)
    {
        try {
            $response = Http::put(Config('app.api_url') . 'assignmentLetter/update', [
                'assignmentId' => (int)$id,
                'businessUnitId' => $request->input('businessUnitId'),
                'assignmentLetterNum' => $request->input('assignmentLetterNum'),
                'dateCreated' => $request->input('dateCreated'),
                'expiredDate' => $request->input('expiredDate'),
                'assignedTo' => $request->input('assignedTo'),
                'vehicleTypeId' => $request->input('vehicleTypeId'),
                'vehicleRegistrationNumber' => $request->input('vehicleRegistrationNumber'),
                'needFor' => $request->input('needFor'),
                'createBy' => $request->input('createBy'),
            ]);
            if ($response->successful()) {
                return redirect()->route('assignment.index')->with('success', 'Surat Jalan berhasil diupdate.');
            } else {
                return back()->withErrors('Gagal mengupdate Surat Jalan.')->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memperbarui Surat Jalan.')->withInput();
        }
    }

    public function destroy(string $id)
    {
        //
    }
}
