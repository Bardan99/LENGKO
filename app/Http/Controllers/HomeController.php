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

   public function index() {
     if (view()->exists('home')) {
       $data['page'] = '';
       return view('home', ['data' => $data]);
     }
     return abort(404);
   }

  public function view($param, Request $request) {
    if (view()->exists($param)) {
      $data['page'] = $param;

      $hold = $request->session()->get('order');
      for ($i = 0; $i < count($hold); $i++) {
        $order[$i] = Menu::where('kode_menu', '=', $hold[$i]['id'])->get()->first();
        $order[$i]['jumlah_pesanan_detil'] = $hold[$i]['count'];
      }
      
      switch ($param) {
        case 'gallery':
          $data['gallery'] =
          (object) array(
              (object) array(
                'path' => 'gallery11-our-beloved-campus.jpg',
                'title' => 'Our beloved campus',
                'desc' => 'Quality is our tradition, it\'s a must! Sebetulnya kami bingung mau tulis apa di bagian ini, tapi ya sudahlah. Semoga kampus kami tidak pelit koneksi internet, internet cepet buat apa? pak sekarang zamannya Cloud! Orang-orang udah pergi ke venus kami masih di bumi aja pak :('
              ),
              (object) array(
                'path' => 'gallery1-mujigae-food-court.jpg',
                'title' => 'Food Court',
                'desc' => 'LENGKO adalah restoran yang bisa dengan mudah ditemukan di sudut kota-kota di Indonesia, bahkan di food-court sekalipun. Dengan dekorasi ruangan yang penuh warna dan kekinian, serta ruangan yang bersih dan nyaman membuat cita rasa kuliner khas Indonesia menjadi lebih berasa. Restoran ini sangat cocok untuk seluruh kalangan, muda-tua.'
              ),
              (object) array(
                'path' => 'gallery12-what.jpg',
                'title' => 'Mr. Soegoto favourite place',
                'desc' => 'Tempat favorit Mr. Soegoto untuk parkir mobil. Sebetulnya kenapa Mr. Soegoto senang sekali menyimpan mobilnya di situ, ini masih menjadi sebuah misteri! Tidak tahu kenapa, hanya ingin menambahkan gambar ini saja; sepertinya kami jatuh cinta!'
              ),
              (object) array(
                'path' => 'gallery3-mujigae-restaurant-ciwalk.jpg',
                'title' => 'Independent Resto',
                'desc' => 'Selain terdapat di mall, LENGKO mempunyai restoran tersendiri (khusus) yang bisa ditemukan dengan mudah, hari gini gak bisa pakai G-Maps? Anak muda jaman now akan lebih mudah untuk menemukan restoran ini saat sedang jalan-jalan. Salah satu keunggulan yang terdapat di restoran khusus LENGKO adalah lengkapnya menu yang tersedia jika dibandingkan dengan tempat lainnya.'
              ),
              (object) array(
                'path' => 'gallery9-refreshing-after-meeting.jpg',
                'title' => 'After Scrum Meeting',
                'desc' => 'Kami, sang pujangga, setelah melakukan scrum meeting di Teras Cihampelas. Niatnya sih mau ke Mujigae, cuma pada bandel gk bawa duit; Zak sendalmu mana? btw Azmi yang fotoin!'
              ),
              (object) array(
                'path' => 'gallery6-app-tabs.jpg',
                'title' => 'Get in Touch',
                'desc' => 'Kalian bisa memilih makanan dan minuman langsung melalui perangkat yang sudah tersedia, bingung dengan cara pemakaiannya? Jangan khawatir, panggil pelayan kami melalui perangkat tersebut dengan 1-click.'
              ),
              (object) array(
                'path' => 'gallery10-our-beloved-team.jpg',
                'title' => 'Our beloved team',
                'desc' => 'Ini kami, sang penantang yang gagah berani! Btw senyummu mempesona zak; copy of Raka(1) jangan ngumpet aja nanti diculik :3'
              ),
              (object) array(
                'path' => 'gallery8-fee-selfie.jpg',
                'title' => 'Free Selfie',
                'desc' => 'Jadikan setiap harimu menjadi kenangan manis dalam hidupmu, kami menghargai setiap waktu yang berlalu dalam hidup ini; momen-momen berharga hidup ini tidak akan pernah terulang kembali, cheese!'
              )
          );
        break;
        case 'menu':
          $data['menu'] = DB::table('menu')
          ->orderBy('nama_menu', 'ASC')
          ->skip(0)->take(9)->get();
          $data['menu_obj'] = new MethodController();
        case 'order':
          $data['order-detail'] = DB::table('pesanan')
            ->select('pesanan_detil.*', 'menu.*')
            ->join('pesanan_detil', 'pesanan.kode_pesanan', '=', 'pesanan_detil.kode_pesanan')
            ->join('menu', 'pesanan_detil.kode_menu', '=', 'menu.kode_menu')
            ->orderBy('tanggal_pesanan', 'ASC')
            ->orderBy('waktu_pesanan', 'ASC')
            ->where('pesanan.status_pesanan', '=', 'C')
            //->where('pesanan.kode_perangkat', '=', $kode)
            ->get();
          $data['order-processed'] = DB::table('pesanan')
            ->select('pesanan.*', 'perangkat.nama_perangkat')
            ->join('perangkat', 'pesanan.kode_perangkat', '=', 'perangkat.kode_perangkat')
            ->orderBy('tanggal_pesanan', 'ASC')
            ->orderBy('waktu_pesanan', 'ASC')
            ->where('pesanan.status_pesanan', '=', 'P')
            //->where('pesanan.kode_perangkat', '=', $kode)
            ->get();
          foreach ($data['order-processed'] as $key => $value) {
            $data[$key]['order-processed-detail'] = DB::table('pesanan')
              ->select('pesanan_detil.*', 'menu.*')
              ->join('pesanan_detil', 'pesanan.kode_pesanan', '=', 'pesanan_detil.kode_pesanan')
              ->join('menu', 'pesanan_detil.kode_menu', '=', 'menu.kode_menu')
              ->where('pesanan.kode_pesanan', '=', $data['order-processed'][$key]->kode_pesanan)
              ->get();
          }
          $data['menu_obj'] = new MethodController();
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

          $data['menu_obj'] = new MethodController();
        break;
        default:
          $data['unknown'] = null;
        break;
      }
      return view($param, ['data' => $data, 'device' => Auth::guard('device')->user(), 'order' => $order]);
    }
    return abort(404);
  }

  public function ajax_handler($param, Request $request) {
    if ($request->isMethod('post')) {
        //return response()->json(['data' => 'x']); not yet
    }
    elseif ($request->isMethod('get')) {
      if ($param) {
        switch ($param) {
          case 'bahan-baku':
            $data['material'] = DB::table('bahan_baku')
              ->orderBy('nama_bahan_baku', 'ASC')
              ->get();
          break;
          default:
          break;
        }
      }
      return response()->json(['data' => $data]);
    }
  }

  public function searchmenu(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $keyword = '%' . $data['menu-search-query'] . '%';

      if ($data['menu-search-query'] === "" || $data['menu-search-query'] === " ") {
        $result = DB::table('menu')
          ->orderBy('nama_menu', 'ASC')
          ->skip(0)->take(9)->get();
      }
      else {
        $result = DB::table('menu')
          ->where('kode_menu', 'LIKE', $keyword)
          ->orwhere('nama_menu', 'LIKE', $keyword)
          ->orwhere('harga_menu', 'LIKE', $keyword)
          ->orwhere('deskripsi_menu', 'LIKE', $keyword)
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


  public function addmenu(Request $request) {
    if ($request->ajax()) {
      $data = $request->all();
      $validator = Validator::make($data, [
        '_id' => 'required',
        '_count' => 'required',
      ]);

      if ($validator->fails()) {
        return response()
          ->json([
            'status' => 500,
            'text' => 'Oops, ayo habis ngapain ayoo :o'
        ]);
      }
      else {
        $order['id'] = $data['_id'];
        $order['count'] = $data['_count'];
        $request->session()->push('order', $order);
        return response()->json([
            'status' => 200,
            'text' => 'Berhasil menambahkan pesanan',
          ]);
      }
    }//endif
  }

}
