<?php
namespace App\Services;

use Exception;
use App\Models\Topic;
use App\Models\TopicExercise;
use App\Services\AbstractService;
use App\Exceptions\UknownException;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ItemNotFoundException;
use App\DTO\Exercise\CreateTopicExercisesDto;
use App\DTO\Exercise\UpdateTopicExercisesDto;

class ExerciseService extends AbstractService
{
    /**
     * @throws Exception
     */
    public function createExercise(CreateTopicExercisesDto $data)
    {
        $exercises = $data->exercises;
        $topic_id = $data->topic_id;
        
        $topic = Topic::find($topic_id);
        if (is_null($topic_id)) {
            throw new ItemNotFoundException("The topic does not exist");
        }
        try {
            $exercise = TopicExercise::create([
                "topic_id" => $topic_id,
                "exercises" => $exercises,
                
            ]);
            return $exercise;
        } catch (Exception $th) {
            Log::error("Failed to add the exercises ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }
    public function getExercise(int $id): ?TopicExercise
    {
        $exercise = TopicExercise::find($id);
        if (is_null($exercise)) {
            throw new ItemNotFoundException("Sorry, Exercise can not be found");
        }
        return $exercise;
    }

    public function getTopicExercise(int $id)
    {
        $exercise = TopicExercise::where('topic_id',$id)->first();
        if (is_null($exercise)) {
            throw new ItemNotFoundException("Sorry, Exercise can not be found");
        }
        return $exercise;
    }

    public function updateExercise(UpdateTopicExercisesDto $data, int $id): TopicExercise
    {
        $exercise = TopicExercise::find($id);
        if (is_null($exercise)) {
            throw new ItemNotFoundException("The exercise does not exist");
        }
        $exercises = $data->exercises;
        try {
            $exercise->update([
                "exercises" => $exercises,
            ]);
            return $exercise;
        } catch (Exception $th) {
            Log::error("Failed to update exercise ", [
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
        $exercise = TopicExercise::find($id);
        if (is_null($exercise)) {
            throw new ItemNotFoundException("The exercise does not exist");
        }
        return $exercise->delete();
    }
}