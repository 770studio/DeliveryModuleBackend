<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
     protected $fillable = ['name', 'setting_type', 'value' ];



}
