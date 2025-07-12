<!-- resources/views/filament/resources/survey-resource/pages/survey-results.blade.php -->
<x-filament::page>
    <x-filament::section>
        <h2 class="text-xl font-bold mb-4">{{ __('surveys.results_title', ['title' => $record->title]) }}</h2>
        <p class="mb-4">{{ __('surveys.total_responses', ['count' => $responsesCount]) }}</p>

        @if($responsesCount == 0)
            <div class="p-4 bg-gray-100 rounded-lg text-center">
                <p>{{ __('surveys.no_responses') }}</p>
            </div>
        @else
            <div class="space-y-8">
                @foreach($questionsData as $questionData)
                    <div class="p-4 bg-white rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-3">{{ $questionData['question'] }}</h3>

                        @if($questionData['chartData'])
                            <div class="space-y-3">
                                @foreach($questionData['chartData'] as $data)
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span>{{ $data['label'] }}</span>
                                            <span>{{ $data['value'] }} ({{ $data['percentage'] }}%)</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-primary-600 h-2.5 rounded-full" style="width: {{ $data['percentage'] }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if($questionData['textAnswers'])
                            <div class="space-y-2 mt-3">
                                @foreach($questionData['textAnswers'] as $date => $text)
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <p>{{ $text }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($date)->format('d.m.Y H:i') }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </x-filament::section>
</x-filament::page>
