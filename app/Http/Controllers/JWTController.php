<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class JWTController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Register user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ],
        [
            'email.unique' => 'Email already taken'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

        return response()->json([
            'message' => 'User successfully registered'
        ], 201);
    }

    /**
     * login user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {


        $credentials = [
            'email' => $request['email'],
            'password' => $request['password'],
        ];
        
        if (!$token = auth()->attempt($credentials)) {

            $a = RateLimiter::hit($request->email,10);

            if($a>5){
                return response()->json(['error' => '5 failed attempts account locking for 5 minutes'], 401);
            }

            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Logout user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'User successfully logged out.']);
    }

    /**
     * Refresh token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get user profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            // 'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60
        ],201);
    }
}