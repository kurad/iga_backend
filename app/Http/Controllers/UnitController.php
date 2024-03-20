<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\UnitService;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Unit\CreateUnitRequest;
use App\Models\Subject;

class UnitController extends Controller
{
    public function __construct(public UnitService $unitService)
    {
    }

    public function index()
    {
        $units = $this->unitService->allUnit()->toArray();
        return Response::json($units);
    }

    public function store(CreateUnitRequest $request)
    {
        try {

            $unit = $this->unitService->create($request->dto);
            return Response::json($unit);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
    public function unitPerSubject(int $subject)
    {
        try {
            $units = $this->unitService->unitsPerSubject($subject);
            return Response::json($units);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function SubjectName(int $subject)
    {
        try {
            $units = $this->unitService->SubjectName($subject);
            return Response::json($units);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
}