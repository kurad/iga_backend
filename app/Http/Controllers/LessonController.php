<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Subject\CreateSubjectRequest;
use App\Services\LessonService;

class LessonController extends Controller
{
    public function __construct(public LessonService $lessonService)
    {
    }

    public function index()
    {
        $lesson = $this->lessonService->allLesson()->toArray();
        return Response::json($lesson);
    }

    public function store(CreateSubjectRequest $request)
    {
        try {

            $lesson = $this->lessonService->create($request->dto);
            return Response::json($lesson);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
}