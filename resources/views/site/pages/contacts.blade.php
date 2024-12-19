@extends('site.layout.site', [
    'title' => 'Контакти',
    'seoDescription' => 'Контакти фітнес центру у Полтаві',
    ])

@section('content')

    <div class="text-center my-4">

        <div>
            {!! $settings['contacts'] ?? '' !!}
        </div>

        <div class="google-maps">
            {!! $settings['google_map_code'] ?? '' !!}
        </div>
    </div>

@endsection
