<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\EducationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EducationController extends Controller
{
    public function __construct(private EducationRepositoryInterface $education) {}

    public function index(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $this->education->published((int) $request->query('per_page', 10)),
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->hasPermission('article.create'), 403);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:article,video,tip',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'video_url' => 'nullable|url',
            'status' => 'sometimes|in:draft,published',
            'estimated_minutes' => 'sometimes|integer|min:1|max:180',
        ]);

        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($data['title']) . '-' . Str::lower(Str::random(5));
        $data['status'] = $data['status'] ?? 'draft';
        $data['published_at'] = $data['status'] === 'published' ? now() : null;

        return response()->json([
            'success' => true,
            'message' => 'Konten edukasi berhasil dibuat.',
            'data' => $this->education->create($data)->load('user'),
        ], 201);
    }
}
