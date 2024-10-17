<nav class="flex justify-end flex-1 -mx-3 space-x-4">
    @auth
        <a
            href="{{ url('/biblioteca-magica') }}"
            class="px-4 py-2 text-lg font-semibold text-purple-700 transition duration-300 ease-in-out bg-yellow-200 rounded-full hover:bg-yellow-300 hover:text-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
        >
            Biblioteca Magică
        </a>
    @else
        <a
            href="{{ route('login') }}"
            class="px-4 py-2 text-base font-semibold text-gray-700 transition duration-300 ease-in-out bg-pink-200 rounded-full md:text-lg hover:bg-gray-300 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
        >
            Autentifică-te
        </a>

        @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="px-4 py-2 text-base font-semibold text-gray-700 transition duration-300 ease-in-out bg-blue-200 rounded-full md:text-lg hover:bg-blue-300 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
            >
                Înregistrează-te
            </a>
        @endif
    @endauth
</nav>