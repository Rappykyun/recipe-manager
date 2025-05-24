{{-- resources/views/dashboard.blade.php --}}
<x-layouts.app>
    <div class="p-8">
        <h1 class="text-3xl font-bold mb-6">Dashboard</h1>
        {{-- Other dashboard content here --}}

        {{-- Include the Livewire recipes index component --}}
        @livewire('recipes.index')
        {{-- or, if using Volt: --}}
        {{-- <livewire:recipes.index /> --}}
    </div>
</x-layouts.app>