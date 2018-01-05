<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Review;
use App\ReviewDevice;
use App\ReviewDetil;
use App\Menu;
use App\Pesanan;
use App\PesananDetil;
use App\Perangkat;
use App\Pemberitahuan;
use Session;

class HomeController extends Controller {
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct() {
      $this->middleware('device'); //defined on route middleware
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */

   public function get_order(Request $request) {
      $order = [];
      $hold = $request->session()->get('order');
      if (count($hold) > 0) {
        foreach ($hold as $key => $value) {
          $order[$key] = Menu::where('kode_menu', '=', $hold[$key]['id'])->get()->first();
          $order[$key]['jumlah_pesanan_detil'] = $hold[$key]['count'];
        }
      }
      return $order;
   }
   public function index(Request $request) {
     if (view()->exists('home')) {
       $data['page'] = '';
       return view('home', ['data' => $data, 'device' => Auth::guard('device')->user(), 'order' => $this->get_order($request)]);
     }
     return abort(404);
   }

  public function view($param, Request $request) {
    if (view()->exists($param)) {
      $data['page'] = $param;
      switch ($param) {
        case 'gallery':
          $data['gallery'] =
          (object) array(
              (object) array(
                'path' => 'gallery13-kfc.jpg',
                'title' => 'LENGKO Crown',
                'desc' => 'Mahkota kebanggaan kami yang senantiasa menjadi penyemangat dalam menyelesaikan pembangunan aplikasi ini, thank you so much Mr. Adam'
              ),
              (object) array(
                'path' => 'gallery11-our-beloved-campus.jpg',
                'title' => 'Our beloved campus',
                'desc' => 'Quality is our tradition, it\'s a must! Sebetulnya kami bingung mau tulis apa di bagian ini, tapi ya sudahlah. Semoga kampus kami tidak pelit koneksi internet, internet cepet buat apa? pak sekarang zamannya Cloud! Orang-orang udah pergi ke venus kami masih di bumi aja pak :('
              ),
              (object) array(
                'path' => 'gallery12-what.jpg',
                'title' => 'Mr. Soegoto favourite place',
                'desc' => 'Tempat favorit Mr. Soegoto untuk parkir mobil. Sebetulnya kenapa Mr. Soegoto senang sekali menyimpan mobilnya di situ, ini masih menjadi sebuah misteri! Tidak tahu kenapa, hanya ingin menambahkan gambar ini saja; sepertinya kami jatuh cinta!'
              ),
              (object) array(
                'path' => 'gallery9-refreshing-after-meeting.jpg',
                'title' => 'After Scrum Meeting',
                'desc' => 'Kami, sang pujangga, setelah melakukan scrum meeting di Teras Cihampelas. Niatnya sih mau ke Mujigae, cuma pada bandel gk bawa duit; Zak sendalmu mana? btw Azmi yang fotoin!'
              ),
              (object) array(
                'path' => 'gallery10-our-beloved-team.jpg',
                'title' => 'Our beloved team',
                'desc' => 'Ini kami, sang penantang yang gagah berani! Btw senyummu mempesona zak; copy of Raka(1) jangan ngumpet aja nanti diculik :3'
              ),
              (object) array(
                'path' => 'gallery14-library.jpg',
                'title' => 'Untung bukan Brazzer captionnya',
                'desc' => 'Azmi pengen eksis katanya, ywdh masukin aja foto ini, Binsar yang fotoin.'
              )
          );
        break;
        case 'menu':
          $data['menu'] = DB::table('menu')
          ->orderBy('nama_menu', 'ASC')
          ->skip(0)->take(9)->get();

          foreach ($data['menu'] as $key => $value) {
            $data[$key]['menu-material'] = DB::table('menu')
            ->select('menu_detil.*')
            ->join('menu_detil', 'menu_detil.kode_menu', '=', 'menu.kode_menu')
            ->where('menu.kode_menu', '=', $value->kode_menu)
            ->get();
          }

          foreach ($data['menu'] as $key => $value) {
            $data[$key]['menu-status'] = DB::table('menu')
            ->select('bahan_baku.*')
            ->join('menu_detil', 'menu_detil.kode_menu', '=', 'menu.kode_menu')
            ->join('bahan_baku', 'bahan_baku.kode_bahan_baku', '=', 'menu_detil.kode_bahan_baku')
            ->where('menu.kode_menu', '=', $value->kode_menu)
            ->get();
          }

          foreach ($data['menu'] as $key => $value) {
            $data[$key]['menu-max'] = DB::table('bahan_baku')
            ->selectRaw('*, FLOOR(bahan_baku.stok_bahan_baku/menu_detil.jumlah_bahan_baku_detil) AS menu_max')
            ->join('menu_detil', 'menu_detil.kode_bahan_baku', '=', 'bahan_baku.kode_bahan_baku')
            ->where('menu_detil.kode_menu', '=', $value->kode_menu)
            ->get();
            foreach ($data[$key]['menu-max'] as $key2 => $value2) {
              if ($key2+1 < count($data[$key]['menu-max'])) {
                if ($value2->menu_max > $data[$key]['menu-max'][$key2+1]->menu_max) {
                  $data['menu'][$key]->menu_max = $data[$key]['menu-max'][$key2+1]->menu_max;//ambil yg minimum
                }
              }
            }
          }

          $data['method'] = new MethodController();
        case 'order':
          $data['order-processed'] = DB::table('pesanan')
            ->select('pesanan.*', 'perangkat.nama_perangkat')
            ->join('perangkat', 'pesanan.kode_perangkat', '=', 'perangkat.kode_perangkat')
            ->orderBy('tanggal_pesanan', 'ASC')
            ->orderBy('waktu_pesanan', 'ASC')
            ->where(function ($qry) {
              $qry->orwhere('pesanan.status_pesanan', '=', 'C')
              ->orwhere('pesanan.status_pesanan', '=', 'P')
              ->orwhere('pesanan.status_pesanan', '=', 'T');
            })
            ->where('pesanan.kode_perangkat', '=',  Auth::guard('device')->user()->kode_perangkat)
            ->get();
          foreach ($data['order-processed'] as $key => $value) {
            $data[$key]['order-processed-detail'] = DB::table('pesanan')
              ->select('pesanan_detil.*', 'menu.*')
              ->join('pesanan_detil', 'pesanan.kode_pesanan', '=', 'pesanan_detil.kode_pesanan')
              ->join('menu', 'pesanan_detil.kode_menu', '=', 'menu.kode_menu')
              ->where('pesanan.kode_pesanan', '=', $data['order-processed'][$key]->kode_pesanan)
              ->orderBy('menu.jenis_menu', 'ASC')
              ->get();
          }
          $data['method'] = new MethodController();
        break;
        case 'reviews':
          $data['review'] = DB::table('kuisioner')
            ->orderBy('judul_kuisioner', 'ASC')
            ->where('status_kuisioner', '=', "1")
            ->get();

          $data['customer-reviews'] = DB::table('kuisioner_perangkat')
            ->orderBy('tanggal_kuisioner_perangkat', 'DSC')
            ->orderBy('waktu_kuisioner_perangkat', 'DSC')
            ->where('status_kuisioner_perangkat', '=', "1")
            ->skip(0)->take(2)->get();

          foreach ($data['customer-reviews'] as $key => $value) {
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

          $data['method'] = new MethodController();
        break;
        default:
          $data['unknown'] = null;
        break;
      }

      return view($param, ['data' => $data, 'device' => Auth::guard('device')->user(), 'order' => $this->get_order($request)]);
    }
    return abort(404);
  }

  public function searchmenu(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $keyword = '%' . $data['menu-search-query'] . '%';

      if ($data['menu-search-query'] === "" || $data['menu-search-query'] === " ") {
        $result = DB::table('menu')
          ->orderBy('nama_menu', 'ASC')
          ->skip(0)->take(9)->get();
        $prev = DB::table('menu')
          ->orderBy('nama_menu', 'ASC')
          ->skip(count($result) - 9)->take(9)->get();
        $next = DB::table('menu')
          ->orderBy('nama_menu', 'ASC')
          ->skip(count($result) + 9)->take(9)->get();
      }
      else {
        $result = DB::table('menu')
          ->where('kode_menu', 'LIKE', $keyword)
          ->orwhere('nama_menu', 'LIKE', $keyword)
          ->orwhere('harga_menu', 'LIKE', $keyword)
          ->orwhere('deskripsi_menu', 'LIKE', $keyword)
          ->orderBy('nama_menu', 'ASC')
          ->skip(0)->take(9)->get();
        $prev = DB::table('menu')
          ->where('kode_menu', 'LIKE', $keyword)
          ->orwhere('nama_menu', 'LIKE', $keyword)
          ->orwhere('harga_menu', 'LIKE', $keyword)
          ->orwhere('deskripsi_menu', 'LIKE', $keyword)
          ->orderBy('nama_menu', 'ASC')
          ->skip(count($result) - 9)->take(9)->get();
        $next = DB::table('menu')
          ->orderBy('nama_menu', 'ASC')
          ->where('kode_menu', 'LIKE', $keyword)
          ->orwhere('nama_menu', 'LIKE', $keyword)
          ->orwhere('harga_menu', 'LIKE', $keyword)
          ->orwhere('deskripsi_menu', 'LIKE', $keyword)
          ->skip(count($result) + 9)->take(9)->get();
      }

      foreach ($result as $key => $value) {
        $tmp[$key]['menu-material'] = DB::table('menu')
        ->select('menu_detil.*')
        ->join('menu_detil', 'menu_detil.kode_menu', '=', 'menu.kode_menu')
        ->where('menu.kode_menu', '=', $value->kode_menu)
        ->get();
      }

      foreach ($result as $key => $value) {
        $tmp[$key]['menu-status'] = DB::table('menu')
        ->select('bahan_baku.*')
        ->join('menu_detil', 'menu_detil.kode_menu', '=', 'menu.kode_menu')
        ->join('bahan_baku', 'bahan_baku.kode_bahan_baku', '=', 'menu_detil.kode_bahan_baku')
        ->where('menu.kode_menu', '=', $value->kode_menu)
        ->get();
      }

      foreach ($result as $key => $value) {
        $data[$key]['menu-max'] = DB::table('bahan_baku')
        ->selectRaw('*, FLOOR(bahan_baku.stok_bahan_baku/menu_detil.jumlah_bahan_baku_detil) AS menu_max')
        ->join('menu_detil', 'menu_detil.kode_bahan_baku', '=', 'bahan_baku.kode_bahan_baku')
        ->where('menu_detil.kode_menu', '=', $value->kode_menu)
        ->get();
        foreach ($data[$key]['menu-max'] as $key2 => $value2) {
          if ($key2+1 < count($data[$key]['menu-max'])) {
            if ($value2->menu_max > $data[$key]['menu-max'][$key2+1]->menu_max) {
              $result[$key]->menu_max = $data[$key]['menu-max'][$key2+1]->menu_max;//ambil yg minimum
            }
          }
        }
      }

      $pointer['prev']['skip'] = count($result) - 9;
      $pointer['prev']['take'] = 9;

      $pointer['next']['skip'] = count($result) + 9;
      $pointer['next']['take'] = 9;

      if ($result) {
        return response()->json([
            'status' => 200,
            'text' => 'Pencarian selesai dilakukan',
            'content' => $result,
            'available' => $tmp,
            'prev' => $prev,
            'next' => $next,
            'pointer' => $pointer
          ]);
      }

    }
  }

  public function pagemenu(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $keyword = '%' . $data['_keyword'] . '%';
      $category = $data['_category'];
      $skip = $data['_skip'];
      $take = $data['_take'];

      switch ($data['_keyword']) {
        case ' ':
          switch ($category) {
            case 'A':
              $result = DB::table('menu')
                ->orderBy('nama_menu', 'ASC')
                ->skip($skip)->take($take)->get();
              $prev = DB::table('menu')
                ->orderBy('nama_menu', 'ASC')
                ->skip($skip - 9)->take($take)->get();
              $next = DB::table('menu')
                ->orderBy('nama_menu', 'ASC')
                ->skip($skip + 9)->take($take)->get();
            break;
            default:
              $result = DB::table('menu')
                ->where('jenis_menu', 'LIKE', $category)
                ->orderBy('nama_menu', 'ASC')
                ->skip($skip)->take($take)->get();
              $prev = DB::table('menu')
                ->where('jenis_menu', 'LIKE', $category)
                ->orderBy('nama_menu', 'ASC')
                ->skip($skip - 9)->take($take)->get();
              $next = DB::table('menu')
                ->where('jenis_menu', 'LIKE', $category)
                ->orderBy('nama_menu', 'ASC')
                ->skip($skip + 9)->take($take)->get();
            break;
          }
        break;
        default:
          switch ($category) {
            case 'A':
              $result = DB::table('menu')
                ->where(function ($qry) use ($keyword) {
                  $qry ->orwhere('kode_menu', 'LIKE', $keyword)
                  ->orwhere('nama_menu', 'LIKE', $keyword)
                  ->orwhere('harga_menu', 'LIKE', $keyword)
                  ->orwhere('deskripsi_menu', 'LIKE', $keyword);
                })
                ->orderBy('nama_menu', 'ASC')
                ->skip($skip)->take($take)->get();
              $prev = DB::table('menu')
                ->where(function ($qry) use ($keyword) {
                  $qry ->orwhere('kode_menu', 'LIKE', $keyword)
                  ->orwhere('nama_menu', 'LIKE', $keyword)
                  ->orwhere('harga_menu', 'LIKE', $keyword)
                  ->orwhere('deskripsi_menu', 'LIKE', $keyword);
                })
                ->orderBy('nama_menu', 'ASC')
                ->skip($skip - 9)->take($take)->get();
              $next = DB::table('menu')
                ->where(function ($qry) use ($keyword) {
                  $qry ->orwhere('kode_menu', 'LIKE', $keyword)
                  ->orwhere('nama_menu', 'LIKE', $keyword)
                  ->orwhere('harga_menu', 'LIKE', $keyword)
                  ->orwhere('deskripsi_menu', 'LIKE', $keyword);
                })
                ->orderBy('nama_menu', 'ASC')
                ->skip($skip + 9)->take($take)->get();
            break;
            default:
              $result = DB::table('menu')
                ->where(function ($qry) use ($keyword) {
                  $qry ->orwhere('kode_menu', 'LIKE', $keyword)
                  ->orwhere('nama_menu', 'LIKE', $keyword)
                  ->orwhere('harga_menu', 'LIKE', $keyword)
                  ->orwhere('deskripsi_menu', 'LIKE', $keyword);
                })
                ->where('jenis_menu', 'LIKE', $category)
                ->orderBy('nama_menu', 'ASC')
                ->skip($skip)->take($take)->get();
              $prev = DB::table('menu')
                ->where(function ($qry) use ($keyword) {
                  $qry ->orwhere('kode_menu', 'LIKE', $keyword)
                  ->orwhere('nama_menu', 'LIKE', $keyword)
                  ->orwhere('harga_menu', 'LIKE', $keyword)
                  ->orwhere('deskripsi_menu', 'LIKE', $keyword);
                })
                ->where('jenis_menu', 'LIKE', $category)
                ->orderBy('nama_menu', 'ASC')
                ->skip($skip - 9)->take($take)->get();
              $next = DB::table('menu')
                ->where(function ($qry) use ($keyword) {
                  $qry ->orwhere('kode_menu', 'LIKE', $keyword)
                  ->orwhere('nama_menu', 'LIKE', $keyword)
                  ->orwhere('harga_menu', 'LIKE', $keyword)
                  ->orwhere('deskripsi_menu', 'LIKE', $keyword);
                })
                ->where('jenis_menu', 'LIKE', $category)
                ->orderBy('nama_menu', 'ASC')
                ->skip($skip + 9)->take($take)->get();
            break;
          }
        break;
      }


      foreach ($result as $key => $value) {
        $tmp[$key]['menu-material'] = DB::table('menu')
        ->select('menu_detil.*')
        ->join('menu_detil', 'menu_detil.kode_menu', '=', 'menu.kode_menu')
        ->where('menu.kode_menu', '=', $value->kode_menu)
        ->get();
      }

      foreach ($result as $key => $value) {
        $tmp[$key]['menu-status'] = DB::table('menu')
        ->select('bahan_baku.*')
        ->join('menu_detil', 'menu_detil.kode_menu', '=', 'menu.kode_menu')
        ->join('bahan_baku', 'bahan_baku.kode_bahan_baku', '=', 'menu_detil.kode_bahan_baku')
        ->where('menu.kode_menu', '=', $value->kode_menu)
        ->get();
      }


      foreach ($result as $key => $value) {
        $data[$key]['menu-max'] = DB::table('bahan_baku')
        ->selectRaw('*, FLOOR(bahan_baku.stok_bahan_baku/menu_detil.jumlah_bahan_baku_detil) AS menu_max')
        ->join('menu_detil', 'menu_detil.kode_bahan_baku', '=', 'bahan_baku.kode_bahan_baku')
        ->where('menu_detil.kode_menu', '=', $value->kode_menu)
        ->get();
        foreach ($data[$key]['menu-max'] as $key2 => $value2) {
          if ($key2+1 < count($data[$key]['menu-max'])) {
            if ($value2->menu_max > $data[$key]['menu-max'][$key2+1]->menu_max) {
              $result[$key]->menu_max = $data[$key]['menu-max'][$key2+1]->menu_max;//ambil yg minimum
            }
          }
        }
      }


      $pointer['prev']['skip'] = $skip - $take;
      $pointer['prev']['take'] = $take;

      $pointer['next']['skip'] = $skip + $take;
      $pointer['next']['take'] = $take;

      if ($result) {
        return response()->json([
            'status' => 200,
            'text' => 'Pencarian selesai dilakukan',
            'content' => $result,
            'available' => $tmp,
            'prev' => $prev,
            'next' => $next,
            'pointer' => $pointer
          ]);
      }

    }
  }

