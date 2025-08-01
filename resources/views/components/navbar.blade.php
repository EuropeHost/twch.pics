<nav
    aria-label="Global"
    class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8 relative z-50"
>
    <div class="flex lg:flex-1">
        <a href="/" class="-m-1.5 p-1.5">
            <span class="text-lg font-bold text-purple-600 hover:text-purple-500">twch.pics</span>
            <!--img
                src="{{ asset('img/logo.png') }}"
                alt="twch.pics logo"
                class="h-24 w-auto"
            /-->
        </a>
    </div>
    <div class="flex lg:hidden">
        <button
            type="button"
            command="show-modal"
            commandfor="mobile-menu"
            class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700"
        >
            <span class="sr-only">Open main menu</span>
            <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                data-slot="icon"
                aria-hidden="true"
                class="size-6"
            >
                <path
                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>
        </button>
    </div>
    <div class="hidden lg:flex lg:gap-x-12">
        <a href="#features" class="text-sm/6 font-semibold text-gray-900"
            >Features</a
        >
        <a href="#" class="text-sm/6 font-semibold text-gray-900">Clips</a>
        <a href="#" class="text-sm/6 font-semibold text-gray-900"
            >Leaderboards</a
        >
    </div>
    <div class="hidden lg:flex lg:flex-1 lg:justify-end">
        @guest
        <a
            href="{{ route('login') }}"
            class="text-sm/6 font-semibold text-gray-900"
            >Log in with Twitch <span aria-hidden="true">&rarr;</span></a
        >
        @endguest @auth
        <div class="relative group">
            <button
                type="button"
                class="flex items-center gap-x-2 text-sm/6 font-semibold text-gray-900 focus:outline-none"
            >
                <img
                    src="{{ Auth::user()->avatar }}"
                    alt="{{ Auth::user()->name }}"
                    class="w-8 h-8 rounded-full border-2 border-purple-500"
                />
                {{ Auth::user()->name }}
                <svg
                    class="h-5 w-5 flex-none text-gray-400"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                >
                    <path
                        fill-rule="evenodd"
                        d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.06z"
                        clip-rule="evenodd"
                    />
                </svg>
            </button>

            <!-- Dropdown menu -->
            <div
                class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none opacity-0 group-hover:opacity-100 group-focus-within:opacity-100 transition-opacity duration-200 ease-out transform scale-95 group-hover:scale-100 group-focus-within:scale-100 origin-top-right invisible group-hover:visible group-focus-within:visible"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="user-menu-button"
                tabindex="-1"
            >
                <div class="py-1" role="none">
                    <a
                        href="{{ route('dashboard.overview') }}"
                        class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100"
                        role="menuitem"
                        tabindex="-1"
                        id="user-menu-item-2"
                        >Dashboard</a
                    >
                    <a
                        href="#"
                        class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100"
                        role="menuitem"
                        tabindex="-1"
                        id="user-menu-item-1"
                        >Settings</a
                    >
                    <form method="POST" action="{{ route('logout') }}" role="none">
                        @csrf
                        <button
                            type="submit"
                            class="text-gray-700 block w-full text-left px-4 py-2 text-sm hover:bg-gray-100"
                            role="menuitem"
                            tabindex="-1"
                            id="user-menu-item-3"
                        >
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endauth
    </div>
</nav>

<dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden relative z-50">
    <div tabindex="0" class="fixed inset-0 focus:outline-none">
        <div
            class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10"
        >
            <div class="flex items-center justify-between">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="sr-only">twch.pics</span>
                    <img
                        src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                        alt=""
                        class="h-8 w-auto"
                    />
                </a>
                <button
                    type="button"
                    command="close"
                    commandfor="mobile-menu"
                    class="-m-2.5 rounded-md p-2.5 text-gray-700"
                >
                    <span class="sr-only">Close menu</span>
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        data-slot="icon"
                        aria-hidden="true"
                        class="size-6"
                    >
                        <path
                            d="M6 18 18 6M6 6l12 12"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </button>
            </div>
            <div class="mt-6 flow-root">
                <div class="-my-6 divide-y divide-gray-500/10">
                    <div class="space-y-2 py-6">
                        <a
                            href="#features"
                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50"
                            >Features</a
                        >
                        <a
                            href="#"
                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50"
                            >Clips</a
                        >
                        <a
                            href="#"
                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50"
                            >Leaderboards</a
                        >
                    </div>
                    <div class="py-6">
                        @guest
                        <a
                            href="{{ route('login') }}"
                            class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-gray-900 hover:bg-gray-50"
                            >Log in with Twitch</a
                        >
                        @endguest @auth
                        <a
                            href="{{ route('dashboard.overview') }}"
                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50"
                            >Dashboard</a
                        >
                        <a
                            href="#"
                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50"
                            >Settings</a
                        >
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="-mx-3 block w-full text-left rounded-lg px-3 py-2.5 text-base/7 font-semibold text-gray-900 hover:bg-gray-50"
                            >
                                Logout
                            </button>
                        </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</dialog>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const showButtons = document.querySelectorAll('[command="show-modal"]');
        const closeButtons = document.querySelectorAll('[command="close"]');

        showButtons.forEach((button) => {
            button.addEventListener('click', (event) => {
                const targetId = button.getAttribute('commandfor');
                const modal = document.getElementById(targetId);
                if (modal && typeof modal.showModal === 'function') {
                    modal.showModal();
                }
            });
        });

        closeButtons.forEach((button) => {
            button.addEventListener('click', (event) => {
                const targetId = button.getAttribute('commandfor');
                const modal = document.getElementById(targetId);
                if (modal && typeof modal.close === 'function') {
                    modal.close();
                }
            });
        });

        const dropdownButton = document.querySelector('.group > button');
        const dropdownMenu = document.querySelector('.group > div');

        if (dropdownButton && dropdownMenu) {
            document.addEventListener('click', (event) => {
                if (
                    !dropdownButton.contains(event.target) &&
                    !dropdownMenu.contains(event.target)
                ) {
                    dropdownMenu.classList.add('opacity-0', 'invisible');
                    dropdownMenu.classList.remove('opacity-100', 'visible');
                }
            });

            dropdownButton.addEventListener('click', (event) => {
                event.stopPropagation();
                dropdownMenu.classList.toggle('opacity-0');
                dropdownMenu.classList.toggle('opacity-100');
                dropdownMenu.classList.toggle('invisible');
                dropdownMenu.classList.toggle('visible');
            });
        }
    });
</script>