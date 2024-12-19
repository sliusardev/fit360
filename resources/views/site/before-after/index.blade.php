@extends('site.layout.site', [
    'title' => 'До та після',
    ])

@section('content')

    <h2>До та після</h2>

    <div class="my-3 row">
        @foreach($beforeAfterList as $item)

            <div class="mx-auto my-3 text-center col-12 col-md-4" style="">

                <img src="{{$item->getCollageImageUrl()}}" loading="lazy" class="rounded img-fluid" alt="{{$item->title ?? ''}}" style="width: 60%">

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
