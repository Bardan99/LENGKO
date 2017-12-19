<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewDetil extends Model {
  protected $table = "kuisioner_detil";
  protected $primaryKey = "kode_kuisioner_detil";
  public $incrementing = false;
  public $timestamps = false;

  protected $guarded = [];

}
