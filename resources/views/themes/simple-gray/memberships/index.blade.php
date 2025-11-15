@extends('themes.simple-gray.layout.site', [
    'title' => 'Абонементи',
    'seoDescription' => 'Абонементи на тренування у Полтаві',
    'seoKeyWords' => 'фітнес, Полтава, групові заняття, тренування',
    ])

@section('content')

    <div class="bg-gray-50 rounded-lg p-4 mb-4">
        <h3 class="text-lg font-semibold mb-4">
            Абонементи
        </h3>

        <div class="space-y-4">
            @forelse($memberships as $membership)
                <div class="bg-white p-4 rounded-lg shadow">
                    <h4 class="text-md font-semibold text-gray-800 mb-2">
                        {{$membership->name}}
                    </h4>

                    @if($membership->description)
                        <p class="text-sm text-gray-600 mb-3">
                            {!! nl2br(e($membership->description)) !!}
                        </p>
                    @endif

                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div class="bg-gray-100 text-gray-800 text-xs font-semibold px-3 py-2 rounded">
                            <div class="text-gray-500 mb-1">Тип доступу</div>
                            <div class="text-sm">{{$membership->getAccessTypeLabel()}}</div>
                        </div>
                        <div class="bg-gray-100 text-gray-800 text-xs font-semibold px-3 py-2 rounded">
                            <div class="text-gray-500 mb-1">Тривалість</div>
                            <div class="text-sm">{{$membership->getDurationLabel()}}</div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="text-2xl font-bold text-gray-800">
                            {{number_format($membership->price, 0)}} грн
                        </div>
                        <a href="{{route('memberships.show', $membership->id)}}"
                           class="bg-[#383838] text-white px-4 py-2 rounded-md text-sm hover:bg-gray-700">
                            Детальніше
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white p-4 rounded-lg shadow text-center text-gray-500">
                    На даний момент абонементів немає
                </div>
            @endforelse
        </div>

        @if($memberships->hasPages())
            <div class="mt-4">
                {{ $memberships->links() }}
            </div>
        @endif
    </div>

@endsection
