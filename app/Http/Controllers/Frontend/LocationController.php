<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CountryState;
use App\Models\City;

class LocationController extends Controller
{
    /**
     * Get states by country ID (AJAX)
     */
    public function getStatesByCountry($countryId)
    {
        $states = CountryState::where('country_id', $countryId)
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get(['id', 'name']);
        
        return response()->json($states);
    }

    /**
     * Get cities by state ID (AJAX)
     */
    public function getCitiesByState($stateId)
    {
        $cities = City::where('country_state_id', $stateId)
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get(['id', 'name']);
        
        return response()->json($cities);
    }
}