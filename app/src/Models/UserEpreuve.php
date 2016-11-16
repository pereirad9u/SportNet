<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEpreuve extends Model
{
    protected $table = "users_epreuves";
    protected $primaryKey = "id";

    public $timestamps = false;
    public $incrementing = false;


}
