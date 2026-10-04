{{-- Main page shell: navbar, flash message, content slot, footer --}}
@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ? $title . ' · ' : '' }}{{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-800 antialiased">
<div class="flex min-h-screen flex-col">

    {{-- Top navigation with a mobile menu --}}
    <header x-data="{ open: false }" class="sticky top-0 z-40 border-b border-slate-200/70 bg-white/80 backdrop-blur">
        <nav class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8" aria-label="Main navigation">
            <a href="{{ route('home') }}" aria-label="{{ config('app.name') }} home"><x-logo /></a>

            {{-- Desktop links --}}
            <div class="hidden items-center gap-1 md:flex">
                <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Home</a>
                <a href="{{ route('templates.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Templates</a>
                @auth
                    <a href="{{ route('portfolios.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">My Portfolios</a>
                    <a href="{{ route('portfolios.create') }}" class="ml-2 inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:shadow-md hover:brightness-110">
                        <x-icon name="plus" class="h-4 w-4" /> Create
                    </a>

                    {{-- Account dropdown --}}
                    <div x-data="{ menu: false }" @click.outside="menu = false" class="relative ml-2">
                        <button type="button" @click="menu = !menu" class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50" :aria-expanded="menu">
                            {{ auth()->user()->name }}
                            <svg class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/></svg>
                        </button>
                        <div x-show="menu" x-cloak x-transition class="absolute right-0 mt-2 w-48 overflow-hidden rounded-xl border border-slate-200 bg-white py-1 shadow-lg">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Account settings</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-slate-700 hover:bg-slate-50">Log out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Log in</a>
                    <a href="{{ route('register') }}" class="ml-1 inline-flex items-center rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:shadow-md hover:brightness-110">Get started</a>
                @endauth
            </div>

            {{-- Mobile menu button --}}
            <button type="button" @click="open = !open" class="rounded-lg p-2 text-slate-600 hover:bg-slate-100 md:hidden" :aria-expanded="open" aria-label="Toggle menu">
                <x-icon name="x-mark" class="h-6 w-6" x-show="open" x-cloak />
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
            </button>
        </nav>

        {{-- Mobile links --}}
        <div x-show="open" x-cloak x-transition class="border-t border-slate-200 bg-white px-4 py-3 md:hidden">
            <div class="flex flex-col gap-1">
                <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Home</a>
                <a href="{{ route('templates.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Templates</a>
                @auth
                    <a href="{{ route('portfolios.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">My Portfolios</a>
                    <a href="{{ route('portfolios.create') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Create Portfolio</a>
                    <a href="{{ route('profile.edit') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Account settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full rounded-lg px-3 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-100">Log out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Log in</a>
                    <a href="{{ route('register') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Register</a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Flash message shown after saving, updating, or deleting --}}
    @if (session('status'))
        <div x-data="{ show: true }" x-show="show" x-transition class="mx-auto mt-4 w-full max-w-6xl px-4 sm:px-6 lg:px-8" role="status">
            <div class="flex items-center justify-between gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                <span>{{ session('status') }}</span>
                <button type="button" @click="show = false" class="text-emerald-700 hover:text-emerald-900" aria-label="Dismiss"><x-icon name="x-mark" class="h-4 w-4" /></button>
            </div>
        </div>
    @endif

    <main class="flex-1">{{ $slot }}</main>

    {{-- Footer --}}
    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-3 px-4 py-8 text-sm text-slate-500 sm:flex-row sm:px-6 lg:px-8">
            <x-logo />
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Build, preview, and manage your portfolio.</p>
            <div class="flex gap-4">
                <a href="{{ route('templates.index') }}" class="hover:text-slate-800">Templates</a>
                <a href="{{ route('login') }}" class="hover:text-slate-800">Log in</a>
            </div>
        </div>
    </footer>
</div>

@stack('scripts')
</body>
</html>
