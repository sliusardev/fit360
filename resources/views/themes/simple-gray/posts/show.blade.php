@extends('themes.simple-gray.layout.site')

@section('content')
    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow-md">
            <img src="{{$post->thumbnailUrl()}}" alt="{{$post->title}}" class="w-full h-auto object-cover">
            <div class="p-4">
                <h1 class="text-xl font-semibold mb-2">{{$post->title}}</h1>
                <p class="text-gray-600 mb-2">{!! $post->content !!}</p>
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
        <h2 class="text-2xl font-bold my-4">Галерея</h2>
        <div class="grid grid-cols-2 gap-4">
            @foreach($post->images as $image)
                <a href="/storage/{{$image}}" data-fancybox="gallery" data-caption="{{$post->title}}" class="bg-gray-200 rounded-lg overflow-hidden">
                    <img src="/storage/{{$image}}"  class="w-full h-48 object-cover"/>
                </a>
            @endforeach

        </div>

    </div>
@endsection
