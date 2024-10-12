@auth()
    @if(auth()->user()->isAdmin())
        <div>
            <a href="/admin/login">Адмінка</a>
        </div>
    @endif
@endauth

