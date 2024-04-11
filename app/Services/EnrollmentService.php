<?php

namespace App\Services;

use App\DTO\Enrollment\EnrollDto;
use Exception;
use App\Models\Subject;
use App\Exceptions\UknownException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;

class EnrollmentService extends AbstractService
{

    /**
     * @throws Exception
     */
    public function enroll(EnrollDto $data)
    {

        $topic_id = $data->topic_id;
        $user_id = Auth::user()->id;
        try {
            $enroll = Enrollment::create([
                "topic_id" => $topic_id,
                "user_id" =>$user_id,
                
            ]);

            return $enroll;
        } catch (Exception $th) {
            Log::error("Failed to Enroll you", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }
    public function allEnrollments()
    {
        $enrollments = Enrollment::join('topics','topics.id','=','enrollments.topic_id')
                                ->join('units','units.id','=','topics.unit_id')
                                ->join('subjects','subjects.id','=','units.subject_id')
                                ->where('enrollments.user_id', Auth::user()->id)
                                ->get();
        return $enrollments;
    }

    

}