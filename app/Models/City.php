<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
use App\Models\Weather;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    protected $fillable = [
        'name',
        'is_capital',
        'country_id',
        'weather_id',
        'population',
        'latitude',
        'longitude',
        'cost_per_month',
        'internet_speed',
        'timezone',
        'visa_friendly',
        'images',
        'score_overall',
        'score_climate',
        'score_cost',
        'safety_score',
        'avg_rent_usd',
        'avg_temp_c',
    ];

    
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function weather(): BelongsTo
    {
        return $this->hasOne(Weather::class);
    }
}
