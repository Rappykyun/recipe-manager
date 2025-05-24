<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 h-screen border-e border-gray-200 dark:border-zinc-700 bg-gray-100 dark:bg-zinc-900">
            @include('components.layouts.app.sidebar')
        </aside>
        <!-- Main Content -->
        <main class="flex-1 p-8 bg-white dark:bg-zinc-800 min-h-screen">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
