<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="dark" data-bs-theme="light">
<head>
    <meta charset="utf-8" />
    <title>Forgot Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{asset('Admin/assets/images/favicon.ico')}}">
    <link href="{{asset('Admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('Admin/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('Admin/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="container-xxl">
    <div class="row vh-100 d-flex justify-content-center">
        <div class="col-12 align-self-center">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 mx-auto">
                        <div class="card">

                            <!-- Header -->
                            <div class="card-body p-0 bg-black auth-header-box rounded-top">
                                <div class="text-center p-3">
                                    <h4 class="mt-3 mb-1 fw-semibold text-white fs-18">Forgot Password</h4>
                                    <p class="text-muted fw-medium mb-0">Enter your email to reset password</p>
                                </div>
                            </div>

                            <!-- Form Body -->
                            <div class="card-body pt-0">

                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <form action="{{ route('password.email') }}" method="POST" class="my-4">
                                    @csrf

                                    <div class="form-group mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Enter email" required>
                                    </div>

                                    <div class="form-group mb-2">
                                        <div class="d-grid">
                                            <button class="btn btn-primary" type="submit">
                                                <span>Send Reset Link</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <div class="text-center mb-2">
                                    <p class="text-muted">
                                        Remember your password?
                                        <a href="{{ route('login') }}" class="text-primary ms-2">Back to Login</a>
                                    </p>
                                </div>

                            </div>

                        </div><!--end card-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
