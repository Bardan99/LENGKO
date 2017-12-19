<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {
  protected $table = "menu";
  protected $primaryKey = "kode_menu";
  public $incrementing = false;
  public $timestamps = false;

  protected $guarded = [];

}
