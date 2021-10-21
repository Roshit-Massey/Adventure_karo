<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Dashboard | Admin & Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="/js/chat-app.js" defer></script>
    <link href="/css/chat-app.css" rel="stylesheet">
    <link rel="shortcut icon" href="/secondary/assets/images/favicon.ico">
    <link href="/secondary/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
    <link href="/secondary/assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="/secondary/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
    <link href="/secondary/assets/css/custom.css" rel="stylesheet" type="text/css" />
    <link href="/secondary/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="/secondary/assets/css/new-custom-style.css" rel="stylesheet" type="text/css" />
    @yield('styles')
</head>
<body data-sidebar="dark">
    <div id="preloader"><div id="status"><div class="spinner"></div></div></div>
    <div id="layout-wrapper">
        @include('secondary.layouts.header_new')
        @include('secondary.layouts.left-navbar_new')
        @yield('container')
        @include('secondary.layouts.footer_new')
    </div> 
    <div class="rightbar-overlay"></div>
    <script src="/secondary/assets/libs/jquery/jquery.min.js"></script>
    <script src="/secondary/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/secondary/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="/secondary/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/secondary/assets/libs/node-waves/waves.min.js"></script>
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyCtSAR45TFgZjOs4nBFFZnII-6mMHLfSYI"></script>
    <script src="/secondary/assets/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js"></script>
    <script src="/secondary/assets/js/app.js"></script>
    <script src="/secondary/assets/libs/select2/js/select2.min.js"></script>
    <script src="/secondary/assets/js/pages/form-advanced.init.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/secondary/sloop.js"> </script>
    <script src="/app.js"> </script>
    @yield('scripts')
</body>
</html>