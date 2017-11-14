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
       $menus = DB::table('menu')->skip(0)->take(9)->get();
       return view('home', ['menus' => $menus]);
     }
     return abort(404);
   }

  public function view($param) {
    if (view()->exists($param)) {
      if ($param == 'gallery') { //tanam manual
          $data = (object) array(
              (object) array('path' => 'gallery1-mujigae-food-court.jpg', 'title' => 'Food Court', 'deskripsi' => ''),
              (object) array('path' => 'gallery2-mujigae-restaurant.jpg', 'title' => 'Mall Resto', 'deskripsi' => ''),
              (object) array('path' => 'gallery3-mujigae-restaurant-ciwalk.jpg', 'title' => 'Independent Resto', 'deskripsi' => ''),
              (object) array('path' => 'gallery4-app-tablets.jpg', 'title' => 'Easy Access', 'deskripsi' => ''),
              (object) array('path' => 'gallery5-comfortable-seat.jpg', 'title' => 'Comfortable Seat', 'deskripsi' => ''),
              (object) array('path' => 'gallery6-app-tabs.jpg', 'title' => 'Get in Touch', 'deskripsi' => ''),
              (object) array('path' => 'gallery7-free-hot-pan.jpg', 'title' => 'Serve Yourself', 'deskripsi' => ''),
              (object) array('path' => 'gallery8-fee-selfie.jpg', 'title' => 'Free Selfie', 'deskripsi' => '')
          );
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
