<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $recipe = DB::transaction(function () use ($data) {
            $new_recipe = Recipe::create([
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

                $new_recipe->ingredients()->attach($ingredient->id, [
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'],
                ]);
                
            }
            return $new_recipe;
        });
        return redirect()->route('recipes.show', $recipe)->with('success', 'Recipe updated!');

    }

    public function edit(Recipe $recipe): View
    {
        $recipe->load('ingredients');

        $rows = $recipe->ingredients->map(fn ($ingredient) => [
            'name' => $ingredient->name,
            'quantity' => $ingredient->pivot->quantity,
            'unit' => $ingredient->pivot->unit,
        ])->values()->all();

        return view('recipes.edit', compact('recipe', 'rows'));
    }

    public function update(StoreRecipeRequest $request, Recipe $recipe): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $recipe) {
            $recipe->update([
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

            $links[$ingredient->id] = [
                'quantity' => $item['quantity'],
                'unit' => $item['unit'],
            ];
        }
        $recipe->ingredients()->sync($links);

        });

        return redirect()->route('recipes.show', $recipe)->with('success', 'Recipe updated!');
    }

    public function destroy(Recipe $recipe): RedirectResponse
    {
        $recipe->delete();
        return redirect()->route('recipes.index')->with('success', 'Recipe deleted!');
    }
}