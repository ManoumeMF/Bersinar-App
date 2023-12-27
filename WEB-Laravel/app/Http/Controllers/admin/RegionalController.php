<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class RegionalController extends Controller
{
  public function province(Request $request){
    $response = Http::get(Config('app.api_url') . 'provinces/viewAll');
    $list = "<option>Pilih Provinsi</option>";
    foreach($response as $row){
        $list.="<option value='$row->id'>$row->name</option>";
    }
    echo $list;
  }
  public function city(Request $request, $id){
    $response = Http::get(Config('app.api_url') . 'cities/viewByProvinceId?id=' . $id);
    $list = "<option>Pilih Kota</option>";
    foreach($response as $row){
        $list.="<option value='$row->id'>$row->name</option>";
    }
    echo $list;
  }
  public function subdistrict(Request $request, $id){
    $response = Http::get(Config('app.api_url') . 'subdistricts/viewByDistrictId' .$id);
    $list = "<option>Pilih Kecamatan</option>";
    foreach($response as $row){
        $list.="<option value='$row->id'>$row->name</option>";
    }
    echo $list;
  }
}