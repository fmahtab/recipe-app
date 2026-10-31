<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Recipes</title>
</head>
<body>
    <h1>Recipes</h1>

    <p><a href="{{ route('recipes.create') }}">Add a recipe</a></p>

    <form method="GET" action="{{ route('recipes.index') }}">
        <input type="text" name="q" value="{{ $search }}" placeholder="Search recipes">
        <button type="submit">Search</button>
        @if ($search !== '')
            <a href="{{ route('recipes.index') }}">Clear</a>
        @endif
    </form>


    <ul>
        @forelse ($recipes as $recipe)
            <li>
                <a href="{{ route('recipes.show', $recipe) }}">{{ $recipe->title }}</a>
                ({{ $recipe->prep_minutes }} min, serves {{ $recipe->servings }})
            </li>
        @empty
            <li>No recipes yet.</li>
        @endforelse
    </ul>
</body>
</html>