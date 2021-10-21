<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Adventure Karo  | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  {!! Html::style('public/css/all.min.css') !!}
  <!-- Ionicons -->
  {!! Html::style('public/css/ionicons.min.css') !!}
  <!-- icheck bootstrap -->
  {!! Html::style('public/css/icheck-bootstrap.min.css') !!}
  <!-- Font style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Theme style -->
  {!! Html::style('public/css/adminlte.min.css') !!}
  <!-- Google Font: Source Sans Pro -->
  {!! Html::style('public/css/css.css') !!}
  {!! Html::style('public/assets/css/style.css') !!}
  <!-- Toastr style -->
  {!! Html::style('public/css/toastr.min.css') !!} 

</head>
<body class="hold-transition login-page" style="background: #f3f3f3 !important;"> 

          @yield('content')
            
 {!! Html::script('public/js/jquery.min.js') !!}
 {!! Html::script('public/js/bootstrap.bundle.min.js') !!}
 {!! Html::script('public/js/adminlte.min.js') !!}
 {!! Html::script('public/js/toastr.min.js') !!}
 {!! Toastr::message() !!}

@yield('script')    
</body>
</html>    
  
