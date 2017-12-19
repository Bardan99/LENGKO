<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model {
  protected $table = "bahan_baku";
  protected $primaryKey = "kode_bahan_baku";
  public $incrementing = true;
  public $timestamps = false;

  protected $guarded = [];

}
