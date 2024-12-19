@extends('site.layout.site')

@section('content')

    <div class="text-center my-4">

        <div class="row">
            <div class="col-12 col-md-6 my-3 text-decoration-none">
                <a href="{{route('activity.list')}}" class="link">
                    <div class="card">
                        <div class="card-body">
                            <h4>Групові заняття</h4>
                        </div>
                    </div>
                </a>

            </div>

            @auth
                <div class="col-12 col-md-6 my-3 text-decoration-none">
                    <a href="{{route('activity.my')}}" class="link">
                        <div class="card">
                            <div class="card-body">
                                <h4>Мої тренування</h4>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-md-6 my-3 text-decoration-none">
                    <a href="{{route('activity.myArchive')}}" class="link">
                        <div class="card">
                            <div class="card-body">
                                <h4>Moї Завершені</h4>
                            </div>
                        </div>
                    </a>
                </div>
            @endauth

            <div class="col-12 col-md-6 my-3 text-decoration-none">
                <a href="{{route('trainer.index')}}" class="link">
                    <div class="card">
                        <div class="card-body">
                            <h4>Тренери</h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 my-3 text-decoration-none">
                <a href="{{route('price-list.index')}}" class="link">
                    <div class="card">
                        <div class="card-body">
                            <h4>Прайси Студії</h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 my-3 text-decoration-none">
                <a href="{{route('before-after.index')}}" class="link">
                    <div class="card">
                        <div class="card-body">
                            <h4>До та Після</h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 my-3 text-decoration-none">
                <a href="{{route('feedback.index')}}" class="link">
                    <div class="card">
                        <div class="card-body">
                            <h4>Відгуки</h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 my-3 text-decoration-none">
                <a href="{{route('page.contacts')}}" class="link">
                    <div class="card">
                        <div class="card-body">
                            <h4>Контакти</h4>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

@endsection
