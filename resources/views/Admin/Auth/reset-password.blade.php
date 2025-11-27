<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="dark" data-bs-theme="light">
<head>
    <meta charset="utf-8" />
    <title>Reset Password</title>
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
                                    <h4 class="mt-3 mb-1 fw-semibold text-white fs-18">Reset Password</h4>
                                    <p class="text-muted fw-medium mb-0">Create a new password</p>
                                </div>
                            </div>

                            <!-- Form Body -->
                            <div class="card-body pt-0">

                                @if(session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                               <form action="{{ route('password.update') }}" method="POST" class="my-4">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group mb-3">
        <label class="form-label">Email</label>
        <input type="email"
               class="form-control @error('email') is-invalid @enderror"
               name="email"
               value="{{ $email }}"
               readonly>
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3 position-relative">
        <label class="form-label">New Password</label>
        <input type="password"
               class="form-control @error('password') is-invalid @enderror"
               name="password"
               placeholder="Enter new password"
               id="password"
               required>
        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password" style="position:absolute; top:38px; right:10px; cursor:pointer;"></span>
        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3 position-relative">
        <label class="form-label">Confirm Password</label>
        <input type="password"
               class="form-control @error('password_confirmation') is-invalid @enderror"
               name="password_confirmation"
               placeholder="Confirm new password"
               id="password_confirmation"
               required>
        <span toggle="#password_confirmation" class="fa fa-fw fa-eye field-icon toggle-password" style="position:absolute; top:38px; right:10px; cursor:pointer;"></span>
        @error('password_confirmation')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-grid">
        <button class="btn btn-primary" type="submit">
            <span>Reset Password</span>
        </button>
    </div>
</form>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
document.querySelectorAll('.toggle-password').forEach(function(element) {
    element.addEventListener('click', function() {
        const input = document.querySelector(this.getAttribute('toggle'));
        if (input.type === "password") {
            input.type = "text";
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
        }
    });
});
</script>


                                <div class="text-center mb-2">
                                    <p class="text-muted">
                                        Back to login?
                                        <a href="{{ route('login') }}" class="text-primary ms-2">Login</a>
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
