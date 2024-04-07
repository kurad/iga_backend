<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except'=>['login', 'register']]);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email','password');
        $validator = Validator::make($credentials,[
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 401);
        }
        try{
            if(! $token = JWTAuth::attempt($credentials)){
                return response()->json([
                    'success' =>false,
                    'errors' => "Login credentials are invalid"
                    //'Login credentials are invalid.',
                ], 401);
            }
        } catch(JWTException $e){
            return $credentials;
            return response()->json([
                'success' =>false,
                'message' =>'Could not create token.',
            ], 500);
        }

        return response()->json([
            'user' =>auth()->user(),
            'success' => true,
            'token' =>$token,
        ]);
        
    }
 
    public function register(Request $request)
    {
               // data validation
               $validator = Validator::make($request->all(),[
                "firstname" => "required|string",
                "lastname" => "required|string",
                "phone" => "nullable|string",
                "email" => "required|email|unique:users",
                "password" => "required|string|confirmed",
                "password_confirmation" => "required",
                "school_id" => "required",

            ]);
            if($validator->fails()){
                return response()->json([
                    'errors' => $validator->messages()
                ],401);
            }
    
            // User Model
           $user = new User ([
                "firstname" => $request->firstname,
                "lastname" => $request->lastname,
                "phone" => $request->phone,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "school_id" => $request->school_id
            ]);
            $user->save();
            $accessToken = $user->createToken('authToken')->accessToken;
            //Auth::login($user, true);
            //$user->sendEmailVerificationNotification();
            $success = 'Please confirm your email';
        
            // Response
            return response()->json([
                'user' =>$user,
                'access_token' => $accessToken,
                "status" => true,
                "message" => $success
            ]);
    }

    public function staff_register(Request $request)
    {
               // data validation
               $validator = Validator::make($request->all(),[
                "firstname" => "required|string",
                "lastname" => "required|string",
                "phone" => "nullable|string",
                "email" => "required|email|unique:users",
                "password" => "required|string",
                "school_id" => "required",
                "is_admin" => "required",
            ]);
            if($validator->fails()){
                return response()->json([
                    'errors' => $validator->errors()
                ],401);
            }
    
            // User Model
           $user = new User ([
                "firstname" => $request->firstname,
                "lastname" => $request->lastname,
                "phone" => $request->phone,
                "email" => $request->email,
                "is_admin" => $request->is_admin,
                "password" => Hash::make($request->password),
                "school_id" => $request->school_id
            ]);
            $user->save();
            $success = 'User Registered successfully';
        
            // Response
            return response()->json([
                'user' =>$user,
                "status" => true,
                "message" => $success
            ]);
    }
    public function getUser()
    {
        $user = auth()->user();
        return response()->json($user, 200);
    }
    // User Profile (GET)
    public function profile(){

        $userdata = auth()->user();
        return Response::json($userdata);

        // return response()->json([
        //     //"status" => true,
        //     "message" => "Profile data",
        //     "data" => $userdata
        // ]);
    } 
public function signin(Request $request)
{
    $request->validate([
        'email' => 'required|string|email',
        'password'=>'required|string',
    ]);
    $credentials = $request -> only('email','password');
    $token = Auth::attempt($credentials);
    if(!$token){
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized',
        ], 401);
    }
    $user = Auth::user();
    return response()->json([
        'status' => 'success',
        'user' => $user,
        'authorization' => [
            'token' => $token,
            'type' => 'bearer',
        ]
        ]);
}
public function users_list()
{
    // $users = User::with('user_school')
    //             ->where('is_admin',1)
    //             ->orWhere('is_admin',2)
    //             ->get();
    // return $users;

    $users = User::join('schools','users.school_id','=','schools.id')
                ->join('sectors','sectors.id','=','schools.sector_id')
                ->join('districts','districts.id','=','sectors.district_id')
                ->join('provinces','provinces.id','=','districts.province_id')
                ->where('is_admin',1)
                ->orWhere('is_admin',2)
                ->get();
    return $users;
}
        
}