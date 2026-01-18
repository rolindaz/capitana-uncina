<nav class="header-nav navbar d-flex px-4">

    <img class="cat" src="{{ asset('storage/element1.png') }}" alt="cat">
    
    <x-search-bar/>
    
    <img class="geko" src="{{ asset('storage/element2.png') }}" alt="geko">

    <div class="d-flex align-items-center gap-3">
        <span class="small" style="font-family: 'Walter Turncoat'; font-weight: 600;">
            {{ auth()->user()->name ?? 'Admin' }}
        </span>
        -
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm" style="font-family: 'Walter Turncoat'; font-weight: 600;">Logout</button>
        </form>
    </div>

    <img class="chameleon" src="{{ asset('storage/element3.png') }}" alt="chameleon">
</nav>
