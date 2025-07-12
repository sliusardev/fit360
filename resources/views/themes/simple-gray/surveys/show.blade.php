@extends('themes.simple-gray.layout.site', [
                    'title' => 'Анкета: ' . $survey->title,
                    'seoDescription' => 'Анкета: ' . $survey->title . ' - ' . ($survey->description ?? 'Будь ласка, заповніть цю анкету для покращення наших послуг.'),
                    ])

                @section('content')
                    <div class="container mx-auto py-8 px-4">
                        <div class="max-w-2xl mx-auto bg-white p-6 md:p-8 rounded-lg shadow-lg">
                            <h1 class="text-2xl font-bold mb-6 text-gray-800">{{ $survey->title }}</h1>

                            @if($survey->description)
                                <p class="mb-6 text-gray-600 leading-relaxed">{{ $survey->description }}</p>
                            @endif

                            <form action="{{ route('surveys.submit', $survey) }}" method="POST">
                                @csrf

                                @foreach($survey->questions as $question)
                                    <div class="mb-8 pb-6 border-b border-gray-200 last:border-0">
                                        <label class="block mb-4 font-medium text-gray-700 text-lg">
                                            {{ $question->question }}
                                            @if($question->is_required)
                                                <span class="text-red-500">*</span>
                                            @endif
                                        </label>

                                        @if($question->type === 'yes_no')
                                            <div class="flex flex-wrap gap-4">
                                                <label class="inline-flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-blue-50 transition-colors">
                                                    <input type="radio" name="answers[{{ $question->id }}]" value="Так" {{ $question->is_required ? 'required' : '' }}
                                                           class="form-radio h-5 w-5 text-blue-600">
                                                    <span class="ml-2 font-medium">Так</span>
                                                </label>
                                                <label class="inline-flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-blue-50 transition-colors">
                                                    <input type="radio" name="answers[{{ $question->id }}]" value="Ні" {{ $question->is_required ? 'required' : '' }}
                                                           class="form-radio h-5 w-5 text-blue-600">
                                                    <span class="ml-2 font-medium">Ні</span>
                                                </label>
                                            </div>
                                        @elseif($question->type === 'plus_minus')
                                            <div class="flex flex-wrap gap-4">
                                                <label class="inline-flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-blue-50 transition-colors">
                                                    <input type="radio" name="answers[{{ $question->id }}]" value="+" {{ $question->is_required ? 'required' : '' }}
                                                           class="form-radio h-5 w-5 text-blue-600">
                                                    <span class="ml-2 text-lg font-medium">+</span>
                                                </label>
                                                <label class="inline-flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-blue-50 transition-colors">
                                                    <input type="radio" name="answers[{{ $question->id }}]" value="-" {{ $question->is_required ? 'required' : '' }}
                                                           class="form-radio h-5 w-5 text-blue-600">
                                                    <span class="ml-2 text-lg font-medium">-</span>
                                                </label>
                                            </div>
                                        @elseif($question->type === 'text')
                                            <textarea name="answers[{{ $question->id }}]" rows="3" {{ $question->is_required ? 'required' : '' }}
                                                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-3"></textarea>
                                        @elseif($question->type === 'rating')
                                            <div class="flex flex-wrap gap-2">
                                                @for($i = 1; $i <= 10; $i++)
                                                    <label class="rating-label cursor-pointer">
                                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $i }}" class="sr-only peer" {{ $question->is_required ? 'required' : '' }}>
                                                        <span class="flex items-center justify-center w-12 h-12 border rounded-lg peer-checked:bg-blue-600 peer-checked:text-white hover:bg-gray-100 peer-checked:hover:bg-blue-600 transition-colors text-lg font-medium">{{ $i }}</span>
                                                    </label>
                                                @endfor
                                            </div>
                                        @endif
                                    </div>
                                @endforeach

                                <div class="mt-8">
                                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors text-lg font-medium shadow-md">
                                        Надіслати відгук
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endsection
