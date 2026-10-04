<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    // URL slugs of the static pages linked from the footer
    public const SLUGS = ['privacy', 'terms', 'cookies', 'documentation', 'guide', 'support'];

    // Shows one static page
    public function show(string $page): View
    {
        abort_unless(in_array($page, self::SLUGS, true), 404);

        return view('pages.show', ['page' => $this->pages()[$page]]);
    }

    // Starter content for every page; review and edit it before going public
    private function pages(): array
    {
        $app = config('app.name');

        return [
            'privacy' => [
                'title' => 'Privacy Policy',
                'intro' => "This policy explains what information {$app} collects and how it is used.",
                'sections' => [
                    'What we collect' => 'Your name, email address, and a securely hashed password when you register. Everything you enter while building a portfolio, such as education, skills, projects, work experience, and social links, plus any profile picture or resume you upload. If you join the newsletter, we store the email address you provide.',
                    'How we use it' => 'To run your account, save and display your portfolios, and send account emails such as password resets. Newsletter addresses are used only for product updates and new template releases.',
                    'Storage and security' => 'Portfolio data is kept in an online database and uploaded files on private storage attached to the application. Passwords are hashed, and only you can view, edit, or delete your portfolios while signed in.',
                    'Your choices' => 'You can edit or delete any portfolio at any time from the Manage page. You can delete your account from the account settings page, which also removes your portfolios. Contact us to unsubscribe from the newsletter.',
                    'Sharing' => 'We do not sell your personal information.',
                ],
            ],
            'terms' => [
                'title' => 'Terms of Service',
                'intro' => "By creating an account you agree to these terms for using {$app}.",
                'sections' => [
                    'Using the service' => 'Provide accurate information and keep your login details secure. You are responsible for the content you add to your portfolios.',
                    'Your content' => 'You keep ownership of everything you write or upload. You allow us to store it and display it to you in order to provide the service.',
                    'Acceptable use' => 'Do not upload unlawful, harmful, or infringing material, and do not try to access other people\'s accounts or data.',
                    'Availability' => 'The service is provided as is. Features may change, and the service may be paused for maintenance without notice.',
                ],
            ],
            'cookies' => [
                'title' => 'Cookie Policy',
                'intro' => "This page explains the cookies and browser storage {$app} uses.",
                'sections' => [
                    'Essential cookies' => 'A session cookie keeps you signed in, and a security token cookie protects forms from forgery. The site cannot work without them.',
                    'Preferences' => 'Your light or dark theme choice is saved in your browser\'s local storage so it is remembered on your next visit.',
                    'No advertising cookies' => 'We do not use advertising or third-party tracking cookies.',
                    'Managing cookies' => 'You can clear cookies and site data in your browser settings. Clearing them signs you out.',
                ],
            ],
            'documentation' => [
                'title' => 'Documentation',
                'intro' => 'A quick reference for everything the portfolio builder can do.',
                'sections' => [
                    'Creating a portfolio' => 'Use Create Portfolio and complete the form: personal information, education, skills, projects, work experience, and social links. Empty rows are ignored when you save.',
                    'Templates' => 'Choose Simple, Modern, or Creative. You can preview each one with your data before selecting it, and change it later from the preview page.',
                    'Uploads' => 'Profile pictures can be JPG, JPEG, PNG, or WEBP up to 2 MB. Resumes must be PDF files up to 5 MB.',
                    'Managing portfolios' => 'The Manage page lists your portfolios. Search by name, email, or title, sort by name or date, and view, edit, or delete any entry.',
                    'Account' => 'Update your name, email, and password from the account settings page.',
                ],
            ],
            'guide' => [
                'title' => 'User Guide',
                'intro' => 'Go from sign-up to a finished portfolio in five steps.',
                'sections' => [
                    '1. Create an account' => 'Register with your name, email, and a password, then sign in.',
                    '2. Enter your information' => 'Click Create Portfolio and fill in the form. Add as many education, project, and experience entries as you need.',
                    '3. Choose a template' => 'Preview Simple, Modern, and Creative with your own data, then select your favorite.',
                    '4. Review your portfolio' => 'Check the generated result. Use Edit to change details or Change Template to switch designs.',
                    '5. Keep it up to date' => 'Return to the Manage page any time to update or delete a portfolio.',
                ],
            ],
            'support' => [
                'title' => 'Support Center',
                'intro' => 'Answers to common problems.',
                'sections' => [
                    'I cannot sign in' => 'Check your email and password, or use the forgot password link on the login page to request a reset.',
                    'My upload failed' => 'Pictures must be JPG, JPEG, PNG, or WEBP up to 2 MB, and resumes must be PDF files up to 5 MB.',
                    'I cannot see my portfolio' => 'Portfolios belong to the account that created them. Make sure you are signed in with the same account.',
                    'Still stuck?' => 'Email us using the address below and describe what you were doing when the problem happened.',
                ],
            ],
        ];
    }
}
