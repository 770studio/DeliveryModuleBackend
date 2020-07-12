<?php

namespace App;

use Illuminate\Database\Eloquent\Model;




class VehiclePreference extends Model


{
    protected $table = "vehicle_preference";
    protected $fillable = ['name', 'distance_id', 'description', 'index', 'merchant_type',  'vehicle_type'];


    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }


    public function Distance() {
        return $this->hasOne('App\Distance', 'id', 'distance_id');
    }
    public function Mtype() {
        return $this->hasOne('App\MerchantType', 'id', 'merchant_type');
    }
    public function Vtype() {
        return $this->hasOne('App\VehicleType', 'id', 'vehicle_type');
    }

    public function scopeFiltering($query)
    {

        return $query->orderBy('index', 'asc')-> with(['Distance', 'Mtype', 'Vtype'])  ->get();

    }


}
