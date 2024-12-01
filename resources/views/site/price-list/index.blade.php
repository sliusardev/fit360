@extends('site.layout.site', [
    'title' => 'Прайси студії',
    'seoDescription' => '',
    'seoKeyWords' => '',
    ])

@section('content')

    <div class="text-center my-4">
        <h1>Прайси Студії</h1>

        <div class="row">
            @foreach($priceLists as $price)
                <div class="col-12 col-md-6 my-3 text-decoration-none">
                    <a href="{{route('price-list.show', $price->id)}}" class="link">
                        <div class="card">
                            <div class="card-body">
                                <h4>{{$price->title}}</h4>
                            </div>
                        </div>
                    </a>

                </div>
            @endforeach
        </div>
    </div>

@endsection
