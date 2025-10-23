<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">

<head>


    <meta charset="utf-8" />
            <title>Dashboard | Vanguard</title>
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
            <meta content="" name="author" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <meta name="csrf-token" content="{{ csrf_token() }}">


            <!-- App favicon -->
            <link rel="shortcut icon" href="{{asset('Admin/assets/images/favicon.ico')}}">



     <!-- App css -->
     <link href="{{asset('Admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
     <link href="{{asset('Admin/assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
     <link href="{{asset('Admin/assets/libs/animate.css/animate.min.css')}}" rel="stylesheet" type="text/css">
     <link href="{{asset('Admin/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
     <link href="{{asset('Admin/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css" />
     <link href="https://cdn.jsdelivr.net/npm/icofont@1.0.0/dist/icofont.min.css" rel="stylesheet">

</head>
@include('Admin.Layouts.partials.sidebar')
@include('Admin.Layouts.partials.header')
 <div class="page-wrapper">
        <div class="page-content">
            @yield('content')
            <footer class="footer text-center text-sm-start d-print-none">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-0 rounded-bottom-0">
                                <div class="card-body">
                                    <p class="text-muted mb-0">
                                        ©
                                        <script> document.write(new Date().getFullYear()) </script>
                                        Vanguard
                                        <span
                                            class="text-muted d-none d-sm-inline-block float-end">
                                            Design with
                                            <i class="iconoir-heart-solid text-danger align-middle"></i>
                                        by Smartenough solutions</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
<div id="spinner-overlay" style="display: none; position: fixed; z-index: 99999; background: rgba(255, 255, 255, 0.8); top: 0; left: 0; height: 100%; width: 100%; justify-content: center; align-items: center;">
    <div class="spinner-border text-warning" role="status" style="width: 4rem; height: 4rem;">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<script>
    function showSpinner() {
        document.getElementById('spinner-overlay').style.display = 'flex';
    }

    function hideSpinner() {
        document.getElementById('spinner-overlay').style.display = 'none';
    }
</script>

    <script src="{{asset('Admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('Admin/assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('Admin/assets/libs/simplebar/simplebar.min.js')}}"></script>
        <!-- Sweet-Alert  -->
    <script src="{{asset('Admin/assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{asset('Admin/assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="https://apexcharts.com/samples/assets/stock-prices.js'"></script>
    <script src="{{asset('Admin/assets/js/pages/index.init.js')}}"></script>
    <script src="{{asset('Admin/assets/js/DynamicSelect.js')}}"></script>
    <script src="{{asset('Admin/assets/js/app.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>
<!--end body-->

</html>
