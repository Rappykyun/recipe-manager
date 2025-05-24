<?php

namespace App\Livewire\Recipes;

use Livewire\Component;
<<<<<<< HEAD
use Livewire\WithFileUploads;
use App\Models\Recipe;

class Create extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $category;
    public $prep_time;
    public $is_public;
    public $image;
    public $ingredients = [];
    public $tags;

    public function rules()
    {
        return [
            'title' => 'required|min:3',
            'description' => 'required',
            'category' => 'required',
            'prep_time' => 'nullable|numeric|min:1',
            'is_public' => 'boolean',
            'image' => 'nullable|image|max:1024', // Add this rule (max 1MB)
            'ingredients' => 'required|array|min:1',
            'ingredients.*.name' => 'required|string',
            'ingredients.*.quantity' => 'required|string',
            'tags' => 'array',
        ];
    }

    public function save()
    {
        $this->validate();
        $recipe = Recipe::create([
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'perp_time' => $this->prep_time,
            'user_id' => auth()->id(),

        ]);

        if ($this->image) {
            $path = $this->image->store('recipes', 'public');
            $recipe->update(['image_path' => $path]);

        }

        foreach ($this->ingredients as $ingredient) {
            $recipe->ingredients()->create([
                'name' => $ingredient['name'],
                'quantity' => $ingredient['quantity'],
            ]);

        }
        if (!empty($this->tags)) {
            $recipe->tags->attach($this->tags);
        }

        $this->dispatch('close-modal');
        $this->dispatch('recipe-created');
    }
    public function render()
    {


=======

class Create extends Component
{
    public function render()

    {

        
>>>>>>> f1ab130b3ba0c014929c0b524b2c54be0100b95d
        return view('livewire.recipes.create');
    }
}
