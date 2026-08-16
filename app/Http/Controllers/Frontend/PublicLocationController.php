<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CountryState;
use App\Models\City;
use Illuminate\Http\Request;

class PublicLocationController extends Controller
{
    /**
     * Get states by country ID
     */
    public function getStatesByCountry($country)
    {
        $states = CountryState::where('country_id', $country)
                             ->where('status', 1)
                             ->select('id', 'name')
                             ->get();
        
        return response()->json($states);
    }

    /**
     * Get cities by state ID
     */
    public function getCitiesByState($state)
    {
        $cities = City::where('country_state_id', $state)
                     ->where('status', 1)
                     ->select('id', 'name')
                     ->get();
        
        return response()->json($cities);
    }
}