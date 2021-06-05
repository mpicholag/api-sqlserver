<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\UserRole;
use App\Enums\HttpStatusCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthenticationController extends Controller
{
    public function __constructor() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function login(Request $request) {
        $data = $request->all();
		$validator = Validator::make($data['data'], [
			'email' => 'required|string|email|max:255',
			'password' => 'required|string',
		]);

		if ($validator->fails())
        {
            return response(['error'=>$validator->errors()], HttpStatusCode::BadRequest);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return response(['code' => 1007,'message' => 'Unauthorized'], HttpStatusCode::Unauthorized);
        }
        return $this->createNewToken($token);
    }

    public function index() {
        $users = User::all();

        return response(['users' => $users], HttpStatusCode::OK);
    }

    public function create(Request $request) {
        $data = $request->all();
		$validator = Validator::make($data, [
            'first_name' => 'required',
            'last_name' => 'string',
			'email' => 'required|unique:users|string|email|max:255',
            'password' => 'required|string|confirmed',
        ]);
        
        if ($validator->fails())
        {
            return response(['error'=>$validator->errors()], HttpStatusCode::BadRequest);
        }
        $user = User::create(array_merge(
            $validator->validate(),
            ['password' => bcrypt($data['password'])]
        ));

        return response(['user' => $user], HttpStatusCode::Created);
    }

    public function createRole(Request $request) {
        $roleId = $request->input('roleId');
        $userId = $request->input('userId');
        $role = UserRole::create(array('role_id'=>$roleId, 'user_id'=>$userId));
        return response(['message' => 'Created success'], HttpStatusCode::Created);
    }
    
    public function register(Request $request) {
        $data = $request->all();
		$validator = Validator::make($data['data'], [
            'first_name' => 'required',
			'email' => 'required|unique:users|string|email|max:255',
            'password' => 'required|string|confirmed',
        ]);
        
        if ($validator->fails())
        {
            return response(['error'=>$validator->errors()], HttpStatusCode::BadRequest);
        }
        $user = User::create(array_merge(
            $validator->validate(),
            ['password' => bcrypt($data['data']['password'])]
        ));
        return response(['user' => $user], HttpStatusCode::Created);
    }

    public function logout()
    {
        auth()->logout();
        return response(['message' => 'Successfully logged out'], HttpStatusCode::OK);
    }

    public function me() {
        $user = auth()->user();
        return response(['user' => $user]);
    }

    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    protected function createNewToken($token) {
        $user = auth()->user();
        return response([
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL()*60,
            'user' => $user,
        ], HttpStatusCode::OK);
    }
}
