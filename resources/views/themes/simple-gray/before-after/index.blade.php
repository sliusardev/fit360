@extends('themes.simple-gray.layout.site', [
    'title' => 'До та після',
    ])

@section('content')

    <div class="bg-gray-100 rounded-lg p-4 mb-4">
        <h3 class="text-lg font-semibold mb-2">
            До та після
        </h3>
        <div class="space-y-4">

            @foreach($beforeAfterList as $item)

                <div class="bg-white p-4 rounded-lg shadow">
                    <img class="w-full h-100 object-cover rounded-lg mb-2" src="{{$item->getCollageImageUrl()}}" alt="{{$item->title ?? ''}}"/>
                    <h4 class="text-md font-semibold text-gray-800 mb-2 text-center">
                        {{$item->title}}
                    </h4>
                    <a class="bg-[#383838] text-white rounded-md w-full py-2 text-sm text-center block" href="{{route('before-after.show', $item->id)}}">
                        Переглянути
                    </a>
                </div>
            @endforeach

        </div>
    </div>

    <div>
        {{$beforeAfterList->links()}}
    </div>


@endsection
