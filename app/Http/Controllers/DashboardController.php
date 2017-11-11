<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class DashboardController extends Controller {

  public function index() {
    if (view()->exists('dashboard.home')) {
      //$menus = DB::table('hidangan')->skip(0)->take(9)->get();
      $navbar = new NavBarController;
      $pages = $navbar->get_navbar('root');
      return view('dashboard.home', ['pages' => $pages, 'page' => '']);
    }
    return abort(404);
  }

  public function view($param) {
    if (view()->exists('dashboard.' . $param)) {
      $navbar = new NavBarController;
      $pages = $navbar->get_navbar('root');
      switch ($param) {
        case 'device':
          $data['device'] = DB::table('perangkat')
            ->orderBy('nama_perangkat', 'ASC')
            ->select('*', DB::raw('IF (status_perangkat = 1, "available", IF (status_perangkat = 0, "unavailable", "disabled")) AS status_text'))
            ->get();
        break;
        case 'employee':
          $data['employee'] = DB::table('pegawai')
            ->join('otoritas','otoritas.kode_otoritas', '=', 'pegawai.kode_otoritas')
            ->select('*', DB::raw('IF (jenis_kelamin_pegawai = "L", "Laki-Laki", IF (jenis_kelamin_pegawai = "P", "Perempuan", "-")) AS jenis_kelamin_pegawai'))
            ->orderBy('nama_pegawai', 'ASC')
            ->get();
          $data['authority'] = DB::table('otoritas')
            ->orderBy('nama_otoritas', 'ASC')
            ->get();
        break;
        case 'menu':
          $data['menu'] = DB::table('menu')
            ->orderBy('nama_menu', 'ASC')
            ->skip(0)->take(3)->get();
          $data['material'] = DB::table('bahan_baku')
            ->orderBy('nama_bahan_baku', 'ASC')
            ->get();
          $data['material-request'] = DB::table('pengadaan_bahan_baku')
            ->join('prioritas', 'prioritas.kode_prioritas', '=', 'pengadaan_bahan_baku.kode_prioritas')
            ->orderBy('tanggal_pengadaan_bahan_baku', 'DSC')
            ->get();
          if ($data['material-request']) {
            foreach ($data['material-request'] as $key => $value) {
              $data[$key]['material-request-detail'] = DB::table('pengadaan_bahan_baku_detil')
                ->orderBy('nama_bahan_baku', 'ASC')
                ->get();
            }
          }                
          $data['priority'] = DB::table('prioritas')
            ->orderBy('nama_prioritas', 'ASC')
            ->get();
          $data['menu_obj'] = new MethodController();
        break;
        default:
          $data['unknown'] = null;
        break;
      }
      return view('dashboard.' . $param, ['pages' => $pages, 'page' => $param, 'data' => $data]);
    }
    return abort(404);
  }
}
