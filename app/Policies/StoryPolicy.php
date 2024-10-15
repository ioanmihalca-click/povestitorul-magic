<?php

namespace App\Policies;

use App\Models\Story;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StoryPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Story $story)
    {
        return $user->id === $story->user_id;
    }

    // Poți adăuga alte metode aici pentru alte acțiuni (update, delete, etc.)
}