<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Country::all());
    }



    public function getCountries()
    {
        try {
            $response = Http::get('https://restcountries.com/v2/all');
            // Vérifie si la réponse est valide
            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'Failed to fetch data from external API'], 500);
            }
        } catch (\Exception $e) {
            // Gérer les erreurs de l'API externe
            return response()->json(['error' => 'Error fetching countries: ' . $e->getMessage()], 500);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Tu peux utiliser un service externe ou une base de données pour récupérer les informations du pays
        try {
            // Exemple d'appel à une API externe pour récupérer les informations d'un pays par son ID
            $response = Http::get("https://restcountries.com/v2/{$id}");

            // Retourner les détails du pays à la vue via Inertia.js
            return Inertia::render('CountryDetail', [
                'country' => $response->json(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération du pays : ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        //
    }
}
