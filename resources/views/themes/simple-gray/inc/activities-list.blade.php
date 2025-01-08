<div class="space-y-4">
    @foreach($activities as $activity)
        <div class="bg-white p-4 rounded-lg shadow-xl">
            <div class="bg-gray-100 text-dark text-xs font-semibold px-2 py-1 rounded mb-2 text-center">
                {{$activity->startTimeHuman()}}
            </div>
            <h4 class="text-md font-semibold text-gray-800 mb-2 text-center">
                {{$activity->title}}
            </h4>
            <p class="text-sm text-gray-600 text-center">
                Кількість місць: <span class="font-bold">{{$activity->available_slots}}</span>
            </p>
            <p class="text-sm text-gray-600 text-center mb-4">
                Залишилось місць: <span class="font-bold">{{$activity->getFreeSlots()}}</span>
            </p>
            <a class="bg-[#383838] text-white rounded-md w-full py-2 text-center block" href="{{route('activity.show', $activity->id)}}">
                Переглянути
            </a>
        </div>

    @endforeach
</div>
