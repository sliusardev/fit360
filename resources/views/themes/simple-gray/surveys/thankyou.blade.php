@extends('themes.simple-gray.layout.site', [
    'title' => 'Дякуємо за заповнення анкети',
    'seoDescription' => 'Дякуємо за заповнення анкети та ваш цінний відгук',
    ])

@section('content')
    <div class="container mx-auto py-16 px-4">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg text-center">
            <div class="text-green-500 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <h1 class="text-3xl font-bold mb-4 text-gray-800">Дякуємо!</h1>

            <p class="text-lg text-gray-600 mb-8">
                Ваші відповіді успішно збережено. Ми цінуємо ваш час та відгук.
            </p>

            @if(isset($survey))
                <p class="text-gray-500 mb-8">
                    Ви заповнили анкету: <strong>{{ $survey->title }}</strong>
                </p>
            @endif

            <div class="mt-8">
                <a href="{{ route('home') }}" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors text-lg font-medium shadow-md">
                    Повернутися на головну
                </a>
            </div>
        </div>
    </div>
@endsection
