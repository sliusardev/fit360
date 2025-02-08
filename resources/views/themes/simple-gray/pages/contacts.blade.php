@extends('themes.simple-gray.layout.site', [
    'title' => 'Контакти',
    'seoDescription' => 'Контакти фітнес центру у Полтаві',
    ])

@section('content')

    <div class="bg-gray-100 rounded-lg p-4 mb-4">
        <h3 class="text-lg font-semibold mb-2">
            Контакти
        </h3>
        <div class="space-y-4 sm:space-y-6 md:space-y-8">
            <div class="bg-white p-4 rounded-lg shadow text-center">
                {!! $settings['contacts'] ?? '' !!}

                <div class="mt-4">
                    {!! $settings['google_map_code'] ?? '' !!}
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">
                    Про нас
                </h3>
                <p>
                    {!! $settings['about_us'] ?? '' !!}
                </p>
            </div>
        </div>
    </div>

@endsection
