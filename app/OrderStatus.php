<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table = 'order_statuses';
    protected $fillable = ['name', 'is_rejectable', 'is_initial', 'is_final', 'status_caption' , 'index'];

    protected static $instance;


    public function scopeAsc($query)
    {
        if(!self::$instance)  {
            self::$instance = $query->orderBy('index', 'asc')->get();

        }
        return self::$instance;


    }
}
