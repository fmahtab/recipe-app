@extends('layouts.recipes.app')

@section('title', $recipe->title)

@section('content')
    <p><a href="{{ route('recipes.index') }}">&larr; All recipes</a></p>

    <div class="card">
        <h1 style="margin-top:0;">{{ $recipe->title }}</h1>

        <div style="display:flex; gap:0.5rem; margin-bottom:1rem;">
            <a class="btn" href="{{ route('recipes.edit', $recipe) }}">Edit</a>
            <form method="POST" action="{{ route('recipes.destroy', $recipe) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">Delete</button>
            </form>
        </div>

        @if ($recipe->description)
            <p>{{ $recipe->description }}</p>
        @endif

        <p style="color:#666;">Prep: {{ $recipe->prep_minutes }} minutes · Serves {{ $recipe->servings }}</p>

        <h2>Ingredients</h2>
        <ul>
            @foreach ($recipe->ingredients as $ingredient)
                <li>{{ $ingredient->pivot->quantity }} {{ $ingredient->pivot->unit }} {{ $ingredient->name }}</li>
            @endforeach
        </ul>

        <h2>Steps</h2>
        <div style="white-space: pre-line;">{{ $recipe->steps }}</div>
    </div>
@endsection