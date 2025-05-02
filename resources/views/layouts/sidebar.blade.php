<aside class="sidebar" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="bi bi-box-seam text-primary"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Logistik</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item mt-2 {{ Request::is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Inventory
    </div>

    <li class="nav-item {{ Request::is('barang*') && !Request::is('barang-masuk*') && !Request::is('barang-keluar*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('barang.index') }}">
            <i class="bi bi-box"></i>
            <span>Daftar Stok Barang</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('barang-masuk*') ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle" href="#" data-target="#collapseBarangMasuk">
            <i class="bi bi-box-arrow-in-down"></i>
            <span>Barang Masuk</span>
        </a>
        <div id="collapseBarangMasuk" class="sidebar-submenu {{ Request::is('barang-masuk*') ? 'show' : '' }}">
            <div class="submenu-inner">
                <a class="submenu-item {{ Request::is('barang-masuk') ? 'active' : '' }}" 
                   href="{{ route('barang-masuk.index') }}">
                    <i class="bi bi-list"></i> Daftar Barang Masuk
                </a>
                <a class="submenu-item {{ Request::is('barang-masuk/create') ? 'active' : '' }}" 
                   href="{{ route('barang-masuk.create') }}">
                    <i class="bi bi-plus-circle"></i> Pencatatan Barang Masuk
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ Request::is('barang-keluar*') ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle" href="#" data-target="#collapseBarangKeluar">
            <i class="bi bi-box-arrow-right"></i>
            <span>Barang Keluar</span>
        </a>
        <div id="collapseBarangKeluar" class="sidebar-submenu {{ Request::is('barang-keluar*') ? 'show' : '' }}">
            <div class="submenu-inner">
                <a class="submenu-item {{ Request::is('barang-keluar') ? 'active' : '' }}" 
                   href="{{ route('barang-keluar.index') }}">
                    <i class="bi bi-list"></i> Daftar Barang Keluar
                </a>
                <a class="submenu-item {{ Request::is('barang-keluar/create') ? 'active' : '' }}" 
                   href="{{ route('barang-keluar.create') }}">
                    <i class="bi bi-plus-circle"></i> Pencatatan Barang Keluar
                </a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline mt-3">
        <button class="rounded-circle border-0" id="sidebarToggle">
            <i class="bi bi-chevron-left"></i>
        </button>
    </div>
</aside>



