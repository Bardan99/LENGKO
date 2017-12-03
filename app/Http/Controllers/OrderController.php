<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Pesanan;
use App\PesananDetil;
use Hash;
use Validator;

class OrderController extends Controller {

  public function confirm(Request $request) {
    $id = $request->get('order-confirm-id');
    $employee = Pesanan::findOrFail($id);
    if ($employee) {
      $data = [
        'status_pesanan' => 'P' //lanjut ke tahap proses = sudah dikonfirmasi
      ];
      $try = Pesanan::find($id)->update($data);
    }
    return redirect('/dashboard/order');
  }

  public function marked(Request $request, $id) {
    $handler = Pesanan::findOrFail($id);
    if ($handler) {
      $try = Pesanan::find($id)->update([
        'status_pesanan' => 'T'
      ]);
      $try = PesananDetil::where(['kode_pesanan' => $id])->update([
        'status_pesanan_detil' => 'D'
      ]);
      return response()->json(['status' => 200, 'text' => 'Pelayan sekarang seharusnya sudah bisa mengantar pesanan']);
    }
    else {
      return response()->json(['status' => 400, 'text' => 'Pesanan tidak ditemukan']);
    }
  }

  public function checked(Request $request, $id) {
    $handler = PesananDetil::findOrFail($id);
    if ($handler) {
      $try = PesananDetil::find($id)->update([
        'status_pesanan_detil' => 'D'
      ]);
      return response()->json(['status' => 200, 'text' => 'Pelayan sekarang seharusnya sudah bisa mengantar pesanan']);
    }
    else {
      return response()->json(['status' => 400, 'text' => 'Pesanan tidak ditemukan']);
    }
  }

  /* dumping
  public function searchmaterial(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $validator = Validator::make($data, [
        'material-search-query' => 'required',
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 500, 'text' => 'Jangan lupa diisi ya kata kunci nya!']);
      }

      $materials = DB::table('bahan_baku')
        ->where('kode_bahan_baku', 'LIKE', '%' . $data['material-search-query'] . '%')
        ->orwhere('nama_bahan_baku', 'LIKE', '%' . $data['material-search-query'] . '%')
        ->orwhere('stok_bahan_baku', 'LIKE', '%' . $data['material-search-query'] . '%')
        ->orwhere('satuan_bahan_baku', 'LIKE', '%' . $data['material-search-query'] . '%')
        ->orwhere('tanggal_kadaluarsa_bahan_baku', 'LIKE', '%' . $data['material-search-query'] . '%')
        ->orderBy('nama_bahan_baku', 'ASC')
        ->get();
      if ($materials) {
        return response()->json([
            'status' => 200,
            'text' => 'Pencarian selesai dilakukan',
            'content' => $materials
          ]);
      }

    }
  }
  */

  public function search(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $keyword = '%' . $data['order-search-query'] . '%';
      $validator = Validator::make($data, [
        'order-search-query' => 'required|min:1',
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 500, 'text' => 'Jangan lupa diisi ya kata kunci nya!']);
      }

      $result['order-confirmation'] = DB::table('pesanan')
        ->select('pesanan.*', 'perangkat.nama_perangkat')
        ->join('perangkat', 'pesanan.kode_perangkat', '=', 'perangkat.kode_perangkat')
        ->orderBy('tanggal_pesanan', 'ASC')
        ->orderBy('waktu_pesanan', 'ASC')
        ->where('pesanan.status_pesanan', '=', 'C')
        ->where(function ($qry) use ($keyword) {
          $qry->orwhere('pesanan.kode_pesanan', 'LIKE', $keyword)
          ->orwhere('pesanan.pembeli_pesanan', 'LIKE', $keyword)
          ->orwhere('pesanan.catatan_pesanan', 'LIKE', $keyword)
          ->orwhere('perangkat.nama_perangkat', 'LIKE', $keyword);
        })
        ->get();

      foreach ($result['order-confirmation'] as $key => $value) {
        $result[$key]['order-confirmation-detail'] = DB::table('pesanan')
          ->select('pesanan_detil.*', 'menu.*')
          ->join('pesanan_detil', 'pesanan.kode_pesanan', '=', 'pesanan_detil.kode_pesanan')
          ->join('menu', 'pesanan_detil.kode_menu', '=', 'menu.kode_menu')
          ->where('pesanan.kode_pesanan', '=', $result['order-confirmation'][$key]->kode_pesanan)
          ->get();
      }

      if ($result) {
        return response()->json([
            'status' => 200,
            'text' => 'Pencarian selesai dilakukan',
            'content' => $result,
          ]);
      }

    }
  }

}
