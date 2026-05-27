<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiKey;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-Key')
                  ?? $request->query('api_key');

        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'API Key tidak ditemukan. Sertakan header X-API-Key.',
            ], 401);
        }

        $keyRecord = ApiKey::where('key_hash', hash('sha256', $apiKey))->first();
        $user = $keyRecord?->isActive() ? $keyRecord->user : null;

        if ($keyRecord && !$user) {
            return response()->json([
                'success' => false,
                'message' => 'API Key sudah dicabut atau kedaluwarsa.',
            ], 401);
        }

        $user ??= User::where('api_key', $apiKey)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'API Key tidak valid.',
            ], 401);
        }

        if ($keyRecord) {
            $keyRecord->update(['last_used_at' => now()]);
        }

        $request->merge(['api_user' => $user]);
        auth()->setUser($user);

        return $next($request);
    }
}
