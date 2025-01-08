@extends('themes.simple-gray.layout.site')

@section('content')

    <div class="grid grid-cols-2 gap-4 mb-4">
        <a class="bg-gray-100 rounded-lg p-4 text-center" href="{{route('activity.list')}}">
            <i class="fas fa-users text-gray-500 text-2xl mb-2">
            </i>
            <p class="text-sm font-semibold">
                Групові заняття
            </p>
        </a>

        <a class="bg-gray-200 rounded-lg p-4 text-center" href="{{route('trainer.index')}}">
            <i class="fas fa-user text-gray-500 text-2xl mb-2">
            </i>
            <p class="text-sm font-semibold">
                Тренери
            </p>
        </a>
        <a class="bg-gray-100 rounded-lg p-4 text-center" href="{{route('price-list.index')}}">
            <i class="fas fa-dollar-sign text-gray-500 text-2xl mb-2">
            </i>
            <p class="text-sm font-semibold">
                Прайси Студії
            </p>
        </a>
        <a class="bg-gray-200 rounded-lg p-4 text-center" href="{{route('before-after.index')}}">
            <i class="fas fa-exchange-alt text-gray-500 text-2xl mb-2">
            </i>
            <p class="text-sm font-semibold">
                До та Після
            </p>
        </a>
        <a class="bg-gray-100 rounded-lg p-4 text-center" href="{{route('feedback.index')}}">
            <i class="fas fa-comments text-gray-500 text-2xl mb-2">
            </i>
            <p class="text-sm font-semibold">
                Відгуки
            </p>
        </a>
        <a class="bg-gray-200 rounded-lg p-4 text-center" href="{{route('page.contacts')}}">
            <i class="fas fa-phone text-gray-500 text-2xl mb-2">
            </i>
            <p class="text-sm font-semibold">
                Контакти
            </p>
        </a>

        @auth

            <a class="bg-gray-100 rounded-lg p-4 text-center" href="{{route('activity.myArchive')}}">
                <i class="fas fa-check-circle text-gray-500 text-2xl mb-2">
                </i>
                <p class="text-sm font-semibold">
                    Moї Завершені
                </p>
            </a>

            <a class="bg-gray-200 rounded-lg p-4 text-center" href="{{route('activity.my')}}">
                <i class="fas fa-dumbbell text-gray-500 text-2xl mb-2">
                </i>
                <p class="text-sm font-semibold">
                    Мої тренування
                </p>
            </a>
        @endauth
    </div>

@endsection
