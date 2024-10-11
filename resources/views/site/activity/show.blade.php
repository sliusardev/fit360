@extends('site.layout.site')

@section('content')
    <div class="card-body">
        <div class=" text-center">
            {{$activity->start_time->format('d-m-Y H:i')}}
        </div>
        <hr>
        <div class="p-3">
            <h4>{{$activity->title}}</h4>
        </div>
        <hr>
        <div class="p-5 text-center">
            <h2>Тренери</h2>

            @foreach($activity->trainers as $trainer)
                <div class="my-2 p-2">

                    @if($trainer->avatar)
                        <img src="/storage/{{$trainer->avatar}}" class="" alt="{{$trainer->name}}" style="width: 50px; border-radius: 50%">
                    @endif

                    <span class="mx-3">{{$trainer->name}}</span>
                </div>

            @endforeach

        </div>
        <div class="row text-center">
            <div class="col-6">
                Всього місць
                <p>{{$activity->available_slots}}</p>
            </div>
            <div class="col-6">
                Залишилось місць
                <p>{{$activity->getFreeSlots()}}</p>
            </div>

            <div class="col-6">
                Ціна
                <p>{{$activity->price}} UAH</p>
            </div>

            <div class="col-6">
                Тривалість
                <p>{{$activity->duration_minutes}} хв.</p>
            </div>
        </div>

        <hr>

        <div class="my-3">
            <p>Опис:</p>
            {!! $activity->description !!}
        </div>

        @auth()
            @if(auth()->user()->hasActivity($activity->id))
                <div class="text-center">
                    <a href="{{route('activity-cancel-join', $activity->id)}}">
                        <button type="button" style="width: 100%" class="btn btn-danger">Відмінити</button>
                    </a>
                </div>
            @else
                <div class="text-center">
                    <a href="{{route('activity-join', $activity->id)}}">
                        <button type="button" style="width: 100%" class="btn btn-dark">Приєднатися</button>
                    </a>
                </div>
            @endif


            @if(auth()->user()->isAdmin())

                <div class="my-4 p-3">
                    <h3>Приєднані клієнти</h3>
                    <ul class="list-group">
                        @foreach($activity->users as $user)
                            <li class="list-group-item">{{$user->full_name}}</li>
                        @endforeach
                    </ul>
                </div>

            @endif

        @endauth
    </div>
@endsection
