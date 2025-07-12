@extends('themes.simple-gray.layout.site', [
    'title' => 'Анкета: ' . $survey->title,
    'seoDescription' => 'Анкета: ' . $survey->title . ' - ' . ($survey->description ?? 'Будь ласка, заповніть цю анкету для покращення наших послуг.'),
])

@section('content')
    <div class="container mx-auto py-4 px-0">
        <div class="max-w-full mx-auto bg-white shadow-xl rounded-2xl p-4">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4 text-center">{{ $survey->title }}</h1>

            @if($survey->description)
                <p class="text-gray-600 mb-8 leading-relaxed">{{ $survey->description }}</p>
            @endif

            <form action="{{ route('surveys.submit', $survey->id) }}" method="POST" class="space-y-4 flex flex-col">
                @csrf

                @foreach($survey->questions as $index => $question)
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 shadow-sm">
                        <h3 class="font-medium text-gray-800 mb-4">{{ $question['question'] }}</h3>

                        <div>
                            @switch($question['type'])
                                @case(App\Enums\SurveyTypeEnum::YES_NO->value)
                                    <div class="flex gap-6">
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input id="yes-{{ $index }}" name="answers[{{ $index }}]" type="radio" value="yes" class="form-radio text-blue-600">
                                            <span class="px-2">Так</span>
                                        </label>
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input id="no-{{ $index }}" name="answers[{{ $index }}]" type="radio" value="no" class="form-radio text-red-600">
                                            <span class="px-2">Ні</span>
                                        </label>
                                    </div>
                                    @break

                                @case(App\Enums\SurveyTypeEnum::PLUS_MINUS->value)
                                    <div class="flex gap-6">
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input id="plus-{{ $index }}" name="answers[{{ $index }}]" type="radio" value="plus" class="form-radio text-green-500">
                                            <span class="px-2">+</span>
                                        </label>
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input id="minus-{{ $index }}" name="answers[{{ $index }}]" type="radio" value="minus" class="form-radio text-red-500">
                                            <span class="px-2">-</span>
                                        </label>
                                    </div>
                                    @break

                                @case(App\Enums\SurveyTypeEnum::TEXT->value)
                                    <textarea name="answers[{{ $index }}]" rows="3"
                                              class="w-full rounded-lg border border-gray-300 p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                              placeholder="Ваша відповідь..."></textarea>
                                    @break

                                @case(App\Enums\SurveyTypeEnum::RATING->value)
                                    <div class="flex flex-wrap gap-2">
                                        @for ($i = 1; $i <= 10; $i++)
                                            <label class="flex flex-col items-center space-y-1 cursor-pointer">
                                                <input type="radio" name="answers[{{ $index }}]" value="{{ $i }}"
                                                       class="form-radio text-yellow-500">
                                                <span class="text-sm text-gray-600">{{ $i }}</span>
                                            </label>
                                        @endfor
                                    </div>
                                    @break

                                @case(App\Enums\SurveyTypeEnum::CUSTOM->value)
                                    @if(isset($question['options']))
                                        <div class="space-y-3">
                                            @foreach($question['options'] as $optionIndex => $option)
                                                <label class="flex items-center space-x-2 cursor-pointer">
                                                    <input type="checkbox"
                                                           name="answers[{{ $index }}][]"
                                                           value="{{ $option['option'] }}"
                                                           class="form-checkbox text-indigo-600">
                                                    <span>{{ $option['option'] }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @endif
                                    @break

                                @default
                                    <p class="text-sm text-gray-500 italic">Тип питання не підтримується</p>
                            @endswitch
                        </div>
                    </div>
                @endforeach

                <div>
                    <button type="submit" class="w-full py-3 px-6 text-white font-semibold rounded-lg bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:ring-gray-400 transition-all">
                        Надіслати відповіді
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
