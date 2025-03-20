<nav x-data="{ open: false }" class="bg-gray-900 border-b border-gray-800">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <!-- Spotify-style logo -->
                        <svg class="h-9 w-9" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="12" fill="#1DB954"/>
                            <path d="M17.9938 10.8761C14.5307 8.74017 8.84426 8.52262 5.42209 9.59448C4.79148 9.7974 4.13332 9.43813 3.9304 8.80751C3.72747 8.1769 4.08674 7.51874 4.71735 7.31582C8.64444 6.08276 14.9556 6.3389 18.9139 8.80751C19.4861 9.1437 19.6395 9.87447 19.3033 10.4467C18.9671 11.0189 18.236 11.1726 17.6641 10.8361L17.9938 10.8761Z" fill="white"/>
                            <path d="M17.8109 14.1732C17.5296 14.6373 16.9152 14.7627 16.4511 14.4813C13.5573 12.6944 9.20582 12.1773 5.84426 13.3702C5.3257 13.5372 4.77159 13.241 4.60457 12.7224C4.43756 12.2039 4.73336 11.6497 5.25247 11.4827C9.10992 10.1289 13.9421 10.7176 17.3028 12.8134C17.7669 13.0948 17.8923 13.7091 17.6109 14.1732Z" fill="white"/>
                            <path d="M16.3007 17.3344C16.0768 17.7033 15.5921 17.8027 15.2232 17.5787C12.6993 16.0277 9.53731 15.6632 5.84676 16.6472C5.42343 16.7665 4.9896 16.5131 4.87023 16.0898C4.75087 15.6665 5.00428 15.2326 5.42761 15.1133C9.48996 14.0233 13.0133 14.4473 15.8565 16.2069C16.2254 16.4308 16.3247 16.9155 16.1007 17.2844L16.3007 17.3344Z" fill="white"/>
                        </svg>
                        <span class="ml-2 font-bold text-xl text-white">Soundify</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-gray-300 hover:text-white transition duration-300 font-medium">
                        {{ __('Home') }}
                    </x-nav-link>

                    @can('sound-approve')
                    <x-nav-link :href="route('pending')" :active="request()->routeIs('pending')" class="text-gray-300 hover:text-white transition duration-300 font-medium">
                        {{ __('Pending') }}
                    </x-nav-link>
                    @endcan

                    @can('create-complaint')
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-gray-300 hover:text-white transition duration-300 font-medium">
                        {{ __('Complaint') }}
                    </x-nav-link>
                    @endcan
                </div>
            </div> 

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-gray-300 hover:text-white bg-gray-800 hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-gray-800 rounded-md border border-gray-700">
                            <x-dropdown-link :href="route('profile.edit')" class="text-gray-300 hover:text-white hover:bg-gray-700">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();"
                                        class="text-gray-300 hover:text-white hover:bg-gray-700">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-800 focus:outline-none focus:bg-gray-800 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-gray-800">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-gray-300 hover:text-white hover:bg-gray-700">
                {{ __('Home') }}
            </x-responsive-nav-link>
            
            @can('sound-approve')
            <x-responsive-nav-link :href="route('pending')" :active="request()->routeIs('pending')" class="text-gray-300 hover:text-white hover:bg-gray-700">
                {{ __('Pending') }}
            </x-responsive-nav-link>
            @endcan

            @can('create-complaint')
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-gray-300 hover:text-white hover:bg-gray-700">
                {{ __('Complaint') }}
            </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-700 bg-gray-800">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-300 hover:text-white hover:bg-gray-700">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="text-gray-300 hover:text-white hover:bg-gray-700">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>