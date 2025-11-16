@extends('themes.simple-gray.layout.site', [
    'title' => $membership->name ?? 'Абонемент',
    'seoDescription' => 'Абонемент на тренування у Полтаві',
    ])

@section('content')

    <div class="bg-gray-50 rounded-lg p-4 mb-4">
        <h3 class="text-lg font-semibold mb-4">
            {{$membership->name}}
        </h3>

        <div class="bg-white p-4 rounded-lg shadow">

            @if($membership->description)
                <div class="mb-4">
                    <h4 class="text-md font-semibold text-gray-800 mb-2">
                        Опис
                    </h4>
                    <p class="text-sm text-gray-600">
                        {!! nl2br(e($membership->description)) !!}
                    </p>
                </div>
            @endif

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="bg-gray-100 text-gray-800 text-xs font-semibold px-3 py-2 rounded">
                    <div class="text-gray-500 mb-1">Тип доступу</div>
                    <div class="text-sm">{{$membership->getAccessTypeLabel()}}</div>
                </div>
                <div class="bg-gray-100 text-gray-800 text-xs font-semibold px-3 py-2 rounded">
                    <div class="text-gray-500 mb-1">Тип тривалості</div>
                    <div class="text-sm">{{$membership->getDurationTypeLabel()}}</div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                @if($membership->duration_type->value === 'unlimited')
                    <div class="bg-blue-100 text-gray-800 text-xs font-semibold px-3 py-2 rounded text-center">
                        <div class="text-gray-600 mb-1">Тривалість</div>
                        <div class="text-lg font-bold">{{$membership->duration_days}} днів</div>
                    </div>
                @else
                    <div class="bg-blue-100 text-gray-800 text-xs font-semibold px-3 py-2 rounded text-center">
                        <div class="text-gray-600 mb-1">Кількість відвідувань</div>
                        <div class="text-lg font-bold">{{$membership->visit_limit}}</div>
                    </div>
                @endif

                <div class="bg-green-100 text-gray-800 text-xs font-semibold px-3 py-2 rounded text-center">
                    <div class="text-gray-600 mb-1">Ціна</div>
                    <div class="text-lg font-bold">{{number_format($membership->price, 0)}} грн</div>
                </div>
            </div>

            @auth()
                @if(!$alreadySubscribed)
                        <div class="mt-4">
                            <form action="" method="POST" class="my-3">
                                @csrf
                                <input type="hidden" name="payable_type" value="{{\App\Models\Membership::class}}">
                                <input type="hidden" name="payable_id" value="{{$membership->id}}">
                                <input type="hidden" name="amount" value="{{$membership->price}}">
                                <input type="hidden" name="name" value="{{$membership->name}}">

                                <button type="submit" formaction="{{ route('monobank.pay') }}" class="btn btn-lg bg-gray-800 text-white rounded-md w-full py-2 text-sm flex justify-center" aria-label="Придбати абонемент">
                                    <span>Придбати абонемент</span>
                                    <span class="badge text-bg-secondary">
                                <img src="{{ asset('assets/images/billing/footer_plata_dark_bg@2x.png') }}" alt="Monobank Logo" class="img-fluid" style="height: 20px; margin-left: 8px;">
                            </span>
                                </button>
                            </form>
                        </div>
                @else
                    <div class="mt-4 text-center">
                        <p class="text-sm text-green-600 mb-2">Ви вже маєте активний абонемент цього типу</p>
                        <a href="{{route('memberships.my')}}" class="bg-gray-800 text-white rounded-md px-6 py-2 text-sm inline-block hover:bg-gray-700">
                            Перейти до моїх абонементів
                        </a>
                    </div>
                @endif

            @else
                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600 mb-2">Для придбання абонементу необхідно увійти до системи</p>
                    <a href="/panel/login" class="bg-[#383838] text-white rounded-md px-6 py-2 text-sm inline-block hover:bg-gray-700">
                        Увійти
                    </a>
                </div>
            @endauth

            @auth()
                @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <h4 class="text-md font-semibold text-gray-800 mb-2">
                            Адміністративна інформація
                        </h4>
                        <div class="text-sm text-gray-600">
                            <p>ID абонементу: {{$membership->id}}</p>
                            <p>Створено: {{$membership->created_at->format('d.m.Y H:i')}}</p>
                            <p>Оновлено: {{$membership->updated_at->format('d.m.Y H:i')}}</p>
                            <p>Статус: {{$membership->is_enabled ? 'Активний' : 'Неактивний'}}</p>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </div>

@endsection

