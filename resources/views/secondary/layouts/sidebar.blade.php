   <!-- main menu-->
   <div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow sidebar-scroll">
      <!-- main menu header-->
      <div class="main-menu-header">
        <input type="hidden" placeholder="Search" class="menu-search form-control round"/>
      </div>
      <!--  main menu header-->
      <!-- main menu content-->
      <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
          <li class="nav-item active"><a href="{{ route('dashboard') }}"><i class="icon-home3"></i><span data-i18n="nav.dash.main" class="menu-title" id="font-id">Dashboard</span></a>
          </li>
          @if(Auth::user()->role_id==1)
          <li class="nav-item"><a href="#"><i class="fa fa-users"></i><span data-i18n="nav.page_layouts.main" class="menu-title" id="font-id">Vendor</span></a>
            <ul class="menu-content">
              <li><a href="{{ route('vendor.add_form') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Add Vendor</a>
              </li>
              <li><a href="{{ route('vendor.list') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Vendor List</a>
              </li>
            </ul>
          </li>

          <li class="nav-item"><a href="#"><i class="fa fa-users"></i><span data-i18n="nav.page_layouts.main" class="menu-title" id="font-id">Role</span></a>
            <ul class="menu-content">
              <li><a href="{{ route('role.create') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Add Role</a>
              </li>
              <li><a href="{{ route('role.index') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Role List</a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item"><a href="#"><i class="fa fa-users"></i><span data-i18n="nav.page_layouts.main" class="menu-title" id="font-id">Master Category</span></a>
            <ul class="menu-content">
              <li><a href="{{ route('master_category.create') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Add Category</a>
              </li>
              <li><a href="{{ route('master_category.index') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Category List</a>
              </li>
            </ul>
          </li>

          <li class="nav-item"><a href="#"><i class="fa fa-users"></i><span data-i18n="nav.page_layouts.main" class="menu-title" id="font-id">Variants</span></a>
            <ul class="menu-content">
              <li><a href="{{ route('variant.create') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Add Variant</a>
              </li>
              <li><a href="{{ route('variant.index') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Variant List</a>
              </li>
            </ul>
          </li>
          @endif

          <li class="nav-item"><a href="#"><i class="fa fa-users"></i><span data-i18n="nav.page_layouts.main" class="menu-title" id="font-id">Category</span></a>
            <ul class="menu-content">
              <li><a href="{{ route('category.create') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Add Category</a>
              </li>
              <li><a href="{{ route('category.index') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Category List</a>
              </li>
            </ul>
          </li>

          <li class="nav-item"><a href="#"><i class="fa fa-users"></i><span data-i18n="nav.page_layouts.main" class="menu-title" id="font-id">Sub Category</span></a>
            <ul class="menu-content">
              <li><a href="{{ route('subcategory.create') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Add Sub Category</a>
              </li>
              <li><a href="{{ route('subcategory.index') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Sub Category List</a>
              </li>
            </ul>
          </li>
          <li class="nav-item"><a href="#"><i class="fa fa-users"></i><span data-i18n="nav.page_layouts.main" class="menu-title" id="font-id">Banners</span></a>
            <ul class="menu-content">
              <li><a href="{{ route('vendorbanner.add_form') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Add Banners</a>
              </li>
              <li><a href="{{ route('vendorbanner.list') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Banners List</a>
              </li>
            </ul>
          </li>

          @if(Auth::user()->role_id==1)
          <li class="nav-item"><a href="#"><i class="fa fa-users"></i><span data-i18n="nav.page_layouts.main" class="menu-title" id="font-id">Welcome Screen</span></a>
            <ul class="menu-content">
              <li><a href="{{ route('banner.add_form') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Add Welcome Screen</a>
              </li>
              <li><a href="{{ route('banner.list') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Welcome Screen List</a>
              </li>
            </ul>
          </li>
          @endif
          
          <li class="nav-item"><a href="#"><i class="fa fa-users"></i><span data-i18n="nav.page_layouts.main" class="menu-title" id="font-id">Products</span></a>
            <ul class="menu-content">
              <li><a href="{{ route('product.create') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Add Product</a>
              </li>
              <li><a href="{{ route('product.index') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Product List</a>
              </li>
            </ul>
          </li>

          <li class="nav-item"><a href="#"><i class="fa fa-users"></i><span data-i18n="nav.page_layouts.main" class="menu-title" id="font-id">Orders</span></a>
            <ul class="menu-content">
              <li><a href="{{ route('order.index') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Order List</a>
              </li>
            </ul>
          </li>

          <li class="nav-item"><a href="#"><i class="fa fa-users"></i><span data-i18n="nav.page_layouts.main" class="menu-title" id="font-id">Offer</span></a>
            <ul class="menu-content">
              <li><a href="{{ route('offer.create') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Add Offer</a>
              </li>
              <li><a href="{{ route('offer.index') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Offer List</a>
              </li>
            </ul>
          </li>

          <li class="nav-item"><a href="#"><i class="fa fa-users"></i><span data-i18n="nav.page_layouts.main" class="menu-title" id="font-id">Offer Management</span></a>
            <ul class="menu-content">
              <li><a href="{{ route('offer-management.create') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Add Offer Management</a>
              </li>
              <li><a href="{{ route('offer-management.index') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Offer Management List</a>
              </li>
            </ul>
          </li>

          <li class="nav-item"><a href="#"><i class="fa fa-users"></i><span data-i18n="nav.page_layouts.main" class="menu-title" id="font-id">Delivery Slot</span></a>
            <ul class="menu-content">
              <li><a href="{{ route('delivery-slot.create') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Add Delivery Slot</a>
              </li>
              <li><a href="{{ route('delivery-slot.index') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Delivery Slot List</a>
              </li>
            </ul>
          </li>

          <li class="nav-item"><a href="#"><i class="fa fa-users"></i><span data-i18n="nav.page_layouts.main" class="menu-title" id="font-id">Delivery Charge</span></a>
            <ul class="menu-content">
              <li><a href="{{ route('delivery-charge.create') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Add Delivery Charge</a>
              </li>
              <li><a href="{{ route('delivery-charge.index') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Delivery Charge List</a>
              </li>
            </ul>
          </li>
          
          <!-- <li class=" nav-item"><a href="#"><i class="icon-newspaper-o"></i><span data-i18n="nav.page_layouts.main" class="menu-title" id="font-id">News</span></a>
            <ul class="menu-content">
              <li><a href="{{ route('news.add_form') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Add</a>
              </li>
              <li><a href="{{ route('news.list') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">List</a>
              </li>
            </ul>
          </li>
          <li class=" nav-item"><a href="#"><i class="icon-stack-2"></i><span data-i18n="nav.page_layouts.main" class="menu-title" id="font-id">Events</span></a>
            <ul class="menu-content">
              <li><a href="{{ route('events.add_form') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Add</a>
              </li>
              <li><a href="{{ route('events.list') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">List</a>
              </li>
            </ul>
          </li>
          <li class=" nav-item"><a href="#"><i class="icon-file-photo-o"></i><span data-i18n="nav.page_layouts.main" class="menu-title" id="font-id">Gallery</span></a>
            <ul class="menu-content">
              <li><a href="{{ route('photos.add_form') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Add</a>
              </li>
              <li><a href="{{ route('photos.list') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">List</a>
              </li>
            </ul>
          </li>
          <li class=" nav-item"><a href="#"><i class="icon-file-video-o"></i><span data-i18n="nav.page_layouts.main" class="menu-title" id="font-id">Videos</span></a>
            <ul class="menu-content">
              <li><a href="{{ route('videos.add_form') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">Add</a>
              </li>
              <li><a href="{{ route('videos.list') }}" data-i18n="nav.page_layouts.1_column" class="menu-item" id="dropdown-id">List</a>
              </li>
            </ul>
          </li> -->
        </ul>
      </div>
      <!-- /main menu content-->
      <!-- main menu footer-->
      <!-- include includes/menu-footer-->
      <!-- main menu footer-->
    </div>
    <!-- / main menu-->
