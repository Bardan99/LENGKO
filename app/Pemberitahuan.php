<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pemberitahuan extends Model {
  protected $table = "pemberitahuan";
  protected $primaryKey = "kode_pemberitahuan";
  public $incrementing = true;
  public $timestamps = false;

  protected $guarded = [];

}
