    <!-- Smile, breathe, and go slowly. - Thich Nhat Hanh -->
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Manager
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.sellermanager') }}">
            {{-- <a class="nav-link" href="/admin/sellermanager"> --}}
                <i class="fas fa-fw fa-cog"></i>
                <span>Sellers</span>
            </a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.productmanager') }}">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Products</span>
        </a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.transactionmanager') }}">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Trasaction</span>
        </a>
    </li>
