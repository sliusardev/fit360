@extends('site.layout.site', [
    'title' => 'Тренери',
    'seoDescription' => '',
    'seoKeyWords' => '',
    ])

@section('content')
    <h2>Тренери</h2>
    <div class="row">
        @foreach($trainers as $trainer)

            <div class="mx-auto my-3 text-center col-12 col-md-4" style="">

                <img src="{{$trainer->getImageUrl()}}" loading="lazy" class="rounded img-fluid" alt="{{$trainer->name}}" style="width: 100%">

                <div class="card-body">
                    <h5 class="card-title my-3">{{$trainer->name}}</h5>
                    {{--                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>--}}
                    <a href="{{route('trainer.show', $trainer->id)}}" class="btn btn-dark">Переглянути</a>
                </div>
            </div>
        @endforeach
    </div>


@endsection
