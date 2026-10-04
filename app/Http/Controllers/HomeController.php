<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    // Shows the public landing page
    public function __invoke(): View
    {
        return view('home', ['templates' => config('portfolio.templates')]);
    }
}
