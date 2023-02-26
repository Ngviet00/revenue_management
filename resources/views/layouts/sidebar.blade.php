<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
            Revenue Management
        </div>
    </a>

    <li class="nav-item {{ Route::is('admin.home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.home') }}">
            <i class="fa-solid fa-house"></i>
            <span>Trang chủ</span></a>
    </li>

    <li class="nav-item {{ Route::is('admin.role.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.role.index') }}">
            <i class="fa-solid fa-flag fa-fw"></i>
            <span>Role</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fa-solid fa-building fa-fw"></i>
            <span>Quản lý HKD - Công ty</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fa-brands fa-buysellads fa-fw"></i>
            <span>Nhập - Xuất hàng</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fa-solid fa-landmark fa-fw"></i>
            <span>Vay - nợ</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa-solid fa-user fa-fw"></i>
            <span>Quản lý Thành viên</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="buttons.html">Danh sách</a>
                <a class="collapse-item" href="cards.html">Thêm mới</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
           aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Quản lý Khách hàng</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="#">Danh sách</a>
                <a class="collapse-item" href="#">Thêm mới</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

