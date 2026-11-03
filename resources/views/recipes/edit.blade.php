@extends('layouts.recipes.app')

@section('title', 'Edit ' . $recipe->title)

@section('content')
    <p><a href="{{ route('recipes.show', $recipe) }}">&larr; Back to {{ $recipe->title }}</a></p>

    <div class="card">
        <h1 style="margin-top:0;">Edit Recipe</h1>

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('recipes.update', $recipe) }}">
            @csrf
            @method('PUT')

            <p><label>Title<br><input name="title" value="{{ old('title', $recipe->title) }}"></label></p>
            <p><label>Description<br><textarea name="description" rows="3">{{ old('description', $recipe->description) }}</textarea></label></p>
            <p><label>Prep minutes<br><input type="number" name="prep_minutes" value="{{ old('prep_minutes', $recipe->prep_minutes) }}"></label></p>
            <p><label>Servings<br><input type="number" name="servings" value="{{ old('servings', $recipe->servings) }}"></label></p>
            <p><label>Steps<br><textarea name="steps" rows="6">{{ old('steps', $recipe->steps) }}</textarea></label></p>

            <h2>Ingredients</h2>
            <div id="ingredient-rows">
                @foreach (old('ingredients', $rows) as $i => $item)
                    <div class="ingredient-row" style="display:flex; gap:0.5rem; margin-bottom:0.5rem;">
                        <input name="ingredients[{{ $i }}][name]" placeholder="Name" value="{{ $item['name'] ?? '' }}">
                        <input name="ingredients[{{ $i }}][quantity]" placeholder="Quantity" value="{{ $item['quantity'] ?? '' }}">
                        <input name="ingredients[{{ $i }}][unit]" placeholder="Unit" value="{{ $item['unit'] ?? '' }}">
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-ingredient" style="background:#777;">+ Add ingredient</button>

            <p style="margin-top:1.5rem;"><button type="submit">Save changes</button></p>
        </form>
    </div>
@endsection