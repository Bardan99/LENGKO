<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Facades\DB;
use App\Perangkat;
use App\Pemberitahuan;

class MethodController extends BaseController {

  public function get_navbar($auth) {
    $navbar = DB::table('halaman')
      ->join('halaman_detil', 'halaman.kode_halaman', '=', 'halaman_detil.kode_halaman')
      ->where('halaman_detil.kode_otoritas', '=', $auth)
      ->where('halaman_detil.status_halaman_detil', '=', TRUE)
      ->select('halaman.kode_halaman', 'halaman.nama_halaman', 'halaman.ikon_halaman')
      ->orderby('urutan_halaman', 'asc')
      ->get();
    return ($navbar);
  }

  public function num_to_rp($number, $digit = 0) {
    if (isset($number) && isset($digit)) {
      return 'Rp' . number_format($number, $digit, ',','.');
    }
  }

  public function cut_string($desc, $length) {
    return substr($desc, $length);
  }

  public function menu_type($type) {
    $res = "Makanan";
    if ($type == "D") {
      $res= "Minuman";
    }
    return $res;
  }

  public function rewrite($type, $param) {
    $res = false;
    switch ($type) {
      case 'date':

      break;
      case 'time':

      break;
      case 'status-number':
        switch ($param) {
          case 0:
            $res = 'Belum disetujui';
          break;
          case -1:
            $res = 'Tidak disetujui';
          break;
          case 1:
            $res = 'Disetujui';
          break;
        }
      break;
      case 'status':
        switch ($param) {
          case '':
            $res = '-';
          break;
          case 'C':
            $res = 'Menunggu konfirmasi';
          break;
          case 'P':
            $res = 'Sedang diproses';
          break;
          case 'T':
            $res = 'Menunggu pembayaran';
          break;
          case 'D':
            $res = 'Selesai diproses';
          break;
          default:$res = $param;break;
        }
      break;
      default:break;
    }
    return $res;
  }


  public function generate_notification($data) {
    $valid = Perangkat::find($data['device']);
    if ($valid) {
      $input = [
        'isi_pemberitahuan' => $data['msg'],
        'kode_perangkat' => $data['device'],
      ];
      $try = Pemberitahuan::create($input);
      return true;
    }
    return false;
  }


}
