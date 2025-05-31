@props([
    'search' => '',
    'category' => '',
    'tag' => '',
])

<div class="col-span-full">
    <div class="text-center py-12">
        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <h3 class="text-lg font-medium text-gray-900 mb-2">
            @if ($search || $category || $tag)
                No recipes found
            @else
                No public recipes yet
            @endif
        </h3>

        <p class="text-gray-500 mb-6 max-w-md mx-auto">
            @if ($search || $category || $tag)
                We couldn't find any public recipes matching your search criteria. Try adjusting your filters or search
                terms.
            @else
                There are no public recipes available yet. Check back later as more users share their recipes!
            @endif
        </p>

        @if ($search || $category || $tag)
            <div class="space-y-2">
                <p class="text-sm text-gray-400">
                    Try searching for something else or browse all public recipes.
                </p>
            </div>
        @else
            <div class="space-y-2">
                <p class="text-sm text-gray-400">
                    Encourage other users to make their recipes public so you can discover amazing dishes!
                </p>
            </div>
        @endif
    </div>
</div>
