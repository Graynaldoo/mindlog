<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    public function create(User $user): bool
    {
        return $user->hasPermission('article.create');
    }

    public function update(User $user, Article $article): bool
    {
        return $user->hasRole('admin')
            || ($user->hasRole('educator') && $article->author_id === $user->id);
    }

    public function delete(User $user, Article $article): bool
    {
        return $user->hasRole('admin');
    }
}
