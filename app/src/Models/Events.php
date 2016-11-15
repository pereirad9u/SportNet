<?php
/**
 * Created by PhpStorm.
 * User: debian
 * Date: 15/11/16
 * Time: 10:18
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $table = "event";
    protected $primaryKey = "id";

    public $timestamps = false;
    public $incrementing = false;


}