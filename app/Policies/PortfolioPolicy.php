<?php

namespace App\Policies;

use App\Models\Portfolio;
use App\Models\User;

class PortfolioPolicy
{
    // Any logged-in user can see their own list
    public function viewAny(User $user): bool
    {
        return true;
    }

    // Only the owner can view a portfolio in the dashboard
    public function view(User $user, Portfolio $portfolio): bool
    {
        return $user->id === $portfolio->user_id;
    }

    // Any logged-in user can create a portfolio
    public function create(User $user): bool
    {
        return true;
    }

    // Only the owner can edit a portfolio
    public function update(User $user, Portfolio $portfolio): bool
    {
        return $user->id === $portfolio->user_id;
    }

    // Only the owner can delete a portfolio
    public function delete(User $user, Portfolio $portfolio): bool
    {
        return $user->id === $portfolio->user_id;
    }
}
