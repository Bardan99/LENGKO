<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class MenuController extends Controller {

  public function num_to_rp($number, $digit = 0) {
    if (isset($number) && isset($digit)) {
      return 'Rp' . number_format($number, $digit, ',','.');
    }
  }

  public function view() {
    if (view()->exists('menu')) {
      $menus = DB::table('hidangan')->skip(0)->take(9)->get();
      $obj = new MenuController();
      return view('menu', ['menus' => $menus, 'menu_obj' => $obj]);
    }
    return abort(404);
  }
}
