<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table = 'order_statuses';
    protected $fillable = ['name', 'is_rejectable', 'is_initial', 'is_final', 'status_caption', 'status_text' , 'index'];

    protected static $instance;


    public function scopeAsc($query)
    {
        if(!self::$instance)  {
            self::$instance = $query->orderBy('index', 'asc')->get();

        }

        return self::$instance;


    }

    public function scopeRichArray($query)
    {
        if(!self::$instance)  {
            self::$instance = self::Asc();

        }
        $rich = self::$instance;

        $first_id = $rich->first()->id ;
        $last_id = $rich->last()->id ;

        $rich->transform(function ($item, $key )   use ($last_id , $first_id)  {
            $item->is_first =  ($item->id == $first_id) ?  true : false;
            $item->is_last =  ($item->id == $last_id) ?  true : false;
            return $item;
        });



        //dd($rich->toArray());
        return $rich->toArray();


    }





}
