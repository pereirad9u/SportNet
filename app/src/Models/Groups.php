<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $table = "groups";
    protected $primaryKey = "id";

    public $timestamps = false;
    public $incrementing = false;


}
