<?php

namespace App\Http\Requests;

class UpdatePortfolioRequest extends StorePortfolioRequest
{
    // Only the owner may update; the route parameter must be named {portfolio}
    public function authorize(): bool
    {
        $portfolio = $this->route('portfolio');

        return $portfolio !== null && $this->user()?->id === $portfolio->user_id;
    }
}
