<?php

namespace App\Http\Controllers;

use App\Http\UseCases\UserUseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $userUseCase;

    public function __construct(UserUseCase $useCase)
    {
        $this->userUseCase = $useCase;
    }

    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|string'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'msg' => $validator->errors(),
                    'data' => []
                ], 400);
            }

            $user = $this->userUseCase->createUser($request->all());
            $token = $user->createToken('myapptoken')->plainTextToken;


            return response()->json([
                'message' => '',
                'data' => $user,
                'token' => $token
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string',
                'password' => 'required|string'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'msg' => $validator->errors(),
                    'data' => []
                ], 400);
            }
            $data = $request->all();
            $user = $this->userUseCase->getUser($data['email']);
            if (!$user || !Hash::check($data['password'], $user->password)) {
                return response()->json([
                    'message' => 'Password incorrect',
                    'data' => []
                ], 401);
            }
            $token = $user->createToken('myapptoken')->plainTextToken;


            return response()->json([
                'message' => '',
                'data' => $user,
                'token' => $token
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            auth()->user()->tokens()->delete();

            return response()->json([
                'message' => 'log out successful',
                'data' => []
            ], 200);

        }catch (\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }
}
