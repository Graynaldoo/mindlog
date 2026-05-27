<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\ArticleRepositoryInterface;
use App\Interfaces\StatisticsRepositoryInterface;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Article", description="Artikel edukasi dan literasi digital")
 */
class ArticleController extends Controller
{
    public function __construct(
        private ArticleRepositoryInterface $articles,
        private StatisticsRepositoryInterface $statistics,
    ) {}

    /**
     * @OA\Get(path="/api/articles", tags={"Article"}, summary="Daftar artikel", @OA\Response(response=200, description="Berhasil"))
     */
    public function index(Request $request)
    {
        $status = auth()->user()?->hasPermission('article.manage') ? $request->query('status') : 'published';

        return response()->json([
            'success' => true,
            'data' => $status === 'published'
                ? $this->articles->published((int) $request->query('per_page', 10))
                : $this->articles->paginate($status, (int) $request->query('per_page', 10)),
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('create', Article::class), 403);

        $data = $request->validate($this->rules());
        $data['author_id'] = auth()->id();
        $data['slug'] = Str::slug($data['title']) . '-' . Str::lower(Str::random(5));
        $data['published_at'] = ($data['status'] ?? 'draft') === 'published' ? now() : null;

        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil dibuat.',
            'data' => $this->articles->create($data)->load('category', 'author'),
        ], 201);
    }

    public function show(int $id)
    {
        $article = $this->articles->find($id);

        if (!$article) {
            return response()->json(['success' => false, 'message' => 'Artikel tidak ditemukan.'], 404);
        }

        if ($article->status === 'published' && auth()->check()) {
            $this->articles->incrementReadCount($article);
            $this->statistics->recordArticleRead(auth()->id(), $article->estimated_minutes);
        }

        return response()->json(['success' => true, 'data' => $article->fresh('category', 'author')]);
    }

    public function update(Request $request, int $id)
    {
        $article = $this->articles->find($id);

        if (!$article || auth()->user()->cannot('update', $article)) {
            return response()->json(['success' => false, 'message' => 'Artikel tidak ditemukan.'], 404);
        }

        $data = $request->validate($this->rules(false));
        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']) . '-' . Str::lower(Str::random(5));
        }
        if (($data['status'] ?? $article->status) === 'published' && !$article->published_at) {
            $data['published_at'] = now();
        }

        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil diperbarui.',
            'data' => $this->articles->update($article, $data),
        ]);
    }

    public function destroy(int $id)
    {
        $article = $this->articles->find($id);

        if (!$article || auth()->user()->cannot('delete', $article)) {
            return response()->json(['success' => false, 'message' => 'Artikel tidak ditemukan.'], 404);
        }

        $this->articles->delete($article);

        return response()->json(['success' => true, 'message' => 'Artikel berhasil dihapus.']);
    }

    private function rules(bool $required = true): array
    {
        $rule = $required ? 'required' : 'sometimes';

        return [
            'category_id' => "{$rule}|exists:categories,id",
            'title' => "{$rule}|string|max:255",
            'excerpt' => 'nullable|string|max:500',
            'content' => "{$rule}|string",
            'status' => 'sometimes|in:draft,published',
            'estimated_minutes' => 'sometimes|integer|min:1|max:180',
        ];
    }
}
