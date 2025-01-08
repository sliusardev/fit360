@extends('themes.simple-gray.layout.site', [
    'title' => 'Відгуки клієнтів',
    ])

@section('content')

    <div class="bg-gray-50 rounded-lg p-4 mb-4">

        @auth()
            @if(!$hasFeedBack)
                <div class="bg-gray-100 rounded-lg p-4 mb-4">
                    <form id="feedbackForm" class="space-y-4" action="{{route('feedback.store')}}" method="post">
                        @csrf
                        <div>
                            <label for="feedback" class="block text-sm font-medium text-gray-700">Додайте Ваш відгук:</label>
                            <textarea id="feedback" name="text" rows="4" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" placeholder="Напишіть ваш відгук тут..." required></textarea>
                        </div>
                        <button type="submit" class="bg-[#383838] text-white rounded-md w-full py-2 text-sm text-center">Відправити</button>
                    </form>
                </div>

            @endif
        @endauth

        <h3 class="text-lg font-semibold mb-2">
            Відгуки
        </h3>

        <div class="space-y-4">

            @foreach($feedbacks as $feedback)
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-sm text-gray-700">
                        "{{$feedback->text}}"
                    </p>
                    <p class="text-xs text-gray-500 mt-2">
                        - {{$feedback->user->full_name ?? 'Клієнт'}}
                    </p>
                </div>
            @endforeach

        </div>
    </div>


    <div>
        {{$feedbacks->links()}}
    </div>


@endsection
