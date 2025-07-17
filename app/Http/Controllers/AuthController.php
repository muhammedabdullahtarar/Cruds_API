<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info(
 * version="1.0.0",
 * title="Laravel API Documentation",
 * description="API documentation for Laravel 12 project with Passport and Swagger",
 * @OA\Contact(
 * email="muhammedabdullahtarar@gmail.com"
 * ),
 * @OA\License(
 * name="Apache 2.0",
 * url="http://www.apache.org/licenses/LICENSE-2.0.html"
 * )
 * )
 *
 * @OA\Server(
 * url=L5_SWAGGER_CONST_HOST,
 * description="Laravel API Server"
 * )
 *
 * @OA\SecurityScheme(
 * type="http",
 * description="Bearer Token for authentication",
 * name="bearerAuth",
 * in="header",
 * scheme="bearer",
 * bearerFormat="Passport",
 * securityScheme="bearerAuth",
 * )
 */

class AuthController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/register",
     * operationId="registerUser",
     * tags={"Authentication"},
     * summary="Register a new user",
     * description="Registers a new user and returns an access token.",
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"name","email","password","password_confirmation"},
     * @OA\Property(property="name", type="string", example="John Doe"),
     * @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     * @OA\Property(property="password", type="string", format="password", example="password"),
     * @OA\Property(property="password_confirmation", type="string", format="password", example="password")
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="User registered successfully",
     * @OA\JsonContent(
     * @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     * @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1Qi...")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Validation error",
     * @OA\JsonContent(
     * @OA\Property(property="errors", type="object")
     * )
     * )
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('authToken')->accessToken;

        return response()->json(['user' => $user, 'access_token' => $token], 201);
    }

  /**
     * @OA\Post(
     * path="/api/login",
     * operationId="loginUser",
     * tags={"Authentication"},
     * summary="Log in an existing user",
     * description="Logs in an existing user and returns an access token.",
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"email","password"},
     * @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     * @OA\Property(property="password", type="string", format="password", example="password")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="User logged in successfully",
     * @OA\JsonContent(
     * @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     * @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1Qi...")
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Invalid credentials",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Invalid login credentials")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Validation error",
     * @OA\JsonContent(
     * @OA\Property(property="errors", type="object")
     * )
     * )
     * )
     */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        $user = $request->user();
        $token = $user->createToken('authToken')->accessToken;

        return response()->json(['user' => $user, 'access_token' => $token], 200);
    }

    /**
     * @OA\Post(
     * path="/api/logout",
     * operationId="logoutUser",
     * tags={"Authentication"},
     * summary="Log out authenticated user",
     * description="Revokes the access token of the authenticated user, effectively logging them out.",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="User logged out successfully",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Successfully logged out")
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Unauthenticated",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Unauthenticated.")
     * )
     * )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out']);
    }
}

