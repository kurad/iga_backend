<?php

namespace App\Services;

use Exception;
use App\Models\Topic;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use App\Exceptions\UknownException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\DTO\Subject\CreateSubjectDto;
use App\DTO\Subject\UpdateSubjectDto;
use App\Exceptions\ItemNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use App\Exceptions\InvalidDataGivenException;

class SubjectService extends AbstractService
{

    /**
     * @throws Exception
     */
    public function create(CreateSubjectDto $data): Subject
    {

        $name = $data->name;
        $level_id = $data->level_id;
        $user_id = Auth::user()->id;
        try {
            $subject = Subject::create([
                "name" => $name,
                "level_id" => $level_id,
                "user_id" =>$user_id,
                
            ]);

            return $subject;
        } catch (Exception $th) {
            Log::error("Failed to create the subject", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }
    public function user()
    {
        $user = Auth::user()->id;
        return($user);
    }
    public function getsubject(int $id): ?Subject
    {
        $subject = Subject::find($id);
        if (is_null($subject)) {
            throw new ItemNotFoundException("Sorry, this subject cannot be found");
        }
        return $subject;
    }

    public function allsubjects()
    {
        $subjects = Subject::
                        join('levels','levels.id','=','subjects.level_id')
                        ->select('levels.name','subjects.name as subjName', 'subjects.id')
                        ->get();
        return ($subjects);
    }
    public function countTopicsBySubject(){
        $topics = Topic::select(
            'subjects.name as subjName','levels.name',
            DB::raw("COUNT(*) as total_topics")
            )
            ->join('units','units.id','=','topics.unit_id')
            ->join('subjects','subjects.id','=','units.subject_id')
            ->join('levels','levels.id','=','subjects.level_id')
            ->groupBy('levels.name','subjects.name')
            ->get();
            return $topics;
    }
    public function teacher_subjects()
    {
        $subjects = Subject::
                        join('levels','levels.id','=','subjects.level_id')
                        ->where('user_id',Auth::user()->id)
                        ->select('levels.name','subjects.name as subjName', 'subjects.id')
                        ->get();
        return $subjects;
    }

    public function updatesubject(UpdateSubjectDto $data, int $id): Subject
    {
        $subject = Subject::find($id);
        if (is_null($subject)) {
            throw new ItemNotFoundException("The subject does not exist");
        }

        $name = $data->name;
        $level_id = $data->level_id;

        try {
            $subject->update([
                "name" => $name,
                "level_id" => $level_id,
            ]);

            return $subject;
        } catch (Exception $th) {

            Log::error("Failed to update subject ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }
    public function destroy(int $id): bool
    {
        $subject = Subject::find($id);
        if (is_null($subject)) {
            throw new ItemNotFoundException("The subject does not exist");
        }
        return $subject->delete();
    }
}