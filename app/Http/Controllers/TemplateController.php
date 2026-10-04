<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Support\SamplePortfolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TemplateController extends Controller
{
    // Public gallery of the three templates
    public function gallery(): View
    {
        return view('templates.gallery', ['templates' => config('portfolio.templates')]);
    }

    // Public demo of one template using sample data
    public function demo(string $template): View
    {
        abort_unless(in_array($template, Portfolio::TEMPLATES, true), 404);

        return view('templates.demo', [
            'portfolio' => SamplePortfolio::make($template),
            'template'  => $template,
        ]);
    }

    // Template selection page for a saved portfolio
    public function edit(Portfolio $portfolio): View
    {
        Gate::authorize('update', $portfolio);

        return view('templates.select', [
            'portfolio' => $portfolio,
            'templates' => config('portfolio.templates'),
        ]);
    }

    // Saves the chosen template and shows the finished portfolio
    public function update(Request $request, Portfolio $portfolio): RedirectResponse
    {
        Gate::authorize('update', $portfolio);

        $validated = $request->validate([
            'selected_template' => ['required', Rule::in(Portfolio::TEMPLATES)],
        ], [
            'selected_template.in' => 'Please choose one of the three available templates.',
        ]);

        $portfolio->update($validated);

        return redirect()
            ->route('portfolios.show', $portfolio)
            ->with('status', 'Template applied.');
    }

    // Previews a saved portfolio in any template without saving the choice
    public function preview(Portfolio $portfolio, string $template): View
    {
        Gate::authorize('view', $portfolio);
        abort_unless(in_array($template, Portfolio::TEMPLATES, true), 404);

        return view('portfolios.show', [
            'portfolio' => $portfolio->load(['educations', 'skills', 'projects', 'experiences', 'socialLinks']),
            'template'  => $template,
            'isPreview' => true,
        ]);
    }
}
