<footer class="relative py-6 overflow-hidden bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
    <div class="container px-4 mx-auto">
        <div class="flex flex-col items-center">
            <!-- Element decorativ - stele animate -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                @for ($i = 0; $i < 20; $i++)
                    <div class="absolute animate-twinkle"
                         style="top: {{ rand(0, 100) }}%; left: {{ rand(0, 100) }}%; animation-delay: {{ $i * 0.1 }}s;">
                        <svg class="w-2 h-2 text-yellow-300 fill-current" viewBox="0 0 24 24">
                            <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" />
                        </svg>
                    </div>
                @endfor
            </div>

            <!-- Text copyright -->
            <p class="mb-2 text-sm text-center text-white">
                &copy; {{ date('Y') }} Povestitorul Magic. Toate drepturile rezervate.
            </p>

            <!-- Linie decorativă -->
            <div class="w-24 h-1 mb-4 bg-yellow-300 rounded-full"></div>

            <!-- Link-uri social media (exemple) -->
            <div class="flex space-x-4">
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
        </div>
    </div>
</footer>

