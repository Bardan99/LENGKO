<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class HomeController extends Controller {

  public function view($param = 'home') {
    if (view()->exists($param)) {
      if ($param == 'home') {
        $menus = DB::table('hidangan')->skip(0)->take(5)->get();
        return view($param, ['menus' => $menus]);
      }
    }
    return abort(404, $param);
  }
}
