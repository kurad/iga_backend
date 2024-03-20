<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $levels = Level::orderBy('name', 'ASC')->get();
        $levels = DB::table('levels')->orderBy('name', 'asc')->get();

        return view('pages.levels.levels', compact('levels'));
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
        $level = Level::create([
            'name' =>$request->name
        ]);

        return response()->json([
            'data' => $level,
            'message' => 'Level Successfully added',
            'status' =>200,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getLevels()
    {
        $levels = Level::orderBy('name')->get();
        // $levels = DB::table('levels')->orderBy('name', 'asc')->get();

        if(!$levels){
            return response()->json('No Level is found', 404);
        }
        else{
        return response()->json([
            'data' =>$levels,
            'status' => 200
        ]);
    }
    }
}