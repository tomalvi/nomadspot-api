<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function create(Request $request)
    {
        Country::create([
            'name'   => $request->name,
            'flag'   => $request->flag,
            'slug'   => $request->slug
        ]);
    
    }
}
