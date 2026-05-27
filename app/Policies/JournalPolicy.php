<?php

namespace App\Policies;

use App\Models\Journal;
use App\Models\User;

class JournalPolicy
{
    public function view(User $user, Journal $journal): bool
    {
        return $journal->user_id === $user->id || $user->hasRole('admin');
    }

    public function update(User $user, Journal $journal): bool
    {
        return $journal->user_id === $user->id;
    }

    public function delete(User $user, Journal $journal): bool
    {
        return $journal->user_id === $user->id || $user->hasRole('admin');
    }
}
