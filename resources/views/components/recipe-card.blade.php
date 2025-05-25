<div
    class="bg-white rounded-xl shadow-lg p-5 flex flex-col transition-transform duration-200 hover:scale-105 hover:shadow-2xl border border-gray-100">
    @if ($recipe->image_path)
        <img src="{{ Storage::url($recipe->image_path) }}" alt="{{ $recipe->title }}"
            class="rounded-lg mb-4 h-40 w-full object-cover border border-gray-200">
    @endif
    <div class="flex items-center justify-between mb-2">
        <h3 class="text-xl font-bold text-gray-900 truncate">{{ $recipe->title }}</h3>
        @if ($recipe->category)
            <span
                class="px-2 py-0.5 bg-indigo-50 text-indigo-700 text-xs rounded-full font-semibold border border-indigo-100 ml-2">{{ $recipe->category }}</span>
        @endif
    </div>
    <p class="text-gray-600 mb-3 line-clamp-2">{{ Str::limit($recipe->description, 80) }}</p>
    <div class="flex flex-wrap gap-2 mt-auto">
        @foreach ($recipe->tags as $tag)
            <span
                class="px-2 py-0.5 bg-indigo-100 text-xs rounded-full text-indigo-800 font-medium">#{{ $tag->name }}</span>
        @endforeach
    </div>
</div>
