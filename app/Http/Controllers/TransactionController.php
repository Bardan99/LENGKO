<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Pesanan;
use App\PesananDetil;
use Hash;
use Validator;

class TransactionController extends Controller {

  public function marked(Request $request, $id, $cash) {
    $handler = Pesanan::findOrFail($id);
    if ($handler) {
      $try = Pesanan::find($id)->update([
        'status_pesanan' => 'D',
        'tunai_pesanan' => $cash
      ]);
      return response()->json(['status' => 200, 'text' => 'Pembayaran berhasil dilakukan']);
    }
    else {
      return response()->json(['status' => 400, 'text' => 'Pesanan tidak ditemukan']);
    }
  }

  public function search(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $keyword = '%' . $data['transaction-search-query'] . '%';
      $validator = Validator::make($data, [
        'transaction-search-query' => 'required|min:1',
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 500, 'text' => 'Jangan lupa diisi ya kata kunci nya!']);
      }

      $result['transaction'] = DB::table('pesanan')
        ->select('pesanan.*', 'perangkat.nama_perangkat')
        ->join('perangkat', 'pesanan.kode_perangkat', '=', 'perangkat.kode_perangkat')
        ->orderBy('tanggal_pesanan', 'ASC')
        ->orderBy('waktu_pesanan', 'ASC')
        ->where('pesanan.status_pesanan', '=', 'T')
        ->where(function ($qry) use ($keyword) {
          $qry->orwhere('pesanan.kode_pesanan', 'LIKE', $keyword)
          ->orwhere('pesanan.pembeli_pesanan', 'LIKE', $keyword)
          ->orwhere('pesanan.catatan_pesanan', 'LIKE', $keyword)
          ->orwhere('perangkat.nama_perangkat', 'LIKE', $keyword);
        })
        ->get();

      foreach ($result['transaction'] as $key => $value) {
        $result[$key]['transaction-detail'] = DB::table('pesanan')
          ->select('pesanan_detil.*', 'menu.*')
          ->join('pesanan_detil', 'pesanan.kode_pesanan', '=', 'pesanan_detil.kode_pesanan')
          ->join('menu', 'pesanan_detil.kode_menu', '=', 'menu.kode_menu')
          ->where('pesanan.kode_pesanan', '=', $value->kode_pesanan)
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

  public function searchhistory(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $keyword = '%' . $data['transaction-history-search-query'] . '%';
      $validator = Validator::make($data, [
        'transaction-history-search-query' => 'required|min:1',
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 500, 'text' => 'Jangan lupa diisi ya kata kunci nya!']);
      }

      $result['transaction-history'] = DB::table('pesanan')
        ->select('pesanan.*', 'perangkat.nama_perangkat')
        ->join('perangkat', 'pesanan.kode_perangkat', '=', 'perangkat.kode_perangkat')
        ->orderBy('tanggal_pesanan', 'ASC')
        ->orderBy('waktu_pesanan', 'ASC')
        ->where('pesanan.status_pesanan', '=', 'D')
        ->where(function ($qry) use ($keyword) {
          $qry->orwhere('pesanan.kode_pesanan', 'LIKE', $keyword)
          ->orwhere('pesanan.pembeli_pesanan', 'LIKE', $keyword)
          ->orwhere('pesanan.catatan_pesanan', 'LIKE', $keyword)
          ->orwhere('perangkat.nama_perangkat', 'LIKE', $keyword);
        })
        ->skip(0)->take(5)->get();
      foreach ($result['transaction-history'] as $key => $value) {
        $result[$key]['transaction-history-detail'] = DB::table('pesanan')
          ->select('pesanan_detil.*', 'menu.*')
          ->join('pesanan_detil', 'pesanan.kode_pesanan', '=', 'pesanan_detil.kode_pesanan')
          ->join('menu', 'pesanan_detil.kode_menu', '=', 'menu.kode_menu')
          ->where('pesanan.kode_pesanan', '=', $value->kode_pesanan)
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
