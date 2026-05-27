<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Streak;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use OpenApi\Annotations as OA;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @OA\Tag(name="Auth", description="Authentication endpoints")
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Auth"},
     *     summary="Register user baru",
     *     @OA\RequestBody(required=true, @OA\JsonContent(
     *         required={"name","email","password","password_confirmation"},
     *         @OA\Property(property="name", type="string", example="Warga Belajar"),
     *         @OA\Property(property="email", type="string", example="user@mindlog.test"),
     *         @OA\Property(property="password", type="string", example="password123"),
     *         @OA\Property(property="password_confirmation", type="string", example="password123")
     *     )),
     *     @OA\Response(response=201, description="Registrasi berhasil")
     * )
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $userRole = Role::where('name', 'user')->first();

        $user = User::create([
            'role_id' => $userRole?->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'api_key' => User::generateApiKey(),
        ]);

        Streak::firstOrCreate(['user_id' => $user->id]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil.',
            'data' => [
                'user' => $user->load('role')->only('id', 'name', 'email', 'role'),
                'api_key' => $user->api_key,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ],
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Auth"},
     *     summary="Login dan mendapatkan JWT",
     *     @OA\RequestBody(required=true, @OA\JsonContent(
     *         required={"email","password"},
     *         @OA\Property(property="email", type="string", example="admin@mindlog.test"),
     *         @OA\Property(property="password", type="string", example="password")
     *     )),
     *     @OA\Response(response=200, description="Login berhasil"),
     *     @OA\Response(response=401, description="Kredensial salah")
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password salah.',
                ], 401);
            }
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat token.',
            ], 500);
        }

        $user = auth()->user()->load('role');

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'user' => $user->only('id', 'name', 'email', 'role'),
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => config('jwt.ttl') * 60,
            ],
        ]);
    }

    /**
     * @OA\Post(path="/api/logout", tags={"Auth"}, summary="Logout JWT", security={{"bearerAuth":{}}}, @OA\Response(response=200, description="Logout berhasil"))
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ]);
    }

    public function refresh()
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());

            return response()->json([
                'success' => true,
                'access_token' => $newToken,
                'token_type' => 'Bearer',
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak bisa di-refresh.',
            ], 401);
        }
    }

    /**
     * @OA\Get(path="/api/profile", tags={"Auth"}, summary="Profil user login", security={{"bearerAuth":{}}}, @OA\Response(response=200, description="Profil user"))
     */
    public function profile()
    {
        return response()->json([
            'success' => true,
            'data' => auth()->user()->load('role', 'streak'),
        ]);
    }

    public function regenerateApiKey()
    {
        $user = auth()->user();
        $user->api_key = User::generateApiKey();
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'API Key berhasil diperbarui.',
            'api_key' => $user->api_key,
        ]);
    }
}
