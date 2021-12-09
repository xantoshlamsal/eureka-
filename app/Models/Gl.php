<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gl extends Model
{
    use HasFactory;
    protected $table='gl';
    protected $guarded=['id'];
    public $timestamps= false;

}
