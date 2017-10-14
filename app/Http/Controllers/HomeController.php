<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class HomeController extends Controller {

  public function view_index() {
    $employee = DB::table('employee')->get();
    return view('home', ['employee' => $employee]);
  }

}
