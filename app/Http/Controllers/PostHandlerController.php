<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class PostHandlerController extends Controller {

  public function update() {
    return $request->isMethod('post');
    /*
    if ($request->isMethod('post')) {
      if ($section && $param) {
        switch ($section) {
          case 'pegawai':
            $this->validate($request, [
              'employee-name'     => 'required|email|exists:users,email,role,admin',
              'employee-password' => 'required|min:6|max:15|confirmed',
              //'employee-gender'   => 'required'
            ]);

            $data['name'] = Input::post('employee-name');
            $data['password'] = Input::post('employee-password');
              //DB::table('pegawai')
                //->where('kode_pegawai', '=', $param)
                //->update([]);
          break;
          default:break;
        }
      }
      */

      //return view('dashboard.dashboard', ['result' => 'ok']);
    //}
    //elseif ($request->isMethod('get')) {  //}
  }

}
