@extends('themes.simple-gray.layout.site', [
    'title' => 'Анкета: ' . $survey->title,
    'seoDescription' => 'Анкета: ' . $survey->title . ' - ' . ($survey->description ?? 'Будь ласка, заповніть цю анкету для покращення наших послуг.'),
    ])

@section('content')
    <div class="container mx-auto py-8 px-4">
        <div class="max-w-2xl mx-auto bg-white p-6 md:p-8 rounded-lg shadow">
            <h1 class="text-2xl font-bold mb-6">{{ $survey->title }}</h1>

            @if($survey->description)
                <p class="mb-6 text-gray-600">{{ $survey->description }}</p>
            @endif

            <form action="{{ route('surveys.submit', $survey) }}" method="POST">
                @csrf

                @foreach($survey->questions as $question)
                    <div class="mb-6 pb-6 border-b border-gray-200 last:border-0">
                        <label class="block mb-3 font-medium text-gray-700">
                            {{ $question->question }}
                        </label>

                        @if($question->type === 'yes_no')
                            <div class="flex flex-wrap gap-4">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="Так" required class="form-radio h-5 w-5 text-blue-600">
                                    <span class="ml-2">Так</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="Ні" required class="form-radio h-5 w-5 text-blue-600">
                                    <span class="ml-2">Ні</span>
                                </label>
                            </div>
                        @elseif($question->type === 'plus_minus')
                            <div class="flex flex-wrap gap-4">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="+" required class="form-radio h-5 w-5 text-blue-600">
                                    <span class="ml-2">+</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="-" required class="form-radio h-5 w-5 text-blue-600">
                                    <span class="ml-2">-</span>
                                </label>
                            </div>
                        @elseif($question->type === 'text')
                            <textarea name="answers[{{ $question->id }}]" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required></textarea>
                        @elseif($question->type === 'rating')
                            <div class="flex flex-wrap gap-2">
                                @for($i = 1; $i <= 10; $i++)
                                    <label class="rating-label cursor-pointer">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $i }}" class="sr-only peer" required>
                                        <span class="flex items-center justify-center w-10 h-10 border rounded-md peer-checked:bg-blue-600 peer-checked:text-white hover:bg-gray-100 peer-checked:hover:bg-blue-600">{{ $i }}</span>
                                    </label>
                                @endfor
                            </div>
                        @endif
                    </div>
                @endforeach

                <div class="mt-8">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Надіслати відгук
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
