<?php

namespace App\Repositories;

use App\Interfaces\ArticleRepositoryInterface;
use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function paginate(?string $status = null, int $perPage = 10): LengthAwarePaginator
    {
        return Article::with('category', 'author')
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate($perPage);
    }

    public function published(int $perPage = 10): LengthAwarePaginator
    {
        return Article::with('category', 'author')
            ->published()
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function publishedByCategory(int $categoryId, int $perPage = 9): LengthAwarePaginator
    {
        return Article::with('category', 'author')
            ->published()
            ->where('category_id', $categoryId)
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function latestPublished(int $limit = 5): Collection
    {
        return Article::with('category', 'author')
            ->published()
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    public function find(int $id): ?Article
    {
        return Article::with('category', 'author')->find($id);
    }

    public function findBySlug(string $slug): ?Article
    {
        return Article::with('category', 'author')->where('slug', $slug)->first();
    }

    public function create(array $data): Article
    {
        return Article::create($data);
    }

    public function update(Article $article, array $data): Article
    {
        $article->update($data);

        return $article->fresh('category', 'author');
    }

    public function delete(Article $article): bool
    {
        return $article->delete();
    }

    public function incrementReadCount(Article $article): Article
    {
        $article->increment('read_count');

        return $article->fresh('category', 'author');
    }
}
