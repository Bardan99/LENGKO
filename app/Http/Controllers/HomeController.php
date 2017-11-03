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
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

     public function index() {
       if (view()->exists('home')) {
         $menus = DB::table('hidangan')->skip(0)->take(9)->get();
         return view('home', ['menus' => $menus]);
       }
       return abort(404);
     }

    public function view($param) {
      if (view()->exists($param)) {
        return view($param);
      }
      return abort(404);
    }
}
