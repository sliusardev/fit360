@extends('site.layout.site')

@section('content')

    <div class="text-center my-4">

        <div class="row">
            <div class="col-12 col-md-6 my-3 text-decoration-none">
                <a href="{{route('activity.list')}}" class="link">
                    <div class="card">
                        <div class="card-body">
                            <h4>Групові заняття</h4>
                        </div>
                    </div>
                </a>

            </div>
            <div class="col-12 col-md-6 my-3 text-decoration-none">
                <a href="{{route('activity.my')}}" class="link">
                    <div class="card">
                        <div class="card-body">
                            <h4>Мої тренування</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

@endsection
