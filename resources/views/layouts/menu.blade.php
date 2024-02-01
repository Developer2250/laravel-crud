<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('categories') }}" class="nav-link {{ Request::is('categories') ? 'active' : '' }}">
        <i class="nav-icon fa fa-certificate" aria-hidden="true"></i>
        <p>Category</p>
        <span class="badge badge-info right">{{ $totalCategoryCount }}</span>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('product') }}" class="nav-link {{ Request::is('product') ? 'active' : '' }}">
        <i class="nav-icon fas fa-barcode"></i>
        <p>Product</p>
        <span class="badge badge-info right">{{ $totalProductsCount }}</span>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('users') }}" class="nav-link {{ Request::is('users') ? 'active' : '' }}">
        <i class="nav-icon fa fa-users" aria-hidden="true"></i>
        <p>User</p>
        <span class="badge badge-info right">{{ $totalUserCount }}</span>
    </a>
</li>

{{-- <li class="nav-item">
    <a href="{{ route('history') }}" class="nav-link {{ Request::is('history') ? 'active' : '' }}">
        <i class="nav-icon fa fa-history" aria-hidden="true"></i>
        <p>History</p>
    </a>
</li> --}}
