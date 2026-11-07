<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Recipe;
use App\Models\Ingredient;
use Tests\TestCase;

class RecipeListTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_page_shows_saved_recipes(): void
    {
        Recipe::create([
            'title' => 'Pancakes',
            'prep_minutes' => 15,
            'servings' => 4,
            'steps' => 'Mix and cook.',
        ]);

        $this->get('/recipes')
            ->assertOk()
            ->assertSee('Pancakes');
    }

    public function test_search_only_shows_matching_recipes(): void
    {
        Recipe::create([
            'title' => 'Pancakes',
            'prep_minutes' => 15,
            'servings' => 4,
            'steps' => 'Mix and cook.',
        ]);

        Recipe::create([
            'title' => 'Caesar Salad',
            'prep_minutes' => 10,
            'servings' => 2,
            'steps' => 'Toss and serve.',
        ]);

        $this->get('/recipes?q=salad')
            ->assertOk()
            ->assertSee('Caesar Salad')
            ->assertDontSee('Pancakes');
    }

    public function test_search_finds_recipes_by_ingredient(): void
    {
        $recipe = Recipe::create([
            'title' => 'Garden Bowl',
            'prep_minutes' => 10,
            'servings' => 2,
            'steps' => 'Toss and serve.',
        ]);

        $recipe->ingredients()->attach(
            Ingredient::create(['name' => 'romaine salad mix'])->id,
            ['quantity' => 1, 'unit' => 'bag']
        );

        $this->get('/recipes?q=salad')
            ->assertOk()
            ->assertSee('Garden Bowl');
    }

    public function test_list_shows_pagination_correctly(): void
    {
        for ($i = 1; $i <=12; $i++){
            $recipe = Recipe::create([
                'title' => 'TestRecipe_'.$i,
                'prep_minutes' => 10+$i,
                'servings' => 2+$i,
                'steps' => 'Mix and cook.',
                'ingredients' => [
                    ['name' => ' Flour ', 'quantity' => $i, 'unit' => 'cups'],
                ],
            ]);
            
        }
        $this->get('/recipes')
            ->assertOk()
            ->assertViewHas('recipes', function ($recipes) {
                return $recipes->count() === 10;
            });

        $this->get('/recipes?page=2')
            ->assertOk()
            ->assertViewHas('recipes', function ($recipes) {
                return $recipes->count() === 2;
            });
    }

}
