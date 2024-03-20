<?php

namespace App\Http\Controllers;

use Exception;

use App\Services\ExerciseService;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Exercise\CreateTopicExerciseRequest;
use App\Http\Requests\Exercise\UpdateTopicExerciseRequest;

class ExerciseController extends Controller
{
    public function __construct(public ExerciseService $exerciseService)
    {
    }

    public function getTopicExercise(int $topic)
    {
        try {
            $exercise = $this->exerciseService->getTopicExercise($topic);
            return Response::json($exercise);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
    public function store(CreateTopicExerciseRequest $request)
    {
        try {
            $exercise = $this->exerciseService->createExercise($request->dto);
            return Response::json($exercise);
        } catch (Exception $th) {
            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function updateExercise(UpdateTopicExerciseRequest $request, $id)
    {
        try {
            $exercise = $this->exerciseService->updateExercise($request->dto, $id);
            return Response::json($exercise);
        } catch (Exception $th) {
            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
}