  public function createreview(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $validator = Validator::make($data, [
        '_name' => 'required',
        '_msg' => 'required',
      ]);

      if ($validator->fails()) {
        return response()
          ->json([
            'status' => 500,
            'text' => 'Waduh, kolom nama, kritik, dan sarannya diisi ya ;)'
        ]);
      }

      $valid = false;
      for ($i = 0; $i < count($data['_id']); $i++) {
        if (Review::find($data['_id'][$i])) {
          $valid = true;
        }
      }

      if ($valid) {
        $input = [
          'pembeli_kuisioner_perangkat' => $data['_name'],
          'pesan_kuisioner_perangkat' => $data['_msg'],
          'tanggal_kuisioner_perangkat' => date('Y-m-d'),
          'waktu_kuisioner_perangkat' => date('H:m:s'),
          'status_kuisioner_perangkat' => '1',
          'kode_perangkat' => Auth::guard('device')->user()->kode_perangkat,
        ];
        $try = ReviewDevice::create($input);
        $id = $try->kode_kuisioner_perangkat;

        if ($try) {
          for ($i = 0; $i < count($data['_id']); $i++) {
            $detil[] = array(
              'poin_kuisioner_detil' => $data['_ratting'][$i],
              'kode_kuisioner_perangkat' => $id,
              'kode_kuisioner' => $data['_id'][$i],
            );
          }
          $try = ReviewDetil::insert($detil);
        }
        return response()->json([
            'status' => 200,
            'text' => 'Berhasil menambahkan kuisioner',
          ]);
      }
      else {
        return response()->json([
            'status' => 500,
            'text' => 'Gagal menambahkan kuisioner',
          ]);
      }
    }//endif
  }

  public function checkorder(Request $request, $id) { //from session
    $res = false;
    $order = $request->session()->get('order');
    if (count($order) > 0) {
      foreach ($order as $key => $value) {
        if ($id == $order[$key]['id']) {
          $res = true;
          break;
        }
      }
    }
    return $res;
  }

  public function getposition(Request $request, $id) { //from session
    $res = -1;
    $order = $request->session()->get('order');
    if (count($order) > 0) {
      foreach ($order as $key => $value) {
        if ($id == $order[$key]['id']) {
          $res = $key;
        }
      }
    }
    return $res;
  }

  public function addmenu(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $validator = Validator::make($data, [
        '_id' => 'required',
        '_count' => 'required|min:1',
      ]);

      if ($validator->fails()) {
        return response()
          ->json([
            'status' => 500,
            'text' => 'Oops, habis ngapain ayoo?'
        ]);
      }
      else {
        if ($this->getposition($request, $data['_id']) >= 0) { //if exists add sum
          $order = Session::get('order');
          $order[$this->getposition($request, $data['_id'])]['count'] += $data['_count'];
          Session::set('order', $order);
        }
        else {
          $order['id'] = $data['_id'];
          $order['count'] = $data['_count'];
          $request->session()->push('order', $order);
        }
        return response()->json([
            'status' => 200,
            'text' => 'Berhasil menambahkan pesanan',
          ]);
      }
    }//endif
  }

  public function removemenu(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $validator = Validator::make($data, [
        '_id' => 'required',
      ]);

      if ($validator->fails() && !$this->checkorder($request, $data['_id'])) {
        return response()
          ->json([
            'status' => 500,
            'text' => 'Oops, pesanan tidak ditemukan'
        ]);
      }
      else {
        if ($this->getposition($request, $data['_id']) >= 0) {
          $order = Session::get('order');
          unset($order[$this->getposition($request, $data['_id'])]);
          Session::set('order', $order);
          return response()->json([
              'status' => 200,
              'text' => 'Berhasil menghapus pesanan',
            ]);
        }
        return response()->json([
            'status' => 500,
            'text' => 'Pesanan tidak ditemukan',
          ]);
      }
    }//endif
  }

  public function changemenu(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $validator = Validator::make($data, [
        '_id' => 'required',
        '_count' => 'required|min:1',
      ]);

      if ($validator->fails() && !$this->checkorder($request, $data['_id'])) {
        return response()
          ->json([
            'status' => 500,
            'text' => 'Oops, pesanan tidak ditemukan'
        ]);
      }
      else {
        if ($this->getposition($request, $data['_id']) >= 0) {
          $order = Session::get('order');
          $order[$this->getposition($request, $data['_id'])]['count'] = $data['_count'];
          Session::set('order', $order);
          return response()->json([
              'status' => 200,
              'text' => 'Berhasil mengubah jumlah pesanan',
            ]);
        }
        return response()->json([
            'status' => 500,
            'text' => 'Pesanan tidak ditemukan',
          ]);
      }
    }//endif
  }

  public function orderexists(Request $request) {
    $exists = DB::table('pesanan')
      ->where('status_pesanan', '!=', 'T') //belum close order
      ->where('status_pesanan', '!=', 'D') //belum done order
      ->where('kode_perangkat', '=', Auth::guard('device')->user()->kode_perangkat)
      ->first();
    return $exists;
  }

  public function createorder(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();

      if ($this->orderexists($request)) { //check masih ada order aktif atau tidak
        $currorder = $this->orderexists($request);
        $current = DB::table('pesanan_detil')
          ->where('status_pesanan_detil', '!=', 'D') //belum done order
          ->where('kode_pesanan', '=', $currorder->kode_pesanan)
          ->get();
        $order = $request->session()->get('order');
        $detil = [];
        foreach ($order as $key => $value) {
          $detil[] = array (
            'jumlah_pesanan_detil' => $order[$key]['count'],
            'status_pesanan_detil' => 'P',
            'kode_pesanan' => $currorder->kode_pesanan,
            'kode_menu' => $order[$key]['id']
          );
        }

        Perangkat::find(Auth::guard('device')->user()->kode_perangkat)->update([
          'status_perangkat' => 0
        ]);

        $try = PesananDetil::insert($detil);
        if ($try) {
          $request->session()->forget('order');

          $valid = Perangkat::find(Auth::guard('device')->user()->kode_perangkat);
          $try = new MethodController();
          $try = $try->generate_notification([
            'device' => Auth::guard('device')->user()->kode_perangkat,
            'msg' => 'Terdapat order baru di perangkat ' . $valid->nama_perangkat . '.'
          ]);

          return response()->json(['status' => 200,'text' => 'Mohon ditunggu, pesanan sedang kami proses.']);
        }
        return response()->json(['status' => 500,'text' => 'Oops terjadi sesuatu, silahkan hubungi kami apabila terjadi kendala']);
      }
      else {
        $try = Pesanan::create([
          'tanggal_pesanan' => date('Y-m-d'),
          'waktu_pesanan' => date('H:m:s'),
          'pembeli_pesanan' => $data['_name'],
          'catatan_pesanan' => $data['_addition'],
          'harga_pesanan' => 0,
          'tunai_pesanan' => 0,
          'status_pesanan' => 'C',
          'kode_pegawai' => NULL,
          'kode_perangkat' => Auth::guard('device')->user()->kode_perangkat
        ]);
        $id = $try->kode_pesanan;

        $order = $request->session()->get('order');
        foreach ($order as $key => $value) {
          $detil[] = array(
            'jumlah_pesanan_detil' => $order[$key]['count'],
            'status_pesanan_detil' => 'P',
            'kode_pesanan' => $id,
            'kode_menu' => $order[$key]['id']
          );
        }

        Perangkat::find(Auth::guard('device')->user()->kode_perangkat)->update([
          'status_perangkat' => 0
        ]);

        $try = PesananDetil::insert($detil);
        if ($try) {
          $request->session()->forget('order');

          $valid = Perangkat::find(Auth::guard('device')->user()->kode_perangkat);
          $try = new MethodController();
          $try = $try->generate_notification([
            'device' => Auth::guard('device')->user()->kode_perangkat,
            'msg' => 'Terdapat order baru di perangkat ' . $valid->nama_perangkat . '.'
          ]);

          return response()->json(['status' => 200,'text' => 'Mohon ditunggu, pesanan sedang kami proses.']);
        }
        return response()->json(['status' => 500,'text' => 'Oops terjadi sesuatu, silahkan hubungi kami apabila terjadi kendala']);
      }//endif
    }//end request ajax
  }

  public function filtermenu(Request $request) {
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
          case 'A':
            $result = DB::table('menu')
              ->orderBy('nama_menu', 'ASC')
              ->skip(0)->take(9)->get();
            $prev = DB::table('menu')
              ->orderBy('nama_menu', 'ASC')
              ->skip(count($result) - 9)->take(9)->get();
            $next = DB::table('menu')
              ->orderBy('nama_menu', 'ASC')
              ->skip(count($result) + 9)->take(9)->get();
          break;
          default:
            $result = DB::table('menu')
              ->where('jenis_menu', '=', $data['_keyword'])
              ->orderBy('nama_menu', 'ASC')
              ->skip(0)->take(9)->get();
            $prev = DB::table('menu')
              ->where('jenis_menu', '=', $data['_keyword'])
              ->orderBy('nama_menu', 'ASC')
              ->skip(count($result) - 9)->take(9)->get();
            $next = DB::table('menu')
              ->where('jenis_menu', '=', $data['_keyword'])
              ->orderBy('nama_menu', 'ASC')
              ->skip(count($result) + 9)->take(9)->get();
          break;
        }

        foreach ($result as $key => $value) {
          $tmp[$key]['menu-material'] = DB::table('menu')
          ->select('menu_detil.*')
          ->join('menu_detil', 'menu_detil.kode_menu', '=', 'menu.kode_menu')
          ->where('menu.kode_menu', '=', $value->kode_menu)
          ->get();
        }

        foreach ($result as $key => $value) {
          $tmp[$key]['menu-status'] = DB::table('menu')
          ->select('bahan_baku.*')
          ->join('menu_detil', 'menu_detil.kode_menu', '=', 'menu.kode_menu')
          ->join('bahan_baku', 'bahan_baku.kode_bahan_baku', '=', 'menu_detil.kode_bahan_baku')
          ->where('menu.kode_menu', '=', $value->kode_menu)
          ->get();
        }

        foreach ($result as $key => $value) {
          $data[$key]['menu-max'] = DB::table('bahan_baku')
          ->selectRaw('*, FLOOR(bahan_baku.stok_bahan_baku/menu_detil.jumlah_bahan_baku_detil) AS menu_max')
          ->join('menu_detil', 'menu_detil.kode_bahan_baku', '=', 'bahan_baku.kode_bahan_baku')
          ->where('menu_detil.kode_menu', '=', $value->kode_menu)
          ->get();
          foreach ($data[$key]['menu-max'] as $key2 => $value2) {
            if ($key2+1 < count($data[$key]['menu-max'])) {
              if ($value2->menu_max > $data[$key]['menu-max'][$key2+1]->menu_max) {
                $result[$key]->menu_max = $data[$key]['menu-max'][$key2+1]->menu_max;//ambil yg minimum
              }
            }
          }
        }

        $pointer['prev']['skip'] = count($result) - 9;
        $pointer['prev']['take'] = 9;

        $pointer['next']['skip'] = count($result) + 9;
        $pointer['next']['take'] = 9;

        if ($result) {
          return response()->json([
              'status' => 200,
              'text' => 'Pencarian selesai dilakukan',
              'content' => $result,
              'available' => $tmp,
              'prev' => $prev,
              'next' => $next,
              'pointer' => $pointer
            ]);
        }

      }
    }//endif
  }

  public function notifhelp(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $valid = Perangkat::find($data['_id']);
      if ($valid) {

        $try = new MethodController();
        $try = $try->generate_notification([
          'device' => $data['_id'],
          'msg' => $valid->nama_perangkat . ' membutuhkan bantuan.'
        ]);
        if ($try) {
          return response()->json([
              'status' => 200,
              'text' => 'Berhasil memanggil bantuan.',
            ]);
        }
        return response()->json([
            'status' => 500,
            'text' => 'Gagal memanggil bantuan, silahkan hubungi pelayan secara manual.',
          ]);
      }
      else {
        return response()->json([
            'status' => 500,
            'text' => 'Gagal memanggil bantuan, silahkan hubungi pelayan secara manual.',
          ]);
      }
    }//endif
  }

  public function getnotification(Request $request) {
    $notification = Pemberitahuan::orderBy('kode_pemberitahuan', 'DESC')
      ->orderBy('tanggal_pemberitahuan', 'DESC')
      ->where('kode_perangkat', '=', Auth::guard('device')->user()->kode_perangkat)
      ->where('isi_pemberitahuan', 'NOT LIKE', '%bantuan%')
      ->whereRaw('tanggal_pemberitahuan >= NOW() - INTERVAL 1 HOUR')
      ->get();
    return response()->json([
        'status' => 200,
        'content' => $notification
      ]);
  }

  public function refreshorder(Request $request) {
    $data['order-processed'] = DB::table('pesanan')
      ->select('pesanan.*', 'perangkat.nama_perangkat')
      ->join('perangkat', 'pesanan.kode_perangkat', '=', 'perangkat.kode_perangkat')
      ->orderBy('tanggal_pesanan', 'ASC')
      ->orderBy('waktu_pesanan', 'ASC')
      ->where(function ($qry) {
        $qry->orwhere('pesanan.status_pesanan', '=', 'C')
        ->orwhere('pesanan.status_pesanan', '=', 'P')
        ->orwhere('pesanan.status_pesanan', '=', 'T');
      })
      ->where('pesanan.kode_perangkat', '=',  Auth::guard('device')->user()->kode_perangkat)
      ->get();
    foreach ($data['order-processed'] as $key => $value) {
      $data[$key]['order-processed-detail'] = DB::table('pesanan')
        ->select('pesanan_detil.*', 'menu.*')
        ->join('pesanan_detil', 'pesanan.kode_pesanan', '=', 'pesanan_detil.kode_pesanan')
        ->join('menu', 'pesanan_detil.kode_menu', '=', 'menu.kode_menu')
        ->where('pesanan.kode_pesanan', '=', $data['order-processed'][$key]->kode_pesanan)
        ->get();
    }
    $data['method'] = new MethodController();

    return response()->json([
      'status' => 200,
      'content' => $data,
      'device' => Auth::guard('device')->user(),
      'order' => $this->get_order($request)
    ]);
  }

}
