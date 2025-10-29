<div class="startbar d-print-none">
        <!--start brand-->
        <div class="brand">
            <a href="#" class="logo">
                <span>
                    {{-- <img src="{{asset('Admin/assets/images/logo-sm.png')}}" alt="logo-small" class="logo-sm"> --}}
                </span>
                <span class="">
                    {{-- <img src="{{asset('Admin/assets/images/logo-light.png')}}" alt="logo-large" class="logo-lg logo-light"> --}}
                    {{-- <img src="{{asset('Admin/assets/images/logo-dark.png')}}" alt="logo-large" class="logo-lg logo-dark"> --}}
                </span>
            </a>
        </div>
        <!--end brand-->
        <!--start startbar-menu-->
        <div class="startbar-menu" >
            <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
                <div class="d-flex align-items-start flex-column w-100">
                    <!-- Navigation -->
                    <ul class="navbar-nav mb-auto w-100">
                        <li class="menu-label mt-2">
                            <span>Main</span>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="iconoir-report-columns menu-icon"></i>
                                <span>Dashboard</span>
                                {{-- <span class="badge text-bg-info ms-auto">New</span> --}}
                            </a>
                        </li>
                        @if (Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.employee.index')}}">
                                <i class="iconoir-hand-cash menu-icon"></i>
                                <span>Employee</span>
                            </a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.department.index')}}">
                                <i class="iconoir-hand-cash menu-icon"></i>
                                <span>Department</span>
                            </a>
                        </li><!--end nav-item--> 
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="iconoir-group menu-icon"></i>
                                <span>Clients</span>
                            </a>
                        </li><!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.leavetype.index') }}">
                                <i class="iconoir-book menu-icon"></i>
                                <span>Leave</span>
                            </a>
                        </li><!--end nav-item-->
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.holiday.index') }}">
                             <i class="iconoir-calendar menu-icon"></i>
                                <span>Holiday</span>
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->role == 'employee')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('employee.leaves.index') }}">
                                <i class="iconoir-book menu-icon"></i>
                                <span>Leave Sheet</span>
                            </a>
                        </li><!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('employee.pendingleaves.index') }}">
                                <i class="iconoir-book menu-icon"></i>
                                <span>Pending Leaves</span>
                            </a>
                        </li><!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('employee.leaveapplication.index') }}">
                               <i class="iconoir-book menu-icon"></i>
                                <span>Apply Leave</span>
                            </a>
                            </li><!--end nav-item-->
                        @endif
                        <!--end nav-item-->
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="#sidebarTransactions" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarTransactions">
                                <i class="iconoir-task-list menu-icon"></i>
                                <span>Transactions</span>
                            </a>
                            <div class="collapse " id="sidebarTransactions">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Overview</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Add Transactions</a>
                                    </li><!--end nav-item-->
                                </ul><!--end nav-->
                            </div><!--end startbarTables-->
                        </li><!--end nav-item--> --}}

                    </ul><!--end navbar-nav--->

                </div>
            </div><!--end startbar-collapse-->
        </div><!--end startbar-menu-->
    </div><!--end startbar-->
    <div class="startbar-overlay d-print-none"></div>
