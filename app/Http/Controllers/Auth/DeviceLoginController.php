<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;//use request
use App\Http\Controllers\Controller;//inherit controller
use Auth;

class DeviceLoginController extends Controller {

  protected $username = 'kode_perangkat';
  protected $redirectTo = '/';
  protected $redirectAfterLogout = '/login';

  public function __construct() {
    $this->middleware('guest:device', ['except' => ['logout', 'getLogout']]);
  }

  public function showLoginForm() {
    if (view()->exists('auth.device-login')) {
      return view('auth.device-login');
    }
    return abort(404);
  }

  public function username() {
      return 'kode_perangkat';
  }

  public function login(Request $request) {
    $this->validate($request, [
      'kode_perangkat' => 'required|min:4',
      'password' => 'required|min:4'
    ]);

    $credentials = [
      'kode_perangkat' => $request->kode_perangkat,
      'kata_sandi_perangkat' => $request->password
    ];

    if (Auth::guard('device')->attempt($credentials)) {
      return redirect()->intended('/');
    }
    return redirect()->back()->withInput($request->all());
  }

  public function logout(Request $request) {
    Auth::guard('device')->logout();
    $request->session()->forget('device');
    $request->session()->forget('order');
    return redirect('/login');
  }


}
