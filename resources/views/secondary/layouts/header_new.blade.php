<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ url('/dashboard?status=0') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{asset('/secondary/assets/images/logo.png')}}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('/secondary/assets/images/logo-dark.png')}}" alt="" height="17">
                    </span>
                </a>

                <a href="{{ url('/dashboard?status=0') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{asset('/secondary/assets/images/short-logo.png')}}" alt="" height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('/secondary/assets/images/cartzon-logo.png')}}" alt="" height="50">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                id="vertical-menu-btn">
                <i class="mdi mdi-menu"></i>
            </button>

            <div class="d-none d-sm-block ms-2">
                <h4 class="page-title cartzon-page-title">Adventure Karo</h4>
            </div>
        </div>

        <!-- Search input -->
        <div class="search-wrap" id="search-wrap">
            <div class="search-bar">
                <input class="search-input form-control" placeholder="Search">
                <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                    <i class="mdi mdi-close-circle"></i>
                </a>
            </div>
        </div>

        

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{asset('/secondary/assets/images/short-logo.png')}}"
                        alt="Header Avatar">
                </button> 
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                   <a class="dropdown-item" href="#">Profile</a>
                    <a class="dropdown-item" href="#">My Wallet</a>
                    <a class="dropdown-item d-block" href="#"><span
                            class="badge bg-success float-end">11</span>Settings</a>
                    <a class="dropdown-item" href="#">Lock screen</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Reset Password </a>
                    <a class="dropdown-item text-danger" href="#">Logout</a>
                </div>
            </div>

           

        </div>
    </div>
</header>