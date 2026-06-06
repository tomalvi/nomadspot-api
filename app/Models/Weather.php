<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Weather extends Model
{
    public function cities(): HasMany
    {
        return $this->belongsTo(City::class);
    }
}
