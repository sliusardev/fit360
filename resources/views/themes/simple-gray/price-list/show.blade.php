@extends('themes.simple-gray.layout.site', [
    'title' => $priceList->title ?? '',
    ])

@section('content')

    <a href="{{route('price-list.index')}}">
        <i class="fas fa-chevron-left"></i>
    </a>

    <div class="p-6">

        @if($priceList->getImageUrl())
            <img alt="{{$priceList->title}}" class="w-full h-100 object-cover rounded-lg mb-4" src="{{$priceList->getImageUrl()}}"/>
        @endif

        <h3 class="text-center">{{$priceList->title}}</h3>
        <div class="my-3">
            {!! $priceList->description !!}
        </div>
    </div>
@endsection
