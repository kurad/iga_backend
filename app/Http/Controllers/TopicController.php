<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Services\TopicService;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Topic\CreateTopicRequest;
use App\Http\Requests\Topic\UpdateObjectivesRequest;
use App\Http\Requests\Topic\CreateTopicContentRequest;
use App\Http\Requests\Topic\CreateTopicVideoLinkRequest;
use App\Http\Requests\Topic\UpdateTopicVideoLinkRequest;

class TopicController extends Controller
{
    public function __construct(public TopicService $topicService)
    {
    }

    public function index()
    {
        $topic = $this->topicService->allTopics()->toArray();
        return Response::json($topic);
    }

    public function topicsPerUnit(int $subject)
    {
        try {
            $topics = $this->topicService->topicsPerUnit($subject);
            return Response::json($topics);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
    public function store(CreateTopicRequest $request)
    {
        try {
            $topic = $this->topicService->createTopic($request->dto);
            return Response::json($topic);
        } catch (Exception $th) {
            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function addContent(CreateTopicContentRequest $request, $id)
    {
        try {
            $topic = $this->topicService->updateTopicContent($request->dto, $id);
            return Response::json($topic);
        } catch (Exception $th) {
            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function addVideoLink(CreateTopicVideoLinkRequest $request, $id)
    {
        try {
            $topic = $this->topicService->updateTopicVideoLink($request->dto, $id);
            return Response::json($topic);
        } catch (Exception $th) {
            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function updateVideoLink(UpdateTopicVideoLinkRequest $request, $id)
    {
        try {
            $topic = $this->topicService->updateTopicVideoLink($request->dto, $id);
            return Response::json($topic);
        } catch (Exception $th) {
            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function updateObjective(UpdateObjectivesRequest $request, $id)
    {
        try {
            $topic = $this->topicService->updateObjective($request->dto, $id);
            return Response::json($topic);
        } catch (Exception $th) {
            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
    public function levels()
    {
        $levels = $this->topicService->levels()->toArray();
        return Response::json($levels);
    }

    public function subjects(Request $request)
    {
        $subjects = $this->topicService->subjects($request);
            return Response::json($subjects);
    }
    public function teacher_subjects(Request $request)
    {
        $subjects = $this->topicService->teacher_subjects($request);
            return Response::json($subjects);
    }

    public function units(Request $request)
    {
        $units = $this->topicService->units($request);
            return Response::json($units);
    }

    public function findTopics(Request $request)
    {
        $topics = $this->topicService->findTopics($request);
            return Response::json($topics);
    }

    public function getTopic(int $id)
    {
        $topic = $this->topicService->getTopic($id);
            return Response::json($topic);
    }
}