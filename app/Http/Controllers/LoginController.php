<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class LoginController extends Controller {

  public function view() {
    if (view()->exists('auth.login')) {
      return view('auth.login');
    }
    return abort(404);
  }
}
