<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model {
  protected $table = "pegawai";
  public $primaryKey = "kode_pegawai";
  public $incrementing = false;
  public $timestamps = false;

  protected $guarded = [];

}
