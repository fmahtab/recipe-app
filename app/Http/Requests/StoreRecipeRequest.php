<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $ingredients = collect($this->input('ingredients', []))
            ->filter(fn ($item) => filled($item['name'] ?? null)
                || filled($item['quantity'] ?? null)
                || filled($item['unit'] ?? null))
            ->values()
            ->all();

        $this->merge(['ingredients' => $ingredients]);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'prep_minutes' => ['required', 'integer', 'min:1'],
            'servings' => ['required', 'integer', 'min:1'],
            'steps' => ['required', 'string'],
            'ingredients' => ['required', 'array', 'min:1'],
            'ingredients.*.name' => ['required', 'string', 'max:255'],
            'ingredients.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'ingredients.*.unit' => ['required', 'string', 'max:20'],
        ];
    }
}
