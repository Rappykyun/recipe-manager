<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white">
    <div class="flex flex-col h-full">
        <!-- Logo and App Name -->
        <div class="flex items-center gap-2 p-4">
            <span class="text-lg font-bold text-gray-900">Recipe Manager</span>
        </div>
        <!-- Navigation -->
        <nav class="bg-gray-50 flex-1 px-2 py-4 mx-2 mt-2 rounded-lg shadow-sm">
            <div class="pl-2 mb-3 text-xs font-semibold tracking-wider text-gray-500 uppercase">Main</div>
            <div class="flex flex-col gap-2">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition
                    {{ request()->routeIs('dashboard') ? 'bg-indigo-100 text-indigo-700 font-semibold shadow' : 'text-gray-900 hover:bg-gray-200' }}">
                    <x-heroicon-o-home class="w-6 h-6" />
                    <span>Dashboard</span>
                </a>
                {{-- <a href="{{ route('') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('') ? 'bg-indigo-100 dark:bg-zinc-800 text-indigo-700 dark:text-indigo-300 font-semibold shadow' : 'text-gray-900 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-zinc-800' }}">
                    <x-heroicon-o-globe-alt class="w-6 h-6" />
                    <span>Public Recipes</span>
                </a> --}}
                <a href="{{ route('recipes.index') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('recipes.index') ? 'bg-indigo-100 dark:bg-zinc-800 text-indigo-700 dark:text-indigo-300 font-semibold shadow' : 'text-gray-900 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-zinc-800' }}">
                    <x-heroicon-o-book-open class="w-6 h-6" />
                    <span>My Recipes</span>
                </a>
            </div>
        </nav>
        <!-- User Info -->
        <div class="flex items-center gap-3 p-4 mt-2 border-t border-gray-200">
            <div class="flex items-center justify-center w-10 h-10 font-bold text-gray-700 bg-gray-300 rounded-full">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</div>
                <div class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="ml-2 text-xs text-r,phped-500 hover:underline">Log Out</button>
            </form>
        </div>
    </div>

    @fluxScripts
</body>

</html>
