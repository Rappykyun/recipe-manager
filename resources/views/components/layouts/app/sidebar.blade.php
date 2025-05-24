<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <div class="h-full flex flex-col">
        <!-- Logo and App Name -->
        <div class="flex items-center gap-2 p-4">

            <span class="font-bold text-lg text-gray-900 dark:text-white">Reciper Manager</span>
        </div>
        <!-- Navigation -->
        <nav class="flex-1 px-2 py-4 bg-gray-50 dark:bg-zinc-900 rounded-lg mx-2 mt-2 shadow-sm">
            <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 pl-2">Main
            </div>
            <div class="flex flex-col gap-2">
                <a href="{{ route('') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition
          {{ request()->routeIs('') ? 'bg-indigo-100 dark:bg-zinc-800 text-indigo-700 dark:text-indigo-300 font-semibold shadow' : 'text-gray-900 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-zinc-800' }}">
                    <x-heroicon-o-home class="w-6 h-6" />
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('') ? 'bg-indigo-100 dark:bg-zinc-800 text-indigo-700 dark:text-indigo-300 font-semibold shadow' : 'text-gray-900 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-zinc-800' }}">
                    <x-heroicon-o-globe-alt class="w-6 h-6" />
                    <span>Public Recipes</span>
                </a>
                <a href="{{ route('recipes.index') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('recipes.index') ? 'bg-indigo-100 dark:bg-zinc-800 text-indigo-700 dark:text-indigo-300 font-semibold shadow' : 'text-gray-900 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-zinc-800' }}">
                    <x-heroicon-o-book-open class="w-6 h-6" />
                    <span>My Recipes</span>
                </a>
            </div>
        </nav>
        <!-- User Info -->
        <div class="p-4 border-t border-gray-200 dark:border-zinc-700 flex items-center gap-3 mt-2">
            <div
                class="flex items-center justify-center h-10 w-10 rounded-full bg-gray-300 dark:bg-zinc-700 text-gray-700 dark:text-white font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-semibold text-gray-900 dark:text-white truncate">{{ auth()->user()->name }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="ml-2 text-xs text-r,phped-500 hover:underline">Log Out</button>
            </form>
        </div>
    </div>

<<<<<<< HEAD
    @fluxScripts
</body>

=======
            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
>>>>>>> f1ab130b3ba0c014929c0b524b2c54be0100b95d
</html>
