<?php

namespace App\Policies;

use App\Models\Journal;
use App\Models\User;

class JournalPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

     public function create(User $user)
    {
        return $user->isMember() || $user->isAdmin();
    }

    public function update(User $user, Journal $journal)
    {
        return $user->isAdmin() ||
               ($user->isMember() && $journal->author_id === $user->id);
    }

    public function delete(User $user, Journal $journal)
    {
        return $user->isAdmin() ||
               ($user->isMember() && $journal->author_id === $user->id);
    }

    public function publish(User $user, Journal $journal)
    {
        return $user->isAdmin() || $user->isMember();
    }


}
