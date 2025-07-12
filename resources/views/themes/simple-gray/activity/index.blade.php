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

    <div class="w-full my-3">
        <a class="bg-gradient-to-r from-gray-200 to-gray-300 rounded-lg p-4 text-center block transition-all duration-300 hover:shadow-md hover:from-gray-300 hover:to-gray-200 transform hover:-translate-y-1" href="{{route('surveys.show', 1)}}">
            <i class="fas fa-comment-alt text-gray-500 text-2xl mb-2 block animate-pulse"></i>
            <p class="text-sm font-semibold uppercase tracking-wide">
                Анонімний відгук
            </p>
            <span class="text-xs text-gray-500 mt-1 block">Поділіться своєю думкою</span>
        </a>
    </div>

    <div class="swiper">
        <div class="swiper-wrapper">
            @foreach($posts as $post)
                <div class="swiper-slide">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden my-3">
                        @if(!empty($post->thumbnailUrl()))
                            <a href="{{route('posts.show', $post->slug)}}">
                                <img src="{{$post->thumbnailUrl()}}" alt="Blog Image" class="w-full h-48 object-cover">
                            </a>
                        @endif

                        <div class="p-4">
                            <a href="{{route('posts.show', $post->slug)}}">
                                <h2 class="text-xl font-semibold mb-2">{{$post->title}}</h2>


                                <p class="text-gray-600 mb-2">{!! $post->short !!}</p>
                                <span class="text-gray-500 text-sm">{{$post->dateTime()}}</span>
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
