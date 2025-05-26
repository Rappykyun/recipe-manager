@props([
    'search' => '',
    'category' => '',
    'tag' => '',
])

<div class="col-span-full">
    <div class="p-12 text-center bg-white rounded-lg shadow">
        <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
        </svg>
        <h3 class="mt-4 text-lg font-medium text-gray-900">No recipes found</h3>
        <p class="mt-2 text-sm text-gray-500">
            @if ($search || $category || $tag)
                Try adjusting your search or filters.
            @else
                Get started by creating your first recipe.
            @endif
        </p>
        <div class="mt-6">
            <button type="button" wire:click="openAddModal"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Recipe
            </button>
        </div>
    </div>
</div>
