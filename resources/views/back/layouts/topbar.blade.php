<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mx-3">
        <i class="fa fa-bars"></i>
    </button>
    <div class="dropdown ms-auto">
        <button class="btn btn-sm btn-outline-light border-0 text-dark" type="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="fas fa-plus"></i> Hızlı Ekle
        </button>
        <ul class="dropdown-menu dropdown-menu-start shadow border-0 bg-light">
            <li><a class="dropdown-item" href="{{route('admin.products.create')}}">Yeni Ürün Ekle</a></li>
            <li><a class="dropdown-item" href="{{route('admin.categories')}}">Yeni Kategori Ekle</a></li>
            <li><a class="dropdown-item" href="{{route('admin.pages.create')}}">Yeni Sayfa Ekle</a></li>
            <li><a class="dropdown-item" href="{{route('admin.blog.create')}}">Yeni Blog Yazı Ekle</a></li>
        </ul>
    </div>
    <a target="_blank" href="{{ route('index') }}"
        class="btn btn-sm btn-outline-light border-0 text-dark rounded-0 ms-3">
        <i class="fa-solid fa-up-right-from-square"></i>
        Siteye Git
    </a>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ms-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle " src="{{ asset(Auth::user()->img) }}" lazy="loading">

                <span class="d-none d-lg-inline text-gray-600 small me-2 ">
                    {{ Auth::user()->name }}
                </span>
                <i class="fas fa-chevron-down"></i>

            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                    <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>
                    Profilim
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item" type="submit">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Çıkış Yap
                    </button>
                </form>

            </div>
        </li>

    </ul>

</nav>
