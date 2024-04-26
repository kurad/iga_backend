<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardDataController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\QuestionController;





Route::post('login', [AuthController::class, 'login']);
Route::post('signin', [AuthController::class, 'signin']);
Route::get('/user', [AuthController::class, 'getUser'])->middleware('auth:api');



Route::prefix("/v1")->group(function () {
    Route::get('/province', [LevelController::class, 'provinces']);
    Route::get('/count/school', [DashboardDataController::class, 'countSchools']);
    Route::get('/count/subject', [DashboardDataController::class, 'countSubjects']);
    Route::get('/count/lessons', [DashboardDataController::class, 'countLessons']);
    Route::get('/count/student', [DashboardDataController::class, 'countStudents']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/district', [LevelController::class, 'districts']);
    Route::get('/sector', [LevelController::class, 'sectors']);
    Route::get('/school', [LevelController::class, 'schools']);

    Route::get('/dropdown/levels', [TopicController::class, 'levels']);
    Route::get('/dropdown/subjects', [TopicController::class, 'subjects']);
    Route::get('/teacher/subjects', [TopicController::class, 'teacher_subjects']);
    Route::get('/dropdown/units', [TopicController::class, 'units']);
    Route::get('/unit/topics', [TopicController::class, 'findTopics']);
    Route::get('/teacher/topics', [TopicController::class, 'findTeacherTopics'])->middleware('auth:api');

    Route::get("/schools", [SchoolController::class, "index"]);
    Route::get("/school-info", [SchoolController::class, "schoolDetails"]);
    Route::post("/school", [SchoolController::class, "store"]);

    Route::get("levels", [LevelController::class, "index"]);
    Route::get("level/{id}", [LevelController::class, "show"]);
    Route::put("level/{id}", [LevelController::class, "update"]);
    Route::post("levels", [LevelController::class, "store"]);

    Route::get("count/topics", [SubjectController::class, "countTopicsBySubject"]);
    Route::get("count/topics/{id}", [SubjectController::class, "TopicsBySubject"]);
    Route::get("student/topic/{id}", [SubjectController::class, "getTopic"]);
    Route::get("student/topic/{id}", [SubjectController::class, "getTopic"]);
    Route::get("student/topics", [TopicController::class, "index"]);
    // Route::get("enrollments", [EnrollmentController::class, "index"]);
    Route::post("enrollments", [EnrollmentController::class, "enroll"])->middleware('auth:api');
    Route::get("enrollments", [EnrollmentController::class, "allEnrollments"])->middleware('auth:api');
    
    });

    Route::group(["middleware"=> ["auth:api"]], function(){
        Route::get("profile", [AuthController::class, "profile"]);
        Route::post('/staff/register', [AuthController::class, 'staff_register']);
        Route::get('users/list',[AuthController::class, 'users_list']);


        Route::get("subjects", [SubjectController::class, "index"]);
        Route::get("teacher/subjects", [SubjectController::class, "teacher_subjects"]);
        Route::get("user", [SubjectController::class, "user"]);
        Route::post("subjects", [SubjectController::class, "store"]);
        
        Route::get("units", [UnitController::class, "index"]);
        Route::get("units/subjects/{id}", [UnitController::class, "SubjectName"]);
        Route::post("units", [UnitController::class, "store"]);
        Route::get('/topics',[TopicController::class, "index"]);
        Route::post('/topics',[TopicController::class, "store"]);
        Route::get('unit/{id}/topics',[TopicController::class, "topicsPerUnit"]);
        Route::get("subjects/{id}", [UnitController::class, "unitPerSubject"]);

        Route::get('/topic/{id}',[TopicController::class, "getTopic"]);
        Route::put('/topic/content/{id}',[TopicController::class, "addContent"]);
        Route::put('/topic/video/{id}',[TopicController::class, "addVideoLink"]);
        Route::put('/topic/objective/{id}',[TopicController::class, "updateObjective"]);

        Route::put('/topic/exercise/{id}',[ExerciseController::class,"updateExercise"]);
        Route::post('/topic/exercise',[ExerciseController::class,"store"]);
        Route::get('/topic/exercises/{id}',[ExerciseController::class,"getTopicExercise"]);

        
        Route::get('/topic/question/{id}',[QuestionController::class,"getTopicQuestion"]);
        Route::post('/topic/question',[QuestionController::class,"store"]);
        Route::put('/topic/question/{id}',[QuestionController::class,"updateQuestion"]);






    });
 