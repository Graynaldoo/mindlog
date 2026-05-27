<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use App\Models\User;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    public function generate(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:255',
        ]);

        $plainKey = User::generateApiKey();
        $apiKey = ApiKey::create([
            'user_id' => auth()->id(),
            'name' => $data['name'] ?? 'Default API Key',
            'key_hash' => hash('sha256', $plainKey),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'API key berhasil dibuat. Simpan key ini karena tidak ditampilkan lagi.',
            'data' => [
                'id' => $apiKey->id,
                'name' => $apiKey->name,
                'api_key' => $plainKey,
            ],
        ], 201);
    }

    public function revoke(ApiKey $apiKey)
    {
        abort_unless($apiKey->user_id === auth()->id() || auth()->user()->hasRole('admin'), 403);

        $apiKey->update(['revoked_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'API key berhasil dicabut.',
        ]);
    }

    public function validateKey()
    {
        return response()->json([
            'success' => true,
            'message' => 'API key valid.',
            'data' => auth()->user()->only('id', 'name', 'email'),
        ]);
    }
}
