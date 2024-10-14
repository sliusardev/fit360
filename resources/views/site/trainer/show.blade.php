@extends('site.layout.site')

@section('content')
    <div class="card-body">
        <div class=" text-center">
            <img src="{{$trainer->getImageUrl()}}" alt="{{$trainer->name}}" class="img-fluid rounded" style="max-height: 400px">
            <h2 class="my-3">{{$trainer->name}}</h2>
        </div>
        <div>
            <h3>Спеціалізація:</h3>
            {!! $trainer->specialization !!}
        </div>

        <div>
            <h3>Інформація:</h3>
            {!! $trainer->description !!}
        </div>
    </div>
@endsection
