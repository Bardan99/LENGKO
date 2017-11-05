<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class DashboardController extends Controller {

  public function index() {
    if (view()->exists('dashboard.main')) {
      //$menus = DB::table('hidangan')->skip(0)->take(9)->get();
      return view('dashboard.main');
    }
    return abort(404);
  }

  public function view($param) {
    if (view()->exists('dashboard.' . $param)) {
      return view('dashboard.' . $param);
    }
    return abort(404);
  }
}
