@extends('themes.simple-gray.layout.site', [
    'title' => 'Анкета: ' . $survey->title,
    'seoDescription' => 'Анкета: ' . $survey->title . ' - ' . ($survey->description ?? 'Будь ласка, заповніть цю анкету для покращення наших послуг.'),
])

@section('content')
    <div class="container">
        <h1>{{ $survey->title }}</h1>
        <p>{{ $survey->description }}</p>

        <form action="{{ route('surveys.submit', $survey->id) }}" method="POST">
            @csrf

            @foreach($survey->questions as $question)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>{{ $question->text }}</h5>
                    </div>
                    <div class="card-body">
                        @if($question->type === 'multiple_choice')
                            @foreach($question->options as $option)
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="answers[{{ $question->id }}]"
                                           id="option{{ $option->id }}"
                                           value="{{ $option->id }}">
                                    <label class="form-check-label" for="option{{ $option->id }}">
                                        {{ $option->text }}
                                    </label>
                                </div>
                            @endforeach
                        @elseif($question->type === 'checkbox')
                            @foreach($question->options as $option)
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="answers[{{ $question->id }}][]"
                                           id="option{{ $option->id }}"
                                           value="{{ $option->id }}">
                                    <label class="form-check-label" for="option{{ $option->id }}">
                                        {{ $option->text }}
                                    </label>
                                </div>
                            @endforeach
                        @elseif($question->type === 'text')
                            <textarea class="form-control"
                                      name="answers[{{ $question->id }}]"
                                      rows="3"></textarea>
                        @endif
                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary">Submit Survey</button>
        </form>
    </div>
@endsection
