<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Country;
use App\Models\City;
use App\Models\Weather;
use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

#[Signature('data:import')]
#[Description('Command description')]
class ImportDataCities extends Command
{
    /**
     * Execute the console command.
     */

    public function handle()
    {
        $this->info('Importing countries...');
        $this->importCountries();

        $this->info('Importing cities...');
        $this->importCities();

        $this->info('Done!');
    }

    public function importCountries()
    {
        //AÑADIR REGIONES, LENGUAS, POPULATION,   A LOS PAISES, LA API ESTA LOS TIENE
        $response = Http::withoutVerifying()->get('https://restcountries.com/v3.1/all?fields=name,flag,flags');

        if ($response->failed()) {
            $this->error('Failed to fetch countries');
            return;
        }

        foreach ($response->json() as $data) {
            Country::updateOrCreate(
                [
                    'name'      => $data["name"]["common"],
                    'flag'      => $data["flag"] ?? '',
                    'slug'      => $data["flags"]["png"] ?? ''
                ]
            );
        }

        $this->info('Countries imported: ' . Country::count());

    }

    public function importCities()
    {
            
        DB::table('weather')->insertOrIgnore([
            'id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $topCities = json_decode(file_get_contents(database_path('assets/nomad_cities.json')), true);
        
        foreach ($topCities as $city) {
            $cityLatLonData = Http::withoutVerifying()->get('https://nominatim.openstreetmap.org/search?city=' . $city["city"] . '&format=json&limit=1');

            if ($cityLatLonData->failed() || empty($cityLatLonData->json())) {
                $this->warn("not found");
                continue;
            }
                
            $cityTimeZone = Http::withoutVerifying()->get('https://timeapi.io/api/v1/timezone/coordinate?latitude=' . $cityLatLonData->json()[0]["lat"] . '&longitude=' . $cityLatLonData->json()[0]["lon"]);
            $country = Country::where("name",'LIKE', '%' . $city["country"] . "%")->first();

            $population = Http::withoutVerifying()->post('https://countriesnow.space/api/v0.1/countries/population/cities/filter', [
                'country' => $city['country'],
            ]);

            $populationValue = 1;
            if ($population->successful()) {
                $cities = $population->json()['data'] ?? [];
                $match = collect($cities)->first(function ($item) use ($city) {
                    return strtolower($item['city']) === strtolower($city['city']);
                });
                if ($match && !empty($match['populationCounts'])) {
                    $populationValue = (int) round($match['populationCounts'][0]['value']);
                }
            }


            $imageUrl = Http::withoutVerifying()->get('https://api.unsplash.com/search/photos?query=' . $city["city"] . '+city&per_page=1&client_id=bB6eDHWdbJT0eOn3xrRtrJVUAG9nf-6jlSsXWVzKTZM');

            City::updateOrCreate(
                [
                    'name'              => $city["city"],
                    'country_id'        => $country->id,
                    'population'        => $populationValue,
                    'weather_id'        => 1,
                    'latitude'          => $cityLatLonData->json()[0]["lat"],
                    'longitude'         => $cityLatLonData->json()[0]["lon"],
                    'timezone'          => $cityTimeZone->json()["timezone"],
                    'cost_per_month'    => $city["cost_per_month"],
                    'avg_rent_usd'      => $city["avg_rent_usd"],
                    'internet_speed'    => $city["internet_speed"],
                    'safety_score'      => $city["safety_score"],
                    'score_overall'     => $city["score_overall"],
                    'score_climate'     => $city["score_climate"],
                    'score_cost'        => $city["score_cost"],
                    'visa_friendly'     => $city["visa_friendly"],
                    'images'            => $imageUrl->json()['results'][0]['urls']['regular'] ?? null
                ]
            );
            sleep(1);
        }

        $this->info('Cities imported: ' . City::count());
    
    }


}
