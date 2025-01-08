@extends('themes.simple-gray.layout.site', [
    'title' => $trainer->name,
    ])

@section('content')

    <a href="{{route('trainer.index')}}">
        <i class="fas fa-chevron-left"></i>
    </a>

    <div class="bg-gray-50 rounded-lg p-4 mb-4">
        <h3 class="text-lg font-semibold mb-2">
            {{$trainer->name}}
        </h3>
        <div class="space-y-4">
            <div class="bg-white p-4 rounded-lg shadow">
                @if($trainer->getImageUrl())
                    <img alt="{{$trainer->title}}" loading="lazy" class="w-full h-100 object-cover rounded-lg mb-4" src="{{$trainer->getImageUrl()}}"/>
                @endif

                <h4 class="text-md font-semibold text-gray-800 mb-2">
                    Спеціалізація
                </h4>

                <p class="text-sm text-gray-600">
                    {!! $trainer->specialization !!}
                </p>

                @if(!empty($trainer->description))
                    <div class="my-3">
                        <h4 class="text-md font-semibold text-gray-800 mb-2">
                            Інформація
                        </h4>

                        <p class="text-sm text-gray-600">
                            {!! $trainer->description !!}
                        </p>
                    </div>

                @endif

            </div>
        </div>
    </div>
@endsection
