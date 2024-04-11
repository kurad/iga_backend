<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Exceptions\UknownException;
use App\Http\Requests\Subject\EnrollRequest;
use App\Services\EnrollmentService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function __construct(public EnrollmentService $enrollService)
    {
    }

    public function enroll(EnrollRequest $request)
    {
        try {
            $topic = $this->enrollService->enroll($request->dto);
            return Response::json($topic);
        } catch (Exception $th) {
            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
    public function allEnrollments()
    {
        $enrollments = $this->enrollService->allEnrollments()->toArray();
        return Response::json($enrollments);
    }
}