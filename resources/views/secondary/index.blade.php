<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Login | Adventure Karo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
        <meta content="Themesbrand" name="author">
        <link rel="shortcut icon" href="/secondary/assets/images/favicon.ico">
        <link href="/secondary/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
        <link href="/secondary/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
    </head>
    <body>

        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>
        <div class="accountbg" style="background: url('/secondary/assets/images/bg.jpg');background-size: cover;background-position: center;"></div>
        <div class="account-pages mt-5 pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-5 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center mt-4">
                                    <div class="mb-3">
                                        <a href="/"><img src="/secondary/assets/images/cartzon-logo.png" height="60" alt="logo"></a>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <h4 class="font-size-18 mt-2 text-center">Welcome Back !</h4>
                                    <p class="text-muted text-center mb-4">Sign in to continue to Adventure Karo.</p>
                                    <center><span class="login-box-msg" style="color:red;" id="error-login"></span></center>
    
                                    <!-- <form class="form-horizontal" action="index.html"> -->
    
                                        <div class="mb-3">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="text" class="form-control" id="email" placeholder="Enter email">
                                            <span style="color:red;" id="error-email"></span> 
                                        </div>
    
                                        <div class="mb-3">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" class="form-control" id="password" placeholder="Enter password">
                                            <span style="color:red;" id="error-password"></span> 
                                        </div>
    
                                        <div class="row mt-4">
                                            <div class="col-sm-6">
                                                <div class="form-check">
                                                    <!-- <input class="form-check-input" type="checkbox" value="" id="customControlInline"> -->
                                                    <!-- <label class="form-check-label" for="customControlInline">
                                                        Remember me
                                                    </label> -->
                                                </div>
                                            </div>
                                            <div class="col-sm-6 text-end">
                                                <button class="btn btn-primary w-md waves-effect waves-light" onclick="signIn()">Log In</button>
                                            </div>
                                        </div>
    
                                        <!-- <div class="mb-0 row">
                                            <div class="col-12 mt-4">
                                                <a href="pages-recoverpw.html" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                                            </div>
                                        </div> -->
                                    <!-- </form> -->
    
                                </div>
    
                            </div>
                        </div>
                        <div class="mt-5 text-center position-relative">
                            <!-- <p class="text-white">Don't have an account ? <a href="pages-register.html" class="fw-bold text-primary"> Signup Now </a> </p> -->
                            <!-- <p class="text-white"><script>document.write(new Date().getFullYear())</script> © Adventure Karo. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>         
        <!-- JAVASCRIPT -->
        <script src="/secondary/assets/libs/jquery/jquery.min.js"></script>
        <script src="/secondary/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/secondary/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="/secondary/assets/libs/node-waves/waves.min.js"></script>
        <script src="/secondary/assets/js/app.js"></script>
        <script src="/app.js"></script>
        <script src="/secondary/js/app/login.js"></script>
    </body>
</html>
