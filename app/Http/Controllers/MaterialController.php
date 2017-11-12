<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class MaterialController extends Controller {

  public function get($param) {
    $data = null;
    if ($param) {
      switch ($param) {
        case 'material':
          $data['material'] = DB::table('bahan_baku')
            ->orderBy('nama_bahan_baku', 'ASC')
            ->get();
        break;
        default:break;
      }
    }
    return $data;
  }

}
