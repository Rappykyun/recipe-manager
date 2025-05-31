<div class="flex flex-col h-full w-full">

    <div class="flex items-center gap-2 p-4">
        <span class="text-lg font-bold text-gray-900">Recipe Manager</span>
    </div>

    <!-- Navigation -->
    <nav class="bg-white flex-1 py-4 px-2 mt-2 rounded-lg shadow-sm mx-2">
        <div class="pl-2 mb-3 text-xs font-semibold tracking-wider text-gray-500 uppercase">Main</div>
        <div class="flex flex-col gap-2">
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition w-full
                {{ request()->routeIs('dashboard') ? 'bg-indigo-100 text-indigo-700 font-semibold shadow' : 'text-gray-900 hover:bg-gray-100' }}">
                <x-heroicon-o-home class="w-5 h-5 flex-shrink-0" />
                <span class="truncate">Dashboard</span>
            </a>
            <a href="{{ route('exploreRecipes') }}"
                class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition w-full
                {{ request()->routeIs('exploreRecipes') || request()->routeIs('exploreRecipes.show') ? 'bg-indigo-100 text-indigo-700 font-semibold shadow' : 'text-gray-900 hover:bg-gray-100' }}">
                <x-heroicon-o-magnifying-glass class="w-5 h-5 flex-shrink-0" />
                <span class="truncate">Explore Recipes</span>
            </a>
            <a href="{{ route('myRecipes') }}"
                class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition w-full
                {{ request()->routeIs('myRecipes') || request()->routeIs('recipes.show') ? 'bg-indigo-100 text-indigo-700 font-semibold shadow' : 'text-gray-900 hover:bg-gray-100' }}">
                <x-heroicon-o-book-open class="w-5 h-5 flex-shrink-0" />
                <span class="truncate">My Recipes</span>
            </a>
        </div>
    </nav>

    <!-- User Info -->
    <div class="flex items-center gap-3 p-4 mt-2 border-t border-gray-200">
        <div
            class="flex items-center justify-center w-10 h-10 font-bold text-gray-700 bg-gray-300 rounded-full flex-shrink-0">
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
        </div>
        <div class="flex-1 min-w-0">
            <div class="font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</div>
            <div class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
            @csrf
            <button type="submit" class="text-xs text-red-600 hover:underline cursor-pointer">
                Log Out
            </button>
        </form>
    </div>
</div>
