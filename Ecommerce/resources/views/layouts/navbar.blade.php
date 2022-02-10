
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('home')}}" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

         <!-- Extend Screen -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="javascript:void(0)" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      @guest
          @if (Route::has('login'))
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
              </li>
          @endif

      @else
        <li class="navbar-nav ml-auto">
            <div class="nav-item" >
                <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
      @endguest
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
      <img src="{{asset('dist/img/shopinglogo.jpg')}}" alt="ShopingKart Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">ShopingKart</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/user8-128x128.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="javascript:void(0)" class="d-block">{{ Auth::user()->firstname}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <!-- User Management -->
          <li class="nav-item {{ request()->is('adduser') || request()->is('showuser') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('adduser') || request()->is('showuser') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p class="{{ request()->is('adduser') || request()->is('showuser') ? 'text-white' : '' }}">
                User Management
                <i class="fas fa-angle-left right "></i>
                <span class="badge badge-info right"></span>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('AddUser')}}" class="nav-link {{ request()->is('adduser') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p class=" {{ request()->is('adduser') ? 'text-dark' : '' }}">Add User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('ShowUser')}}" class="nav-link {{ request()->is('showuser') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="{{ request()->is('showuser') ? 'text-dark' : '' }}">Modify User</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Banner Management -->

          <li class="nav-item {{ request()->is('addbanner') || request()->is('showbanner') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('addbanner') || request()->is('showbanner') ? 'active' : '' }}">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p class="{{ request()->is('addbanner') || request()->is('showbanner') ? 'text-white' : '' }}">
              Banner Management
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('AddBanner')}}" class="nav-link {{ request()->is('addbanner') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="{{ request()->is('addbanner') ? 'text-dark' : '' }}">Add Banner</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('ShowBanner')}}" class="nav-link {{ request()->is('showbanner') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="{{ request()->is('showbanner') ? 'text-dark' : '' }}">Modify Banner</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Category Management -->

          <li class="nav-item {{ request()->is('addcategory') || request()->is('showcategory') || request()->is('addsubcategory') || request()->is('showsubcategory') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('addcategory') || request()->is('showcategory') || request()->is('addsubcategory') || request()->is('showsubcategory') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tree"></i>
              <p class="{{ request()->is('addcategory') || request()->is('showcategory') || request()->is('addsubcategory') || request()->is('showsubcategory') ? 'text-white' : '' }}">
                Category Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('AddCategory')}}" class="nav-link {{ request()->is('addcategory') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="{{ request()->is('addcategory') ? 'text-dark' : '' }}">Add Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('ShowCategory')}}" class="nav-link {{ request()->is('showcategory') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="{{ request()->is('showcategory') ? 'text-dark' : '' }}">Modify Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('AddSubCategory')}}" class="nav-link {{ request()->is('addsubcategory') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="{{ request()->is('addsubcategory') ? 'text-dark' : '' }}">Add Sub-Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('ShowSubCategory')}}" class="nav-link {{ request()->is('showsubcategory') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="{{ request()->is('showsubcategory') ? 'text-dark' : '' }}">Modify Sub-Category</p>
                </a>
              </li>
              
            </ul>
          </li>

          <!-- Product Management -->

          <li class="nav-item {{ request()->is('addproduct') || request()->is('showproduct') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('addproduct') || request()->is('showproduct') ? 'active' : '' }}">
              <i class="nav-icon fas fa-edit"></i>
              <p class="{{ request()->is('addproduct') || request()->is('showproduct') ? 'text-white' : '' }}">
                Product Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('AddProduct')}}" class="nav-link {{ request()->is('addproduct') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="{{ request()->is('addproduct') ? 'text-dark' : '' }}">Add Product</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('ShowProduct')}}" class="nav-link {{ request()->is('showproduct') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="{{ request()->is('showproduct') ? 'text-dark' : '' }}">Modify Product</p>
                </a>
              </li>
            </ul>

          </li>

          <!-- Coupon Management -->
          <li class="nav-item {{ request()->is('addcoupon') || request()->is('showcoupons')  ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('addcoupon') || request()->is('showcoupons')  ? 'active' : '' }}">
              <i class="nav-icon fas fa-table"></i>
              <p class="{{ request()->is('addcoupon') || request()->is('showcoupons')  ? 'text-white' : '' }}">
                Coupon Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('AddCoupon')}}" class="nav-link {{ request()->is('addcoupon') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="{{ request()->is('addcoupon') ? 'text-dark' : '' }}">Add Coupon</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('ShowCoupons')}}" class="nav-link {{ request()->is('showcoupons') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="{{ request()->is('showcoupons') ? 'text-dark' : '' }}">Modify Coupon</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-header">Process Managements</li>

          <!-- contact Notification -->
          <li class="nav-item">
            <a href="{{route('ContactUs')}}" class="nav-link {{ request()->is('contactus') ? 'active' : '' }}">
              <i class="nav-icon far fa-image"></i>
              <p class="{{ request()->is('contactus') ? 'text-white' : '' }}">
                Contact Notifications
              </p>
            </a>
          </li>
          
          <!-- CMS -->
          <li class="nav-item">
            <a href="{{route('AddCMS')}}" class="nav-link {{ request()->is('cms') || request()->is('displaycms')  ? 'active' : '' }}">
              <i class="nav-icon fas fa-columns"></i>
              <p class="{{ request()->is('cms') || request()->is('displaycms')  ? 'text-white' : '' }}">
                CMS
              </p>
            </a>
          </li>
          
          <!-- Order Management -->
          <li class="nav-item {{ request()->is('order') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('order') ? 'active' : '' }}">
              <i class="nav-icon fas fa-book"></i>
              <p class="{{ request()->is('order') ? 'text-white' : '' }}">
                Order Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('Orders')}}" class="nav-link {{ request()->is('order') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="{{ request()->is('order') ? 'text-dark' : '' }}">Order Details</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-plus-square"></i>
              <p>
                Reports
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Sales
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Login v1</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Register v1</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Forgot Password v1</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Recover Password v1</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Customer Registered
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Login v2</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Register v2</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Forgot Password v2</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Recover Password v2</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Coupon Used</p>
                </a>
              </li>
            </ul>
          </li> -->

          <!-- Settings -->
          <li class="nav-item">
            <a href="{{route('userSettings')}}" class="nav-link {{ request()->is('usersettings') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-cog"></i>
              <p class="{{ request()->is('usersettings') ? 'text-white' : '' }}">
                Settings
              </p>
            </a>
          </li>
          <hr>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>