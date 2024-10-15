<nav class="-mx-3 flex flex-1 justify-end space-x-4">
    @auth
        <a
            href="{{ url('/biblioteca-magica') }}"
            class="rounded-full px-4 py-2 text-lg font-semibold text-purple-700 bg-yellow-200 transition duration-300 ease-in-out hover:bg-yellow-300 hover:text-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
        >
            Biblioteca Magică
        </a>
    @else
        <a
            href="{{ route('login') }}"
            class="rounded-full px-4 py-2 text-lg font-semibold text-gray-700 bg-pink-200 transition duration-300 ease-in-out hover:bg-gray-300 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
        >
            Autentifică-te
        </a>

        @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="rounded-full px-4 py-2 text-lg font-semibold text-gray-700 bg-blue-200 transition duration-300 ease-in-out hover:bg-blue-300 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
            >
                Înregistrează-te
            </a>
        @endif
    @endauth
</nav>