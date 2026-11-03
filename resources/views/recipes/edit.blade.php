<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit {{ $recipe->title }}</title>
    @vite('resources/js/recipe-form.ts')
</head>
<body>
    <h1>Edit Recipe</h1>

    <form method="POST" action="{{ route('recipes.update', $recipe) }}">
        @csrf
        @method('PUT')
        <p><label>Title <input name="title" value="{{ old('title', $recipe->title) }}"></label></p>
        <p><label>Description <textarea name="description">{{ old('description', $recipe->description) }}</textarea></label></p>
        <p><label>Steps <textarea name="steps" rows="6" cols="50">{{ old('steps', $recipe->steps) }}</textarea></label></p>

        
        
        <p><label>Prep minutes <input type="number" name="prep_minutes" value="{{ old('prep_minutes', $recipe->prep_minutes) }}"></label></p>
        <p><label>Servings <input type="number" name="servings" value="{{ old('servings', $recipe->servings) }}"></label></p>

        <h3>Ingredients</h3>
        <div id="ingredient-rows">
            @foreach (old('ingredients', $rows) as $i => $item)
                <p class="ingredient-row">
                    Name <input name="ingredients[{{ $i }}][name]" value="{{ $item['name'] ?? '' }}">
                    Quantity <input name="ingredients[{{ $i }}][quantity]" value="{{ $item['quantity'] ?? '' }}">
                    Unit <input name="ingredients[{{ $i }}][unit]" value="{{ $item['unit'] ?? '' }}">
                </p>
            @endforeach
        </div>
        <button type="button" id="add-ingredient">Add ingredient</button>
        <p><button type="submit">Save changes</button></p>
    </form>
</body>
</html>