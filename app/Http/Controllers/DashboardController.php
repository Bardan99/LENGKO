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
          $employee = new EmployeeController;
          $data['employee'] = DB::table('pegawai')
            ->join('otoritas','otoritas.kode_otoritas', '=', 'pegawai.kode_otoritas')
            ->select('*', DB::raw('IF (jenis_kelamin_pegawai = "L", "Laki-Laki", IF (jenis_kelamin_pegawai = "P", "Perempuan", "-")) AS jenis_kelamin_pegawai'))
            ->orderBy('nama_pegawai', 'ASC')
            ->get();
          $data['authority'] = DB::table('otoritas')
            ->orderBy('nama_otoritas', 'ASC')
            ->get();
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
