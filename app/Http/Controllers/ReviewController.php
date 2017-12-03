<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Review;
use Hash;
use Validator;

class ReviewController extends Controller {

  public function create(Request $request) {
    $data = $request->all();

    $menu = Review::find($data['review-add-title']);
    if (!$menu) {
      $rules = [
        'review-add-title' => 'required|min:3',
        'review-add-content' => 'required|min:8'
      ];

      $input = [
        'judul_kuisioner' => $data['review-add-title'],
        'isi_kuisioner' => $data['review-add-content'],
        'tanggal_kuisioner' => date('Y-m-d'),
        'waktu_kuisioner' => date('H:m:s'),
        'status_kuisioner' => '1',
        'kode_pegawai' => 'toor', //tmp
      ];

      $this->validate($request, $rules);

      $try = Review::create($input);
    }
    return redirect('/dashboard/review');
  }

  public function retrieve() {
    $review['min'] = DB::table('kuisioner_perangkat')
              ->join('kuisioner_detil', 'kuisioner_detil.kode_kuisioner_perangkat', '=', 'kuisioner_perangkat.kode_kuisioner_perangkat')
              ->join('kuisioner', 'kuisioner.kode_kuisioner', '=', 'kuisioner_detil.kode_kuisioner')
              ->select('kuisioner.judul_kuisioner', 'kuisioner.status_kuisioner',
                DB::raw('ROUND(MIN(kuisioner_detil.poin_kuisioner_detil), 2) AS poin_kuisioner'))
              ->where('kuisioner.status_kuisioner', '=', '1')
              ->where('kuisioner_perangkat.status_kuisioner_perangkat', '=', '1')
              ->groupBy('kuisioner.judul_kuisioner')
              ->get();
    $review['max'] = DB::table('kuisioner_perangkat')
              ->join('kuisioner_detil', 'kuisioner_detil.kode_kuisioner_perangkat', '=', 'kuisioner_perangkat.kode_kuisioner_perangkat')
              ->join('kuisioner', 'kuisioner.kode_kuisioner', '=', 'kuisioner_detil.kode_kuisioner')
              ->select('kuisioner.judul_kuisioner', 'kuisioner.status_kuisioner',
                DB::raw('ROUND(MAX(kuisioner_detil.poin_kuisioner_detil), 2) AS poin_kuisioner'))
              ->where('kuisioner.status_kuisioner', '=', '1')
              ->where('kuisioner_perangkat.status_kuisioner_perangkat', '=', '1')
              ->groupBy('kuisioner.judul_kuisioner')
              ->get();
    $review['avg'] = DB::table('kuisioner_perangkat')
              ->join('kuisioner_detil', 'kuisioner_detil.kode_kuisioner_perangkat', '=', 'kuisioner_perangkat.kode_kuisioner_perangkat')
              ->join('kuisioner', 'kuisioner.kode_kuisioner', '=', 'kuisioner_detil.kode_kuisioner')
              ->select('kuisioner.judul_kuisioner', 'kuisioner.status_kuisioner',
                DB::raw('ROUND(AVG(kuisioner_detil.poin_kuisioner_detil), 2) AS poin_kuisioner'))
              ->where('kuisioner.status_kuisioner', '=', '1')
              ->where('kuisioner_perangkat.status_kuisioner_perangkat', '=', '1')
              ->groupBy('kuisioner.judul_kuisioner')
              ->get();
    $review['labels'] = DB::table('kuisioner_perangkat')
              ->join('kuisioner_detil', 'kuisioner_detil.kode_kuisioner_perangkat', '=', 'kuisioner_perangkat.kode_kuisioner_perangkat')
              ->join('kuisioner', 'kuisioner.kode_kuisioner', '=', 'kuisioner_detil.kode_kuisioner')
              ->select('kuisioner.judul_kuisioner')
              ->where('kuisioner.status_kuisioner', '=', '1')
              ->where('kuisioner_perangkat.status_kuisioner_perangkat', '=', '1')
              ->groupBy('kuisioner.judul_kuisioner')
              ->get();
    return $review;
  }

  public function search(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $keyword = '%' . $data['review-search-query'] . '%';
      $validator = Validator::make($data, [
        'review-search-query' => 'required|min:1',
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 500, 'text' => 'Jangan lupa diisi ya kata kunci nya!']);
      }

      $result['review-device'] = DB::table('kuisioner_perangkat')
        ->orderBy('tanggal_kuisioner_perangkat', 'ASC')
        ->orderBy('waktu_kuisioner_perangkat', 'ASC')
        ->where('kode_kuisioner_perangkat', 'LIKE', $keyword)
        ->orwhere('pembeli_kuisioner_perangkat', 'LIKE', $keyword)
        ->orwhere('pesan_kuisioner_perangkat', 'LIKE', $keyword)
        ->orwhere('tanggal_kuisioner_perangkat', 'LIKE', $keyword)
        ->orwhere('waktu_kuisioner_perangkat', 'LIKE', $keyword)
        ->orwhere('kode_perangkat', 'LIKE', $keyword)
        ->skip(0)->take(5)->get();

      foreach ($result['review-device'] as $key => $value) {
        $result[$key]['review-detail'] = DB::table('kuisioner_detil')
          ->join('kuisioner', 'kuisioner.kode_kuisioner', '=', 'kuisioner_detil.kode_kuisioner')
          ->where('kuisioner_detil.kode_kuisioner_perangkat', '=', $value->kode_kuisioner_perangkat)
          ->get();
      }

      if ($result) {
        return response()->json([
            'status' => 200,
            'text' => 'Pencarian selesai dilakukan',
            'content' => $result
          ]);
      }

    }
  }

}
