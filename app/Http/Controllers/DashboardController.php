<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Pegawai;
use App\Perangkat;
use Hash;

class DashboardController extends Controller {

  public function __construct() {
    //$this->middleware('auth');
  }

  public function index() {
    if (view()->exists('dashboard.home')) {
      $navbar = new NavBarController;
      $pages = $navbar->get_navbar('root');
      $data['employee'] = Pegawai::where('kode_pegawai', 'toor')
                          ->join('otoritas', 'otoritas.kode_otoritas', '=', 'pegawai.kode_otoritas')
                          ->first();
      return view('dashboard.home', ['data' => $data, 'pages' => $pages, 'page' => '']);
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
            ->select('*',
              DB::raw(
                'IF (status_perangkat = "1", "available", IF (status_perangkat = "0", "unavailable", "disabled")) AS status_text,
                IF (status_perangkat = "1", "Tersedia", IF (status_perangkat = "0", "Tidak Tersedia", "Tidak Diketahui")) AS status_text_human'
                ))
            ->skip(0)->take(8)->get();
          $data['status'] = (object) array(
            (object) array(
              'status' => 1,
              'text'   => 'Tersedia'),
            (object) array(
              'status' => 0,
              'text'   => 'Tidak Tersedia')
          );
        break;
        case 'employee':
          $data['employee'] = DB::table('pegawai')
            ->join('otoritas','otoritas.kode_otoritas', '=', 'pegawai.kode_otoritas')
            ->select('*', DB::raw('IF (jenis_kelamin_pegawai = "L", "Laki-Laki", IF (jenis_kelamin_pegawai = "P", "Perempuan", "-")) AS jenis_kelamin_pegawai'))
            ->where('pegawai.kode_pegawai', '!=', 'toor') //yg login gk boleh hapus datanya sendiri
            ->orderBy('nama_pegawai', 'ASC')
            ->skip(0)->take(5)->get();
          $data['authority'] = DB::table('otoritas')
            ->orderBy('nama_otoritas', 'ASC')
            ->get();
        break;
        case 'material':
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
          $data['material-request-user'] = DB::table('pengadaan_bahan_baku')
            ->join('prioritas', 'prioritas.kode_prioritas', '=', 'pengadaan_bahan_baku.kode_prioritas')
            ->orderBy('tanggal_pengadaan_bahan_baku', 'DSC')
            //->where('pengadaan_bahan_baku.kode_pegawai', '=', '')
            ->get();
          if ($data['material-request-user']) {
            foreach ($data['material-request-user'] as $key => $value) {
              $data[$key]['material-request-user-detail'] = DB::table('pengadaan_bahan_baku_detil')
                ->orderBy('nama_bahan_baku', 'ASC')
                ->get();
            }
          }
          $data['priority'] = DB::table('prioritas')
            ->orderBy('nama_prioritas', 'ASC')
            ->get();
          $data['menu_obj'] = new MethodController();
        break;
        case 'menu':
          $data['menu'] = DB::table('menu')
            ->orderBy('nama_menu', 'ASC')
            ->skip(0)->take(3)->get();
          foreach ($data['menu'] as $key => $value) {
            $data[$key]['menu-status'] = DB::table('menu')
            ->select('bahan_baku.nama_bahan_baku', 'bahan_baku.stok_bahan_baku')
            ->join('bahan_baku_detil', 'bahan_baku_detil.kode_menu', '=', 'menu.kode_menu')
            ->join('bahan_baku', 'bahan_baku.kode_bahan_baku', '=', 'bahan_baku_detil.kode_bahan_baku')
            ->where('menu.kode_menu', '=', $value->kode_menu)
            ->get();
          }
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
        case 'order':
          $data['order'] = DB::table('pesanan')
            ->select('pesanan.*', 'perangkat.nama_perangkat')
            ->join('perangkat', 'pesanan.kode_perangkat', '=', 'perangkat.kode_perangkat')
            ->orderBy('tanggal_pesanan', 'ASC')
            ->orderBy('waktu_pesanan', 'ASC')
            ->where('pesanan.status_pesanan', '=', 'P')
            ->skip(0)->take(7)->get();
          $data['order-detail'] = DB::table('pesanan')
            ->select('pesanan_detil.*', 'menu.*')
            ->join('pesanan_detil', 'pesanan.kode_pesanan', '=', 'pesanan_detil.kode_pesanan')
            ->join('menu', 'pesanan_detil.kode_menu', '=', 'menu.kode_menu')
            ->orderBy('tanggal_pesanan', 'ASC')
            ->orderBy('waktu_pesanan', 'ASC')
            ->where('pesanan.status_pesanan', '=', 'P')
            ->skip(0)->take(20)->get();
          $data['order-detail-food'] = DB::table('pesanan')
            ->select('pesanan_detil.*', 'menu.*')
            ->join('pesanan_detil', 'pesanan.kode_pesanan', '=', 'pesanan_detil.kode_pesanan')
            ->join('menu', 'pesanan_detil.kode_menu', '=', 'menu.kode_menu')
            ->where('menu.jenis_menu', '=', 'F')
            ->get();
          $data['order-detail-drink'] = DB::table('pesanan')
            ->select('pesanan_detil.*', 'menu.*')
            ->join('pesanan_detil', 'pesanan.kode_pesanan', '=', 'pesanan_detil.kode_pesanan')
            ->join('menu', 'pesanan_detil.kode_menu', '=', 'menu.kode_menu')
            ->where('menu.jenis_menu', '=', 'D')
            ->get();
          $data['order-confirmation'] = DB::table('pesanan')
            ->select('pesanan.*', 'perangkat.nama_perangkat')
            ->join('perangkat', 'pesanan.kode_perangkat', '=', 'perangkat.kode_perangkat')
            ->orderBy('tanggal_pesanan', 'ASC')
            ->orderBy('waktu_pesanan', 'ASC')
            ->where('pesanan.status_pesanan', '=', 'C')
            ->skip(0)->take(2)->get();
          foreach ($data['order-confirmation'] as $key => $value) {
            $data[$key]['order-confirmation-detail'] = DB::table('pesanan')
              ->select('pesanan_detil.*', 'menu.*')
              ->join('pesanan_detil', 'pesanan.kode_pesanan', '=', 'pesanan_detil.kode_pesanan')
              ->join('menu', 'pesanan_detil.kode_menu', '=', 'menu.kode_menu')
              ->where('pesanan.kode_pesanan', '=', $data['order-confirmation'][$key]->kode_pesanan)
              ->get();
          }
          $data['menu_obj'] = new MethodController();
        break;
        case 'transaction':
          $data['transaction'] = DB::table('pesanan')
            ->select('pesanan.*', 'perangkat.nama_perangkat')
            ->join('perangkat', 'pesanan.kode_perangkat', '=', 'perangkat.kode_perangkat')
            ->orderBy('tanggal_pesanan', 'ASC')
            ->orderBy('waktu_pesanan', 'ASC')
            ->where('pesanan.status_pesanan', '=', 'T')
            ->skip(0)->take(1)->get();
          foreach ($data['transaction'] as $key => $value) {
            $data[$key]['transaction-detail'] = DB::table('pesanan')
              ->select('pesanan_detil.*', 'menu.*')
              ->join('pesanan_detil', 'pesanan.kode_pesanan', '=', 'pesanan_detil.kode_pesanan')
              ->join('menu', 'pesanan_detil.kode_menu', '=', 'menu.kode_menu')
              ->where('pesanan.kode_pesanan', '=', $data['transaction'][$key]->kode_pesanan)
              ->get();
          }
          $data['transaction-history'] = DB::table('pesanan')
            ->select('pesanan.*', 'perangkat.nama_perangkat')
            ->join('perangkat', 'pesanan.kode_perangkat', '=', 'perangkat.kode_perangkat')
            ->orderBy('tanggal_pesanan', 'ASC')
            ->orderBy('waktu_pesanan', 'ASC')
            ->where('pesanan.status_pesanan', '=', 'D')
            ->skip(0)->take(2)->get();
          foreach ($data['transaction-history'] as $key => $value) {
            $data[$key]['transaction-history-detail'] = DB::table('pesanan')
              ->select('pesanan_detil.*', 'menu.*')
              ->join('pesanan_detil', 'pesanan.kode_pesanan', '=', 'pesanan_detil.kode_pesanan')
              ->join('menu', 'pesanan_detil.kode_menu', '=', 'menu.kode_menu')
              ->where('pesanan.kode_pesanan', '=', $data['transaction-history'][$key]->kode_pesanan)
              ->get();
          }
          $data['menu_obj'] = new MethodController();
        break;
        case 'report':
          $data['report-type'] = DB::table('jenis_laporan')
            ->orderBy('urutan_jenis_laporan', 'ASC')
            ->get();
        break;
        case 'review':
        $data['review'] = DB::table('kuisioner')
          ->orderBy('tanggal_kuisioner', 'ASC')
          ->orderBy('waktu_kuisioner', 'ASC')
          ->skip(0)->take(5)->get();
        foreach ($data['review'] as $key => $value) {
          $data[$key]['review-detail'] = DB::table('kuisioner_detil')
            ->where('kuisioner_detil.kode_kuisioner', '=', $data['review'][$key]->kode_kuisioner)
            ->get();
        }
        break;
        default:
          $data['unknown'] = null;
        break;
      }
      return view('dashboard.' . $param, ['pages' => $pages, 'page' => $param, 'data' => $data]);
    }
    return abort(404);
  }

  public function update(Request $request, $param) {
    switch ($param) {
      case 'profile':
        $id = $request->get('employee-id');
        $employee = Pegawai::findOrFail($id);
        if ($employee) {
          $this->validate($request, [
            'employee-name' => 'required|min:4',
            'employee-password' => 'required|min:6',
            'employee-gender' => 'required'
          ]);

          $try = Pegawai::find($id)->update([
            'nama_pegawai' => $request->get('employee-name'),
            'kata_sandi_pegawai' => Hash::make($request->get('employee-password')),
            'jenis_kelamin_pegawai' => $request->get('employee-gender')
          ]);
        }
        return redirect('/dashboard');
      break;
      case 'device':
        $id = $request->get('device-id');
        $device = Perangkat::findOrFail($id);
        if ($device) {
          $pw = $request->get('device-change-password');
          if (strlen($pw) > 0) {
            $this->validate($request, [
              'device-change-name' => 'required|min:4',
              'device-change-password' => 'required|min:6',
              'device-change-chair' => 'required|min:1',
              'device-change-status' => 'required'
            ]);
            $try = Perangkat::find($id)->update([
              'nama_perangkat' => $request->get('device-change-name'),
              'kata_sandi_perangkat' => Hash::make($request->get('device-change-password')),
              'jumlah_kursi_perangkat' => $request->get('device-change-chair'),
              'status_perangkat' => $request->get('device-change-status')
            ]);
          }
          else {
            $this->validate($request, [
              'device-change-name' => 'required|min:4',
              'device-change-chair' => 'required|min:1',
              'device-change-status' => 'required'
            ]);
            $try = Perangkat::find($id)->update([
              'nama_perangkat' => $request->get('device-change-name'),
              'jumlah_kursi_perangkat' => $request->get('device-change-chair'),
              'status_perangkat' => $request->get('device-change-status')
            ]);
          }

        }
        return redirect('/dashboard/device');
      break;
      case 'employee':
        $id = $request->get('employee-id');
        $employee = Pegawai::findOrFail($id);
        if ($employee) {
          $pw = $request->get('employee-change-password');
          if (strlen($pw) > 0) {
            $this->validate($request, [
              'employee-change-name' => 'required|min:4',
              'employee-change-gender' => 'required|min:1',
              'employee-change-password' => 'required|min:6',
              'employee-change-authority' => 'required|min:1'
            ]);
            $try = Pegawai::find($id)->update([
              'nama_pegawai' => $request->get('employee-change-name'),
              'kata_sandi_pegawai' => Hash::make($request->get('employee-change-password')),
              'jenis_kelamin_pegawai' => $request->get('employee-change-gender'),
              'kode_otoritas' => $request->get('employee-change-authority')
            ]);
          }
          else {
            $this->validate($request, [
              'employee-change-name' => 'required|min:4',
              'employee-change-gender' => 'required|min:1',
              'employee-change-authority' => 'required|min:1'
            ]);
            $try = Pegawai::find($id)->update([
              'nama_pegawai' => $request->get('employee-change-name'),
              'jenis_kelamin_pegawai' => $request->get('employee-change-gender'),
              'kode_otoritas' => $request->get('employee-change-authority')
            ]);
          }

        }
        return redirect('/dashboard/employee');
      break;
      default:break;
    }
  }

  public function create(Request $request) {

  }

  public function delete(Request $request, $param, $id) {
    switch ($param) {
      case 'device':
        $device = Perangkat::find($id);
        if ($device) {
          Perangkat::destroy($id);
        }
        return redirect('/dashboard/device');
      break;
      case 'employee':
        $employee = Pegawai::find($id)->delete();
        if ($employee) {
          Pegawai::destroy($id);
        }
        return redirect('/dashboard/employee');
      break;
      default:break;
    }
  }

}
