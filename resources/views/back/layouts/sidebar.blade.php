<ul class="navbar-nav bg-dark sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a title="FilAdmin" class="sidebar-brand d-flex align-items-center justify-content-center"
        href="{{ route('admin.index') }}">
        <img width="40" loading="lazy" src="{{asset('back/logo.png')}}">
        <div class="sidebar-brand-text mx-2">FilAdmin</div>
    </a>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Başlangıç">
        <a class="nav-link" href="{{ route('admin.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
        </a>
    </li>
    <li class="nav-item">
        <a title="Siparişlerim" class="nav-link collapsed d-flex flex-column align-items-center" href="#" data-bs-toggle="collapse" data-bs-target="#orders">
            <i class="fa-solid fa-cart-shopping"></i><small>({{ $orders->count() }})</small>
        </a>
        <div id="orders" class="collapse" aria-labelledby="orders" data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('admin.orders',['order_status'=>0]) }}">Onay Bekleyenler ({{$orders->where('order_status',0)->count()}})</a>
                <a class="collapse-item" href="{{ route('admin.orders',['order_status'=>1]) }}">Stok Bekleyenler ({{$orders->where('order_status',1)->count()}})</a>
                <a class="collapse-item" href="{{ route('admin.orders',['order_status'=>2]) }}">Tamamlananlar ({{$orders->where('order_status',2)->count()}})</a>
                <a class="collapse-item" href="{{ route('admin.orders',['order_status'=>3]) }}">İptal Edilenler ({{$orders->where('order_status',3)->count()}})</a>

            </div>
        </div>
    </li>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Kategoriler">
        <a class="nav-link" href="{{ route('admin.categories') }}">
            <i class="fa-solid fa-list"></i>
        </a>
    </li>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Ürünler">
        <a class="nav-link" href="{{ route('admin.products') }}">
            <i class="fa-solid fa-box"></i>
        </a>
    </li>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Sayfalar">
        <a class="nav-link" href="{{ route('admin.pages') }}">
            <i class="fa-solid fa-file"></i>
        </a>
    </li>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Blog Yazıları">
        <a class="nav-link" href="{{ route('admin.blog') }}">
            <i class="fa-solid fa-newspaper"></i>
        </a>
    </li>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a title="Site Ayarları" class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapse1"
            aria-expanded="true" aria-controls="collapse1">
            <i class="fa-solid fa-cogs"></i>
        </a>
        <div id="collapse1" class="collapse" aria-labelledby="heading1" data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('admin.modules') }}">Modül Ayarları</a>
                <a class="collapse-item" href="{{ route('admin.site.settings') }}">Site Ayarları</a>
                <a class="collapse-item" href="{{ route('admin.site.settings.footer_links') }}">Footer Linkler</a>
                <a class="collapse-item" href="{{ route('admin.site.settings.faqs') }}">Sıkça Sorulan Sorular</a>
            </div>
        </div>
    </li>

     <!-- Nav Item - Dashboard -->
     <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Kuponlar">
        <a class="nav-link" href="{{ route('admin.coupons') }}">
            <i class="fa-solid fa-gift"></i>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="btn btn-outline-light border-0" id="sidebarToggle">
            <i class="fas fa-chevron-left"></i>
        </button>
    </div>
    <!--- @bykodhan - admin@filadmin.com -->
</ul>
