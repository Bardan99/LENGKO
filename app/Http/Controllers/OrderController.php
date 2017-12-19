<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Pesanan;
use App\PesananDetil;
use App\Perangkat;
use App\Menu;
use Auth;
use Hash;
use Validator;

class OrderController extends Controller {

  public function confirm(Request $request) {
    $id = $request->get('order-confirm-id');
    $order = Pesanan::findOrFail($id);
    if ($order) {
      $data = [
        'status_pesanan' => 'P' //lanjut ke tahap proses = sudah dikonfirmasi
      ];
      $try = Pesanan::find($id)->update($data);

      $valid = Perangkat::find($order->kode_perangkat);
      if ($valid) {
        $try = new MethodController();
        $try = $try->generate_notification([
          'device' => $valid->kode_perangkat,
          'msg' => 'Pesanan ' . $order->pembeli_pesanan . '[' . $valid->nama_perangkat . ']' . ' sudah dikonfirmasi pelayan.'
        ]);
      }
    }
    return redirect('/dashboard/order');
  }

  public function marked(Request $request, $id) {
    $order = Pesanan::find($id);
    if ($order) {
      $try = Pesanan::find($id)->update([
        'status_pesanan' => 'T',
        'kode_pegawai' => Auth::guard('employee')->user()->kode_pegawai
      ]);
      $try = PesananDetil::where(['kode_pesanan' => $id])->update([
        'status_pesanan_detil' => 'D'
      ]);

      $valid = Perangkat::find($order->kode_perangkat);
      $try = new MethodController();
      $try = $try->generate_notification([
        'device' => $valid->kode_perangkat,
        'msg' => 'Pesanan #' . $order->kode_pesanan . ' [' . $order->pembeli_pesanan . '@' . $valid->nama_perangkat . '] selesai dibuat.'
      ]);

      return response()->json(['status' => 200, 'text' => 'Pelayan sekarang seharusnya sudah bisa mengantar pesanan']);
    }
    else {
      return response()->json(['status' => 400, 'text' => 'Pesanan tidak ditemukan']);
    }
  }

  public function checked(Request $request, $id) {
    $orderdetil = PesananDetil::findOrFail($id);
    if ($orderdetil) {
      $try = PesananDetil::find($id)->update([
        'status_pesanan_detil' => 'D',
      ]);

      $order = Pesanan::find($orderdetil->kode_pesanan);
      if ($order) {
        $valid = Perangkat::find($order->kode_perangkat);
        $menu = Menu::find($orderdetil->kode_menu);
        $try = new MethodController();
        $try = $try->generate_notification([
          'device' => $valid->kode_perangkat,
          'msg' => 'Pesanan #' . $order->kode_pesanan . ' (' . $menu->nama_menu . ') [' . $order->pembeli_pesanan . '@' . $valid->nama_perangkat . '] selesai dibuat.'
        ]);
      }

      return response()->json(['status' => 200, 'text' => 'Pelayan sekarang seharusnya sudah bisa mengantar pesanan']);
    }
    else {
      return response()->json(['status' => 400, 'text' => 'Pesanan tidak ditemukan']);
    }
  }

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

  public function refreshconfirmationorder(Request $request) {
    $data['order-confirmation'] = DB::table('pesanan')
      ->select('pesanan.*', 'perangkat.nama_perangkat')
      ->join('perangkat', 'pesanan.kode_perangkat', '=', 'perangkat.kode_perangkat')
      ->orderBy('tanggal_pesanan', 'ASC')
      ->orderBy('waktu_pesanan', 'ASC')
      ->where('pesanan.status_pesanan', '=', 'C')
      ->skip(0)->take(5)->get();
    foreach ($data['order-confirmation'] as $key => $value) {
      $data[$key]['order-confirmation-detail'] = DB::table('pesanan')
        ->select('pesanan_detil.*', 'menu.*')
        ->join('pesanan_detil', 'pesanan.kode_pesanan', '=', 'pesanan_detil.kode_pesanan')
        ->join('menu', 'pesanan_detil.kode_menu', '=', 'menu.kode_menu')
        ->where('pesanan.kode_pesanan', '=', $data['order-confirmation'][$key]->kode_pesanan)
        ->get();
    }
    return response()->json([
      'status' => 200,
      'content' => $data
    ]);
  }

  public function refreshqueueorder(Request $request) {
    $data['order'] = DB::table('pesanan')
      ->select('pesanan.*', 'perangkat.nama_perangkat')
      ->join('perangkat', 'pesanan.kode_perangkat', '=', 'perangkat.kode_perangkat')
      ->orderBy('tanggal_pesanan', 'ASC')
      ->orderBy('waktu_pesanan', 'ASC')
      ->where('pesanan.status_pesanan', '=', 'P')
      ->get();
    $data['order-detail'] = DB::table('pesanan')
      ->select('pesanan_detil.*', 'menu.*')
      ->join('pesanan_detil', 'pesanan.kode_pesanan', '=', 'pesanan_detil.kode_pesanan')
      ->join('menu', 'pesanan_detil.kode_menu', '=', 'menu.kode_menu')
      ->orderBy('tanggal_pesanan', 'ASC')
      ->orderBy('waktu_pesanan', 'ASC')
      ->where('pesanan.status_pesanan', '=', 'P')
      ->where('pesanan_detil.status_pesanan_detil', '=', 'P')
      ->get();

    foreach ($data['order'] as $key => $value) {
      $data[$key]['order-detail-food'] = DB::table('pesanan')
        ->select('pesanan_detil.*', 'menu.*')
        ->join('pesanan_detil', 'pesanan.kode_pesanan', '=', 'pesanan_detil.kode_pesanan')
        ->join('menu', 'pesanan_detil.kode_menu', '=', 'menu.kode_menu')
        ->where('menu.jenis_menu', '=', 'F')
        ->where('pesanan.kode_pesanan', '=', $value->kode_pesanan)
        ->get();

      $data[$key]['order-detail-drink'] = DB::table('pesanan')
        ->select('pesanan_detil.*', 'menu.*')
        ->join('pesanan_detil', 'pesanan.kode_pesanan', '=', 'pesanan_detil.kode_pesanan')
        ->join('menu', 'pesanan_detil.kode_menu', '=', 'menu.kode_menu')
        ->where('menu.jenis_menu', '=', 'D')
        ->where('pesanan.kode_pesanan', '=', $value->kode_pesanan)
        ->get();
    }
    return response()->json([
      'status' => 200,
      'content' => $data
    ]);
  }

}
