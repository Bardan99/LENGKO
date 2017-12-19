<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\BahanBaku;
use App\Pegawai;
use App\Perangkat;
use App\Menu;
use App\MenuDetil;
use App\Review;
use App\ReviewDevice;
use App\ReviewDetil;
use App\Pemberitahuan;
use Auth;
use Validator;
use Hash;

class DashboardController extends Controller {

  public function __construct() {
      $this->middleware('employee'); //defined on route middleware
  }

  public function index() {
    if (view()->exists('dashboard.home')) {
      $navbar = new MethodController;
      $pages = $navbar->get_navbar(Auth::guard('employee')->user()->kode_otoritas);
      $data['employee'] = Pegawai::where('kode_pegawai', Auth::guard('employee')->user()->kode_pegawai)
                          ->join('otoritas', 'otoritas.kode_otoritas', '=', 'pegawai.kode_otoritas')
                          ->first();
      $data['notification'] = Pemberitahuan::orderBy('kode_pemberitahuan', 'DESC')
                          ->orderBy('tanggal_pemberitahuan', 'DESC')
                          ->skip(0)->take(10)->get();
      return view('dashboard.home', ['data' => $data, 'pages' => $pages, 'page' => '/']);
    }
    return abort(404);
  }

  public function view($param) {
    if (view()->exists('dashboard.' . $param)) {
      $navbar = new MethodController;
      $pages = $navbar->get_navbar(Auth::guard('employee')->user()->kode_otoritas);
      $access = false;
      foreach ($pages as $key => $value) {
        if ($param == $value->kode_halaman) {
          $access = true;
        }
      }
      if (!$access) {
        return abort(403);
      }
      else {
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
              ->where('pegawai.kode_pegawai', '!=', Auth::guard('employee')->user()->kode_pegawai) //yg login gk boleh hapus datanya sendiri
              ->orderBy('nama_pegawai', 'ASC')
              ->skip(0)->take(8)->get();
            $data['authority'] = DB::table('otoritas')
              ->orderBy('nama_otoritas', 'ASC')
              ->get();
          break;
          case 'material':
            $data['material'] = DB::table('bahan_baku')
              ->orderBy('tanggal_kadaluarsa_bahan_baku', 'ASC')
              ->skip(0)->take(7)->get();
            $data['material-request'] = DB::table('pengadaan_bahan_baku')
              ->join('prioritas', 'prioritas.kode_prioritas', '=', 'pengadaan_bahan_baku.kode_prioritas')
              ->orderBy('pengadaan_bahan_baku.kode_prioritas', 'ASC')
              ->orderBy('pengadaan_bahan_baku.tanggal_pengadaan_bahan_baku', 'DSC')
              ->where('pengadaan_bahan_baku.status_pengadaan_bahan_baku', '=', 0)
              ->get();
            if ($data['material-request']) {
              foreach ($data['material-request'] as $key => $value) {
                $data[$key]['material-request-detail'] = DB::table('pengadaan_bahan_baku_detil')
                  ->orderBy('nama_bahan_baku', 'ASC')
                  ->where('kode_pengadaan_bahan_baku', '=', $value->{'kode_pengadaan_bahan_baku'})
                  ->get();
              }
            }
            $data['material-request-user'] = DB::table('pengadaan_bahan_baku')
              ->join('prioritas', 'prioritas.kode_prioritas', '=', 'pengadaan_bahan_baku.kode_prioritas')
              //->where('pengadaan_bahan_baku.kode_pegawai', '=', '')
              ->orderBy('pengadaan_bahan_baku.kode_prioritas', 'ASC')
              ->orderBy('pengadaan_bahan_baku.tanggal_pengadaan_bahan_baku', 'DSC')
              ->where('pengadaan_bahan_baku.status_pengadaan_bahan_baku', '=', 0)
              ->get();
            if ($data['material-request-user']) {
              foreach ($data['material-request-user'] as $key => $value) {
                $data[$key]['material-request-user-detail'] = DB::table('pengadaan_bahan_baku_detil')
                  ->orderBy('nama_bahan_baku', 'ASC')
                  ->where('kode_pengadaan_bahan_baku', '=', $value->{'kode_pengadaan_bahan_baku'})
                  ->get();
              }
            }
            $data['material-expired-soon'] = DB::table('bahan_baku')
              ->orderBy('tanggal_kadaluarsa_bahan_baku', 'ASC')
              ->where('tanggal_kadaluarsa_bahan_baku', '>=', date('Y-m-d'))
              ->where('tanggal_kadaluarsa_bahan_baku', '<=', date('Y-m-d', strtotime('+7 days')))
              ->get();
            $data['material-expired'] = DB::table('bahan_baku')
              ->orderBy('tanggal_kadaluarsa_bahan_baku', 'ASC')
              ->where('tanggal_kadaluarsa_bahan_baku', '<', date('Y-m-d'))
              ->get();
            $data['material-almost-empty'] = DB::table('bahan_baku')
              ->orderBy('tanggal_kadaluarsa_bahan_baku', 'ASC')
              ->where('stok_bahan_baku', '>', 0)
              ->where('stok_bahan_baku', '<=', 20)
              ->get();
            $data['material-empty'] = DB::table('bahan_baku')
              ->orderBy('tanggal_kadaluarsa_bahan_baku', 'ASC')
              ->where('stok_bahan_baku', '=', 0)
              ->get();
            $data['priority'] = DB::table('prioritas')
              ->orderBy('nama_prioritas', 'ASC')
              ->get();
            $data['method'] = new MethodController();
          break;
          case 'menu':
            $data['menu'] = DB::table('menu')
              ->orderBy('nama_menu', 'ASC')
              ->skip(0)->take(3)->get();
            foreach ($data['menu'] as $key => $value) {
              $data[$key]['menu-material'] = DB::table('menu')
              ->select('menu_detil.*')
              ->join('menu_detil', 'menu_detil.kode_menu', '=', 'menu.kode_menu')
              ->where('menu.kode_menu', '=', $value->kode_menu)
              ->get();
            }

            foreach ($data['menu'] as $key => $value) {
              $data[$key]['menu-status'] = DB::table('menu')
              ->select('bahan_baku.nama_bahan_baku', 'bahan_baku.stok_bahan_baku')
              ->join('menu_detil', 'menu_detil.kode_menu', '=', 'menu.kode_menu')
              ->join('bahan_baku', 'bahan_baku.kode_bahan_baku', '=', 'menu_detil.kode_bahan_baku')
              ->where('menu.kode_menu', '=', $value->kode_menu)
              ->get();
            }
            $data['material'] = DB::table('bahan_baku')
              ->orderBy('nama_bahan_baku', 'ASC')
              ->get();

            $data['method'] = new MethodController();
          break;
          case 'order':
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
            $data['method'] = new MethodController();
          break;
          case 'transaction':
            $data['transaction'] = DB::table('pesanan')
              ->select('pesanan.*', 'perangkat.nama_perangkat')
              ->join('perangkat', 'pesanan.kode_perangkat', '=', 'perangkat.kode_perangkat')
              ->orderBy('tanggal_pesanan', 'ASC')
              ->orderBy('waktu_pesanan', 'ASC')
              ->where('pesanan.status_pesanan', '=', 'T')
              ->get();
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
              ->skip(0)->take(5)->get();
            foreach ($data['transaction-history'] as $key => $value) {
              $data[$key]['transaction-history-detail'] = DB::table('pesanan')
                ->select('pesanan_detil.*', 'menu.*')
                ->join('pesanan_detil', 'pesanan.kode_pesanan', '=', 'pesanan_detil.kode_pesanan')
                ->join('menu', 'pesanan_detil.kode_menu', '=', 'menu.kode_menu')
                ->where('pesanan.kode_pesanan', '=', $data['transaction-history'][$key]->kode_pesanan)
                ->get();
            }
            $data['method'] = new MethodController();
          break;
          case 'report':
            $data['unknown'] = null;
          break;
          case 'review':
            $data['review'] = DB::table('kuisioner')
              ->orderBy('tanggal_kuisioner', 'ASC')
              ->orderBy('waktu_kuisioner', 'ASC')
              ->get();

            $data['review-device'] = DB::table('kuisioner_perangkat')
              ->orderBy('tanggal_kuisioner_perangkat', 'ASC')
              ->orderBy('waktu_kuisioner_perangkat', 'ASC')
              ->skip(0)->take(5)->get();

            foreach ($data['review-device'] as $key => $value) {
              $data[$key]['review-detail'] = DB::table('kuisioner_detil')
                ->join('kuisioner', 'kuisioner.kode_kuisioner', '=', 'kuisioner_detil.kode_kuisioner')
                ->where('kuisioner_detil.kode_kuisioner_perangkat', '=', $value->kode_kuisioner_perangkat)
                ->get();
            }

            $data['review-status'] = DB::table('kuisioner')
              ->orderBy('tanggal_kuisioner', 'ASC')
              ->orderBy('waktu_kuisioner', 'ASC')
              ->where('status_kuisioner', '=', '1')
              ->get();

          break;
          default:
            $data['unknown'] = null;
          break;
        }
        return view('dashboard.' . $param, ['pages' => $pages, 'page' => $param, 'data' => $data, 'auth' => Auth::guard('employee')->user()->kode_otoritas]);
      }
    }
    return abort(404);
  }

  public function update(Request $request, $param) {
    switch ($param) {
      case 'profile':
        $id = $request->get('employee-id');
        $employee = Pegawai::findOrFail($id);
        if ($employee) {
          $rules = [
            'employee-name' => 'required|min:4',
            'employee-password' => 'required|min:4',
            'employee-gender' => 'required'
          ];

          $data = [
            'nama_pegawai' => $request->get('employee-name'),
            'kata_sandi_pegawai' => Hash::make($request->get('employee-password')),
            'jenis_kelamin_pegawai' => $request->get('employee-gender'),
          ];

          $file = $request->file('employee-photo');
          if ($file) {
            $fileName   = strtolower(str_replace(" ", "-", $data['nama_pegawai'])) . '.' . $file->getClientOriginalExtension();
            $request->file('employee-photo')->move("files/images/employee", $fileName);
            $data['gambar_pegawai'] = $fileName;
            //$rules['employee-photo'] = 'mimes:jpeg,png|required|image|max:2048';
          }
          $this->validate($request, $rules);
          $try = Pegawai::find($id)->update($data);
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
              'employee-change-password' => 'required|min:4',
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
      case 'material':
        $id = $request->get('material-id');
        $material = BahanBaku::findOrFail($id);
        if ($material) {
          $this->validate($request, [
            'material-change-name' => 'required|min:3',
            'material-change-stock' => 'required|min:1',
            'material-change-unit' => 'required|min:1',
            'material-change-date' => 'required'
          ]);
          $try = BahanBaku::find($id)->update([
            'nama_bahan_baku' => $request->get('material-change-name'),
            'stok_bahan_baku' => $request->get('material-change-stock'),
            'satuan_bahan_baku' => $request->get('material-change-unit'),
            'tanggal_kadaluarsa_bahan_baku' => $request->get('material-change-date')
          ]);
        }
        return redirect('/dashboard/material');
      break;
      case 'menu':
        $id = $request->get('menu-change-id');
        $menu = Menu::findOrFail($id);
        if ($menu) {
          $rules = [
            'menu-change-name' => 'required|min:4',
            'menu-change-price' => 'required|min:1',
            'menu-change-description' => 'required',
            'menu-change-type' => 'required'
          ];

          $data = [
            'nama_menu' => $request->get('menu-change-name'),
            'harga_menu' => $request->get('menu-change-price'),
            'deskripsi_menu' => $request->get('menu-change-description'),
            'jenis_menu' => $request->get('menu-change-type')
          ];

          $file = $request->file('menu-change-thumbnail');
          if ($file) {
            $fileName   = strtolower(str_replace(" ", "-", $data['nama_menu'])) . '.' . $file->getClientOriginalExtension();
            $request->file('menu-change-thumbnail')->move("files/images/menus", $fileName);
            $data['gambar_menu'] = $fileName;
            $rules['menu-change-thumbnail'] = 'required';
          }
          $this->validate($request, $rules);
          $try = Menu::find($id)->update($data);

          $available = false;

          for ($i = 0 ;$i < $request->get('menu-material-max'); $i++) {
            if ($request->get('menu-material-change-count-' . $i) > 0) {
              $detil[] = array(
                'kode_menu' => $id,
                'kode_bahan_baku' => $request->get('menu-material-change-id-' . $i),
                'jumlah_bahan_baku_detil' => $request->get('menu-material-change-count-' . $i)
              );
              $available = true;
            }
          }

          if ($available) {
            $try = MenuDetil::where(['kode_menu' => $id])->delete();
            $try = MenuDetil::insert($detil);
          }

        }
        return redirect('/dashboard/menu');
      break;
      case 'reviewdevice':
        $id = $request->get('_id');
        $handler = ReviewDevice::find($id);
        if ($handler) {
          $status = 1;
          if ($handler->status_kuisioner_perangkat == 1) {
            $status = 0;
          }
          $try = ReviewDevice::find($id)->update([
            'status_kuisioner_perangkat' => $status,
          ]);
        }
        return redirect('/dashboard/review');
      break;
      default:break;
    }
  }

  public function delete(Request $request, $param, $id) {
    switch ($param) {
      case 'device':
        $handler = Perangkat::find($id);
        if ($handler) {
          Perangkat::destroy($id);
        }
        return redirect('/dashboard/device');
      break;
      case 'employee':
        $handler = Pegawai::find($id)->delete();
        if ($handler) {
          Pegawai::destroy($id);
        }
        return response()->json(['status' => 200, 'text' => 'Berhasil menghapus pegawai']);
      break;
      case 'material':
        $handler = BahanBaku::find($id)->delete();
        if ($handler) {
          BahanBaku::destroy($id);
        }
        return redirect('/dashboard/material');
      break;
      case 'menu':
        $handler = Menu::find($id);
        if ($handler) {
          $try = Menu::destroy($id);
          return response()->json(['status' => 200, 'text' => 'Berhasil menghapus menu']);
        }
        else {
          return response()->json(['status' => 400, 'text' => 'Menu tidak ditemukan.']);
        }
      break;
      case 'review':
        $handler = Review::find($id);
        if ($handler) {
          $try = Review::destroy($id);
          return response()->json(['status' => 200, 'text' => 'Berhasil menghapus kuisioner']);
        }
        else {
          return response()->json(['status' => 400, 'text' => 'Kuisioner tidak ditemukan.']);
        }
      break;
      case 'reviewdevice':
        $handler = ReviewDevice::find($id);
        if ($handler) {
          $try = ReviewDevice::destroy($id);
          return response()->json(['status' => 200, 'text' => 'Berhasil menghapus hasil kuisioner']);
        }
        else {
          return response()->json(['status' => 400, 'text' => 'Hasil kuisioner tidak ditemukan.']);
        }
      break;
      default:break;
    }
  }

  public function filterdevice(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $validator = Validator::make($data, [
        '_keyword' => 'required'
      ]);

      if ($validator->fails()) {
        return response()
          ->json([
            'status' => 500,
            'text' => 'Oops, terjadi sesuatu'
        ]);
      }
      else {
        switch ($data['_keyword']) {
          case '*':
            $devices = DB::table('perangkat')
              ->orderBy('nama_perangkat', 'ASC')
              ->select('*',
                DB::raw(
                  'IF (status_perangkat = "1", "available", IF (status_perangkat = "0", "unavailable", "disabled")) AS status_text,
                  IF (status_perangkat = "1", "Tersedia", IF (status_perangkat = "0", "Tidak Tersedia", "Tidak Diketahui")) AS status_text_human'
                  ))
              ->get();
          break;
          default:
          $devices = DB::table('perangkat')
            ->where('status_perangkat', '=', $data['_keyword'])
            ->orderBy('nama_perangkat', 'ASC')
            ->select('*',
              DB::raw(
                'IF (status_perangkat = "1", "available", IF (status_perangkat = "0", "unavailable", "disabled")) AS status_text,
                IF (status_perangkat = "1", "Tersedia", IF (status_perangkat = "0", "Tidak Tersedia", "Tidak Diketahui")) AS status_text_human'
                ))
            ->get();
          break;
        }

        return response()->json([
            'status' => 200,
            'text' => 'Pencarian selesai dilakukan',
            'content' => $devices,
            'auth' => Auth::guard('employee')->user()->kode_otoritas
          ]);

      }
    }//endif
  }

  public function getnotification(Request $request) {
    $notification = Pemberitahuan::orderBy('kode_pemberitahuan', 'DESC')
      ->orderBy('tanggal_pemberitahuan', 'DESC')
      ->whereRaw('tanggal_pemberitahuan >= NOW() - INTERVAL 1 HOUR')
      ->get();
    return response()->json([
        'status' => 200,
        'content' => $notification
      ]);
  }

}
