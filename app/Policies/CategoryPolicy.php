<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function create(User $user): bool
    {
        return $user->hasPermission('category.manage');
    }

    public function update(User $user, Category $category): bool
    {
        return $user->hasPermission('category.manage');
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->hasPermission('category.manage');
    }
}
