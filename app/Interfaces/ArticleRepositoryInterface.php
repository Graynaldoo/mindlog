<?php

namespace App\Interfaces;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ArticleRepositoryInterface
{
    public function paginate(?string $status = null, int $perPage = 10): LengthAwarePaginator;

    public function published(int $perPage = 10): LengthAwarePaginator;

    public function latestPublished(int $limit = 5): Collection;

    public function find(int $id): ?Article;

    public function findBySlug(string $slug): ?Article;

    public function create(array $data): Article;

    public function update(Article $article, array $data): Article;

    public function delete(Article $article): bool;

    public function incrementReadCount(Article $article): Article;
}
