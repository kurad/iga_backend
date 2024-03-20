<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\SubjectService;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Subject\CreateSubjectRequest;

class SubjectController extends Controller
{
    public function __construct(public SubjectService $subjectService)
    {
    }

    public function index()
    {
        $subject = $this->subjectService->allSubjects()->toArray();
        return Response::json($subject);
    }

    public function teacher_subjects()
    {
        $subject = $this->subjectService->teacher_subjects()->toArray();
        return Response::json($subject);
    }

    public function user()
    {
        $user = $this->subjectService->user();
        return Response::json($user);
    }

    public function store(CreateSubjectRequest $request)
    {
        try {

            $subject = $this->subjectService->create($request->dto);
            return Response::json($subject);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
}