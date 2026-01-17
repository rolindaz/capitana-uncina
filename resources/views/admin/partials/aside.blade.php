<aside class="border-end p-3 d-flex align-items-center">

    <ul class="nav nav-pills flex-column gap-3">

        <li class="nav-item mb-3 marker-font">
            <a href="{{ route('projects.index') }}"
               class="side-nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                Projects
            </a>
        </li>

        <li class="nav-item mb-3 marker-font">
            <a href="{{ route('yarns.index') }}"
               class="side-nav-item {{ request()->routeIs('admin.yarns.*') ? 'active' : '' }}">
                Yarns
            </a>
        </li>

        <li class="nav-item mb-3 marker-font">
            <a href="{{ route('yarns.index') }}"
               class="side-nav-item {{ request()->routeIs('admin.yarns.*') ? 'active' : '' }}">
                Categories
            </a>
        </li>

        <li class="nav-item mb-3 marker-font">
            <a href="{{ route('yarns.index') }}"
               class="side-nav-item">
                Fibers
            </a>
        </li>

        <li class="nav-item mb-3 marker-font">
            <a href="{{ route('yarns.index') }}"
               class="side-nav-item">
                Crafts
            </a>
        </li>

        <li class="nav-item mb-3 marker-font">
            <a href="{{ route('yarns.index') }}"
               class="side-nav-item">
                Tags
            </a>
        </li>

        <li class="nav-item mb-3 marker-font">
            <a href="{{ route('yarns.index') }}"
               class="side-nav-item">
                Attributes
            </a>
        </li>
    </ul>
</aside>
