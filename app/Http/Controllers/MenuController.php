<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class MenuController extends Controller {

  public function view() {
    if (view()->exists('menu')) {
      $menus = DB::table('menu')->skip(0)->take(9)->get();
      $obj = new MethodController();
      return view('menu', ['menus' => $menus, 'menu_obj' => $obj]);
    }
    return abort(404);
  }
}
