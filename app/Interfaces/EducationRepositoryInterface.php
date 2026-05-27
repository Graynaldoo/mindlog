<?php

namespace App\Interfaces;

use App\Models\EducationContent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface EducationRepositoryInterface
{
    public function published(int $perPage = 10): LengthAwarePaginator;

    public function create(array $data): EducationContent;

    public function find(int $id): ?EducationContent;

    public function incrementReadCount(EducationContent $content): EducationContent;
}
