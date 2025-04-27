<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    // Register user
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:14',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'division_id' => 'required|exists:divisions,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return ApiResponse::badRequest($validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
                'division_id' => $request->division_id,
                'role_id' => $request->role_id,
                'is_active' => true,
            ]);

            $token = JWTAuth::fromUser($user);

            DB::commit();

            return ApiResponse::success(
                ['token' => $token, 'user' => $user],
                "Successfully registered",
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Registration failed: " . $e->getMessage());
            return ApiResponse::internalServerError($e, 'Registration failed');
        }
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
            Log::error('Failed to login: ' . $e->getMessage());
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
            Log::error('Failed to get authenticated user: ' . $e->getMessage());
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
