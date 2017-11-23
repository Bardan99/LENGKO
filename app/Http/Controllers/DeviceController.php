<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Perangkat;
use Hash;
use Validator;

class DeviceController extends Controller {

  public function create(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $validator = Validator::make($data, [
        'device-create-id' => 'required|min:4',
        'device-create-name' => 'required|min:4',
        'device-create-password' => 'required|min:6',
        'device-create-chair' => 'required|min:1'
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 500, 'text' => 'Perhatikan bahwa semua kolom harus diisi']);
      }
      $device = Perangkat::find($data['device-create-id']);

      if (!$device) {
        $try = Perangkat::create([
          'kode_perangkat' => $data['device-create-id'],
          'nama_perangkat' => $data['device-create-name'],
          'kata_sandi_perangkat' => Hash::make($data['device-create-password']),
          'jumlah_kursi_perangkat' => $data['device-create-chair']
        ]);
        return response()->json(['status' => 200,'text' => 'Yey, berhasil menambahkan perangkat.']);
      }

    }
  }


}
