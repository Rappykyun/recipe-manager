@props([
    'show' => false,
    'title' => 'Add Recipe',
])

@if ($show)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6 relative">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">{{ $title }}</h3>
                <button type="button" onclick="window.livewire.emit('closeModal')"
                    class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div>
                {{ $slot }}
            </div>
        </div>
    </div>
@endif

<script>
    window.livewire.on('closeModal', () => {
        @this.set('showModal', false);
    });
</script>
