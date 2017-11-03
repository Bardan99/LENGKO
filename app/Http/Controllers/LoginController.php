<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class LoginController extends Controller {

  public function view() {
    if (view()->exists('login')) {
      $obj = new MenuController();
      return view('login', ['login_obj' => $obj]);
    }
    return abort(404);
  }
}
