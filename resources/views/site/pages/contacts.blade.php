@extends('site.layout.site')

@section('content')

    <div class="text-center my-4">

        {{test2()}}

        <div>
            {!! $settings['contacts'] ?? '' !!}
        </div>

        <div class="google-maps">
            {!! $settings['google_map_code'] ?? '' !!}
        </div>
    </div>

@endsection
