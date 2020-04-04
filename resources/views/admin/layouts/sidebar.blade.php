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

    @if (auth()->user()->isAdmin())
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
        
    <div class="sidebar-heading">
        Utama
    </div>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/dashboard') }} ">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/user/index') }} ">
            <i class="fas fa-fw fa-user"></i>
            <span>User</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/gelombang/index') }} ">
            <i class="fas fa-fw fa-user"></i>
            <span>Gelombang Pendaftaran</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/kategori-jurusan/index') }} ">
            <i class="fas fa-fw fa-user"></i>
            <span>Kategori Jurusan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/jurusan/index') }} ">
            <i class="fas fa-fw fa-user"></i>
            <span>Jurusan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/peminat/index') }} ">
            <i class="fas fa-fw fa-user"></i>
            <span>Peminat</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/tagihan/index') }} ">
            <i class="fas fa-fw fa-user"></i>
            <span>Tagihan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/calon-mahasiswa/index') }} ">
            <i class="fas fa-fw fa-user"></i>
            <span>Calon Mahasiswa</span>
        </a>
    </li>
    
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
    @endif

</ul>
<!-- End of Sidebar -->