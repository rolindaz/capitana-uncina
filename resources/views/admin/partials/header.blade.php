<nav class="navbar d-flex navbar-light bg-white border-bottom px-4">
    
    <x-search-bar/>

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
</nav>
