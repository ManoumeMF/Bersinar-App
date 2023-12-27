<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PSpell\Config;

class WeighingItemController extends Controller
{
    protected $httpClient;
    public function __construct(Http $httpClient)
    {
        $this->httpClient = $httpClient;
    }
    public function index()
    {
        $response = Http::get(Config('app.api_url') . 'weighing/viewAll');
        $weighing = $response->json();
        return view('admin.InventoryManagement.weighingItems.index', compact('weighing'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.InventoryManagement.weighingItems.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
