<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NavBarController extends Controller {

      public function get_navbar($auth) {
        //if (view()->exists('home')) { //get auth
          $navbar = DB::table('halaman')
          ->join('otoritas_detil', 'halaman.kode_halaman', '=', 'otoritas_detil.kode_halaman')
          ->where('otoritas_detil.kode_otoritas', '=', $auth)
          ->where('otoritas_detil.status_otoritas_detil', '=', true)
          ->select('halaman.kode_halaman', 'halaman.nama_halaman', 'halaman.ikon_halaman')
          ->orderby('urutan_halaman', 'asc')
          ->get();
          return ($navbar);
        //}
      }
}
