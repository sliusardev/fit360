@extends('themes.simple-gray.layout.site', [
    'title' => 'Мої Заняття'
])

@section('content')

    <div class="bg-gray-50 rounded-lg p-4 mb-4">
        <h3 class="text-lg font-semibold mb-2">
            Мої заняття
        </h3>
        @includeIf('themes.simple-gray.inc.activities-list')
    </div>

@endsection
