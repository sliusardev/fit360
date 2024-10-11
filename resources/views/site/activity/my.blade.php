@extends('site.layout.site')

@section('content')

    <div class="row">
        @foreach($activities as $activity)
            <div class="my-2">
                <a href="{{route('activity-show', $activity->id)}}" class="link">
                    <div class="card">

                        <div class="card-body">
                            <div class=" text-center">
                                {{$activity->start_time->format('d-m-Y H:i')}}
                            </div>
                            <hr>
                            <div>
                                <h4>{{$activity->title}}</h4>
                            </div>
                            <hr>
                            <div class="row text-center">
                                <div class="col-6">
                                    Всього місць
                                    <p>{{$activity->available_slots}}</p>
                                </div>
                                <div class="col-6">
                                    Залишилось місць
                                    <p>{{$activity->getFreeSlots()}}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </a>
            </div>

        @endforeach
    </div>

@endsection
