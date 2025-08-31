@extends('themes.simple-gray.layout.site', [
    'title' => $activity->title ?? '',
    'seoDescription' => 'Фітнес Заняття у Полтаві з тренером',
    ])

@section('content')

    <div class="bg-gray-50 rounded-lg p-4 mb-4">
        <h3 class="text-lg font-semibold mb-2">
            {{$activity->title}}
        </h3>
        <div class="space-y-4">
            <div class="bg-white p-4 rounded-lg shadow">
                @if($activity->getImageUrl())
                    <img alt="{{$activity->title}}" class="w-full h-100 object-cover rounded-lg mb-4" src="{{$activity->getImageUrl()}}"/>
                @endif

                <div class="bg-gray-100 text-dark text-xs font-semibold px-2 py-1 rounded mb-2 text-center">
                    {{$activity->startTimeHuman()}}
                </div>

                <h4 class="text-md font-semibold text-gray-800 mb-2">
                    Опис
                </h4>

                <p class="text-sm text-gray-600">
                    {!! $activity->description !!}
                </p>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div class="bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded text-center">
                        Ціна
                        <div class="text-lg font-bold">{{$activity->price}} UAH</div>
                    </div>
                    <div class="bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded text-center">
                        Тривалість
                        <div class="text-lg font-bold">{{$activity->duration_minutes}} хв.</div>
                    </div>
                    <div class="bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded text-center">
                        Кількість місць
                        <div class="text-lg font-bold">{{$activity->available_slots}}</div>
                    </div>
                    <div class="bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded text-center">
                        Залишилось місць
                        <div class="text-lg font-bold">{{$activity->getFreeSlots()}}</div>
                    </div>
                </div>

                <div class="my-3">
                    <h4 class="text-md font-semibold text-gray-800 mt-4 mb-2">
                        Інструктори
                    </h4>
                    <ul class="list-disc list-inside text-sm text-gray-600">
                        @foreach($activity->trainers as $trainer)
                            <li class="my-2">
                                <a class="text-blue-500 " href="{{route('trainer.show', $trainer->id)}}">{{$trainer->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>


                @auth()

                    @if(!$activity->isOld())
                        @if(auth()->user()->hasActivity($activity->id))
                            <a class="bg-red-500 text-white rounded-md w-full py-2 text-sm text-center block" href="{{route('activity.cancelJoin', $activity->id)}}">
                                Відмінити
                            </a>

                            @if(!$currentUserPayed  && auth()->user()->isAdmin() || $currentUserPayed && $currentUserPayed['status'] !== __('dashboard.paid'))
                                <form action="" method="POST" class="my-3">
                                    @csrf
                                    <input type="hidden" name="payable_type" value="{{\App\Models\Activity::class}}">
                                    <input type="hidden" name="payable_id" value="{{$activity->id}}">
                                    <input type="hidden" name="amount" value="{{$activity->price}}">
                                    <input type="hidden" name="name" value="{{$activity->title}}">

                                    <button type="submit" formaction="{{ route('monobank.pay') }}" class="btn  btn-lg bg-gray-800 text-white rounded-md w-full py-2 text-sm flex justify-center" aria-label="Оплатити online">
                                        <span>Оплатити online</span>
                                        <span class="badge text-bg-secondary">
                                            <img src="{{ asset('assets/images/billing/footer_plata_dark_bg@2x.png') }}" alt="Monobank Logo" class="img-fluid" style="height: 20px; margin-left: 8px;">
                                        </span>
                                    </button>
                                </form>
                            @endif


                        @else
                            <a class="bg-[#383838] text-white rounded-md w-full py-2 text-sm text-center block" href="{{route('activity.join', $activity->id)}}">
                                Приєднатися
                            </a>
                        @endif
                    @endif

                    @if(auth()->user()->isAdmin() || auth()->user()->isTrainer())

                        <h4 class="text-md font-semibold text-gray-800 mt-4 mb-2">
                            Клієнти, що записалися
                        </h4>
                        <ul class="list-disc list-inside text-sm text-gray-600">
                            @foreach($activity->users as $user)
                                <li>{{$user->full_name ?? 'Клієнт'}}</li>
                            @endforeach
                        </ul>

                        @if($payments->isNotEmpty())
                            <h4 class="text-md font-semibold text-gray-800 mt-4 mb-2">
                                Клієнти, що заплатили онлайн
                            </h4>
                            <ul class="list-disc list-inside text-sm text-gray-600">
                                @foreach($payments as $item)
                                    <li class="flex justify-between">
                                        <span class="bg-blue-100 p-2 rounded-1">{{$item['name']}}</span>
                                        <span class="bg-grey-100 p-2 rounded-1">{{$item['date']}}</span>
                                        <span class="bg-green-100 p-2 rounded-1"> статус: {{$item['status']}}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                    @endif
                @endauth
            </div>
        </div>
    </div>


@endsection
