<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaktecOwnItems extends Model
{
   // protected $fillable = ['title', 'url', 'track' ];
   // protected $guarded = [];
    protected $table = 'paktec_own_items';
    protected $fillable = ['title', 'url', 'track', 'price', 'listing_id', 'best_seller'];

    public function competitors()
    {
        return $this->hasMany('App\PaktecCompetitorsItems', 'origin_id');
    }

}
