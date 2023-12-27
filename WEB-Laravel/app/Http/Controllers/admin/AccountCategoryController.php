<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class AccountCategoryController extends Controller
{
    protected $httpClient;
    public function __construct(Http $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function index(): View
    {
        $response = $this->httpClient::get(Config('app.api_url') . 'accountCategory/viewAll');
        $accountCategory = $response->json();
        return view('admin.SettingsAndConfigurations.accountCategory.index', compact('accountCategory'));
    }

    public function create(): View
    {
        return view('admin.SettingsAndConfigurations.accountCategory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'accountCategory' => 'required',
            'description' => 'required',
        ]);

        $response = $this->httpClient::post(Config('app.api_url') . 'accountCategory/insert', [
            'accountCategory' => $request->input('accountCategory'),
            'description' => $request->input('description')
        ]);
        return redirect()->route('accountCategory.index')->with('success', 'Kategori Rekening berhasil ditambahkan');
        if ($response->successful()) {
            return response()->json(['message' => 'Kategori Rekening berhasil ditambahkan.'], 200);
        } else {
            return response()->json(['message' => 'Gagal menambahkan Kategori Rekening.'], 400);
        }
    }

    public function edit($id): View
    {
        $response = $this->httpClient::get(Config('app.api_url') . 'accountCategory/viewById?id=' . $id);
        $temp = $response->json();
        $accountCategoryData = $temp['data'];
        // return dd($accountCategoryData);

        if (!$accountCategoryData) {
            return redirect()->route('accountCategory.index')->with('error', 'Kategori Rekening tidak ditemukan.');
        }
        return view('admin.SettingsAndConfigurations.accountCategory.update', compact('accountCategoryData'));
    }



    public function update(Request $request, $id)
    {
        try {
            $response = $this->httpClient::put(config('app.api_url') . 'accountCategory/update', [
                "accountCategoryId" => (int)$id,
                'accountCategory' => $request->input('accountCategory'),
                'description' => $request->input('description'),
            ]);

            if ($response->successful()) {
                return redirect()->route('accountCategory.index')->with('success', 'Kategori Rekening berhasil diupdate.');
            } else {
                return back()->withErrors('Gagal mengupdate Kategori Rekening.')->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memperbarui Kategori Rekening.')->withInput();
        }
    }

    public function show($id): View
    {
        $response = $this->httpClient::get(Config('app.api_url') . 'accountCategory/viewById?id=' . $id);
        if ($response->successful()) {
            $accountCategory = $response->json()['data'];

            return view('admin.SettingsAndConfigurations.accountCategory.show', compact('accountCategory'));
        } else {
            return redirect()->route('accountCategory.index')->with('error', 'Kategori Rekening tidak ditemukan.');
        }
    }

    public function delete($id)
    {
        $response = $this->httpClient::delete(config('app.api_url') . 'accountCategory/deleteById?id=' . $id);
        if ($response->successful()) {
            return redirect()->route('accountCategory.index')->with('success', 'Kategori Rekening berhasil dihapus.');
        } else {
            return back()->withErrors('Gagal menghapus Kategori Rekening.');
        }
    }
}
