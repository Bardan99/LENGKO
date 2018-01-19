<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Pegawai;
use Hash;
use Auth;
use Validator;

class EmployeeController extends Controller {

  public function create(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $validator = Validator::make($data, [
        'employee-create-id' => 'required|min:4',
        'employee-create-name' => 'required|min:4',
        'employee-create-password' => 'required|min:4',
        'employee-create-gender' => 'required|min:1',
        'employee-create-authority' => 'required'
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 500, 'text' => 'Perhatikan bahwa semua kolom harus diisi']);
      }
      $employee = Pegawai::find($data['employee-create-id']);

      if (!$employee) {
        $try = Pegawai::create([
          'kode_pegawai' => strtolower($data['employee-create-id']),
          'nama_pegawai' => $data['employee-create-name'],
          'kata_sandi_pegawai' => Hash::make($data['employee-create-password']),
          'jenis_kelamin_pegawai' => $data['employee-create-gender'],
          'kode_otoritas' => $data['employee-create-authority']
        ]);
        return response()->json(['status' => 200,'text' => 'Yey, berhasil menambahkan pegawai.']);
      }
      else {
        return response()->json(['status' => 400,'text' => 'Pegawai sudah terdaftar, gagal menambahkan pegawai.']);
      }

    }
  }

  public function search(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $validator = Validator::make($data, [
        'employee-search-query' => 'required|min:1',
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 500, 'text' => 'Jangan lupa diisi ya kata kunci nya!']);
      }

      $keyword = '%' . $data['employee-search-query'] . '%';
      $employees = DB::table('pegawai')
        ->join('otoritas','otoritas.kode_otoritas', '=', 'pegawai.kode_otoritas')
        ->select('*', DB::raw('IF (jenis_kelamin_pegawai = "L", "Laki-Laki", IF (jenis_kelamin_pegawai = "P", "Perempuan", "-")) AS jenis_kelamin_pegawai'))
        ->where('pegawai.kode_pegawai', '!=', Auth::guard('employee')->user()->kode_pegawai) //yg login gk boleh hapus datanya sendiri
        ->where(function ($qry) use ($keyword) {
          $qry ->where('kode_pegawai', 'LIKE', $keyword)
          ->orwhere('nama_pegawai', 'LIKE', $keyword);
        })
        ->orderBy('nama_pegawai', 'ASC')
        ->get();

      $authority = DB::table('otoritas')
        ->orderBy('nama_otoritas', 'ASC')
        ->get();
      if ($employees) {
        return response()->json([
            'status' => 200,
            'text' => 'Pencarian selesai dilakukan',
            'content' => $employees,
            'authority' => $authority
          ]);
      }

    }
  }

  public function retrieve() {
    $devices = DB::table('pegawai')
              ->select('otoritas.nama_otoritas AS title',
                DB::raw('COUNT(pegawai.kode_otoritas) AS res'))
              ->join('otoritas', 'pegawai.kode_otoritas', '=', 'otoritas.kode_otoritas')
              ->groupBy('otoritas.kode_otoritas')
              ->orderBy('otoritas.nama_otoritas', 'ASC')
              ->get();
    return $devices;
  }

}
