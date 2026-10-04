<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePortfolioRequest;
use App\Http\Requests\UpdatePortfolioRequest;
use App\Models\Portfolio;
use App\Services\PortfolioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function __construct(private PortfolioService $portfolios)
    {
    }

    // Manage page: lists the user's portfolios with search and sorting
    public function index(Request $request): View
    {
        $portfolios = Portfolio::ownedBy($request->user()->id)
            ->search($request->query('search'))
            ->sortBy($request->query('sort'))
            ->paginate(9)
            ->withQueryString();

        return view('portfolios.index', [
            'portfolios' => $portfolios,
            'search'     => $request->query('search'),
            'sort'       => $request->query('sort', 'date_desc'),
        ]);
    }

    // Shows the empty portfolio form
    public function create(): View
    {
        Gate::authorize('create', Portfolio::class);

        return view('portfolios.create', ['portfolio' => new Portfolio()]);
    }

    // Saves a new portfolio, then sends the user to pick a template
    public function store(StorePortfolioRequest $request): RedirectResponse
    {
        $portfolio = $this->portfolios->create(
            $request->user(),
            $request->validated(),
            $request->file('profile_picture'),
            $request->file('resume'),
        );

        return redirect()
            ->route('portfolios.template.edit', $portfolio)
            ->with('status', 'Portfolio saved! Now choose a template.');
    }

    // Preview page: renders the portfolio in its selected template
    public function show(Portfolio $portfolio): View
    {
        Gate::authorize('view', $portfolio);

        return view('portfolios.show', [
            'portfolio' => $this->withRelations($portfolio),
            'template'  => $portfolio->selected_template,
            'isPreview' => false,
        ]);
    }

    // Shows the form pre-filled with the saved portfolio
    public function edit(Portfolio $portfolio): View
    {
        Gate::authorize('update', $portfolio);

        return view('portfolios.edit', ['portfolio' => $this->withRelations($portfolio)]);
    }

    // Saves changes to an existing portfolio
    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio): RedirectResponse
    {
        $this->portfolios->update(
            $portfolio,
            $request->validated(),
            $request->file('profile_picture'),
            $request->file('resume'),
        );

        return redirect()
            ->route('portfolios.show', $portfolio)
            ->with('status', 'Portfolio updated.');
    }

    // Deletes a portfolio and its files
    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        Gate::authorize('delete', $portfolio);

        $this->portfolios->delete($portfolio);

        return redirect()
            ->route('portfolios.index')
            ->with('status', 'Portfolio deleted.');
    }

    // Loads every related record a form or template needs
    private function withRelations(Portfolio $portfolio): Portfolio
    {
        return $portfolio->load(['educations', 'skills', 'projects', 'experiences', 'socialLinks']);
    }
}
