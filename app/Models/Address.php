<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'email', 'phone', 'country_id', 'state_id', 
        'city_id', 'address', 'zip_code', 'type', 'default_shipping', 'default_billing'
    ];

    public function country(){
        return $this->belongsTo(Country::class)->select('id','name');
    }

    public function countryState(){
        return $this->belongsTo(CountryState::class,'state_id')->select('id','name');
    }

    public function city(){
        return $this->belongsTo(City::class)->select('id','name');
    }
}
