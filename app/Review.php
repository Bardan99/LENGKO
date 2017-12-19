<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model {
  protected $table = "kuisioner";
  protected $primaryKey = "kode_kuisioner";
  public $incrementing = false;
  public $timestamps = false;

  protected $guarded = [];

}
