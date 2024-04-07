<?php
namespace App\Services;

use Exception;
use App\Models\Unit;
use App\Models\Topic;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\DTO\Topic\CreateTopicDto;
use App\DTO\Topic\UpdateObjectivesDto;
use App\DTO\Topic\UpdateTopicDto;
use App\Services\AbstractService;
use Illuminate\Support\Facades\DB;
use App\Exceptions\UknownException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\DTO\Topic\UpdateTopicContentDto;
use App\DTO\Topic\UpdateTopicVideoLinkDto;
use App\Exceptions\ItemNotFoundException;
use Illuminate\Database\Eloquent\Collection;

class TopicService extends AbstractService
{
    /**
     * @throws Exception
     */
    public function createTopic(CreateTopicDto $data)
    {
        $topic_title = $data->topic_title;
        $instructional_objectives = $data->instructional_objectives;
        $unit_id = $data->unit_id;
        
        $unit = Unit::find($unit_id);
        if (is_null($unit)) {
            throw new ItemNotFoundException("The unit does not exist");
        }
        try {
            $topic = Topic::create([
                "topic_title" => $topic_title,
                "instructional_objectives" => $instructional_objectives,
                "unit_id" => $unit_id
                
            ]);
            return $topic;
        } catch (Exception $th) {
            Log::error("Failed to add the lesson ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }
    public function getTopic(int $id): ?Topic
    {
        $topic = Topic::find($id);
        if (is_null($topic)) {
            throw new ItemNotFoundException("Sorry, Topic can not be found");
        }
        return $topic;
    }

    public function allTopics(): Collection
    {
        $topics = Topic::with('unit')->get();
        return $topics;
    }

    
    public function topicsPerUnit(int $unitId): Collection
    {
        $topics = Topic::where("unit_id", "=", $unitId)->get();
        return $topics;
    }

    public function updateTopic(UpdateTopicDto $data, int $id): Topic
    {
        $topic = Topic::find($id);
        if (is_null($topic)) {
            throw new ItemNotFoundException("The Topic does not exist");
        }
        $topic_title = $data->topic_title;
        $unit_id = $data->unit_id;
        $instructional_objectives = $data->instructional_objectives;
        try {
            $topic->update([
                "topic_title" => $topic_title,
                "instructional_objectives" => $instructional_objectives,
                "unit_id" => $unit_id,
                "user_id" => Auth::user()->id
            ]);
            return $topic;
        } catch (Exception $th) {
            Log::error("Failed to update topic ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }

    public function updateTopicContent(UpdateTopicContentDto $data, int $id): Topic
    {
        $topic = Topic::find($id);
        if (is_null($topic)) {
            throw new ItemNotFoundException("The Topic does not exist");
        }
        $topic_content = $data->topic_content;
        try {
            $topic->update([
                "topic_content" => $topic_content,

            ]);
            return $topic;
        } catch (Exception $th) {
            Log::error("Failed to add lesson content ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }

    public function updateTopicVideoLink(UpdateTopicVideoLinkDto $data, int $id): Topic
    {
        $topic = Topic::find($id);
        if (is_null($topic)) {
            throw new ItemNotFoundException("The Topic does not exist");
        }
        $video_link = $data->video_link;
        try {
            $topic->update([
                "video_link" => $video_link,

            ]);
            return $topic;
        } catch (Exception $th) {
            Log::error("Failed to add lesson video link ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }

    public function updateObjective(UpdateObjectivesDto $data, int $id)
    {
        $topic = Topic::find($id);
        if (is_null($topic)) {
            throw new ItemNotFoundException("The Topic does not exist");
        }
        $instructional_objectives = $data->instructional_objectives;
        try {
            $topic->update([
                "instructional_objectives" => $instructional_objectives,

            ]);
            return $topic;
        } catch (Exception $th) {
            Log::error("Failed to add lesson video link ", [
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
        $topic = Topic::find($id);
        if (is_null($topic)) {
            throw new ItemNotFoundException("The Topic does not exist");
        }
        return $topic->delete();
    }
    
    public function levels()
    {
        $levels = DB::table('levels')->get();
        return ($levels);
    }
    public function subjects(Request $request)
    {
        // $user_id = Auth
        $subjects = DB::table('subjects')
                        ->where('level_id',$request->level_id)
                        // ->where('user_id',Auth::user()->id)
                        ->get();
        return ($subjects);
    }
    

    public function teacher_subjects(Request $request)
    {
        $user_id = Auth::user();
        $subjects = DB::table('subjects')
                        ->where('level_id',$request->level_id)
                        // ->where('user_id', $user_id)
                        ->get();
        return ($subjects);
    }

    public function units(Request $request)
    {
        $units = DB::table('units')->where('subject_id',$request->subject_id)->get();
        return ($units);
    }
    public function findTopics(Request $request)
    {
        $topics = DB::table('topics')->where('unit_id',$request->unit_id)->get();
        return ($topics);
    }
    public function findTeacherTopics(Request $request)
    {
       $user = Auth::user()->id;
        $topics = Topic::join('units','topics.unit_id','=','units.id')
                        ->join('subjects','units.subject_id','=','subjects.id')
                        ->join('users','subjects.user_id', 'users.id')
                        ->where('users.id','=',$user)
                        ->get();
        //DB::table('topics')->where('unit_id',$request->unit_id)->get();
        return ($topics);
    }
    
}