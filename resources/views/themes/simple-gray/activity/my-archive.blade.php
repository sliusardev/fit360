@extends('themes.simple-gray.layout.site', [
    'title' => 'Мої завершені заняття',
    ])

@section('content')
    <div class="bg-gray-50 rounded-lg p-4 mb-4">
        <h3 class="text-lg font-semibold mb-2">
            Мої завершені заняття
        </h3>
        @includeIf('themes.simple-gray.inc.activities-list')
    </div>


@endsection
