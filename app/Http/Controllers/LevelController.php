<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Level;
use Illuminate\Http\Request;
use App\Services\LevelService;
use App\Exceptions\UknownException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\level\LevelRequest;
use App\Exceptions\InvalidDataGivenException;
use App\Http\Requests\level\UpdateLevelRequest;

class LevelController extends Controller
{
    public function __construct(public LevelService $levelService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $levels = $this->levelService->allLevels()->toArray();
        return Response::json($levels);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LevelRequest $request)
    {
        try {

            $level = $this->levelService->create($request->dto);
            return Response::json($level);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $level = $this->levelService->getLevel($id);
            return Response::json($level);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLevelRequest $request, int $id)
    {
        try {

            $level = $this->levelService->update($request->dto, $id);
            return Response::json($level);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function provinces()
    {
        $levels = $this->levelService->provinces()->toArray();
        return Response::json($levels);
    }

    public function districts(Request $request)
    {
        $districts = $this->levelService->districts($request);
            return Response::json($districts);
    }

    public function sectors(Request $request)
    {
        $sectors = $this->levelService->sectors($request);
            return Response::json($sectors);
    }

    public function schools(Request $request)
    {
        $schools = $this->levelService->schools($request);
            return Response::json($schools);
    }
    
}