<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $recipe->title }}</title>
</head>
<body>
    <p><a href="{{ route('recipes.index') }}">&larr; All recipes</a></p>

    <h1>{{ $recipe->title }}</h1>

    @if ($recipe->description)
        <p>{{ $recipe->description }}</p>
    @endif

    <p>Prep: {{ $recipe->prep_minutes }} minutes &middot; Serves {{ $recipe->servings }}</p>

    <h2>Ingredients</h2>
    <ul>
        @foreach ($recipe->ingredients as $ingredient)
            <li>{{ $ingredient->pivot->quantity }} {{ $ingredient->pivot->unit }} {{ $ingredient->name }}</li>
        @endforeach
    </ul>

    <h2>Steps</h2>
    <div style="white-space: pre-line">{{ $recipe->steps }}</div>
</body>
</html>