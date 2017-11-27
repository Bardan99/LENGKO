<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Pengadaan;
use App\PengadaanDetil;
use Hash;
use Validator;

class PengadaanController extends Controller {

  public function get($param) {
    $data = null;
    if ($param) {
      switch ($param) {
        case 'material':
          $data['material'] = DB::table('bahan_baku')
            ->orderBy('nama_bahan_baku', 'ASC')
            ->get();
        break;
        default:break;
      }
    }
    return $data;
  }


  public function create(Request $request) {

    $data = $request->all();

    $items['material-request-create-subject'] = 'required|min:4';
    $items['material-request-create-priority'] = 'required|min:1';
    for ($i = 0; $i < $data['material-request-create-max'] + 1; $i++) {
      $items['material-request-create-item-' . $i] = 'required|min:1';
    }

    $this->validate($request, $items);

    $try = Pengadaan::create([
      'subjek_pengadaan_bahan_baku' => $data['material-request-create-subject'],
      'tanggal_pengadaan_bahan_baku' => date('Y-m-d'),
      'waktu_pengadaan_bahan_baku' => date('H:m:s'),
      'catatan_pengadaan_bahan_baku' => $data['material-request-create-addition'],
      'status_pengadaan_bahan_baku' => 0,
      'kode_pegawai' => 'toor',//sementara
      'kode_prioritas' => $data['material-request-create-priority']
    ]);
    $id = $try->kode_pengadaan_bahan_baku;

    for ($i = 0; $i < $data['material-request-create-max'] + 1; $i++) {
      $detils[] = array(
        'nama_bahan_baku' => $data['material-request-create-item-' . $i],
        'jumlah_bahan_baku' => 0,
        'satuan_bahan_baku' => '',
        'kode_pengadaan_bahan_baku' => $id,
      );
    }

    $try = PengadaanDetil::insert($detils);

    return redirect('/dashboard/material');
  }


}
