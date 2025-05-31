<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 h-full border-e border-gray-200 bg-gray-50 flex-shrink-0">
            @include('components.layouts.app.sidebar')
        </aside>
        <!-- Main Content -->
        <main class="flex-1 p-8 bg-white overflow-auto">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
