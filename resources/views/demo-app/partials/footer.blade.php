<nav class="navbar row row-cols-4">
    <div class="col d-flex align-items-center px-0">
        <form id="logout-form" action="{{ route('logout') }}" method="GET">
            @csrf
            <button type="submit">
                <img src="{{ asset('storage/beanie.png') }}" alt="projects">
            </button>
        </form>
    </div>
    <div class="col d-flex align-items-center px-0">
        <form id="logout-form" action="{{ route('logout') }}" method="GET">
            @csrf
            <button type="submit">
                <img src="{{ asset('storage/stitching.png') }}" alt="stash">
            </button>
        </form>
    </div>
    <div class="d-flex align-items-center px-0">
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">
                <img src="{{ asset('storage/beanie.png') }}" alt="projects">
            </button>
        </form>
    </div>
    <div class="d-flex align-items-center px-0">
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">
                <img src="{{ asset('storage/beanie.png') }}" alt="projects">
            </button>
        </form>
    </div>
</nav>