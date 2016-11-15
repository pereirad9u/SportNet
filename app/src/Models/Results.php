<?php
/**
 * Created by PhpStorm.
 * User: debian
 * Date: 15/11/16
 * Time: 10:20
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Results extends Model
{
    protected $table = "results";
    protected $primaryKey = "id";

    public $timestamps = false;
    public $incrementing = false;


}