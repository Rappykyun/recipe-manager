<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 h-screen border-e border-gray-200 bg-gray-50">
            @include('components.layouts.app.sidebar')
        </aside>
        <!-- Main Content -->
        <main class="flex-1 p-8 bg-white min-h-screen">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
