<?php

  namespace App\Http\Controllers;

  use App\Http\Requests;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Http\Request;

  class HomeController extends Controller {
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct() {
      //$this->middleware('auth'); //only used if implement to all method on this class
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

  public function view($param) {
    if (view()->exists($param)) {
      $data['page'] = $param;
      switch ($param) {
        case 'gallery':
          $data['gallery'] =
          (object) array(
              (object) array(
                'path' => 'gallery1-mujigae-food-court.jpg',
                'title' => 'Food Court',
                'desc' => 'LENGKO adalah restoran yang bisa dengan mudah ditemukan di sudut kota-kota di Indonesia, bahkan di food-court sekalipun. Dengan dekorasi ruangan yang penuh warna dan kekinian, serta ruangan yang bersih dan nyaman membuat cita rasa kuliner khas Indonesia menjadi lebih berasa. Restoran ini sangat cocok untuk seluruh kalangan, muda-tua.'
              ),
              (object) array(
                'path' => 'gallery2-mujigae-restaurant.jpg',
                'title' => 'Mall Resto',
                'desc' => 'LENGKO juga memiliki cabang di beberapa mall di Indonesia. Diantaranya terdapat di kota Bandung, Jakarta, dan Depok. Kamu bukan anak muda zaman now kalau belum pernah coba makan di sini.'
              ),
              (object) array(
                'path' => 'gallery3-mujigae-restaurant-ciwalk.jpg',
                'title' => 'Independent Resto',
                'desc' => 'Selain terdapat di mall, LENGKO mempunyai restoran tersendiri (khusus) yang bisa ditemukan dengan mudah, hari gini gak bisa pakai G-Maps? Anak muda jaman now akan lebih mudah untuk menemukan restoran ini saat sedang jalan-jalan. Salah satu keunggulan yang terdapat di restoran khusus LENGKO adalah lengkapnya menu yang tersedia jika dibandingkan dengan tempat lainnya.'
              ),
              (object) array(
                'path' => 'gallery4-app-tablets.jpg',
                'title' => 'Easy Access',
                'desc' => 'LENGKO memberi kemudahan pengunjung dalam memilih pesanan makanan mereka. Tidak perlu bersusah payah untuk memanggil atau menunggu pelayan, kalian cukup memesan makanan dan minuman yang kalian inginkan melalui perangkat yang sudah kami sediakan.'
              ),
              (object) array(
                'path' => 'gallery5-comfortable-seat.jpg',
                'title' => 'Comfortable Seat',
                'desc' => 'Tempat duduk dan meja sangat kekinian dan nyaman bagi pengunjung. Tempat yang berwarna warni lengkap dengan berbagai macam fasilitas yang bisa memanjakan kamu hinga klepek-klepek.'
              ),
              (object) array(
                'path' => 'gallery6-app-tabs.jpg',
                'title' => 'Get in Touch',
                'desc' => 'Kalian bisa  memilih makanan dan minuman langsung melalui perangkat yang sudah tersedia, bingung dengan cara pemakaiannya? Jangan khawatir, panggil pelayan kami melalui perangkat tersebut dengan 1-click.'
              ),
              (object) array(
                'path' => 'gallery7-free-hot-pan.jpg',
                'title' => 'Serve Yourself',
                'desc' => 'Kamu berdidikasi tinggi ingin menyiapkan segala bumbu-bumbu khusus untuk hidangan yang sudah kamu pesan? Kami dengan senang hati akan membantu untuk menyiapkan peralatan dan perlengkapan yang kamu butuhkan sesuai dengan hidangan yang telah dipesan.'
              ),
              (object) array(
                'path' => 'gallery8-fee-selfie.jpg',
                'title' => 'Free Selfie',
                'desc' => 'Jadikan setiap harimu menjadi kenangan manis dalam hidupmu, kami menghargai setiap waktu yang berlalu dalam hidup ini; momen-momen berharga hidup ini tidak akan pernah terulang kembali, cheese!'
              )
          );
        break;
        case 'menu':
          $data['menu'] = DB::table('menu')->skip(0)->take(9)->get();
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
            ->orderBy('nama_kuisioner', 'ASC')
            ->get();
          $data['customer-reviews'] = DB::table('kuisioner_perangkat')
            ->join('kuisioner_detil', 'kuisioner_detil.kode_kuisioner_perangkat', '=', 'kuisioner_perangkat.kode_kuisioner_perangkat')
            ->where('status_kuisioner_perangkat', '=', TRUE)
            ->orderBy('tanggal_kuisioner_perangkat', 'DSC')
            ->orderBy('waktu_kuisioner_perangkat', 'DSC')
            ->skip(0)->take(3)->get();
          $data['menu_obj'] = new MethodController();
        break;
        default:
          $data['unknown'] = null;
        break;
      }
      return view($param, ['data' => $data]);
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

}
