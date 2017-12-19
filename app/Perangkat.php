<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perangkat extends Model {
  protected $table = "perangkat";
  protected $primaryKey = "kode_perangkat";
  public $incrementing = false;//declare pk bukan integer
  public $timestamps = false;

  protected $guarded = [];

}
