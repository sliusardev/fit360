@extends('themes.simple-gray.layout.site', [
    'title' => $item->title ?? '',
    ])

@section('content')

    <a href="{{route('before-after.index')}}">
        <i class="fas fa-chevron-left"></i>
    </a>

    <div class="bg-gray-50 rounded-lg p-4 mb-4">
        <h3 class="text-lg font-semibold mb-2">
            {{$item->title ?? ''}}
        </h3>
        <div class="space-y-4">
            <div class="bg-white p-4 rounded-lg shadow">
                @if($item->getCollageImageUrl())
                    <img alt="{{$item->title}}" loading="lazy" class="w-full h-100 object-cover rounded-lg mb-4" src="{{$item->getCollageImageUrl()}}"/>
                @endif

                <h4 class="text-md font-semibold text-gray-800 mb-2">
                    Опис
                </h4>

                <p class="text-sm text-gray-600">
                    {!! $item->description !!}
                </p>

            </div>
        </div>
    </div>

@endsection
