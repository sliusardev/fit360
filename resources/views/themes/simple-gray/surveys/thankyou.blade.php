@extends('themes.simple-gray.layout.site', [
    'title' => 'Дякуємо за ваш відгук',
    'seoDescription' => 'Дякуємо за ваш відгук! Ми цінуємо вашу думку і будемо працювати над покращенням наших послуг.',
    ])

@section('content')
    <div class="container mx-auto py-8 px-4">
        <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow text-center">
            <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <h1 class="text-2xl font-bold mb-4">Дякуємо за ваш відгук!</h1>
            <p class="mb-6 text-gray-600">Ваша думка допомагає нам покращувати якість обслуговування.</p>
        </div>
    </div>
@endsection
