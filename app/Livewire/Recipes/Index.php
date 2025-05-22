<?php

namespace App\Livewire\Recipes;

use Livewire\Component;
use App\Models\Recipe;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $tag = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $recipes = Recipe::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->category, function ($query) {
                $query->where('category', $this->category);
            })
            ->when($this->tag, function ($query) {
                $query->whereHas('tags', function ($query) {
                    $query->where('name', $this->tag);
                });
            })
            ->with(['ingredients', 'tags'])
            ->latest()
            ->paginate(10);

        return view('livewire.recipes.index', [
            'recipes' => $recipes,
            'categories' => ['Breakfast', 'Lunch', 'Dinner', 'Dessert'],
            'tags' => \App\Models\Tag::all(),
        ]);
    }
} 