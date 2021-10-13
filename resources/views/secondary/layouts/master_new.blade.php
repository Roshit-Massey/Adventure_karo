<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | Admin & Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- for chat support -->
    <script src="{{ asset('/js/chat-app.js') }}" defer></script>
    <!-- for chat support -->
    <!-- Styles -->
    <link href="{{ asset('/css/chat-app.css') }}" rel="stylesheet">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('/secondary/assets/images/favicon.ico')}}">


    <!-- Bootstrap Css -->
    <link href="{{asset('/secondary/assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{asset('/secondary/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{asset('/secondary/assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css">
    <!-- Custom Css-->
    <link href="{{asset('/secondary/assets/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/secondary/assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css">
    <!--New Custom Css-->
    <link href="{{asset('/secondary/assets/css/new-custom-style.css')}}" rel="stylesheet" type="text/css" />
   
    

      <style type="text/css">
        .order-det {
          color: #2ca6b1;
          border: 1px solid #2ca6b1 !important;
          border-radius: 4px;
          padding: 2px 8px;
          margin-left: 10px;
          cursor: pointer;
          font-size: 14px;
        }

         .order-placed-on{
          text-align: right;
        }
        .bold {
            font-weight: 600;
        }
        .payment-statement{
            display: flex;
            flex-direction: column;
        }

        .payment-wallet{
          text-align: right;
          margin-top: -50px;
        }
        .solid-line{
          border-bottom: 1px solid #ccc;
        }
        .user-order-details{
          margin-top: 20px;
          font-size: 13px;
        }
        .order-del-text{
          margin: 5px !important;
        }
        .order-btn{
          margin-top: 20px;
          display: flex;
            justify-content: flex-end;
        }
        .bg-secondary-btn{
          background-color: #a8a8a8 !important;
          color: #ffffff;
          font-size: 14px;
          border-radius: 4px;
          border: none;
          height: 28px;
          padding: 0px 10px;
          margin-right: 5px;
        }
         .bg-success-btn{
          background-color: #2ca6b1 !important;
          color: #ffffff;
          font-size: 14px;
          border-radius: 4px;
          border: none;
          height: 28px;
          padding: 0px 10px;
        }
    </style>
    
    @yield('styles')
</head>

<body data-sidebar="dark">

    <!-- Loader -->
    <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('secondary.layouts.header_new')
        @include('secondary.layouts.left-navbar_new')

        @yield('container')


        @include('secondary.layouts.footer_new')

    </div> 
    <!-- END layout-wrapper --> 
 


    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <script src="{{asset('/secondary/assets/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('/secondary/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('/secondary/assets/libs/metismenu/metisMenu.min.js')}}"></script>
    <script src="{{asset('/secondary/assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('/secondary/assets/libs/node-waves/waves.min.js')}}"></script>
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyCtSAR45TFgZjOs4nBFFZnII-6mMHLfSYI"></script>
     <script src="{{asset('/secondary/assets/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js')}}"></script>
    <script src="{{asset('/secondary/assets/js/app.js')}}"></script>
    <script src="{{asset('/secondary/assets/libs/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('/secondary/assets/js/pages/form-advanced.init.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    @yield('scripts')
</body>

</html>