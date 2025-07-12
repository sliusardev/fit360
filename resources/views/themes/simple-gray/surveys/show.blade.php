@extends('themes.simple-gray.layout.site', [
    'title' => 'Анкета: ' . $survey->title,
    'seoDescription' => 'Анкета: ' . $survey->title . ' - ' . ($survey->description ?? 'Будь ласка, заповніть цю анкету для покращення наших послуг.'),
])

@section('content')
    <div class="container mx-auto py-8 px-4">
        <div class="max-w-3xl mx-auto p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-3">{{ $survey->title }}</h1>
            @if($survey->description)
                <p class="text-gray-600 mb-8 text-ellipsis p-2">{{ $survey->description }}</p>
            @endif

            <form action="{{ route('surveys.submit', $survey->id) }}" method="POST" class="space-y-6">
                @csrf

                @foreach($survey->questions as $index => $question)
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 my-2">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ $question['question'] }}</h3>

                        <div class="mt-4">
                            @switch($question['type'])
                                @case(App\Enums\SurveyTypeEnum::YES_NO->value)
                                    <div class="space-y-2 flex flex-wrap gap-4">
                                        <div class="flex items-center">
                                            <input id="yes-{{ $index }}" name="answers[{{ $index }}]" type="radio" value="yes"
                                                class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                            <label for="yes-{{ $index }}" class="ml-3 text-gray-700 p-2">Так</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="no-{{ $index }}" name="answers[{{ $index }}]" type="radio" value="no"
                                                class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                            <label for="no-{{ $index }}" class="ml-3 text-gray-700 p-2">Ні</label>
                                        </div>
                                    </div>
                                    @break

                                @case(App\Enums\SurveyTypeEnum::PLUS_MINUS->value)
                                    <div class="space-y-2 flex flex-wrap gap-4">
                                        <div class="flex items-center">
                                            <input id="plus-{{ $index }}" name="answers[{{ $index }}]" type="radio" value="plus"
                                                class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                            <label for="plus-{{ $index }}" class="ml-3 text-gray-700 p-2">+</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="minus-{{ $index }}" name="answers[{{ $index }}]" type="radio" value="minus"
                                                class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                            <label for="minus-{{ $index }}" class="ml-3 text-gray-700 p-2">-</label>
                                        </div>
                                    </div>
                                    @break

                                @case(App\Enums\SurveyTypeEnum::TEXT->value)
                                    <div>
                                        <textarea name="answers[{{ $index }}]" rows="3"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-800 p-2"
                                            placeholder="Ваша відповідь..."></textarea>
                                    </div>
                                    @break

                                @case(App\Enums\SurveyTypeEnum::RATING->value)
                                    <div class="flex space-x-4 gap-2">
                                        @for ($i = 1; $i <= 10; $i++)
                                            <div class="flex flex-col items-center">
                                                <input id="rating-{{ $index }}-{{ $i }}" name="answers[{{ $index }}]"
                                                    type="radio" value="{{ $i }}"
                                                    class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                <label for="rating-{{ $index }}-{{ $i }}" class="mt-1 text-gray-700">{{ $i }}</label>
                                            </div>
                                        @endfor
                                    </div>
                                    @break

                                @case(App\Enums\SurveyTypeEnum::CUSTOM->value)
                                    <div class="space-y-2 gap-2">
                                        @if(isset($question['options']))
                                            @foreach($question['options'] as $optionIndex => $option)
                                                <div class="flex items-center">
                                                    <input id="option-{{ $index }}-{{ $optionIndex }}"
                                                        name="answers[{{ $index }}][]"
                                                        type="checkbox"
                                                        value="{{ $option['option'] }}"
                                                        class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                    <label for="option-{{ $index }}-{{ $optionIndex }}"
                                                        class="ml-3 text-gray-700 px-2">{{ $option['option'] }}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    @break

                                @default
                                    <p class="text-gray-500 italic">Тип питання не підтримується</p>
                            @endswitch
                        </div>
                    </div>
                @endforeach

                <div class="mt-8">
                    <button type="submit"
                        class="w-full py-3 px-4 text-white rounded-lg bg-gray-800 ">
                        Надіслати відповіді
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
