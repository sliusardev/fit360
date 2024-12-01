@extends('site.layout.site', [
    'title' => $item->title ?? '',
    'seoDescription' => '',
    'seoKeyWords' => '',
    ])

@section('content')

    @push('custom-header')
        <script defer src="https://cdn.jsdelivr.net/npm/img-comparison-slider@8/dist/index.js" ></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/img-comparison-slider@8/dist/styles.css" />
    @endpush

    <div class="my-3">
        <div class="card my-3">
            <div class="card-body">
                <a href="{{route('before-after.show', $item->id)}}">
                    <h5 class="card-title">{{$item->title ?? ''}}</h5>
                </a>

                <div class="mx-auto text-center my-3" style="width: 80%">
                    <img-comparison-slider>
                        <img slot="first" src="{{$item->getBeforeImageUrl()}}" class="img-fluid"/>
                        <img slot="second" src="{{$item->getAfterImageUrl()}}" class="img-fluid"/>
                    </img-comparison-slider>
                </div>

                <p class="card-text">
                    {!! $item->description !!}
                </p>
            </div>
        </div>
    </div>

@endsection
