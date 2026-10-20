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
            /* ---------- Auth pages: dark + glass (scoped to this layout only) ---------- */
            .auth-bg {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 24px 16px;
                color: #e5e7eb;
                background-color: #05060f;
                background-image:
                    radial-gradient(600px circle at 15% 0%, rgba(79, 70, 229, 0.22), transparent 60%),
                    radial-gradient(600px circle at 90% 100%, rgba(124, 58, 237, 0.20), transparent 60%),
                    linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
                background-size: auto, auto, 40px 40px, 40px 40px;
            }

            .auth-logo img,
            .auth-logo svg {
                filter: brightness(0) invert(1); /* dark logo -> white */
            }

            .auth-card {
                width: 100%;
                max-width: 28rem;
                margin-top: 24px;
                padding: 28px 28px;
                background: rgba(18, 19, 30, 0.60);
                -webkit-backdrop-filter: blur(18px);
                backdrop-filter: blur(18px);
                border: 1px solid rgba(255, 255, 255, 0.10);
                border-radius: 20px;
                box-shadow: 0 20px 50px rgba(0, 0, 0, 0.45);
            }

            /* labels */
            .auth-card label { color: #d1d5db; }

            /* inputs */
            .auth-card input[type="text"],
            .auth-card input[type="email"],
            .auth-card input[type="password"] {
                background-color: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.12);
                color: #fff;
                border-radius: 12px;
                box-shadow: none;
            }
            .auth-card input::placeholder { color: #6b7280; }
            .auth-card input[type="text"]:focus,
            .auth-card input[type="email"]:focus,
            .auth-card input[type="password"]:focus {
                border-color: #6366f1;
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.28);
                outline: none;
            }

            /* browser autofill (otherwise turns the input white) */
            .auth-card input:-webkit-autofill,
            .auth-card input:-webkit-autofill:focus {
                -webkit-text-fill-color: #fff;
                -webkit-box-shadow: 0 0 0 1000px #161727 inset;
                caret-color: #fff;
            }

            /* checkbox */
            .auth-card input[type="checkbox"] {
                background-color: rgba(255, 255, 255, 0.06);
                border: 1px solid rgba(255, 255, 255, 0.25);
                border-radius: 5px;
                color: #6366f1;
            }
            .auth-card input[type="checkbox"]:focus {
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.28);
                outline: none;
            }

            /* links + helper text */
            .auth-card a { color: #a5b4fc; }
            .auth-card a:hover { color: #fff; }
            .auth-card .text-gray-600,
            .auth-card .text-gray-500 { color: #9ca3af; }
            .auth-card .text-red-600 { color: #f87171; }
            .auth-card .text-green-600 { color: #4ade80; }

            /* submit button */
            .auth-card button[type="submit"] {
                background-image: linear-gradient(90deg, #4f46e5, #7c3aed);
                background-color: #4f46e5;
                border: 1px solid rgba(255, 255, 255, 0.10);
                color: #fff;
                border-radius: 12px;
                transition: opacity .15s ease, transform .15s ease;
            }
            .auth-card button[type="submit"]:hover { opacity: .9; }
            .auth-card button[type="submit"]:focus {
                outline: none;
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.35);
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="auth-bg">
            <div class="auth-logo">
                <a href="/">
                    <x-application-logo class="w-48 h-auto" />
                </a>
            </div>

            <div class="auth-card">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>