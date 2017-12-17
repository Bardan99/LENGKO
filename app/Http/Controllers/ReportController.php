<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class ReportController extends Controller {

  public function income() {
    $result = DB::table('pesanan')
              ->select(DB::raw('SUM(harga_pesanan) AS pendapatan, tanggal_pesanan AS tanggal'))
              ->where('status_pesanan', '=', 'D')
              ->where('tanggal_pesanan', '>=', date('Y-m-d', strtotime('-7 days')))
              ->where('tanggal_pesanan', '<=', date('Y-m-d'))
              ->groupBy('tanggal_pesanan')
              ->orderBy('tanggal_pesanan', 'ASC')
              ->get();
    return $result;
  }

  public function report(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();

      if ($data['_start'] && $data['_end']) {
        $result = DB::table('pesanan')
          ->select(DB::raw('SUM(harga_pesanan) AS pendapatan, tanggal_pesanan AS tanggal'))
          ->where('status_pesanan', '=', 'D')
          ->where('tanggal_pesanan', '>=', $data['_start'])
          ->where('tanggal_pesanan', '<=', $data['_end'])
          ->groupBy('tanggal_pesanan')
          ->orderBy('tanggal_pesanan', 'ASC')
          ->get();
      }
      else { //metode default
        switch ($data['_type']) {
          case 'daily':
            $result = DB::table('pesanan')
              ->select(DB::raw('SUM(harga_pesanan) AS pendapatan, tanggal_pesanan AS tanggal'))
              ->where('status_pesanan', '=', 'D')
              ->where('tanggal_pesanan', '=', date('Y-m-d'))
              ->groupBy('tanggal_pesanan')
              ->orderBy('tanggal_pesanan', 'ASC')
              ->get();
          break;
          case 'weekly':
            $result = DB::table('pesanan')
              ->select(DB::raw('SUM(harga_pesanan) AS pendapatan, tanggal_pesanan AS tanggal'))
              ->where('status_pesanan', '=', 'D')
              ->where('tanggal_pesanan', '>=', date('Y-m-d', strtotime('-7 days')))
              ->where('tanggal_pesanan', '<=', date('Y-m-d'))
              ->groupBy('tanggal_pesanan')
              ->orderBy('tanggal_pesanan', 'ASC')
              ->get();
          break;
          case 'monthly':
            $result = DB::table('pesanan')
              ->select(DB::raw('SUM(harga_pesanan) AS pendapatan, tanggal_pesanan AS tanggal'))
              ->where('status_pesanan', '=', 'D')
              ->where('tanggal_pesanan', '>=', date('Y-m-d', strtotime('-30 days')))
              ->where('tanggal_pesanan', '<=', date('Y-m-d'))
              ->groupBy('tanggal_pesanan')
              ->orderBy('tanggal_pesanan', 'ASC')
              ->get();
          break;
          case 'yearly':
            $result = DB::table('pesanan')
              ->select(DB::raw('SUM(harga_pesanan) AS pendapatan, tanggal_pesanan AS tanggal'))
              ->where('status_pesanan', '=', 'D')
              ->where('tanggal_pesanan', '>=', date('Y-m-d', strtotime('-365 days')))
              ->where('tanggal_pesanan', '<=', date('Y-m-d'))
              ->groupBy('tanggal_pesanan')
              ->orderBy('tanggal_pesanan', 'ASC')
              ->get();
          break;
          default:
            $result = DB::table('pesanan')
              ->select(DB::raw('SUM(harga_pesanan) AS pendapatan, tanggal_pesanan AS tanggal'))
              ->where('status_pesanan', '=', 'D')
              ->where('tanggal_pesanan', '=', date('Y-m-d'))
              ->groupBy('tanggal_pesanan')
              ->orderBy('tanggal_pesanan', 'ASC')
              ->get();
          break;
        }
      } //endif
      if ($result) {
        return response()->json([
            'status' => 200,
            'text' => 'Pencarian selesai dilakukan',
            'content' => $result
          ]);
      }
      else {
        return response()->json([
            'status' => 200,
            'text' => 'Data tidak ditemukan'
          ]);
      }
    }//endrequestajax
  }//endfunction


  public function incomereport(Request $request, $type) {
    if (view()->exists('dashboard.reportincome')) {
        switch ($type) {
          case 'daily':
            $result = DB::table('pesanan')
              ->select(DB::raw('SUM(harga_pesanan) AS pendapatan, tanggal_pesanan AS tanggal'))
              ->where('status_pesanan', '=', 'D')
              ->where('tanggal_pesanan', '=', date('Y-m-d'))
              ->groupBy('tanggal_pesanan')
              ->orderBy('tanggal_pesanan', 'ASC')
              ->get();
            $period = 'Harian (' . date('Y-m-d') . ')';
          break;
          case 'weekly':
            $result = DB::table('pesanan')
              ->select(DB::raw('SUM(harga_pesanan) AS pendapatan, tanggal_pesanan AS tanggal'))
              ->where('status_pesanan', '=', 'D')
              ->where('tanggal_pesanan', '>=', date('Y-m-d', strtotime('-7 days')))
              ->where('tanggal_pesanan', '<=', date('Y-m-d'))
              ->groupBy('tanggal_pesanan')
              ->orderBy('tanggal_pesanan', 'ASC')
              ->get();
            $period = 'Mingguan (' . date('Y-m-d', strtotime('-7 days')) . ' s.d. ' . date('Y-m-d') . ')';
          break;
          case 'monthly':
            $result = DB::table('pesanan')
              ->select(DB::raw('SUM(harga_pesanan) AS pendapatan, tanggal_pesanan AS tanggal'))
              ->where('status_pesanan', '=', 'D')
              ->where('tanggal_pesanan', '>=', date('Y-m-d', strtotime('-30 days')))
              ->where('tanggal_pesanan', '<=', date('Y-m-d'))
              ->groupBy('tanggal_pesanan')
              ->orderBy('tanggal_pesanan', 'ASC')
              ->get();
            $period = 'Bulanan (' . date('Y-m-d', strtotime('-30 days')) . ' s.d. ' . date('Y-m-d') . ')';
          break;
          case 'yearly':
            $result = DB::table('pesanan')
              ->select(DB::raw('SUM(harga_pesanan) AS pendapatan, tanggal_pesanan AS tanggal'))
              ->where('status_pesanan', '=', 'D')
              ->where('tanggal_pesanan', '>=', date('Y-m-d', strtotime('-365 days')))
              ->where('tanggal_pesanan', '<=', date('Y-m-d'))
              ->groupBy('tanggal_pesanan')
              ->orderBy('tanggal_pesanan', 'ASC')
              ->get();
            $period = 'Tahunan (' . date('Y-m-d', strtotime('-365 days')) . ' s.d. ' . date('Y-m-d') . ')';
          break;
          default:
            return redirect('/dashboard/report');
          break;
        }//endswitch
        $method = new MethodController();
        return view('dashboard.reportincome', ['data' => $result, 'method' => $method, 'period' => $period]);
    }//report blade exists
    return abort(404);
  }

  public function incomereportdate(Request $request, $start, $end) {
    if (view()->exists('dashboard.reportincome')) {
      if ($start && $end) {
        $result = DB::table('pesanan')
          ->select(DB::raw('SUM(harga_pesanan) AS pendapatan, tanggal_pesanan AS tanggal'))
          ->where('status_pesanan', '=', 'D')
          ->where('tanggal_pesanan', '>=', $start)
          ->where('tanggal_pesanan', '<=', $end)
          ->groupBy('tanggal_pesanan')
          ->orderBy('tanggal_pesanan', 'ASC')
          ->get();
        $period = $start . ' s.d. ' . $end;
      }
      else {
        return redirect('/dashboard/report');
      }
      $method = new MethodController();
      return view('dashboard.reportincome', ['data' => $result, 'method' => $method, 'period' => $period]);
    }//report blade exists
    return abort(404);
  }


}
