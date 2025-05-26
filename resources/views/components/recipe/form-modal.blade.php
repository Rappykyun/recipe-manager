@props([
    'modalOpen' => false,
    'modalMode' => '',
    'categories' => [],
    'selectedTags' => [],
    'ingredients' => [],
])

@if ($modalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">

     
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" aria-hidden="true" wire:click="closeModal">
        </div>

     
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

          
            <div
                class="inline-block w-full max-w-4xl px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:p-6">

                <div class="sm:flex sm:items-start">
                    <div class="w-full mt-3 text-center sm:mt-0 sm:text-left">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-semibold leading-6 text-gray-900" id="modal-title">
                                @if ($modalMode === 'add')
                                    Add New Recipe
                                @elseif($modalMode === 'edit')
                                    Edit Recipe
                                @elseif($modalMode === 'delete')
                                    Delete Recipe
                                @else
                                    Recipe Form
                                @endif
                            </h3>
                            <button type="button" wire:click="closeModal"
                                class="text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        @if ($modalMode === 'delete')
                            <x-recipe.delete-confirmation />
                        @else
                            <x-recipe.form :categories="$categories" :selectedTags="$selectedTags" :ingredients="$ingredients" :modalMode="$modalMode" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
