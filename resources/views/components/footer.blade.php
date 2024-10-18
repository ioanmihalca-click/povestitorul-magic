<footer class="relative py-6 overflow-hidden bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
    <div class="container px-4 mx-auto">
        <div class="flex flex-col items-center">
            <!-- Element decorativ - stele animate -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                @for ($i = 0; $i < 20; $i++)
                    <div class="absolute animate-twinkle"
                        style="top: {{ rand(0, 100) }}%; left: {{ rand(0, 100) }}%; animation-delay: {{ $i * 0.1 }}s;">
                        <svg class="w-2 h-2 text-yellow-300 fill-current" viewBox="0 0 24 24">
                            <path
                                d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" />
                        </svg>
                    </div>
                @endfor
            </div>

            <!-- Linkuri informative -->
            <nav class="mb-4">
                <ul class="flex flex-wrap justify-center -m-2">
                    <li class="p-2">
                        <a href="{{ route('about') }}"
                            class="text-white transition duration-300 hover:text-yellow-300">Despre Noi</a>
                    </li>
                    <li class="p-2">
                        <a href="{{ route('contact') }}"
                            class="text-white transition duration-300 hover:text-yellow-300">Contact</a>
                    </li>
                    <li class="p-2">
                        <a href="{{ route('privacy-policy') }}"
                            class="text-white transition duration-300 hover:text-yellow-300">Politica de
                            Confidențialitate</a>
                    </li>
                    <li class="p-2">
                        <a href="{{ route('terms-and-conditions') }}"
                            class="text-white transition duration-300 hover:text-yellow-300">Termeni și Condiții</a>
                    </li>
                </ul>
            </nav>

            <!-- Text copyright -->
            <p class="mb-2 text-sm text-center text-white">
                &copy; {{ date('Y') }} Povestitorul Magic. Toate drepturile rezervate.
            </p>

            <!-- Linie decorativă -->
            <div class="w-24 h-1 mb-4 bg-yellow-300 rounded-full"></div>

            <!-- Link-uri social media -->
            <div class="flex mb-4 space-x-4">
                <a href="#" class="text-white transition duration-300 hover:text-yellow-300">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="text-white transition duration-300 hover:text-yellow-300">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="text-white transition duration-300 hover:text-yellow-300">
                    <i class="fab fa-twitter"></i>
                </a>
            </div>

            <!-- Informații despre dezvoltator -->
            <p class="text-sm text-center text-white">
                Dezvoltat și întreținut de <a href="https://clickstudios-digital.com" target="_blank"
                    class="underline transition duration-300 hover:text-yellow-300">Click Studios Digital</a>
            </p>
        </div>
    </div>
</footer>
