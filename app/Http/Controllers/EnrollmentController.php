<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Exceptions\UknownException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::where('user_id', Auth::user()->id);
    }
    public function enroll(Request $request)
    {
        try {
            $enrollment = Enrollment::create([
                "topic_id" => $request->topic_id,
                "user_id" =>Auth::user()->id,               
            ]);

            return $enrollment;
        } catch (Exception $th) {
            Log::error("Failed to Enroll you to this lesson", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }
}