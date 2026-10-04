<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    // Saves a footer newsletter sign-up and returns to the same page
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email:rfc', 'max:255'],
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email'    => 'Please enter a valid email address.',
        ]);

        // Show errors next to the footer form instead of at the top of the page
        if ($validator->fails()) {
            return back()
                ->withFragment('newsletter')
                ->withErrors($validator, 'newsletter')
                ->withInput();
        }

        // Signing up twice with the same address is harmless
        NewsletterSubscriber::firstOrCreate(['email' => strtolower($request->input('email'))]);

        return back()
            ->withFragment('newsletter')
            ->with('newsletter_status', 'Thanks for subscribing! You will receive product updates and new template releases.');
    }
}
