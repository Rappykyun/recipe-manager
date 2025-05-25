<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recipe Manager</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm h-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-gray-800">Recipe Manager</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-gray-900">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="py-24 bg-gradient-to-b from-white to-gray-50 flex items-center justify-center">
            <div class="max-w-3xl mx-auto px-4 text-center">
                <h2 class="text-5xl font-bold text-gray-900 mb-4">Organize Your Recipes</h2>
                <p class="mt-2 text-xl text-gray-600 mb-8">
                    Create, manage, and share your favorite recipes all in one place.
                </p>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="bg-blue-500 text-white px-8 py-3 rounded-md text-lg font-medium hover:bg-blue-600 transition">
                        Get Started
                    </a>
                @endif
                <div class="mt-6">
                    <a href="{{ route('public') }}"
                        class="text-md text-gray-500 hover:underline hover:text-gray-700 hover:cursor-pointer">
                        Explore Recipes
                    </a>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-16 bg-white">
            <div class="max-w-6xl mx-auto px-4">
                <h3 class="text-2xl font-bold text-gray-800 text-center mb-10">Features</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <h3 class="text-xl font-semibold text-gray-900">Create Recipes</h3>
                        <p class="mt-2 text-gray-600">Easily add new recipes with ingredients, instructions, and cooking
                            times.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <h3 class="text-xl font-semibold text-gray-900">Organize with Tags</h3>
                        <p class="mt-2 text-gray-600">Categorize your recipes with custom tags for easy searching.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <h3 class="text-xl font-semibold text-gray-900">Share with Others</h3>
                        <p class="mt-2 text-gray-600">Share your favorite recipes with friends and family.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
