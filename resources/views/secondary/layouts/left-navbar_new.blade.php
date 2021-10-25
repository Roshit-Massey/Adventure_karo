    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">

<div data-simplebar class="h-100">

    <!--- Sidemenu -->
    <div id="sidebar-menu">
        <!-- Left Menu Start -->
        <ul class="metismenu list-unstyled" id="side-menu">
        @if(Session::get('role') == 'admin')
            <li>
                <a href="/v1" class="waves-effect">
                    <i class="mdi mdi-view-dashboard"></i>
                    <span> Dashboard </span>
                </a>
            </li>
            <li>
                <a href="/v1/inclusives">
                    <i class="mdi mdi-format-horizontal-align-right"></i>
                    <span>Inclusives</span>
                </a>
            </li>

            <li>
                <a href="/v1/exclusives">
                    <i class="mdi mdi-format-horizontal-align-left"></i>
                    <span>Exclusives</span>
                </a>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="mdi mdi-factory"></i>
                    <span>Activities</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="/v1/activities">All Activities</a></li>
                    <li><a href="/v1/activity/0">Add New Activity</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="mdi mdi-tooltip-text"></i>
                    <span>Experiences</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="/v1/experiences">All Experiences</a></li>
                    <li><a href="/v1/experience/0">Add New Experience</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="mdi mdi-account-multiple-outline"></i>
                    <span>Vendors</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="/v1/vendors">All Vendors</a></li>
                    <li><a href="/v1/vendor/0">Add New Vendor</a></li>
                </ul>
            </li>
            @endif
            @if(Session::get('role') == 'vendor')
            <li>
                <a href="/v2">
                    <i class="mdi mdi-view-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/v2/add-activity">
                    <i class="mdi mdi-format-horizontal-align-left"></i>
                    <span>Add Activity</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
    <!-- Sidebar -->
</div>
</div>
<!-- Left Sidebar End -->