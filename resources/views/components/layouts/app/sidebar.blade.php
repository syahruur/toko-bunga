<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <span class="font-bold text-lg text-zinc-900 dark:text-zinc-100">Toko Bunga</span>
            </a>

            <flux:navlist variant="outline">
                @auth
                    @if(auth()->user()->isAdmin())
                        <flux:navlist.group heading="Admin" class="grid">
                            <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>Dashboard</flux:navlist.item>
                            <flux:navlist.item icon="users" :href="route('admin.pengguna')" :current="request()->routeIs('admin.pengguna')" wire:navigate>Pengguna</flux:navlist.item>
                            <flux:navlist.item icon="archive" :href="route('admin.produk')" :current="request()->routeIs('admin.produk')" wire:navigate>Produk</flux:navlist.item>
                            <flux:navlist.item icon="shopping-bag" :href="route('admin.pesanan')" :current="request()->routeIs('admin.pesanan')" wire:navigate>Pesanan</flux:navlist.item>
                        </flux:navlist.group>
                    @else
                        <flux:navlist.group heading="Menu" class="grid">
                            <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>Dashboard</flux:navlist.item>
                            <flux:navlist.item icon="archive" :href="route('produk.index')" :current="request()->routeIs('produk.index')" wire:navigate>Produk</flux:navlist.item>
                            <flux:navlist.item icon="shopping-cart" :href="route('keranjang.index')" :current="request()->routeIs('keranjang.index')" wire:navigate>Keranjang</flux:navlist.item>
                            <flux:navlist.item icon="clock" :href="route('pesanan.riwayat')" :current="request()->routeIs('pesanan.riwayat')" wire:navigate>Riwayat Pesanan</flux:navlist.item>
                            <flux:navlist.item icon="search" :href="route('pesanan.lacak')" :current="request()->routeIs('pesanan.lacak')" wire:navigate>Lacak Pesanan</flux:navlist.item>
                        </flux:navlist.group>
                    @endif
                @else
                    <flux:navlist.group heading="Menu" class="grid">
                        <flux:navlist.item icon="archive" :href="route('produk.index')" :current="request()->routeIs('produk.index')" wire:navigate>Produk</flux:navlist.item>
                    </flux:navlist.group>
                @endauth
            </flux:navlist>
            <flux:spacer />

            <!-- Desktop User Menu -->
            @auth
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
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
            @endauth
        </flux:sidebar>

        <!-- Mobile User Menu -->
        @auth
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
        @endauth

        {{ $slot }}

        @fluxScripts
    </body>
</html>
