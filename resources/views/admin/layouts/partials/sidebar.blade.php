<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-palette"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Negre WorkShop</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Gestion du Contenu
    </div>

    <!-- Nav Item - Produits -->
    <li class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.products.index') }}">
            <i class="fas fa-fw fa-box"></i>
            <span>Produits</span>
        </a>
    </li>

    <!-- Nav Item - Catégories -->
    <li class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.categories.index') }}">
            <i class="fas fa-fw fa-folder"></i>
            <span>Catégories</span>
        </a>
    </li>

    <!-- Nav Item - Commandes -->
    <li class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.orders.index') }}">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Commandes</span>
        </a>
    </li>

    <!-- Nav Item - Activités -->
    <li class="nav-item {{ request()->routeIs('admin.activities.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.activities.index') }}">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Activités</span>
        </a>
    </li>

    <!-- Nav Item - Messages -->
    <li class="nav-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.contacts.index') }}">
            <i class="fas fa-fw fa-envelope"></i>
            <span>Messages</span>
            @php
                $contactsCount = \App\Models\Contact::count();
            @endphp
            @if($contactsCount > 0)
                <span class="badge badge-danger badge-counter ml-2">{{ $contactsCount > 9 ? '9+' : $contactsCount }}</span>
            @endif
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Utilisateurs
    </div>

    <!-- Nav Item - Clients -->
    <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Utilisateurs</span>
        </a>
    </li>

    @if(auth()->user()->type === 'super_admin')
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Developer Settings
    </div>

    <!-- Nav Item - Carousel -->
    <li class="nav-item {{ request()->routeIs('admin.developer.carousel.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.developer.carousel.index') }}">
            <i class="fas fa-fw fa-images"></i>
            <span>Carrousel</span>
        </a>
    </li>

    <!-- Nav Item - Pages Contents -->
    <li class="nav-item {{ request()->routeIs('admin.developer.page-contents.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="{{ request()->routeIs('admin.developer.page-contents.*') ? 'true' : 'false' }}" aria-controls="collapsePages">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Contenus des Pages</span>
        </a>
        <div id="collapsePages" class="collapse {{ request()->routeIs('admin.developer.page-contents.*') ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Modifier les pages:</h6>
                <a class="collapse-item {{ request()->is('admin/developer/page-contents/home') ? 'active' : '' }}" href="{{ route('admin.developer.page-contents.edit', 'home') }}">Page d'Accueil</a>
                <a class="collapse-item {{ request()->is('admin/developer/page-contents/peinture') ? 'active' : '' }}" href="{{ route('admin.developer.page-contents.edit', 'peinture') }}">Page Peinture</a>
                <a class="collapse-item {{ request()->is('admin/developer/page-contents/design') ? 'active' : '' }}" href="{{ route('admin.developer.page-contents.edit', 'design') }}">Page Design</a>
                <a class="collapse-item {{ request()->is('admin/developer/page-contents/gallery') ? 'active' : '' }}" href="{{ route('admin.developer.page-contents.edit', 'gallery') }}">Page Gallery</a>
                <a class="collapse-item {{ request()->is('admin/developer/page-contents/contact') ? 'active' : '' }}" href="{{ route('admin.developer.page-contents.edit', 'contact') }}">Page Contact</a>
                <a class="collapse-item {{ request()->is('admin/developer/page-contents/marques') ? 'active' : '' }}" href="{{ route('admin.developer.page-contents.edit', 'marques') }}">Page Marques</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Composants partagés:</h6>
                <a class="collapse-item {{ request()->is('admin/developer/page-contents/modals') ? 'active' : '' }}" href="{{ route('admin.developer.page-contents.edit', 'modals') }}">Modales (Textes)</a>
            </div>
        </div>
    </li>

    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

