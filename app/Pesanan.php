<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model {
  protected $table = "pesanan";
  protected $primaryKey = "kode_pesanan";
  public $incrementing = true;
  public $timestamps = false;

  protected $guarded = [];

}
