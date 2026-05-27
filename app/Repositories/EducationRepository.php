<?php

namespace App\Repositories;

use App\Interfaces\EducationRepositoryInterface;
use App\Models\EducationContent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EducationRepository implements EducationRepositoryInterface
{
    public function published(int $perPage = 10): LengthAwarePaginator
    {
        return EducationContent::with('user')
            ->published()
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function create(array $data): EducationContent
    {
        return EducationContent::create($data);
    }

    public function find(int $id): ?EducationContent
    {
        return EducationContent::with('user')->find($id);
    }

    public function incrementReadCount(EducationContent $content): EducationContent
    {
        $content->increment('read_count');

        return $content->fresh('user');
    }
}
