<div class="fixed inset-0 bg-gray-800 bg-opacity-50 z-40 sidebar sidebar-hidden" id="sidebar">
    <div class="absolute right-0 top-0 bg-white w-64 h-full shadow-lg p-4">
        <button class="text-gray-500 mb-4" onclick="toggleSidebar()">
            <i class="fas fa-times">
            </i>
        </button>
        <div class="text-center mb-4">
            <img alt="Fit360 logo" class="w-auto h-16 rounded-lg mx-auto mb-2" height="100" src="https://fit360.com.ua/assets/images/header/fit360_logo.jpg" width="200"/>
        </div>
        <ul>
            <li class="mb-2">
                <a class="text-gray-700" href="/">
                    Головна
                </a>
            </li>

            <li class="mb-2">
                <a class="text-gray-700" href="{{route('activity.list')}}">
                    Групові заняття
                </a>
            </li>

            @auth
                <li class="mb-2">
                    <a class="text-gray-700" href="{{route('activity.my')}}">
                        Мої тренування
                    </a>
                </li>

                <li class="mb-2">
                    <a class="text-gray-700" href="{{route('activity.myArchive')}}">
                        Moї Завершені
                    </a>
                </li>
            @endauth

            <li class="mb-2">
                <a class="text-gray-700" href="{{route('trainer.index')}}">
                    Тренери
                </a>
            </li>

            <li class="mb-2">
                <a class="text-gray-700" href="{{route('price-list.index')}}">
                    Прайси Студії
                </a>
            </li>

            <li class="mb-2">
                <a class="text-gray-700" href="{{route('before-after.index')}}">
                    До та Після
                </a>
            </li>
            <li class="mb-2">
                <a class="text-gray-700" href="{{route('feedback.index')}}">
                    Відгуки
                </a>
            </li>
            <li class="mb-2">
                <a class="text-gray-700" href="{{route('page.contacts')}}">
                    Контакти
                </a>
            </li>
        </ul>
        @auth()
            @if(auth()->user()->isAdmin())
                <div>
                    <hr>
                    <a href="/admin/login">Адмінка</a>
                </div>
            @endif
        @endauth
    </div>


</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('sidebar-hidden');
    }
</script>
