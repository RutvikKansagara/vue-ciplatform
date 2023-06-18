<?php

namespace App\Http\Controllers;


use App\Models\Country;
use App\Models\City;
use Illuminate\Http\Request;
use App\Models\MissionTheme;
class CountryCityController extends Controller
{
     public function fetchCountries()
    {
        $countries = Country::all();
        $missionthemes = MissionTheme::all();
        return response()->json(['countries' => $countries,'missionthemes' => $missionthemes]);
    }

    public function fetchCities(Request $request)
    {
        $countryId = $request->input('country_id');
        $cities = City::where('country_id', $countryId)->get();

        return response()->json(['cities' => $cities]);
    }


}
