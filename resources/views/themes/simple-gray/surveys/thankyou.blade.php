@extends('themes.simple-gray.layout.site', [
    'title' => 'Дякуємо за заповнення анкети',
    'seoDescription' => 'Дякуємо за заповнення анкети та ваш цінний відгук',
])

@section('content')
    <div class="container mx-auto py-16 px-4">
        <div class="max-w-2xl mx-auto bg-gradient-to-br from-white to-blue-50 p-10 rounded-xl shadow-xl border border-blue-100 text-center">
            <div class="relative mb-8">
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-24 h-24 bg-blue-100 rounded-full opacity-70"></div>
                </div>
                <div class="relative text-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <h1 class="text-4xl font-bold mb-6 text-blue-800">Дякуємо!</h1>

            <div class="w-20 h-1 bg-blue-500 mx-auto rounded-full mb-8"></div>

            <p class="text-xl text-gray-600 mb-8 max-w-lg mx-auto">
                Ваші відповіді успішно збережено. Ми цінуємо ваш час та відгук.
            </p>

            @if(isset($survey))
                <div class="bg-white p-6 rounded-lg shadow-md border border-blue-50 mb-10 inline-block">
                    <p class="text-gray-700">
                        Ви заповнили анкету: <strong class="text-blue-700">{{ $survey->title }}</strong>
                    </p>
                </div>
            @endif

            <div class="mt-10">
                <a href="{{ route('home') }}" class="px-10 py-4 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-xl hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all text-lg font-medium shadow-lg transform hover:scale-105 active:scale-100 inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Повернутися на головну
                </a>
            </div>
        </div>
    </div>
@endsection
