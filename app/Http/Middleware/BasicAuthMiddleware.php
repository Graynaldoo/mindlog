<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class BasicAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $email = $request->getUser();
        $password = $request->getPassword();

        if (!$email || !$password) {
            return response()->json([
                'success' => false,
                'message' => 'Basic Auth diperlukan.',
            ], 401, ['WWW-Authenticate' => 'Basic realm="MindLog EduSmart API"']);
        }

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password Basic Auth tidak valid.',
            ], 401);
        }

        auth()->setUser($user);
        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}
