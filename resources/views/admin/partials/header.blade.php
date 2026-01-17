<nav class="header-nav navbar d-flex px-4">

    <img class="cat" src="{{ asset('storage/element1.png') }}" alt="cat">
    
    <x-search-bar/>
    
    <img class="geko" src="{{ asset('storage/element2.png') }}" alt="geko">
    

    <div class="d-flex align-items-center gap-3">
        <span class="small text-muted">
            {{ auth()->user()->name ?? 'Admin' }}
        </span>

        <img
            src="https://ui-avatars.com/api/?name=Admin"
            class="rounded-circle"
            width="32"
            height="32"
        >
    </div>

    <img class="chameleon" src="{{ asset('storage/element3.png') }}" alt="chameleon">
</nav>
