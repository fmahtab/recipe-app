<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Recipe</title>
</head>
<body>
    <h1>Add a Recipe</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('recipes.store') }}">
        @csrf

        <p><label>Title <input name="title" value="{{ old('title') }}"></label></p>
        <p><label>Description <textarea name="description">{{ old('description') }}</textarea></label></p>
        <p><label>Prep minutes <input type="number" name="prep_minutes" value="{{ old('prep_minutes') }}"></label></p>
        <p><label>Servings <input type="number" name="servings" value="{{ old('servings', 1) }}"></label></p>
        <p><label>Steps <textarea name="steps">{{ old('steps') }}</textarea></label></p>

        <h3>Ingredient</h3>

        <div id="ingredient-rows">
            @for ($i = 0; $i < 3; $i++)
                <p class="ingredient-row">
                    Name <input name="ingredients[{{ $i }}][name]" value="{{ old('ingredients.$i.name') }}">
                    Quantity <input name="ingredients[{{ $i }}][quantity]" value="{{ old('ingredients.$i.quantity') }}">
                    Unit <input name="ingredients[{{ $i }}][unit]" value="{{ old('ingredients.$i.unit') }}">
                </p>
            @endfor
        </div>

        <button type="button" id="add-ingredient">Add more ingredient</button>


        <button type="submit">Save recipe</button>
    </form>
</body>
</html>


<script>
    document.getElementById('add-ingredient').addEventListener('click', function () {
        const container = document.getElementById('ingredient-rows');
        const rows = container.querySelectorAll('.ingredient-row');
        const nextIndex = rows.length;

        const newRow = rows[rows.length - 1].cloneNode(true);
        newRow.querySelectorAll('input').forEach(function (input) {
            input.value = '';
            input.name = input.name.replace(/ingredients\[\d+\]/, 'ingredients[' + nextIndex + ']');
        });

        container.appendChild(newRow);
    });
</script>