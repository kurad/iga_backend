<?php

namespace App\Services;

use Exception;
use App\Models\Unit;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;
use App\DTO\Lesson\CreateLessonDto;
use App\DTO\Lesson\UpdateLessonDto;
use App\Exceptions\UknownException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Exceptions\ItemNotFoundException;
use App\Exceptions\InvalidDataGivenException;

class LessonService extends AbstractService
{

    /**
     * @throws Exception
     */
    public function create(CreateLessonDto $data): Lesson
    {

        $lesson_title = $data->lesson_title;
        $instructional_objective = $data->instructional_objective;
        $unit_id = $data->unit_id;

        $lessonExists = Lesson::where("lesson_title", $lesson_title)
                                ->while("unit_id", $unit_id)
                                ->exists();
        
        if ($lessonExists) {
            throw new InvalidDataGivenException("The Lesson already exists");
        }

        try {
            $lesson = Lesson::create([
                "lesson_title" => $lesson_title,
                "instructional_objective" =>$instructional_objective,
                "unit_id" => $unit_id,
                "user_id" =>Auth::user()->id,
                
            ]);

            return $lesson;
        } catch (Exception $th) {
            Log::error("Failed to create the lesson ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }

    public function getLesson(int $id): ?Lesson
    {
        $lesson = Lesson::find($id);
        if (is_null($lesson)) {
            throw new ItemNotFoundException("Sorry, this lesson cannot be found");
        }
        return $lesson;
    }

    public function allLesson()
    {
        $lessons = Lesson::join('units','units.id','=','units.lesson_id')
                        ->select('lessons.lesson_title','lessons.nstructional_objective', 'units.name')
                        ->get();
        return $lessons;
    }

    public function updateLesson(UpdateLessonDto $data, int $id): Lesson
    {
        $lesson = Lesson::find($id);
        if (is_null($lesson)) {
            throw new ItemNotFoundException("The lesson does not exist");
        }

        $lesson_title = $data->lesson_title;
        $instructional_objective = $data->instructional_objective;
        $unit_id = $data->unit_id;

        try {
            $lesson->update([
                "lesson_title" => $lesson_title,
                "instructional_objective" =>$instructional_objective,
                "unit_id" => $unit_id,
            ]);

            return $lesson;
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
        $lesson = Lesson::find($id);
        if (is_null($lesson)) {
            throw new ItemNotFoundException("The lesson does not exist");
        }
        return $lesson->delete();
    }

    public function lessonsPerUnit(int $unitId)
    {

        $lessons = Lesson::join('subjects','subjects.id','=','units.subject_id')
        ->where("units.subject_id", "=", $unitId)
        ->get(['subjects.id','subjects.name','units.unit_title','units.key_unit_competence']);
        return $lessons;
        
    }


}