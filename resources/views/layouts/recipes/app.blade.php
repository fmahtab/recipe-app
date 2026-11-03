<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Recipe Box')</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 0; background: #f7f7f5; color: #222; }
        header { background: #fff; border-bottom: 1px solid #e5e5e0; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        header a { color: #222; text-decoration: none; }
        header .brand { font-weight: 700; }
        main { max-width: 760px; margin: 2rem auto; padding: 0 1rem; }
        .card { background: #fff; border: 1px solid #e5e5e0; border-radius: 8px; padding: 1.5rem; }
        input, textarea { width: 100%; box-sizing: border-box; padding: 0.5rem; border: 1px solid #ccc; border-radius: 6px; font: inherit; }
        button, .btn { background: #2f6f4e; color: #fff; border: 0; border-radius: 6px; padding: 0.5rem 1rem; cursor: pointer; text-decoration: none; display: inline-block; font: inherit; }
        .btn-danger { background: #b03a2e; }
        .alert { background: #e8f5ee; border: 1px solid #b7dfc8; padding: 0.75rem 1rem; border-radius: 6px; margin-bottom: 1rem; }
        .errors { color: #b03a2e; }
    </style>
</head>
<body>
    <header>
        <a class="brand" href="{{ route('recipes.index') }}">Recipe Box</a>
        <a href="{{ route('recipes.create') }}">+ Add recipe</a>
    </header>

    <main>
        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    @vite('resources/js/recipe-form.ts')
</body>
</html>