<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class MethodController extends BaseController {

  public function num_to_rp($number, $digit = 0) {
    if (isset($number) && isset($digit)) {
      return 'Rp' . number_format($number, $digit, ',','.');
    }
  }

  public function cut_string($desc, $length) {
    return substr($desc, $length);
  }

  public function menu_type($type) {
    $res = "Makanan";
    if ($type == "D") {
      $res= "Minuman";
    }
    return $res;
  }

  public function rewrite($type, $param) {
    $res = false;
    switch ($type) {
      case 'date':

      break;
      case 'time':

      break;
      default:break;
    }
    return $res;
  }

}
