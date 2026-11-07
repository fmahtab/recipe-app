@extends('layouts.recipes.app')

@section('title', 'Recipes')

@section('content')

    <h1>Recipes</h1>

    <form method="GET" action="{{ route('recipes.index') }}" style="display:flex; gap:0.5rem; margin-bottom:1.5rem;">
        <input type="text" name="q" value="{{ $search }}" placeholder="Search by title or ingredient">
        <button type="submit">Search</button>
        @if ($search !== '')
            <a class="btn" href="{{ route('recipes.index') }}" style="background:#777;">Clear</a>
        @endif
    </form>

    @forelse ($recipes as $recipe)
        <div class="card" style="margin-bottom:1rem;">
            <h2 style="margin:0 0 0.25rem;">
                <a href="{{ route('recipes.show', $recipe) }}">{{ $recipe->title }}</a>
            </h2>
            <p style="margin:0; color:#666;">{{ $recipe->prep_minutes }} min · serves {{ $recipe->servings }}</p>
        </div>
    @empty
        <div class="card">
            @if ($search !== '')
                No recipes match "{{ $search }}".
            @else
                No recipes yet. <a href="{{ route('recipes.create') }}">Add your first one.</a>
            @endif
        </div>
    @endforelse
    <div style="display:flex; justify-content:flex-end; margin-top:1rem;">
        {{ $recipes->links() }}
    </div>
@endsection