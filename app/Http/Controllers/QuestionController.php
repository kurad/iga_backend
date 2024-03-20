<?php

namespace App\Http\Controllers;

use Exception;

use App\Services\QuestionService;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Question\UpdateTopicQuestionRequest;
use App\Http\Requests\Question\CreateTopicQuestionRequest;

class QuestionController extends Controller
{
    public function __construct(public QuestionService $questionService)
    {
    }

    public function getTopicQuestion(int $topic)
    {
        try {
            $question = $this->questionService->getTopicQuestion($topic);
            return Response::json($question);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
    public function store(CreateTopicQuestionRequest $request)
    {
        try {
            $question = $this->questionService->createQuestion($request->dto);
            return Response::json($question);
        } catch (Exception $th) {
            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function updateQuestion(UpdateTopicQuestionRequest $request, $id)
    {
        try {
            $question = $this->questionService->updateQuestion($request->dto, $id);
            return Response::json($question);
        } catch (Exception $th) {
            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
}