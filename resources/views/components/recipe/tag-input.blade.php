@props([
    'selectedTags' => [],
])

<div x-data="{
    tagInput: '',
    addTag() {
        let tag = this.tagInput.trim();
        if (tag && !$wire.selectedTags.includes(tag)) {
            $wire.selectedTags.push(tag);
        }
        this.tagInput = '';
    },
    handleInput(e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            this.addTag();
        }
    }
}">
    <label class="block text-sm font-medium text-gray-700">Tags</label>
    <div class="flex flex-wrap gap-2 mt-2">
        @foreach ($selectedTags as $index => $tag)
            @if ($tag)
                <span class="flex items-center px-3 py-1 text-sm bg-indigo-100 text-indigo-700 rounded-full">
                    <span>{{ $tag }}</span>
                    <button type="button" class="ml-2 text-indigo-500 hover:text-red-500"
                        wire:click="removeTag({{ $index }})">×</button>
                </span>
            @endif
        @endforeach
    </div>
    <input x-model="tagInput" @keydown="handleInput" @blur="addTag" type="text"
        class="w-full px-4 py-3 mt-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        placeholder="Type a tag and press Enter or comma">
    @error('selectedTags')
        <span class="text-sm text-red-500">{{ $message }}</span>
    @enderror
</div>
