 <div class="topbar d-print-none">
        <div class="container-fluid">
            <nav class="topbar-custom d-flex justify-content-between" id="topbar-custom">


                <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                    <li>
                        <button class="nav-link mobile-menu-btn nav-icon" id="togglemenu">
                            <i class="iconoir-menu"></i>
                        </button>
                    </li>

                </ul>
                <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">



                    <li class="topbar-item">
                        <a class="nav-link nav-icon" href="javascript:void(0);" id="light-dark-mode">
                            <i class="iconoir-half-moon dark-mode"></i>
                            <i class="iconoir-sun-light light-mode"></i>
                        </a>
                    </li>



                    <li class="dropdown topbar-item">
                        <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#" role="button"
                            aria-haspopup="false" aria-expanded="false" data-bs-offset="0,19">
                            <img src="{{asset('Admin/assets/images/smartenough_logo.png')}}" alt="" class="thumb-md rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end py-0">
                            <div class="d-flex align-items-center dropdown-item py-2 bg-secondary-subtle">
                                <div class="flex-shrink-0">
                                    <img src="{{asset('Admin/assets/images/smartenough_logo.png')}}" alt="" class="thumb-md rounded-circle">
                                </div>
                                <div class="flex-grow-1 ms-2 text-truncate align-self-center">
                                    <h6 class="my-0 fw-medium text-dark fs-13">{{ Auth::user()->name }}</h6>
                                    <small class="text-muted mb-0">{{ Auth::user()->email }}</small>
                                </div><!--end media-body-->
                            </div>
                             <form id="logout-form" action="{{ route('logout')}}" method="post">
                                @csrf
                                <button type="button" class="dropdown-item text-danger" onclick="logoutConfirm()">
                                    <i class="las la-power-off fs-18 me-1 align-text-bottom"></i> Logout
                                </button>
                            </form>
                        </div>
                    </li>
                </ul><!--end topbar-nav-->
            </nav>
            <!-- end navbar-->
        </div>
    </div>
<script>
    function logoutConfirm() {
        Swal.fire({
            title: 'Logout?',
            text: "Are you sure you want to logout?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, logout'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>
