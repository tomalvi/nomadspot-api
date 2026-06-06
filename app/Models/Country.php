<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $fillable = [
        'name',
        'flag',
        'slug'
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }


}
