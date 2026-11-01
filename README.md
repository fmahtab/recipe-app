# Recipe App

A Laravel app for saving recipes with their ingredients. Each recipe can have many ingredients, and each ingredient can appear in many recipes. Each link stores its quantity and unit.

## Features

- Add a recipe with a title, prep time, servings, steps, and any number of ingredients
- Validation with a Form Request, which skips blank ingredient rows
- List all recipes, newest first
- Search recipes by title or by ingredient name
- Recipe detail page showing ingredients with quantities
- Add-ingredient button, written in TypeScript and built with Vite

## Tech Stack

- PHP 8.3+ and Laravel
- SQLite database
- Blade templates
- TypeScript and Vite for the frontend
- PHPUnit feature tests

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

4. Create the SQLite database file:

   ```bash
   touch database/database.sqlite
   ```

   On Windows PowerShell, use `New-Item database\database.sqlite` instead.

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