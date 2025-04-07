<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use Illuminate\Support\Facades\File;

class CountrySeeder extends Seeder
{
    public function run()
    {
        // Charger le fichier JSON
        $json = File::get(base_path('storage/app/data.json'));
        $countries = json_decode($json, true);

        foreach ($countries as $country) {
            Country::create([
                'name' => $country['name'],
                'population' => $country['population'] ?? null,
                'region' => $country['region'] ?? null,
                'capital' => $country['capital'] ?? null,
                'flag' => $country['flag'] ?? null,
                'languages' => json_encode($country['languages'] ?? []),
                'currencies' => json_encode($country['currencies'] ?? []),
            ]);
        }
    }
}
