<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;//use request
use App\Http\Controllers\Controller;//inherit controller
use Auth;

class EmployeeLoginController extends Controller {

  protected $username = 'kode_pegawai';
  protected $redirectTo = '/dashboard';
  protected $redirectAfterLogout = '/dashboard/login';

  public function __construct() {
    $this->middleware('guest:employee', ['except' => ['logout', 'getLogout']]);
  }

  public function showLoginForm() {
    if (view()->exists('auth.employee-login')) {
      return view('auth.employee-login');
    }
    return abort(404);
  }

  public function username() {
      return 'kode_pegawai';
  }

  public function login(Request $request) {
    $this->validate($request, [
      'kode_pegawai' => 'required|min:4',
      'password' => 'required|min:4'
    ]);

    $credentials = [
      'kode_pegawai' => $request->kode_pegawai,
      'kata_sandi_pegawai' => $request->password
    ];

    if (Auth::guard('employee')->attempt($credentials)) {
      return redirect()->intended('/dashboard');
    }
    return redirect()->back()->withInput($request->all());
  }

  public function logout(Request $request) {
    Auth::guard('employee')->logout();
    $request->session()->forget('employee');
    return redirect('/dashboard/login');
  }


}
