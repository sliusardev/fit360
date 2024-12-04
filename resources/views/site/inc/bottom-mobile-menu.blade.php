<style>
    body {
        padding-bottom: 60px;
    }
    .app-menu {
        display: none;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: #f8f9fa;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    }
    .app-menu .nav-link {
        text-align: center;
        padding: 0.5rem 0;
        color: #6c757d;
    }
    .app-menu .nav-link.active {
        color: #0d6efd;
    }
    .app-menu .nav-link i {
        font-size: 1.3rem;
        display: block;
        margin-bottom: 0.25rem;
    }
    .app-menu .nav-link span {
        font-size: 1rem;
    }
    .dropdown-menu {
        margin-bottom: 0.5rem;
        box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .app-menu {
            display: block;
        }
    }
</style>

<nav class="app-menu">
    <ul class="nav nav-justified">
        <li class="nav-item">
            <a class="nav-link active" href="/">
                <i class="bi bi-house-door"></i>
                <span>Головна</span>
            </a>
        </li>
        <li class="nav-item dropup">
            <a class="nav-link" href="#" id="activityDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-calendar-check"></i>
                <span>Тренування</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="activityDropdown">
                <li><a class="dropdown-item" href="{{route('activity.list')}}">Групові тренування</a></li>
                <li><a class="dropdown-item" href="{{route('trainer.index')}}">Наші Тренери</a></li>
                <li><a class="dropdown-item" href="{{route('price-list.index')}}">Наші Прайси</a></li>
            </ul>
        </li>
        <li class="nav-item dropup">
            <a class="nav-link" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person"></i>
                <span>Профіль</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="{{route('activity.my')}}">Мої тренування</a></li>
                <li><a class="dropdown-item" href="{{route('activity.myArchive')}}">Мої завершені</a></li>
{{--                <li><a class="dropdown-item" href="#">Вийти</a></li>--}}
            </ul>
        </li>
    </ul>
</nav>
