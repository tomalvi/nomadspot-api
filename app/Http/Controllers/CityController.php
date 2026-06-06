<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\City;

class CityController extends Controller
{
    public function index()
    { 
        $cities = City::with('country')
            ->select('id', 'name', 'country_id')
            ->get()
            ->map(function ($city) {
                return [
                    'city_id'            => $city->id,
                    'name'          => $city->name,
                    'country'       => $city->country->name ?? null,
                    'slug'          => $city->country->slug ?? null,
                    'flag'          => $city->country->flag ?? null,
                ];
            });


        return response()->json($cities);
    }


    public function panel()
    { 
        $cities = City::with('country')
            ->orderBy('score_overall', 'desc')
            ->get()
            ->map(function ($city) {
                return [
                    'city_id'               => $city->id,
                    'name'                  => $city->name,
                    'country'               => $city->country->name ?? null,
                    'slug'                  => $city->country->slug ?? null,
                    'flag'                  => $city->country->flag ?? null,
                    'population'            => $city->population,
                    'latitude'              => $city->latitude,
                    'longitude'             => $city->longitude,
                    'cost_per_month'        => $city->cost_per_month,
                    'internet_speed'        => $city->internet_speed,
                    'timezone'              => $city->timezone,
                    'visa_friendly'         => $city->visa_friendly,
                    'images'                => $city->images,
                    'score_overall'         => $city->score_overall,
                    'score_climate'         => $city->score_climate,
                    'score_cost'            => $city->score_cost,
                    'safety_score'          => $city->safety_score,
                    'avg_rent_usd'          => $city->avg_rent_usd,
                    'avg_temp_c'            => $city->avg_temp_c
                ];
            });

        return response()->json($cities);
    }


    public function show($id)
    {
        $city = City::with('country')->findOrFail($id);

        return response()->json([
            'id'      => $city->id,
            'name'    => $city->name,
            'country' => $city->country->name ?? null,
            'slug'    => $city->country->slug ?? null,
            'flag'    => $city->country->flag ?? null,
        ]);

    }
}
