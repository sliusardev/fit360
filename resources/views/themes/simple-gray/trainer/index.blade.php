@extends('themes.simple-gray.layout.site', [
    'title' => 'Фітнес Тренери',
    ])

@section('content')

    <div class="bg-gray-100 rounded-lg p-4 mb-4">
        <h3 class="text-lg font-semibold mb-2">
            Тренери
        </h3>
        <div class="space-y-4">

            @foreach($trainers as $trainer)

                <div class="bg-white p-4 rounded-lg shadow">
                    <img class="w-full h-100 object-cover rounded-lg mb-2" src="{{$trainer->getImageUrl()}}" alt="{{$trainer->name}}"/>
                    <h4 class="text-md font-semibold text-gray-800 mb-2 text-center">
                        {{$trainer->name}}
                    </h4>
                    <a class="bg-[#383838] text-white rounded-md w-full py-2 text-sm text-center block" href="{{route('trainer.show', $trainer->id)}}">
                        Переглянути
                    </a>
                </div>
            @endforeach

        </div>
    </div>

@endsection
