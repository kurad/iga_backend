<?php
namespace App\Services;

use Exception;
use App\Models\Topic;
use App\Models\TopicQuestion;
use App\Services\AbstractService;
use App\Exceptions\UknownException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ItemNotFoundException;
use App\DTO\Question\CreateTopicQuestionsDto;
use App\DTO\Question\UpdateTopicQuestionsDto;

class QuestionService extends AbstractService
{
    /**
     * @throws Exception
     */
    public function createQuestion(CreateTopicQuestionsDto $data)
    {
        $question = $data->question;
        $topic_id = $data->topic_id;
        $user_id = Auth::user()->id;
        
        try {
            $question = TopicQuestion::create([
                "topic_id" => $topic_id,
                "question" => $question,
                "user_id"  => $user_id,
                
            ]);
            return $question;
        } catch (Exception $th) {
            Log::error("Failed to add the questions ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }
    
    public function getTopicQuestion(int $id)
    {
        $question = TopicQuestion::where('topic_id',$id)->first();
        if (is_null($question)) {
            throw new ItemNotFoundException("Sorry, question can not be found");
        }
        return $question;
    }
    public function updateQuestion(UpdateTopicQuestionsDto $data, int $id)
    {
        $q = TopicQuestion::find($id);

        if (is_null($q)) {
            throw new ItemNotFoundException("The question does not exist");
        }
        $question = $data->question;
        try {
            $q->update([
                "question" => $question,
            ]);
            return $question;
        } catch (Exception $th) {
            Log::error("Failed to update question ", [
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
        $q = TopicQuestion::find($id);
        if (is_null($q)) {
            throw new ItemNotFoundException("The question does not exist");
        }
        return $q->delete();
    }
}