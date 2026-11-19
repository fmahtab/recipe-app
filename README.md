# Recipe App

A Laravel app for saving recipes with their ingredients. Each recipe can have many ingredients, and each ingredient can appear in many recipes. Each link stores its quantity and unit.

## Features

- Add a recipe with a title, prep time, servings, steps, and any number of ingredients
- Validation with a Form Request, which skips blank ingredient rows
- Search recipes by title or by ingredient name
- Browse recipes newest first, with 10 recipes per page and search preserved across pages
- Recipe detail page showing ingredients with quantities
- Add-ingredient button, written in TypeScript and built with Vite
- Registration with validation and hashed passwords
- Sign-in and sign-out
- Public recipe browsing
- Recipe creation for signed-in users, with ownership assigned automatically
- Editing and deletion restricted to the owner
- Confirmation before deletion

## Tech Stack

- PHP 8.3+ and Laravel
- Blade templates
- TypeScript and Vite for the frontend
- PHPUnit feature tests
- MySQL 8, running in Docker

## Prerequisites

Install these before you start:

- **PHP 8.3 or newer** with the `pdo_mysql` extension
- **Docker Desktop** installed and running
- **Composer 2**, the PHP package manager: https://getcomposer.org
- **Node.js 20 or newer** (includes npm): https://nodejs.org
- **Git**: https://git-scm.com

You don't need to install Laravel separately. The project includes it, and `composer install` downloads the framework into the `vendor/` folder.

## Setup

1. Install PHP dependencies:

   ```bash
   composer install
   ```

2. Install frontend dependencies:

   ```bash
   npm install
   ```

3. Create your environment file and app key:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   On Windows PowerShell, use `copy .env.example .env` instead of `cp`.
   This step writes a secret `APP_KEY` into `.env`. Laravel uses it to encrypt sessions and cookies. Without it, the app shows "No application encryption key has been specified."

4. Start MySQL and configure Laravel’s connection.

   In PowerShell, run the following command. Replace `CHOOSE_A_NEW_PASSWORD` with a password you choose.

   ```powershell
   docker run -d --name recipe-app-mysql `
     -p 127.0.0.1:3307:3306 `
     -e MYSQL_RANDOM_ROOT_PASSWORD=yes `
     -e MYSQL_DATABASE=recipe_app `
     -e MYSQL_USER=recipe_user `
     -e 'MYSQL_PASSWORD=CHOOSE_A_NEW_PASSWORD' `
     -v recipe-app-mysql-data:/var/lib/mysql `
     mysql:8
   ```

   Update these settings in `.env`, using the same password:

   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3307
   DB_DATABASE=recipe_app
   DB_USERNAME=recipe_user
   DB_PASSWORD="your_chosen_password"
   ```

   Clear Laravel’s cached configuration:

   ```powershell
   php artisan config:clear
   ```

   Wait for MySQL to finish initializing before running migrations.

   For later sessions, start the existing container with:

   ```powershell
   docker start recipe-app-mysql
   ```

5. Run the migrations:

   ```bash
   php artisan migrate
   ```

6. Start the app:

   ```bash
   php artisan serve
   ```

   Open http://127.0.0.1:8000/recipes in your browser.

7. For the TypeScript build, run this in a second terminal:

   ```bash
   npm run dev
   ```

## Running Tests

```bash
php artisan test
```

To run only the recipe tests:

```bash
php artisan test --filter=RecipeListTest
```

## Project Structure

- `app/Models/` holds `Recipe` and `Ingredient`, with the `belongsToMany` relationship
- `app/Http/Controllers/RecipeController.php` handles the list, search, detail, and save actions
- `app/Http/Requests/StoreRecipeRequest.php` holds validation rules
- `resources/views/recipes/` holds the Blade pages
- `resources/js/recipe-form.ts` holds the TypeScript for the ingredient button
- `tests/Feature/RecipeListTest.php` holds the feature tests