<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    protected $table = "pegawai";
    protected $primaryKey = "kode_pegawai";
    public $incrementing = false;
    public $timestamps = false;
    public $remember = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_pegawai', 'kata_sandi_pegawai',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function getAuthPassword() {
      return $this->kata_sandi_pegawai;
    }
}
