<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengadaanDetil extends Model {
  protected $table = "pengadaan_bahan_baku_detil";
  protected $primaryKey = "kode_pengadaan_bahan_baku_detil";
  public $incrementing = true;
  public $timestamps = false;

  protected $guarded = [];

}
