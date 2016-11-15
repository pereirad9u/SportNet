<?php
/**
 * Created by PhpStorm.
 * User: debian
 * Date: 15/11/16
 * Time: 10:19
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Organisers extends Model
{
    protected $table = "organisers";
    protected $primaryKey = "id";

    public $timestamps = false;
    public $incrementing = false;


}