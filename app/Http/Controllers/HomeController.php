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

    public function ajax_handler(Request $request) {
        if ($request->isMethod('post')) {
            return response()->json(['data' => 'x']);
        }
        elseif ($request->isMethod('get')) {
            $data['field-bahan-baku'] = '<div class="row padd-lr-15"><div class="col-md-offset-2 col-md-6">';
            $data['field-bahan-baku'] .= '<input type="text" id="material-name-" name="" class="input-lengko-default block" placeholder="Nama Bahan Baku" /></div>';
            $data['field-bahan-baku'] .= '<div class="col-md-4"><div class="row"><div class="col-md-2 col-xs-12 col-sm-12 padd-lr-15">';
            $data['field-bahan-baku'] .= '<button type="button" class="btn-lengko btn-lengko-default block" onclick="add_val(\'material-list-\', \'material-name-\');" style="height:42px; padding: 10px 5px 10px 5px; font-size: 13pt;">';
            $data['field-bahan-baku'] .= '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;</button>';
            $data['field-bahan-baku'] .= '</div><div class="col-md-10 col-xs-12 col-sm-12 padd-lr-15">';
            $data['field-bahan-baku'] .= '<select id="material-list-" name="" class="select-lengko-default block" onchange="add_val(\'material-list-\', \'material-name-\');">';
            $data['field-bahan-baku'] .=  '</select>';
            $data['field-bahan-baku'] .=  '</div></div></div></div>';
            return response()->json(['data' => $data]);
        }

    }
}
