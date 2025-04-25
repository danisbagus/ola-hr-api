<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    // Register user
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return ApiResponse::unauthorized("Invalid request", $validator->errors()->first());
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        $response = ['token' => $token, 'user' => $user];
        return ApiResponse::success($response, "Successfully registered", ApiResponse::HTTP_CREATED);
    }

    // Login user

    public function login(Request $request)
    {
        try {
            $credentials = $request->only(['email', 'password']);

            if (!$token = JWTAuth::attempt($credentials)) {
                return ApiResponse::unauthorized('Invalid credentials');
            }

            $response = ['token' => $token];
            return ApiResponse::success($response, 'Successfully login');
        } catch (JWTException $e) {
            return ApiResponse::internalServerError($e->getMessage(), 'Failed to login');
        }
    }

    // Get authenticated user
    public function getUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return ApiResponse::unauthorized('User not found');
            }

            $response = ['user' => $user];
            return ApiResponse::success($response, 'Successfully get authenticated user');
        } catch (JWTException $e) {
            return ApiResponse::internalServerError($e->getMessage(), 'Failed to get authenticated user');
        }
    }

    // Logout user
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return ApiResponse::success(null, 'Successfully logged out');
    }
}
