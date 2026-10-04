# Deploying to Railway (app + MySQL)

Railway detects Laravel automatically (Railpack + FrankenPHP). On every deploy it installs
Composer packages, runs `npm run build`, runs `php artisan migrate --force`, creates the
`public/storage` link, and caches config and routes. You do not need a Dockerfile.

## 1. Prepare the project (once)

1. Copy `app/Providers/AppServiceProvider.php` and `.env.example` from this stage into the project.
2. Open `bootstrap/app.php`. Inside `->withMiddleware(function (Middleware $middleware) { ... })`
   add this line (replace the `//` comment if that is all that is there):

       $middleware->trustProxies(at: '*');

3. Generate a production key and copy the output (starts with `base64:`):

       php artisan key:generate --show

## 2. Put the code on GitHub

1. Create an empty repository at https://github.com/new named `portfolio-generator`
   (no README, no .gitignore).
2. In CMD, from the project folder:

       git init
       git add .
       git commit -m "Portfolio Template Generator"
       git branch -M main
       git remote add origin https://github.com/YOUR-USERNAME/portfolio-generator.git
       git push -u origin main

`.env` is ignored by Git, so your local passwords are never uploaded. Check that `.env`
does not appear on GitHub.

## 3. Create the Railway project

1. Sign up at https://railway.com (GitHub login is easiest). Check the current plan and
   trial terms on the sign-up page.
2. **New Project > Deploy from GitHub repo**, select `portfolio-generator`.
3. Click **Add Variables** BEFORE the first deploy (step 5).
4. In the project canvas click **+ New > Database > Add MySQL**. The service is named `MySQL`.

## 4. Attach a volume for uploads

Railway containers lose local files on every redeploy, so uploaded pictures and resumes need
a volume.

1. Open the app service, then add a **Volume** (Settings, or press Ctrl+K and search "volume").
2. Mount path: `/app/storage/app/public`

## 5. App service variables

Add these in the app service (Variables > Raw Editor). Replace the APP_KEY value.

    APP_NAME="Portfolio Generator"
    APP_ENV=production
    APP_DEBUG=false
    APP_KEY=base64:PASTE_THE_KEY_FROM_STEP_1
    APP_URL=https://${{RAILWAY_PUBLIC_DOMAIN}}
    DB_CONNECTION=mysql
    DB_URL=${{MySQL.MYSQL_URL}}
    SESSION_DRIVER=database
    SESSION_SECURE_COOKIE=true
    CACHE_STORE=database
    QUEUE_CONNECTION=database
    FILESYSTEM_DISK=local
    PORTFOLIO_DISK=public
    LOG_CHANNEL=stderr
    LOG_LEVEL=error
    RAILPACK_PHP_EXTENSIONS=pdo_mysql

If your MySQL service has a different name than `MySQL`, use that name in `DB_URL`.

## 6. Get a public URL

App service > Settings > Networking > **Generate Domain**. Then redeploy if the deploy ran
before the domain existed (so APP_URL is filled in).

## 7. Test the live site

1. Open the URL and register a new account (the demo seeder is not run in production).
2. Create a portfolio with a picture and a PDF resume, pick a template, preview it.
3. Deployments > **Redeploy**. Open the portfolio again. If the picture is still there, the
   volume works.

## Troubleshooting

- **Build or deploy fails:** open the deployment and read the Build Logs and Deploy Logs.
- **500 error:** the real message is in the Deploy Logs (LOG_CHANNEL=stderr). Temporarily set
  APP_DEBUG=true to see it in the browser, then set it back to false.
- **"Access denied" or connection errors:** check DB_URL, and that the MySQL service is running.
- **Page looks unstyled or has mixed-content warnings:** check that APP_URL starts with https://
  and that step 1.2 was done.
- **419 Page Expired after login:** check SESSION_SECURE_COOKIE=true and APP_URL, then clear
  browser cookies for the site.
- **Uploads disappear after redeploy:** the volume is missing or has the wrong mount path.
- **Permission denied when uploading:** add the variable RAILWAY_RUN_UID=0 and redeploy.
- **Connecting from your own PC:** the database is private by default. Enable Public Access in the
  MySQL service Settings > Networking, and use `MYSQL_PUBLIC_URL`. Public access can add network charges,
  so turn it off when finished.
