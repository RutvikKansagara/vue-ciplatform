<?php

namespace App\Http\Controllers;

use App\Models\MissionTheme;

use App\Http\Requests\StoreMissionThemeRequest;
use App\Http\Requests\UpdateMissionThemeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\City;
use Illuminate\Pagination\LengthAwarePaginator;

class MissionThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return MissionTheme::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view('admin.missiontheme.create'); // Create view by name missiontheme/create.blade.php
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMissionThemeRequest $request)
    {
        $missiontheme = MissionTheme::create($request->all());

        if ($missiontheme) {
            return response()->json(['message' => 'mission theme created successfully'], 201);
        } else {
            return response()->json(['message' => 'Failed to create mision theme'], 500);
        }
        //dd(MissionTheme::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(MissionTheme $missiontheme)
    {
        return $missiontheme;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MissionTheme $missionTheme, $missionThemeId)
    {
        $missionTheme = $missionTheme->find($missionThemeId);
        return view('admin.missiontheme.edit', compact('missionTheme'));
        // Create view by name missiontheme/edit.blade.php
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMissionThemeRequest $request, MissionTheme $missiontheme)
    {

        $missiontheme->update($request->all());

        return response()->json(['missiontheme' => $missiontheme,'message' => 'mission theme updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MissionTheme $missiontheme)
    {
        $missiontheme->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }

    public function fetchMissionThemes(){

        $missionthemes = MissionTheme::all();
        return response()->json(['missionthemes'=> $missionthemes]);
    }

}

