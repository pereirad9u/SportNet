<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $table = "users_groups";
    protected $primaryKey = "id";

    public $timestamps = false;
    public $incrementing = false;


}
