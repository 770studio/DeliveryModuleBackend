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
        $rich = self::$instance->where('id', '!=', 0 );

        $first_id = $rich->first()->id ;
        $last_id = $rich->last()->id ;

        $rich->transform(function ($item, $key )   use ($last_id , $first_id)  {
            $item->is_first =  ($item->id == $first_id) ?  true : false;
            $item->is_last =  ($item->id == $last_id) ?  true : false;
            return $item;
        });



        //dd($rich->toArray());
        return $rich; //->toArray();


    }


    public static function getStatusText( $satus_id ) {
        if(!$satus_id) return null;
        return self::Asc()->find($satus_id)->status_text;
    }
    public static function getStatusCaption( $satus_id ) {
        if(!$satus_id) return null;
        return self::Asc()->find($satus_id)->status_caption;
    }

    public static function getNextStatus( $satus_id ) {
        $rich = self::RichArray();

        if(!$satus_id)  $next_index = $rich->min('index');
        else {
            $status = $rich->find($satus_id);
            if($status->is_last ) return false; // no next status
            $next_index = $status->index + 1;
        }

        return $rich->where('index',  $next_index )->first();
    }

    public static function getNextStatusText( $satus_id ) {

        $next = self::getNextStatus( $satus_id );
        return $next ? $next->status_text : false;

    }
    public static function getNextStatusCaption( $satus_id ) {
        $next = self::getNextStatus( $satus_id );
        return $next ? $next->status_caption : false;
    }

    public static function getNextStatusId( $satus_id ) {
        $next = self::getNextStatus( $satus_id );
        return $next ? $next->id : false;
    }
    public static function isRejectable( $satus_id ) {
        $next = self::getNextStatus( $satus_id );
        if(!$next) return false; // e.g completed
        return (bool)$next->is_rejectable;

    }



}
