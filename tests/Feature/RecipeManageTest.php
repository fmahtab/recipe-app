<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeManageTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_replaces_title_and_ingredients(): void
    {
        $recipe = Recipe::create([
            'title' => 'Pancakes',
            'prep_minutes' => 15,
            'servings' => 4,
            'steps' => 'Mix and cook.',
        ]);

        $recipe->ingredients()->attach(
            Ingredient::create(['name' => 'flour'])->id,
            ['quantity' => 2, 'unit' => 'cups']
        );

        $this->put('/recipes/'.$recipe->id, [
            'title' => 'Waffles',
            'prep_minutes' => 20,
            'servings' => 2,
            'steps' => 'Mix and bake.',
            'ingredients' => [
                ['name' => 'sugar', 'quantity' => 1, 'unit' => 'cup'],
            ],
        ])->assertRedirect('/recipes/'.$recipe->id);

        $recipe->refresh()->load('ingredients');

        $this->assertSame('Waffles', $recipe->title);
        $this->assertCount(1, $recipe->ingredients);
        $this->assertSame('sugar', $recipe->ingredients->first()->name);
    }

    public function test_delete_removes_recipe_and_its_ingredient_links(): void
    {
        $recipe = Recipe::create([
            'title' => 'Pancakes',
            'prep_minutes' => 15,
            'servings' => 4,
            'steps' => 'Mix and cook.',
        ]);

        $recipe->ingredients()->attach(
            Ingredient::create(['name' => 'flour'])->id,
            ['quantity' => 2, 'unit' => 'cups']
        );

        $this->delete('/recipes/'.$recipe->id)->assertRedirect('/recipes');

        $this->assertDatabaseMissing('recipes', ['id' => $recipe->id]);
        $this->assertDatabaseMissing('ingredient_recipe', ['recipe_id' => $recipe->id]);
    }
}