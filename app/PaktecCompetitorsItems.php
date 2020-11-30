<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaktecCompetitorsItems extends Model
{
   // protected $guarded = [];
    protected $table = 'paktec_competitors_items';
    protected $fillable = ['title', 'url', 'origin_id', 'price', 'listing_id'];


    public function origin()
    {

        return $this->belongsTo('App\PaktecOwnItems', 'origin_id', 'id');
    }

}
