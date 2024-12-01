@extends('site.layout.site', [
    'title' => 'Відгуки клієнтів',
    'seoDescription' => '',
    'seoKeyWords' => '',
    ])

@section('content')

    @auth()

        @if(!$hasFeedBack)
            <div>
                <form action="{{route('feedback.store')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="text" class="form-label">Залишити Відгук</label>
                        <textarea class="form-control" id="text" rows="3" name="text"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Відправити</button>
                </form>
            </div>

            <hr>
        @endif

    @endauth

    <h2>Відгуки Клієнтів</h2>

    <div class="my-3">
        @foreach($feedbacks as $feedback)
            <div class="card my-3">
                <div class="card-body">
                    <h5 class="card-title">{{$feedback->user->full_name ?? 'Клієнт'}}</h5>
                    <p class="card-text">{{$feedback->text}}</p>
                </div>
            </div>

        @endforeach
    </div>

    <div>
        {{$feedbacks->links()}}
    </div>


@endsection
