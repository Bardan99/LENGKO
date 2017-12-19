<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PesananDetil extends Model {
  protected $table = "pesanan_detil";
  protected $primaryKey = "kode_pesanan_detil";
  public $incrementing = true;
  public $timestamps = false;

  protected $guarded = [];

}
