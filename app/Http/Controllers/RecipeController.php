<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRecipeRequest;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class RecipeController extends Controller
{
    public function create(): View
    {
        return view('recipes.create');
    }


    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $recipes = Recipe::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('title', 'like', '%'.$search.'%')
                    ->orWhereHas('ingredients', function ($query) use ($search) {
                        $query->where('name', 'like', '%'.$search.'%');
                    });
            })
            //->when($search !== '', fn ($query) => $query->where('title', 'like', '%'.$search.'%'))
            ->latest()
            ->get();

        return view('recipes.index', compact('recipes', 'search'));
    }


    public function show(Recipe $recipe): View
    {
        $recipe->load('ingredients');

        return view('recipes.show', compact('recipe'));
    }

    public function store(StoreRecipeRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $recipe = Recipe::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'prep_minutes' => $data['prep_minutes'],
            'servings' => $data['servings'],
            'steps' => $data['steps'],
        ]);

        foreach ($data['ingredients'] as $item) {
            $ingredient = Ingredient::firstOrCreate([
                'name' => strtolower(trim($item['name'])),
            ]);

            $recipe->ingredients()->attach($ingredient->id, [
                'quantity' => $item['quantity'],
                'unit' => $item['unit'],
            ]);
        }

        return redirect()->route('recipes.create')->with('success', 'Recipe saved!');
    }
}