<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\School;
use Illuminate\Http\Request;
use App\Services\SchoolService;
use App\Exceptions\UknownException;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\SchoolRequest;
use Illuminate\Support\Facades\Response;
use App\Exceptions\InvalidDataGivenException;

class SchoolController extends Controller
{
    public function __construct(public SchoolService $schoolService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schools = $this->schoolService->allSchools()->toArray();
        return Response::json($schools);
    }
    public function schoolDetails()
    {
        $schoolInfo = $this->schoolService->schoolDetails()->toArray();
        return Response::json($schoolInfo);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SchoolRequest $request)
    {
        try {

            $school = $this->schoolService->create($request->dto);
            return Response::json($school);
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
    public function show(string $id)
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
}