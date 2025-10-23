<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="dark" data-bs-theme="light">

    <head>


        <meta charset="utf-8" />
                <title>Login</title>
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
                <meta content="" name="author" />
                <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <!-- App favicon -->
                <link rel="shortcut icon" href="{{asset('Admin/assets/images/favicon.ico')}}">


         <!-- App css -->
         <link href="{{asset('Admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
         <link href="{{asset('Admin/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
         <link href="{{asset('Admin/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />

    </head>


    <!-- Top Bar Start -->
    <body>
    <div class="container-xxl">
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mx-auto">
                            <div class="card">
                                <div class="card-body p-0 bg-black auth-header-box rounded-top">
                                    <div class="text-center p-3">
                                        <a href="#" class="logo logo-admin">
                                            {{-- <img src="{{asset('Admin/assets/images/logo-sm.png')}}" height="50" alt="logo" class="auth-logo"> --}}
                                        </a>
                                        <h4 class="mt-3 mb-1 fw-semibold text-white fs-18">Let's Get Started Vanguard</h4>
                                        <p class="text-muted fw-medium mb-0">Sign in to continue to Vanguard.</p>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                        <form id="admin-login-form" action="{{ route('login.submit') }}" method="POST" class="my-4">
                                        @csrf
                                        <div class="form-group mb-2">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="email" class="form-control" name="email" placeholder="Enter email" value="{{ old('email') }}">
                                            <div class="invalid-feedback" id="error-email"></div>
                                        </div><!--end form-group-->

                                        <div class="form-group">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" class="form-control" name="password" placeholder="Enter password">
                                            <div class="invalid-feedback" id="error-password"></div>
                                        </div><!--end form-group-->

                                        <div class="form-group row mt-3">
                                            <div class="col-sm-6">
                                                <div class="form-check form-switch form-switch-success">
                                                    <input class="form-check-input" type="checkbox" id="customSwitchSuccess">
                                                    <label class="form-check-label" for="customSwitchSuccess">Remember me</label>
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-sm-6 text-end">
                                                <a href="#" class="text-muted font-13"><i class="dripicons-lock"></i> Forgot password?</a>
                                            </div><!--end col-->
                                        </div><!--end form-group-->

                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid mt-3">
                                                    <button class="btn btn-primary" type="submit" id="btn-login">
                                                        <span class="spinner-border spinner-border-sm d-none" id="spinner"></span>
                                                <span>Log In </span><i class="fas fa-sign-in-alt ms-1"></i></button>
                                                </div>
                                            </div><!--end col-->
                                        </div> <!--end form-group-->
                                    </form><!--end form-->
                                    <div class="text-center  mb-2">
                                        <p class="text-muted">Don't have an account ?  <a href="#" class="text-primary ms-2">Free Resister</a></p>
                                    </div>

                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end card-body-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!-- container -->
    </body>
    <!--end body-->
    <script>
document.getElementById('admin-login-form').addEventListener('submit', async (e) => {
    e.preventDefault();

    // clear old errors
    document.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });

    const form   = e.target;
    const submit = document.getElementById('btn-login');
    const spinner = document.getElementById('spinner');
    spinner.classList.remove('d-none');
    submit.disabled = true;

    const payload = new FormData(form);

    try {
        const res = await fetch("{{ route('login.submit') }}", {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },

             // marks it as AJAX
            body: payload
        });

        if (res.ok) {
            const data = await res.json();
            window.location.href = data.redirect; // success
        } else if (res.status === 422) {
    const { errors } = await res.json();

    Object.entries(errors).forEach(([field, messages]) => {
        const input = form.querySelector(`[name="${field}"]`);
        const errorElement = form.querySelector(`#error-${field}`);

        if (input) {
            input.classList.add('is-invalid');
        }

        if (errorElement) {
            errorElement.textContent = messages[0]; // make sure it's a string
        }
    });
} else {
    alert('Server error, try again later.');
}
    } catch (err) {
        console.error(err);
        alert('Network error.');
    } finally {
        spinner.classList.add('d-none');
        submit.disabled = false;
    }
});
</script>

</html>
