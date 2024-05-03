<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Lesson;
use App\Models\School;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class DashboardDataController extends Controller
{
    public function countSchools()
    {
        $schools = School::all()->count();

        return Response::json($schools);
    }
    public function countData()
    {
        $data['schools'] = School::all()->count();
        $data['subjects'] = Subject::all()->count();
        $data['lessons'] = Topic::all()->count();
        $data['students'] = User::where('is_admin',0)->count();

        return Response::json($data);
        
    }
}