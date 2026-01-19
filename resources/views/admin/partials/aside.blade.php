<aside class="border-end p-3 d-flex align-items-center">

    <ul class="nav nav-pills flex-column gap-3">

        <li class="nav-item mb-3 marker-font">
            <a href="{{ route('projects.index') }}"
               class="side-nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                Progetti
            </a>
        </li>

        <li class="nav-item mb-3 marker-font">
            <a href="{{ route('yarns.index') }}"
               class="side-nav-item {{ request()->routeIs('admin.yarns.*') ? 'active' : '' }}">
                Filati
            </a>
        </li>

        <li class="nav-item mb-3 marker-font">
            <a href="{{ route('yarns.index') }}"
               class="side-nav-item {{ request()->routeIs('admin.yarns.*') ? 'active' : '' }}">
                Fibre
            </a>
        </li>

        <li class="nav-item mb-3 marker-font">
            <a href="{{ route('yarns.index') }}"
               class="side-nav-item">
                Colori
            </a>
        </li>

        <li class="nav-item mb-3 marker-font">
            <a href="{{ route('yarns.index') }}"
               class="side-nav-item">
                Categorie
            </a>
        </li>

        <li class="nav-item mb-3 marker-font">
            <a href="{{ route('yarns.index') }}"
               class="side-nav-item">
                Tecniche
            </a>
        </li>

        <li class="nav-item mb-3 marker-font">
            <a href="{{ route('yarns.index') }}"
               class="side-nav-item">
                Tag
            </a>
        </li>

        <li class="nav-item mb-3 marker-font">
            <a href="{{ route('yarns.index') }}"
               class="side-nav-item">
                Attributi
            </a>
        </li>
    </ul>
</aside>
