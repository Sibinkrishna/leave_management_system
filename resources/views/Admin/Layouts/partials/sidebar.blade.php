<div class="startbar d-print-none">
        <!--start brand-->
     <div class="w-100 d-flex justify-content-center align-items-center" style="padding: 10px 0;">
    <img src="{{ asset('Admin/assets/images/smartenough2_logo.png') }}" 
         alt="SmartEnough Solutions Logo"
         style="height: 70px; width: 68px; margin-left: -11px;">
         
    <g>
        <polygon class="st0" points="78,105 15,105 24,87 87,87"></polygon>
        <polygon class="st0" points="96,69 33,69 42,51 105,51"></polygon>
        <polygon class="st0" points="78,33 15,33 24,15 87,15"></polygon>
    </g>
</div>

        <!--end brand-->
        <!--start startbar-menu-->
        <div class="startbar-menu" >
            <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
                <div class="d-flex align-items-start flex-column w-100">
                    <!-- Navigation -->
                    <ul class="navbar-nav mb-auto w-100">
                        {{-- <li class="menu-label mt-2">
                            <span>Main</span>
                        </li> --}}

                        <li class="nav-item">
    @if (Auth::user()->role == 'admin')
    <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="iconoir-report-columns menu-icon"></i>
        <span>Dashboard</span>
    </a>
@elseif (Auth::user()->role == 'employee')
    <a class="nav-link" href="{{ route('employee.dashboard') }}">
        <i class="iconoir-report-columns menu-icon"></i>
        <span>Dashboard</span>
    </a>
@endif

</li>
                       

                        @if (Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.employee.index')}}">
                               <i class="iconoir-user menu-icon"></i> <!-- Changed icon -->
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
                       <li class="nav-item">
                          <a class="nav-link d-flex align-items-center" href="{{ route('admin.leaves.pending') }}">
                          <i class="iconoir-bell menu-icon"></i>
                             <span>Leave Applications</span>
                            @php
                            $pendingCount = \App\Models\LeaveApplication::where('status', 'pending')->count();
                             @endphp
                            @if($pendingCount > 0)
                            <span class="badge bg-danger ms-auto">{{ $pendingCount }}</span>
                             @endif
                               </a>
                              </li>
                               <li class="nav-item">
                                   <a class="nav-link" href="{{ route('admin.wfh.index') }}">
                                  <i class="iconoir-laptop menu-icon"></i>
                                   <span>WFH Records</span>
                                    </a>
                                   </li><!--end nav-item-->

                        @endif
                        @if (Auth::user()->role == 'employee')
                       <li class="nav-item">
                          <a class="nav-link" href="{{ url('employee/holiday') }}">
                            <i class="iconoir-calendar menu-icon"></i>
                            <span>Holiday</span>
                          </a>
                       </li><!--end nav-item-->
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
                            <a class="nav-link" href="{{ route('employee.leaveapplications.index') }}">
                               <i class="iconoir-book menu-icon"></i>
                                <span>Apply Leave</span>
                            </a>
                            </li><!--end nav-item-->

                              <li class="nav-item">
                            <a class="nav-link" href="{{ route('employee.wfh.create') }}">
                             <i class="iconoir-laptop menu-icon"></i>
                            <span>WFH</span>
                             </a>
                            </li><!--end nav-item-->

                             <li class="nav-item">
                            <a class="nav-link" href="{{ route('employee.attendance.records') }}">
                                <i class="iconoir-bell menu-icon"></i>
                               <span>Attendance Record</span>
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
                    <!-- Optional CSS to standardize icon size and spacing -->
<style>
.nav-link i.menu-icon {
    font-size: 1.2rem;        /* consistent size */
    vertical-align: middle;
}
.nav-link span {
    margin-left: 6px;          /* consistent gap */
}
.nav-item .nav-link {
    display: flex;
    align-items: center;       /* vertical center */
    gap: 6px;                  /* spacing between icon & text */
}
.nav-link i.menu-icon {
    font-size: 1.2rem;        /* same size for all */
    line-height: 1;            /* prevent extra vertical spacing */
    display: inline-flex;
    align-items: center;
}

</style>

                </div>
            </div><!--end startbar-collapse-->
        </div><!--end startbar-menu-->
    </div><!--end startbar-->
    <div class="startbar-overlay d-print-none"></div>
