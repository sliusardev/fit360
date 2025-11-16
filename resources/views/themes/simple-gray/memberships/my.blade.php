@extends('themes.simple-gray.layout.site', [
    'title' => 'Мої абонементи',
    'seoDescription' => 'Мої абонементи на тренування',
    ])

@section('content')

    <div class="bg-gray-50 rounded-lg p-4 mb-4">
        <h3 class="text-lg font-semibold mb-4">
            Мої абонементи
        </h3>

        <div class="space-y-4">
            @forelse($memberships as $membership)
                @php
                    $pivot = $membership->pivot;
                    $isActive = $membership->isUserActiveMembership(auth()->user());
                @endphp

                <div class="bg-white p-4 rounded-lg shadow {{ $isActive ? 'border-l-4 border-green-500' : 'border-l-4 border-gray-400' }}">
                    <div class="flex justify-between items-start mb-3">
                        <h4 class="text-md font-semibold text-gray-800">
                            {{$membership->name}}
                        </h4>
                        @if($isActive)
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">
                                Активний
                            </span>
                        @else
                            <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded">
                                Неактивний
                            </span>
                        @endif
                    </div>

                    @if($membership->description)
                        <p class="text-sm text-gray-600 mb-3">
                            {!! nl2br(e($membership->description)) !!}
                        </p>
                    @endif

                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div class="bg-gray-100 text-gray-800 text-xs px-3 py-2 rounded">
                            <div class="text-gray-500 mb-1">Тип доступу</div>
                            <div class="text-sm font-semibold">{{$membership->getAccessTypeLabel()}}</div>
                        </div>
                        <div class="bg-gray-100 text-gray-800 text-xs px-3 py-2 rounded">
                            <div class="text-gray-500 mb-1">Ціна</div>
                            <div class="text-sm font-semibold">{{number_format($membership->price, 0)}} грн</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div class="bg-blue-50 text-gray-800 text-xs px-3 py-2 rounded">
                            <div class="text-gray-500 mb-1">Дата початку</div>
                            <div class="text-sm font-semibold">
                                {{ $pivot->start_date ? \Carbon\Carbon::parse($pivot->start_date)->format('d.m.Y') : 'Не визначено' }}
                            </div>
                        </div>
                        <div class="bg-blue-50 text-gray-800 text-xs px-3 py-2 rounded">
                            <div class="text-gray-500 mb-1">Дата закінчення</div>
                            <div class="text-sm font-semibold">
                                {{ $pivot->end_date ? \Carbon\Carbon::parse($pivot->end_date)->format('d.m.Y') : 'Не визначено' }}
                            </div>
                        </div>
                    </div>

                    @if($membership->duration_type->value === 'visits' && $pivot->visit_limit)
                        <div class="bg-yellow-50 text-gray-800 text-xs px-3 py-2 rounded">
                            <div class="text-gray-500 mb-1">Залишилось відвідувань</div>
                            <div class="text-sm font-semibold">{{$pivot->visit_limit}}</div>
                        </div>
                    @endif

                    <div class="mt-3 flex justify-between items-center">
                        <span class="text-xs text-gray-500">
                            Придбано: {{ \Carbon\Carbon::parse($pivot->created_at)->format('d.m.Y H:i') }}
                        </span>
                        <a href="{{route('memberships.show', $membership->id)}}"
                           class="text-blue-600 text-sm hover:underline">
                            Детальніше
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <i class="fas fa-ticket-alt text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500 mb-4">У вас ще немає придбаних абонементів</p>
                    <a href="{{route('memberships.index')}}"
                       class="bg-[#383838] text-white px-6 py-2 rounded-md text-sm inline-block hover:bg-gray-700">
                        Переглянути абонементи
                    </a>
                </div>
            @endforelse
        </div>
    </div>

@endsection

