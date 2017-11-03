<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class AboutController extends Controller {

  public function view() {
    if (view()->exists('about')) {
      return view('about');
    }
    return abort(404);
  }
}
