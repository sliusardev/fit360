@extends('themes.simple-gray.layout.site')

@section('content')
    <a href="{{route('posts.index')}}">
        <h1 class="text-2xl font-bold mb-6 text-center">Блог</h1>
    </a>
    <div class="container mx-auto p-4">

        <div class="grid grid-cols-1 gap-6 py-3 my-3">
            @foreach($posts as $post)
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform transform hover:scale-105">
                    <a href="{{route('posts.show', $post->slug)}}">
                        <img src="{{$post->thumbnailUrl()}}" alt="Blog Image" class="w-full h-auto object-cover">
                    </a>
                    <div class="p-4">
                        <a href="{{route('posts.show', $post->slug)}}">
                            <h2 class="text-xl font-semibold mb-2">{{$post->title}}</h2>
                        </a>

                        <p class="text-gray-600 mb-2">{!! $post->short !!}</p>
                        <span class="text-gray-500 text-sm">{{$post->dateTime()}}</span>
                    </div>


                    <div class="p-2">
                        <div class="flex flex-row gap-2 flex-wrap">
                            @foreach($post->tags as $tag)
                                <a href="{{route('posts.index',['tag' => $tag->slug])}}" class="shadow-lg p-2 rounded-lg">{{$tag->title}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="mt-4">
            {{ $posts->appends(request()->query())->links() }} <!-- Responsible for pagination links -->
        </div>
    </div>
@endsection
