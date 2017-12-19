<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model {
  protected $table = "pengadaan_bahan_baku";
  protected $primaryKey = "kode_pengadaan_bahan_baku";
  public $incrementing = true;
  public $timestamps = false;

  protected $guarded = [];

}
