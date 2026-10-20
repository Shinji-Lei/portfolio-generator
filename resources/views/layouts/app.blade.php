<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* ---------- App layout: dark + glass ---------- */
            .app-dark {
                min-height: 100vh;
                color: #e5e7eb;
                background-color: #05060f;
                background-image:
                    radial-gradient(700px circle at 10% 0%, rgba(79, 70, 229, 0.20), transparent 60%),
                    radial-gradient(700px circle at 95% 100%, rgba(124, 58, 237, 0.18), transparent 60%),
                    linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
                background-size: auto, auto, 40px 40px, 40px 40px;
                background-attachment: fixed;
            }

            /* page heading bar */
            .app-header {
                background: rgba(18, 19, 30, 0.55);
                -webkit-backdrop-filter: blur(14px);
                backdrop-filter: blur(14px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            }
            .app-dark .app-header h2 { color: #fff; }

            /* glass cards */
            .app-dark .glass-card {
                background: rgba(18, 19, 30, 0.60);
                -webkit-backdrop-filter: blur(18px);
                backdrop-filter: blur(18px);
                border: 1px solid rgba(255, 255, 255, 0.10);
                border-radius: 20px;
                box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
            }

            /* text colors */
            .app-dark .text-gray-900,
            .app-dark .text-gray-800 { color: #f3f4f6; }
            .app-dark .text-gray-700,
            .app-dark .text-gray-600 { color: #d1d5db; }
            .app-dark .text-gray-500,
            .app-dark .text-gray-400 { color: #9ca3af; }
            .app-dark .text-red-600 { color: #f87171; }
            .app-dark .text-green-600 { color: #4ade80; }
            .app-dark label { color: #d1d5db; }

            /* inputs */
            .app-dark input[type="text"],
            .app-dark input[type="email"],
            .app-dark input[type="password"],
            .app-dark input[type="url"],
            .app-dark input[type="number"],
            .app-dark textarea,
            .app-dark select {
                background-color: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.12);
                color: #fff;
                border-radius: 12px;
                box-shadow: none;
            }
            .app-dark input:focus,
            .app-dark textarea:focus,
            .app-dark select:focus {
                border-color: #6366f1;
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.28);
                outline: none;
            }
            .app-dark input::placeholder,
            .app-dark textarea::placeholder { color: #6b7280; }
            .app-dark input:-webkit-autofill,
            .app-dark input:-webkit-autofill:focus {
                -webkit-text-fill-color: #fff;
                -webkit-box-shadow: 0 0 0 1000px #161727 inset;
                caret-color: #fff;
            }
            .app-dark input[type="checkbox"] {
                background-color: rgba(255, 255, 255, 0.06);
                border: 1px solid rgba(255, 255, 255, 0.25);
                color: #6366f1;
            }

            /* primary button (the dark "Save" button) */
            .app-dark .bg-gray-800 {
                background-image: linear-gradient(90deg, #4f46e5, #7c3aed);
                background-color: #4f46e5;
                border: 1px solid rgba(255, 255, 255, 0.10);
                border-radius: 12px;
                color: #fff;
            }

            /* secondary (white) buttons e.g. "Cancel" in the delete modal */
            .app-dark button.bg-white {
                background-color: rgba(255, 255, 255, 0.06);
                border-color: rgba(255, 255, 255, 0.15);
                color: #e5e7eb;
            }

            /* modal panel (delete account confirmation) */
            .app-dark .bg-white.shadow-xl {
                background: #12131e;
                border: 1px solid rgba(255, 255, 255, 0.10);
                color: #e5e7eb;
            }

            /* links */
            .app-dark a.underline { color: #a5b4fc; }
            .app-dark a.underline:hover { color: #fff; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="app-dark">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="app-header">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>