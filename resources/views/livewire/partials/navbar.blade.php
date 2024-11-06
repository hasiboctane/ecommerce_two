<nav x-data="{ mobileMenuIsOpen: false }" @click.away="mobileMenuIsOpen = false"
    class="bg-gradient-to-r from-cyan-100 to-cyan-200 shadow-md flex items-center justify-between  px-6 py-5  fixed w-full z-[250]"
    aria-label="penguin ui menu">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="text-2xl font-bold text-black opacity-100 dark:text-white">
        <span><span class="text-rose-700 dark:text-rose-600">Dress</span> Zone</span>
        <!-- <img src="./your-logo.svg" alt="brand logo" class="w-10" /> -->
    </a>
    <!-- Desktop Menu -->
    <ul class="hidden items-center gap-4 opacity-100 md:flex">
        @foreach ($parent_categories as $pc)
            <div x-data="{ isOpen: false }" class="relative" @mouseenter="isOpen = true" @mouseleave="isOpen = false">
                <button type="button"
                    class="inline-flex cursor-pointer items-center gap-2 whitespace-nowrap rounded-xl px-4 py-2 text-sm font-medium tracking-wide transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-800 dark:focus-visible:outline-slate-300"
                    :class="isOpen ? 'text-rose-700 dark:text-rose-600' : 'text-slate-700 dark:text-slate-300'">

                    <a href="{{ route('products', ['parent_category' => $pc->slug]) }}" wire:navigate
                        class="inline-flex items-center">{{ $pc->name }}</a>

                </button>
                <div x-show="isOpen" x-transition
                    class="absolute top-11 left-0 flex w-48 flex-col overflow-hidden rounded-xl border border-slate-300 bg-slate-100 py-1.5 dark:border-slate-700 dark:bg-slate-800"
                    role="menu">
                    @foreach ($pc->categories as $category)
                        <a href="{{ route('products', ['parent_category' => $pc->slug, 'category' => $category->slug]) }}"
                            wire:navigate
                            class="bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-800/5 hover:text-black focus-visible:bg-slate-800/10 focus-visible:text-black focus-visible:outline-none dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-100/5 dark:hover:text-white dark:focus-visible:bg-slate-100/10 dark:focus-visible:text-white"
                            role="menuitem">{{ $category->name }}</a>
                    @endforeach
                </div>
            </div>
        @endforeach
        {{-- <li><a href="{{ route('products') }}" wire:navigate
                class="font-semibold opacity-100 {{ request()->is('products') ? 'text-rose-700' : 'text-slate-800' }}  hover:text-rose-600  focus:outline-none  dark:text-rose-600 dark:hover:text-rose-600"
                aria-current="page">Products</a></li> --}}
        <li><a href="{{ route('categories') }}" wire:navigate
                class="font-semibold {{ request()->is('categories') ? 'text-rose-700' : 'text-slate-800' }} hover:text-slate-600 focus:outline-none  dark:text-slate-300  dark:hover:text-rose-600">Categories</a>
        </li>


    </ul>
    <div class="hidden md:flex gap-4 justify-between items-center">
        <a class="relative font-medium flex items-center text-rose-700 hover:text-rose-500 dark:text-gray-400 dark:hover:text-gray-500 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
            href="{{ route('cart') }}" wire:navigate>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="flex-shrink-0 w-6 mr-0 ">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
            {{-- <span class="mr-1">Cart</span> --}}
            <span
                class="@if ($total_count == 0) hidden @endif px-1 py-0 absolute -top-1.5 -right-3 rounded-full text-xs font-bold bg-rose-50 border border-rose-500 text-rose-600">{{ $total_count }}</span>
        </a>
        @guest
            <a class="py-1.5 px-2.5 ml-2 inline-flex items-center gap-x-1 text-sm font-semibold rounded-md border border-transparent bg-rose-700 text-white hover:bg-rose-800 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                href="{{ route('login') }}" wire:navigate>
                <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                Log in
            </a>
        @endguest
        @auth
            <div x-data="{ isOpen: false, openedWithKeyboard: false, leaveTimeout: null }" @mouseleave.prevent="leaveTimeout = setTimeout(() => { isOpen = false }, 200)"
                @mouseenter="leaveTimeout ? clearTimeout(leaveTimeout) : true"
                @keydown.esc.prevent="isOpen = false, openedWithKeyboard = false"
                @click.outside="isOpen = false, openedWithKeyboard = false" class="relative">
                <!-- Toggle Button -->
                <button type="button" @mouseover="isOpen = true" @keydown.space.prevent="openedWithKeyboard = true"
                    @keydown.enter.prevent="openedWithKeyboard = true" @keydown.down.prevent="openedWithKeyboard = true"
                    class="inline-flex cursor-pointer items-center gap-2 whitespace-nowrap py-1.5 px-2.5 font-medium tracking-wide transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-800 dark:border-slate-700 dark:bg-slate-800 dark:focus-visible:outline-slate-300"
                    :class="isOpen || openedWithKeyboard ? 'text-black dark:text-white' : 'text-slate-700 dark:text-slate-300'"
                    :aria-expanded="isOpen || openedWithKeyboard" aria-haspopup="true">
                    {{ auth()->user()->name }}
                    {{-- Hasib Islam --}}
                </button>
                <!-- Dropdown Menu -->
                <div x-cloak x-show="isOpen || openedWithKeyboard" x-transition x-trap="openedWithKeyboard"
                    @click.outside="isOpen = false, openedWithKeyboard = false" @keydown.down.prevent="$focus.wrap().next()"
                    @keydown.up.prevent="$focus.wrap().previous()"
                    class="absolute top-10 -left-16  w-full min-w-32 flex flex-col justify-center items-center
                    divide-y divide-slate-300 overflow-hidden rounded-md border border-slate-300 bg-slate-100 py-1.5 dark:border-slate-700 dark:bg-slate-800"
                    role="menu">
                    <a href="#"
                        class="bg-slate-100 px-4 py-2 text-bold block text-slate-700 hover:bg-slate-800/5 hover:text-black focus-visible:bg-slate-800/10 focus-visible:text-black focus-visible:outline-none dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-100/5 dark:hover:text-white dark:focus-visible:bg-slate-100/10 dark:focus-visible:text-white"
                        role="menuitem">My Profile</a>
                    <a href="{{ route('my-orders') }}" wire:navigate
                        class="bg-slate-100 px-4 py-2 text-bold block text-slate-700 hover:bg-slate-800/5 hover:text-black focus-visible:bg-slate-800/10 focus-visible:text-black focus-visible:outline-none dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-100/5 dark:hover:text-white dark:focus-visible:bg-slate-100/10 dark:focus-visible:text-white"
                        role="menuitem">My Orders</a>
                    <a href="{{ route('logout') }}"
                        class="bg-slate-100 px-4 py-2 text-bold block text-slate-700 hover:bg-slate-800/5 hover:text-black focus-visible:bg-slate-800/10 focus-visible:text-black focus-visible:outline-none dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-100/5 dark:hover:text-white dark:focus-visible:bg-slate-100/10 dark:focus-visible:text-white"
                        role="menuitem">Sign Out</a>
                </div>
            </div>
        @endauth


    </div>
    <!-- Mobile Menu Button -->
    <button @click="mobileMenuIsOpen = !mobileMenuIsOpen" :aria-expanded="mobileMenuIsOpen"
        :class="mobileMenuIsOpen ? 'fixed top-6 right-6 z-20' : null" type="button"
        class="flex text-slate-700 dark:text-slate-300 md:hidden" aria-label="mobile menu" aria-controls="mobileMenu">
        <svg x-cloak x-show="!mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true"
            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
        <svg x-cloak x-show="mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true"
            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
    <!-- Mobile Menu -->
    <ul x-cloak x-show="mobileMenuIsOpen"
        x-transition:enter="transition motion-reduce:transition-none ease-out duration-300"
        x-transition:enter-start="-translate-y-full" x-transition:enter-end="translate-y-0"
        x-transition:leave="transition motion-reduce:transition-none ease-out duration-300"
        x-transition:leave-start="translate-y-0" x-transition:leave-end="-translate-y-full" id="mobileMenu"
        class="fixed max-h-svh overflow-y-auto inset-x-0 top-0 z-10 flex flex-col justify-start items-center divide-y divide-cyan-300 rounded-b-xl border-b border-slate-300 bg-cyan-50 px-6 pb-6 pt-10 dark:divide-slate-700 dark:border-slate-700 dark:bg-slate-800 md:hidden">
        <li class="py-4"><a href="{{ route('home') }}" wire:navigate
                class="font-semibold opacity-100 {{ request()->is('home') ? 'text-rose-700' : 'text-slate-800' }}  hover:text-rose-600  focus:outline-none  dark:text-rose-600 dark:hover:text-rose-600"
                aria-current="page">Home</a></li>
        <li class="py-4"><a href="{{ route('products') }}" wire:navigate
                class="font-semibold opacity-100 {{ request()->is('products') ? 'text-rose-700' : 'text-slate-800' }}  hover:text-rose-600  focus:outline-none  dark:text-rose-600 dark:hover:text-rose-600"
                aria-current="page">Products</a></li>
        <li class="py-4"><a href="{{ route('categories') }}" wire:navigate
                class="font-semibold opacity-100 {{ request()->is('categories') ? 'text-rose-700' : 'text-slate-800' }}  hover:text-rose-600  focus:outline-none  dark:text-rose-600 dark:hover:text-rose-600"
                aria-current="page">Categories</a></li>
        <li class="py-4"><a href="#"
                class="w-full text-lg font-medium text-slate-700 focus:underline dark:text-slate-300">Blog</a></li>
        <li class="py-4">
            <a class="py-1.5 px-2.5 inline-flex items-center gap-x-2 text-sm font-semibold rounded-md border border-transparent bg-indigo-600 text-white hover:bg-indigo-800 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                href="{{ route('cart') }}" wire:navigate>
                {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="flex-shrink-0 w-5 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg> --}}
                <span class="mr-1">Cart</span> <span
                    class="py-0 px-1 rounded-full text-xs font-semibold bg-blue-50 border border-blue-200 text-blue-600">{{ $total_count }}</span>
            </a>
        </li>
        <li class="py-4">
            {{-- <a href="#"
                class="w-full text-lg font-medium text-slate-700 focus:underline dark:text-slate-300">Login</a> --}}
            <a class="py-1.5 px-2.5 inline-flex items-center gap-x-2 text-sm font-semibold rounded-md border border-transparent bg-rose-700 text-white hover:bg-rose-800 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                href="/login">
                <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                Log in
            </a>
        </li>
    </ul>
</nav>
