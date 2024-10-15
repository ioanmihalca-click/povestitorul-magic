<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $story->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-3xl font-bold mb-4">{{ $story->title }}</h1>
                    <p class="text-gray-600 mb-4">
                        Gen: {{ $story->genre }} | Vârstă: {{ $story->age }} ani | Temă: {{ $story->theme }}
                    </p>
                    <div class="prose max-w-none">
                        {!! nl2br(e($story->content)) !!}
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('biblioteca-magica') }}" class="text-blue-500 hover:underline">Înapoi la dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>