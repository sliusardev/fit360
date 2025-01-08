@extends('themes.simple-gray.layout.site', [
    'title' => 'Прайси студії',
    ])

@section('content')

    <div class="p-6">
        <h3 class="text-lg font-semibold mb-2">
            Прайси студії
        </h3>

        @foreach($priceLists as $price)

            <a class="flex items-center py-4 border-b border-gray-200" href="{{route('price-list.show', $price->id)}}">
                <i class="fas fa-check text-gray-600 text-xl"></i>
                <span class="ml-4 text-lg">
                    {{$price->title}}
                </span>
            </a>
        @endforeach

    </div>


@endsection
