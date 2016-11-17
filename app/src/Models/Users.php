<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = "users";
    protected $primaryKey = "id";

    public $timestamps = false;
    public $incrementing = false;

    function epreuves(){
       return $this->belongsToMany('App\Models\Epreuves');
    }

}