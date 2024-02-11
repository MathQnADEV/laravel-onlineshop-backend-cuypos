<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}"><i class="fas fa-cash-register"></i> Cuy Pos</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home') }}"><i class="fas fa-cash-register"></i> CP</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="">
                <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-pencil-ruler">
                    </i> <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-header">Features</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-database"></i>
                    <span>your datas</span></a>
                <ul class="dropdown-menu">
                    <li class=''>
                        <a class="nav-link" href="{{ route('users.index') }}"><i class="fas fa-users"></i>Users</a>
                    </li>
                    <li class=''>
                        <a class="nav-link" href="{{ route('categories.index') }}"><i
                                class="fas fa-list"></i>Categories</a>
                    </li>
                    <li class=''>
                        <a class="nav-link" href="{{ route('products.index') }}"><i
                                class="fas fa-cart-shopping"></i>Products</a>
                    </li>

                </ul>
            </li>
        </ul>
    </aside>
</div>
