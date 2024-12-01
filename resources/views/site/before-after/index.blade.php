@extends('site.layout.site', [
    'title' => 'до та після',
    'seoDescription' => '',
    'seoKeyWords' => '',
    ])

@section('content')

    @push('custom-header')
        <script defer src="https://cdn.jsdelivr.net/npm/img-comparison-slider@8/dist/index.js" ></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/img-comparison-slider@8/dist/styles.css" />
    @endpush

    <h2>До та після</h2>

    <div class="my-3 row">
        @foreach($beforeAfterList as $item)

            <div class="mx-auto my-3 text-center col-12 col-md-4" style="">

                <img src="{{$item->getAfterImageUrl()}}" loading="lazy" class="rounded img-fluid" alt="{{$item->title ?? ''}}" style="width: 60%">

                <div class="card-body">
                    <h5 class="card-title my-3">{{$item->name}}</h5>
                    <a href="{{route('before-after.show', $item->id)}}" class="btn btn-dark">Переглянути</a>
                </div>
            </div>

        @endforeach
    </div>

    <div>
        {{$beforeAfterList->links()}}
    </div>


@endsection
