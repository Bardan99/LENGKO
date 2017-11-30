<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuDetil extends Model {
  protected $table = "menu_detil";
  protected $primaryKey = "kode_menu_detil";
  public $incrementing = false;
  public $timestamps = false;

  protected $guarded = [];

}
