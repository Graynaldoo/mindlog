<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function allActive(): Collection
    {
        return Category::where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Category::withCount('articles')
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function find(int $id): ?Category
    {
        return Category::withCount('articles')->find($id);
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {
        $category->update($data);

        return $category->fresh();
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }
}
