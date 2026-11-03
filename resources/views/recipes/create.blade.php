@extends('layouts.recipes.app')

@section('title', 'Add Recipe')

@section('content')
    <p><a href="{{ route('recipes.index') }}">&larr; All recipes</a></p>

    <div class="card">
        <h1 style="margin-top:0;">Add a Recipe</h1>

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('recipes.store') }}">
            @csrf

            <p><label>Title<br><input name="title" value="{{ old('title') }}"></label></p>
            <p><label>Description<br><textarea name="description" rows="3">{{ old('description') }}</textarea></label></p>
            <p><label>Prep minutes<br><input type="number" name="prep_minutes" value="{{ old('prep_minutes') }}"></label></p>
            <p><label>Servings<br><input type="number" name="servings" value="{{ old('servings', 1) }}"></label></p>
            <p><label>Steps<br><textarea name="steps" rows="6">{{ old('steps') }}</textarea></label></p>

            <h2>Ingredients</h2>
            <div id="ingredient-rows">
                @foreach (old('ingredients', [[], [], []]) as $i => $item)
                    <div class="ingredient-row" style="display:flex; gap:0.5rem; margin-bottom:0.5rem;">
                        <input name="ingredients[{{ $i }}][name]" placeholder="Name" value="{{ $item['name'] ?? '' }}">
                        <input name="ingredients[{{ $i }}][quantity]" placeholder="Quantity" value="{{ $item['quantity'] ?? '' }}">
                        <input name="ingredients[{{ $i }}][unit]" placeholder="Unit" value="{{ $item['unit'] ?? '' }}">
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-ingredient" style="background:#777;">+ Add ingredient</button>

            <p style="margin-top:1.5rem;"><button type="submit">Save recipe</button></p>
        </form>
    </div>
@endsection