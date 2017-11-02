<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class HomeController extends Controller {

  public function view_index() {
    $employee = DB::table('pegawai')->get();
    return view('home', ['pegawai' => $employee]);
  }

  public function view_page($page) {
    if (view()->exists($page)) {
      return view($page);
    }
    return abort(404);
  }
}
