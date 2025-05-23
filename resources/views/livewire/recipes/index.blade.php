<div>
    {{-- Search and Add Button Section --}}
    <div class="flex justify-between items-center mb-6">
        {{-- Search Input --}}
        <div class="flex-1 max-w-sm">
            <input
                type="text"
                wire:model.live="search"
                placeholder="Search recipes..."
                class="w-full rounded-lg border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
        </div>

        {{-- Add Recipe Button --}}
        <button
            wire:click="$dispatch('openModal', { component: 'recipes.create' })"
            class="ml-4 px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition"
        >
            Add Recipe
        </button>
    </div>

    {{-- Filters Section --}}
    <div class="flex gap-4 mb-6">
        {{-- Category Filter --}}
        <div class="w-48">
            <select
                wire:model.live="category"
                class="w-full rounded-lg border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
                <option value="">All Categories</option>
                <option value="Breakfast">Breakfast</option>
                <option value="Lunch">Lunch</option>
                <option value="Dinner">Dinner</option>
                <option value="Dessert">Dessert</option>
            </select>
        </div>

        {{-- Tag Filter --}}
        <div class="w-48">
            <select
                wire:model.live="tag"
                class="w-full rounded-lg border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
                <option value="">All Tags</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Recipes Table --}}
    <div class="overflow-x-auto bg-white dark:bg-zinc-900 rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
            <thead class="bg-gray-50 dark:bg-zinc-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Prep Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ingredients</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tags</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-zinc-700">
                @forelse ($recipes as $recipe)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            {{ $recipe->title }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            {{ $recipe->category }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            {{ $recipe->prep_time ? $recipe->prep_time . ' min' : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            {{ $recipe->ingredients->count() }} ingredients
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            <div class="flex flex-wrap gap-1">
                                @foreach($recipe->tags as $tag)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 dark:bg-zinc-800 text-gray-800 dark:text-gray-200">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            <div class="flex items-center gap-2">
                                {{-- Edit Button --}}
                                <button
                                    wire:click="$dispatch('openModal', { component: 'recipes.edit', arguments: { recipe: {{ $recipe->id }} }})"
                                    class="px-3 py-1 border border-gray-300 dark:border-zinc-700 shadow-sm text-xs font-medium rounded text-gray-700 dark:text-gray-200 bg-white dark:bg-zinc-800 hover:bg-gray-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Edit
                                </button>

                                {{-- Share Button (only if recipe is public) --}}
                                @if($recipe->is_public)
                                    <a
                                        href="{{ route('recipes.public', $recipe) }}"
                                        class="px-3 py-1 border border-gray-300 dark:border-zinc-700 shadow-sm text-xs font-medium rounded text-gray-700 dark:text-gray-200 bg-white dark:bg-zinc-800 hover:bg-gray-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        Share
                                    </a>
                                @endif

                                {{-- Delete Button --}}
                                <button
                                    wire:click="$dispatch('openModal', { component: 'recipes.delete', arguments: { recipe: {{ $recipe->id }} }})"
                                    class="px-3 py-1 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                >
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center">
                            No recipes found. Start by adding your first recipe!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $recipes->links() }}
    </div>
</div> 