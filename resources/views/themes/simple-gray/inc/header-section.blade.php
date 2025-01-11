<header class="flex justify-between items-center mb-4">
    <h1 class="text-xl font-bold text-gray-700 italic">
        Fit360 - Фітнес Студія
    </h1>
    <div class="flex gap-4">
        <a href="https://www.instagram.com/fit360_plt/" class="text-gray-500">
            <i class="fab fa-instagram"></i>
        </a>
        <button class="text-gray-500" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</header>

<div class="text-center mb-4">
    <a href="/">
        <img alt="Fit360 фітнес студія в Полтаві" class="rounded-lg mx-auto mb-2" height="100" src="https://fit360.com.ua/assets/images/header/fit360_logo.jpg" width="200"/>
    </a>

    <p class="text-gray-500">
        {!! $settings['slogan'] ?? '' !!}
    </p>

    <div class="bg-gray-100 p-4 rounded-lg mt-3">
        @guest
            <p class="text-gray-500">
                Вітаю! Спробуй <a class="text-blue-500 underline" href="/panel/login">Увійти</a>, або <a class="text-blue-500 underline" href="/panel/register">Зареєструватися</a>
            </p>
        @endguest

        @auth
            <p>
                Вітаю, {{auth()->user()->name}}
            </p>

        @endauth
    </div>
</div>
