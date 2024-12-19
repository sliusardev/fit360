@extends('site.layout.site', [
    'title' => $item->title ?? '',
    ])

@section('content')

{{--    @push('custom-header')--}}
{{--        <script defer src="https://cdn.jsdelivr.net/npm/img-comparison-slider@8/dist/index.js" ></script>--}}
{{--        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/img-comparison-slider@8/dist/styles.css" />--}}
{{--    @endpush--}}

    <div class="my-3">
        <div class="card my-3">
            <div class="card-body">
                <h5 class="card-title">{{$item->title ?? ''}}</h5>

                <div class="mx-auto my-3" style="max-width: 400px">
                    <img src="{{$item->getCollageImageUrl()}}" loading="lazy" class="rounded img-fluid" alt="{{$item->title ?? ''}}" style="width: 100%">
                </div>

{{--                <div class="mx-auto text-center my-3" style="width: 80%">--}}
{{--                    <img-comparison-slider>--}}
{{--                        <img slot="first" src="{{$item->getBeforeImageUrl()}}" class="img-fluid"/>--}}
{{--                        <img slot="second" src="{{$item->getAfterImageUrl()}}" class="img-fluid"/>--}}
{{--                    </img-comparison-slider>--}}
{{--                </div>--}}

                <p class="card-text">
                    {!! $item->description !!}
                </p>
            </div>
        </div>
    </div>

@endsection
