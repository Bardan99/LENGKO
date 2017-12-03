<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewDevice extends Model {
  protected $table = "kuisioner_perangkat";
  protected $primaryKey = "kode_kuisioner_perangkat";
  public $incrementing = false;
  public $timestamps = false;

  protected $guarded = [];

}
