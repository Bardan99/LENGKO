<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Http\Requests;
use App\User;
use Auth;

class LoginController extends Controller {

  public function view() {
    if (view()->exists('auth.login')) {
      return view('auth.login');
    }
    return abort(404);
  }

  /*public function validation(Request $request) {
    $details = [
      'kode_pegawai' => $request->get('kode_pegawai'),
      'kata_sandi_pegawai' => $request->get('kata_sandi_pegawai')
    ];

    if (Auth::attempt($details)) {
      $auth = User::find($request->get('kode_pegawai'));
      dd($auth);
    }
    else {
      //$auth = User::find($request->get('kode_pegawai'));
      //dd($auth);
    }
  }*/
  public function username() {
      return 'kode_pegawai';
  }

  public function authenticate(Request $request) {
    if (Auth::attempt(['kode_pegawai' => $request->kode_pegawai, 'kata_sandi_pegawai' => $request->password])) {
      return redirect()->intended('/dashboard');
    }
  }

  public function logout() {
    Auth::logout();
    Session::flush();
    return redirect('/dashboard');
  }
}
