@extends('site.layout.site', [
    'title' => $priceList->title ?? '',
    'seoDescription' => '',
    'seoKeyWords' => '',
    ])

@section('content')
    <a href="{{route('price-list.index')}}">
        <h1 class="text-center">Прайси Студії</h1>
    </a>
    <hr>
    <div class="card-body">

        @if(!empty($priceList->getImageUrl()))
            <div class="text-center my-3">
                <img src="{{$priceList->getImageUrl()}}" alt="{{$priceList->title}}" loading="lazy" style="width: 100%" class="rounded img-fluid">
            </div>
        @endif

        <h2 class="text-center">{{$priceList->title}}</h2>
        <div class="my-3">
            {!! $priceList->description !!}
        </div>
    </div>
@endsection
