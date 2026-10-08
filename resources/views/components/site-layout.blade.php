{{-- Main page shell: navbar, flash message, content slot, footer --}}
@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ? $title . ' · ' : '' }}{{ config('app.name') }}</title>
       <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    {{-- Keeps Alpine-controlled elements (menus, footer pop-ups) hidden until Alpine has started --}}
    <style>
        [x-cloak] { display: none !important; }

        /* Dark gradient page background (plain CSS so it works even if Tailwind hasn't been rebuilt) */
        .site-body {
            background:
                radial-gradient(60rem 30rem at 50% -10%, rgba(79, 70, 229, 0.18), transparent 60%),
                radial-gradient(40rem 25rem at 100% 100%, rgba(192, 38, 211, 0.10), transparent 60%),
                linear-gradient(135deg, #020617 0%, #0f172a 55%, #1e1b4b 100%);
            background-attachment: fixed;
            color: #e2e8f0;
        }

        /* Transparent header with no border */
        /* Glassmorphic header */
        .site-header {
            background: rgba(3, 5, 11, 0.72);
            -webkit-backdrop-filter: blur(16px);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .site-header .nav-link { color: #cbd5e1; }
        .site-header .nav-link:hover { background: rgba(255, 255, 255, 0.08); color: #ffffff; }

        .site-header .nav-account-btn {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #e2e8f0;
        }
        .site-header .nav-account-btn:hover { background: rgba(255, 255, 255, 0.12); }
        .site-header .nav-account-btn svg { color: #94a3b8; }

        .site-header .nav-menu {
            background: #0b0f1c;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.5);
        }
        .site-header .nav-menu a,
        .site-header .nav-menu button { color: #cbd5e1; }
        .site-header .nav-menu a:hover,
        .site-header .nav-menu button:hover { background: rgba(255, 255, 255, 0.08); color: #ffffff; }

        .site-header .nav-toggle { color: #cbd5e1; }
        .site-header .nav-toggle:hover { background: rgba(255, 255, 255, 0.08); color: #ffffff; }

        .site-header .nav-mobile {
            background: #070a14;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }
        .site-header .nav-mobile a,
        .site-header .nav-mobile button { color: #cbd5e1; }
        .site-header .nav-mobile a:hover,
        .site-header .nav-mobile button:hover { background: rgba(255, 255, 255, 0.08); color: #ffffff; }

        /* Footer layout (plain CSS so it works even if Tailwind hasn't been rebuilt) */
        .footer-grid { display: grid; gap: 2.5rem; grid-template-columns: 1fr; }
        @media (min-width: 640px)  { .footer-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .footer-grid { grid-template-columns: 5fr 3fr 4fr; } }
        .footer-legal { display: flex; flex-wrap: wrap; justify-content: center; gap: 0.5rem 1.5rem; list-style: none; margin: 0; padding: 0; }

        /* Dark footer (plain CSS; scoped so the Privacy/Terms pop-up stays white) */
        .site-footer { background: #0f172a; border-top: 1px solid #1e293b; }
        .site-footer .footer-grid h3 { color: #ffffff; }
        .site-footer .footer-grid p,
        .site-footer .footer-grid ul { color: #94a3b8; }
        .site-footer .footer-grid a { color: #94a3b8; }
        .site-footer .footer-grid a:hover { color: #a5b4fc; }
        .site-footer .footer-grid .footer-social a { border-color: #334155; }
        .site-footer .footer-grid .footer-social a:hover { border-color: #818cf8; color: #a5b4fc; }
        .site-footer .footer-contact svg { color: #818cf8; }
        .site-footer .footer-bottom { border-top-color: #1e293b; color: #94a3b8; }
        .site-footer .footer-bottom button:hover { color: #a5b4fc; }

        /* Team / group members */
        .site-footer .footer-team { margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #1e293b; }
        .site-footer .footer-team h3 { color: #ffffff; font-size: 0.875rem; font-weight: 600; margin: 0; }
        .site-footer .footer-team-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 0.75rem 1.5rem; list-style: none; margin: 1rem 0 0; padding: 0; font-size: 0.875rem; color: #94a3b8; }
        .site-footer .footer-team-list li { display: flex; align-items: center; gap: 0.625rem; }
        .site-footer .footer-team-list li::before { content: ""; width: 6px; height: 6px; border-radius: 9999px; background: #818cf8; flex-shrink: 0; }
    </style>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Optional per-page head content (the homepage uses this for its 3D background) --}}
    @stack('head')
</head>
<body class="site-body min-h-screen font-sans antialiased">

{{-- Optional per-page background layer, sits behind everything (empty on most pages) --}}
@stack('background')

<div class="flex min-h-screen flex-col">

    {{-- Top navigation with a mobile menu --}}
    <header x-data="{ open: false }" class="site-header sticky top-0 z-40">
        <nav class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8" aria-label="Main navigation">
            {{-- Header logo (public/images/logo.png) --}}
            <a href="{{ route('home') }}" aria-label="{{ config('app.name') }} home" class="flex shrink-0 items-center">
                <img src="{{ asset('images/shxn.png') }}" alt="{{ config('app.name') }} logo" class="-my-2 h-14 w-auto max-w-[220px] object-contain">
            </a>

            {{-- Desktop links --}}
            <div class="hidden items-center gap-1 md:flex">
                <a href="{{ route('home') }}" class="nav-link rounded-lg px-3 py-2 text-sm font-medium transition">Home</a>
                <a href="{{ route('templates.index') }}" class="nav-link rounded-lg px-3 py-2 text-sm font-medium transition">Templates</a>
                @auth
                    <a href="{{ route('portfolios.index') }}" class="nav-link rounded-lg px-3 py-2 text-sm font-medium transition">My Portfolios</a>
                    <a href="{{ route('portfolios.create') }}" class="ml-2 inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:shadow-md hover:brightness-110">
                        <x-icon name="plus" class="h-4 w-4" /> Create
                    </a>

                    {{-- Account dropdown --}}
                    <div x-data="{ menu: false }" @click.outside="menu = false" class="relative ml-2">
                        <button type="button" @click="menu = !menu" class="nav-account-btn flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium transition" :aria-expanded="menu">
                            {{ auth()->user()->name }}
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/></svg>
                        </button>
                        <div x-show="menu" x-cloak x-transition class="nav-menu absolute right-0 mt-2 w-48 overflow-hidden rounded-xl py-1">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm">Account settings</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2 text-left text-sm">Log out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="nav-link rounded-lg px-3 py-2 text-sm font-medium transition">Log in</a>
                    <a href="{{ route('register') }}" class="ml-1 inline-flex items-center rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:shadow-md hover:brightness-110">Get started</a>
                @endauth
            </div>

            {{-- Mobile menu button --}}
            <button type="button" @click="open = !open" class="nav-toggle rounded-lg p-2 md:hidden" :aria-expanded="open" aria-label="Toggle menu">
                <x-icon name="x-mark" class="h-6 w-6" x-show="open" x-cloak />
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
            </button>
        </nav>

        {{-- Mobile links --}}
        <div x-show="open" x-cloak x-transition class="nav-mobile px-4 py-3 md:hidden">
            <div class="flex flex-col gap-1">
                <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 text-sm font-medium">Home</a>
                <a href="{{ route('templates.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium">Templates</a>
                @auth
                    <a href="{{ route('portfolios.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium">My Portfolios</a>
                    <a href="{{ route('portfolios.create') }}" class="rounded-lg px-3 py-2 text-sm font-medium">Create Portfolio</a>
                    <a href="{{ route('profile.edit') }}" class="rounded-lg px-3 py-2 text-sm font-medium">Account settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full rounded-lg px-3 py-2 text-left text-sm font-medium">Log out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 text-sm font-medium">Log in</a>
                    <a href="{{ route('register') }}" class="rounded-lg px-3 py-2 text-sm font-medium">Register</a>
                @endauth
            </div>
        </div>
    </header>

   {{-- Flash message shown after saving, updating, or deleting --}}
    @if (session('status'))
        <div x-data="{ show: true }" x-show="show" x-transition class="mx-auto mt-4 w-full max-w-6xl px-4 sm:px-6 lg:px-8" role="status">
            <div style="background-color: #064e3b !important; border: 1px solid #10b981 !important; color: #ecfdf5 !important;" class="flex items-center justify-between gap-3 rounded-2xl px-4 py-3 text-sm font-medium shadow-lg">
                <span>{{ session('status') }}</span>
                <button type="button" @click="show = false" style="color: #6ee7b7;" aria-label="Dismiss"><x-icon name="x-mark" class="h-4 w-4" /></button>
            </div>
        </div>
    @endif

    <main class="flex-1">{{ $slot }}</main>

    {{-- ================= FOOTER ================= --}}
    @php
        // Edit these values to change the footer details
        $footer = [
            'about'   => 'We are working together to improve and maintain the deployed website. We will continue adding features, fixing issues, and refining the design to make the website better and more user-friendly.',
            'email'   => 'shinjilecalvo@gmail.com',
            'phone'   => '+63 970 778 5469',
            'address' => 'Cebu City, Philippines',
            'social'  => [
                'Facebook'  => 'https://www.facebook.com/shinji201/',
                'Instagram' => 'https://www.instagram.com/ei.shxn/',
            ],
            // Group members shown in the footer (edit names here)
            'team'    => [
                'Calvo Shinji Lei',
                'Tudtud Daniel Kim A.',
                'Parba Zyra Mae P.',
                'Belandres Kate A.',
                'Nacua Tyron E.',
                'Manaba Eljun Nish L.',
                'Cudiera Angelo V.',
            ],
        ];

        // Icon paths for the contact list
        $contactIcons = [
            'email'   => 'M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75',
            'phone'   => 'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z',
            'address' => 'M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z',
        ];
    @endphp
    <footer x-data="{ modal: null }" @keydown.escape.window="modal = null"
            x-effect="document.body.style.overflow = modal ? 'hidden' : ''; if (modal) { $nextTick(() => $refs.closeBtn && $refs.closeBtn.focus()) }"
            aria-labelledby="footer-heading" class="site-footer">
        <h2 id="footer-heading" class="sr-only">Footer</h2>

        <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="footer-grid">

                {{-- Logo, website name, about us, and social media --}}
                <div id="about-us">
                    {{-- Footer logo (public/images/logo.png) --}}
                    <a href="{{ route('home') }}" aria-label="{{ config('app.name') }} home" class="inline-flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }} logo" class="h-16 w-auto max-w-[240px] object-contain" style="filter: brightness(0) invert(1);">
                    </a>
                    <h3 class="mt-6 text-sm font-semibold text-slate-900">About Us</h3>
                    <p class="mt-2 max-w-md text-sm leading-6 text-slate-600">{{ $footer['about'] }}</p>

                    <h3 class="mt-6 text-sm font-semibold text-slate-900">Follow Us</h3>
                    <ul class="footer-social mt-3 flex gap-2">
                        @foreach ($footer['social'] as $network => $url)
                            <li>
                                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $network }}"
                                   class="flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 text-slate-500 transition duration-200 hover:-translate-y-0.5 hover:border-indigo-300 hover:text-indigo-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5" aria-hidden="true">
                                        @if ($network === 'Facebook')
                                            <path d="M7 10v4h3v7h4v-7h3l1-4h-4V8a1 1 0 0 1 1-1h3V3h-3a5 5 0 0 0-5 5v2H7" />
                                        @elseif ($network === 'Instagram')
                                            <rect x="4" y="4" width="16" height="16" rx="4" />
                                            <circle cx="12" cy="12" r="3" />
                                            <line x1="16.5" y1="7.5" x2="16.5" y2="7.501" />
                                        @elseif ($network === 'TikTok')
                                            <path d="M21 7.917v4.034a9.948 9.948 0 0 1-5-1.951v4.5a6.5 6.5 0 1 1-8-6.326v4.326a2.5 2.5 0 1 0 4 2v-11.5h4.083a6.005 6.005 0 0 0 4.917 4.917z" />
                                        @endif
                                    </svg>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Quick links --}}
                <nav aria-label="Quick links">
                    <h3 class="text-sm font-semibold text-slate-900">Quick Links</h3>
                    <ul class="mt-4 space-y-3 text-sm text-slate-600">
                        <li><a href="{{ route('home') }}" class="transition hover:text-indigo-600">Home</a></li>
                        <li><a href="#about-us" class="transition hover:text-indigo-600">About</a></li>
                        <li><a href="{{ route('templates.index') }}" class="transition hover:text-indigo-600">Templates</a></li>
                        <li><a href="#contact-info" class="transition hover:text-indigo-600">Contact</a></li>
                    </ul>
                </nav>

                {{-- Contact information --}}
                <div id="contact-info">
                    <h3 class="text-sm font-semibold text-slate-900">Contact Information</h3>
                    <ul class="footer-contact mt-4 space-y-3 text-sm text-slate-600">
                        @foreach (['email' => $footer['email'], 'phone' => $footer['phone'], 'address' => $footer['address']] as $type => $value)
                            <li class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-5 w-5 shrink-0 text-indigo-600" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $contactIcons[$type] }}" /></svg>
                                <span>
                                    <span class="sr-only">{{ ucfirst($type) }}: </span>
                                    @if ($type === 'email')
                                        <a href="mailto:{{ $value }}" class="break-all transition hover:text-indigo-600">{{ $value }}</a>
                                    @elseif ($type === 'phone')
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $value) }}" class="transition hover:text-indigo-600">{{ $value }}</a>
                                    @else
                                        {{ $value }}
                                    @endif
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Group members --}}
            <div class="footer-team">
                <h3>Our Team</h3>
                <ul class="footer-team-list">
                    @foreach ($footer['team'] as $member)
                        <li>{{ $member }}</li>
                    @endforeach
                </ul>
            </div>

            {{-- Copyright and legal links --}}
            <div class="footer-bottom mt-12 flex flex-col items-center justify-between gap-4 border-t border-slate-200 pt-8 text-sm text-slate-500 sm:flex-row">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.</p>
                <ul class="footer-legal">
                    <li><button type="button" @click="modal = 'privacy'" class="rounded transition hover:text-indigo-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">Privacy Policy</button></li>
                    <li><button type="button" @click="modal = 'terms'" class="rounded transition hover:text-indigo-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">Terms &amp; Conditions</button></li>
                </ul>
            </div>
        </div>

        {{-- Pop-up window for the Privacy Policy and Terms & Conditions --}}
        <div x-show="modal" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4" @click.self="modal = null">
            <div role="dialog" aria-modal="true" :aria-label="modal === 'privacy' ? 'Privacy Policy' : 'Terms and Conditions'"
                 class="relative max-h-[85vh] w-full max-w-lg overflow-y-auto rounded-3xl bg-white p-6 shadow-2xl sm:p-8">
                <button type="button" x-ref="closeBtn" @click="modal = null" aria-label="Close"
                        class="absolute right-4 top-4 flex h-11 w-11 items-center justify-center rounded-xl text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                    <x-icon name="x-mark" class="h-5 w-5" />
                </button>

                <div x-show="modal === 'privacy'" class="space-y-4 text-sm leading-6 text-slate-600">
                    <h2 class="pr-10 text-2xl font-bold text-slate-900">Privacy Policy</h2>
                    <p>This policy explains what information {{ config('app.name') }} collects and how it is used.</p>
                    <p><strong class="text-slate-900">What we collect.</strong> Your name, email address, and a securely hashed password when you register, plus everything you enter into your portfolios and any picture or resume you upload.</p>
                    <p><strong class="text-slate-900">How we use it.</strong> To run your account and to save and display your portfolios. We do not sell your personal information.</p>
                    <p><strong class="text-slate-900">Your control.</strong> Only you can view, edit, or delete your portfolios while signed in. You can delete a portfolio at any time from the Manage page.</p>
                </div>

                <div x-show="modal === 'terms'" class="space-y-4 text-sm leading-6 text-slate-600">
                    <h2 class="pr-10 text-2xl font-bold text-slate-900">Terms &amp; Conditions</h2>
                    <p>By creating an account you agree to these terms for using {{ config('app.name') }}.</p>
                    <p><strong class="text-slate-900">Your account.</strong> Provide accurate information and keep your login details secure. You are responsible for the content you add.</p>
                    <p><strong class="text-slate-900">Your content.</strong> You keep ownership of everything you write or upload. You allow us to store it so we can provide the service.</p>
                    <p><strong class="text-slate-900">Acceptable use.</strong> Do not upload unlawful or infringing material, and do not try to access other people's accounts.</p>
                    <p><strong class="text-slate-900">Availability.</strong> The service is provided as is, and features may change without notice.</p>
                </div>
            </div>
        </div>
    </footer>
</div>

@stack('scripts')
</body>
</html>