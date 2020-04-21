<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('') }}">
        <div class="sidebar-brand-icon">
            {{-- <img src="{{ asset('img/logo_bernimed.png') }}" class="img-fluid" style="min-height:50px;" alt="logo"> --}}
            <i class="fas fa-home"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    
    <li class="nav-item">
        <a class="nav-link" href="{{ url('dashboard') }} ">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    @if (auth()->user()->is_owner)
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Bengkel
    </div>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('user') }} ">
            <i class="fas fa-fw fa-home"></i>
            <span>User</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('mekanik') }} ">
            <i class="fas fa-fw fa-home"></i>
            <span>Mekanik</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('kupon') }} ">
            <i class="fas fa-fw fa-home"></i>
            <span>Kupon</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('produk') }} ">
            <i class="fas fa-fw fa-home"></i>
            <span>Produk</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('service') }} ">
            <i class="fas fa-fw fa-home"></i>
            <span>Service</span>
        </a>
    </li>
    @endif
    @if (auth()->user()->hasAnyActors(['owner', 'admin']))
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Layanan
        </div>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('service-barang/order') }} ">
                <i class="fas fa-fw fa-home"></i>
                <span>Order Service</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#penjualanProduk"
            aria-expanded="true" aria-controls="penjualanProduk">
            <i class="fas fa-fw fa-home"></i>
            <span>Penjualan Produk</span>
        </a>
        <div id="penjualanProduk" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Jenis:</h6>
                    <a class="collapse-item" href="{{ url('produk-transaksi/online') }}">Online</a>
                    <a class="collapse-item" href="{{ url('produk-transaksi/offline') }}">Offline</a>
                </div>
            </div>
        </li>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Laporan
        </div>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('service-barang') }} ">
                <i class="fas fa-fw fa-home"></i>
                <span>Service barang</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#nota"
            aria-expanded="true" aria-controls="nota">
            <i class="fas fa-fw fa-home"></i>
            <span>Nota</span>
        </a>
        <div id="nota" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Jenis:</h6>
                    <a class="collapse-item" href="{{ url('nota/service') }}">Service Barang</a>
                    <a class="collapse-item" href="{{ url('nota/produk') }}">Penjualan Produk</a>
                </div>
            </div>
        </li>
    @endif
    @if (auth()->user()->hasAnyActors(['member']))
        
    @endif
    
    {{-- <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Journal</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Custom Utilities:</h6>
                    <a class="collapse-item" href="utilities-color.html">Colors</a>
                    <a class="collapse-item" href="utilities-border.html">Borders</a>
                    <a class="collapse-item" href="utilities-animation.html">Animations</a>
                    <a class="collapse-item" href="utilities-other.html">Other</a>
                </div>
            </div>
        </li> --}}

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

</ul>
<!-- End of Sidebar -->