<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    ActivityLogController,
    CompanySettingController,
    DepartmentController,
    EmployeeController,
    LeaveApprovalController,
    LeaveBalanceController,
    LeaveTypeController,
    ReportController,
    UserController,
    HolidayController,

};
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\{DashboardController, ProfileController};
// use App\Http\Controllers\Employee\LeaveController;
use App\Http\Controllers\Employee\LeaveSheetController; 
use App\Http\Controllers\Employee\PendingLeaveController;
use App\Http\Controllers\Employee\LeaveApplicationController;
use App\Http\Controllers\Employee\AttendanceController ;





// ================== AUTH ROUTES ==================
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login.submit');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('change-password', [AuthController::class, 'showChangePassword'])->name('password.change');
Route::post('change-password', [AuthController::class, 'changePassword'])->name('password.update');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// ================== DASHBOARD ==================

// Admin Dashboard


// Employee Dashboard
// Route::get('/dashboard', [DashboardController::class, 'index'])
//     ->middleware(['auth','role:employee'])
//     ->name('employee.dashboard');


// ================== ADMIN ROUTES ==================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
  
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth','role:admin'])
    ->name('dashboard');
    // Employee Management
    Route::get('/employee-create', [EmployeeController::class, 'create'])->name('employee.create');
    Route::post('/employee-create', [EmployeeController::class, 'store'])->name('employee.store');
    Route::get('/employee-index', [EmployeeController::class, 'index'])->name('employee.index');
    Route::get('/employee-profile/{id}', [EmployeeController::class, 'show'])->name('employee.show');
    Route::get('/employee-edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('/employee-edit/{id}', [EmployeeController::class, 'update'])->name('employee.update');
    Route::post('/employee-delete/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');

    // Company Settings
    Route::get('company-settings', [CompanySettingController::class, 'edit'])->name('company.settings.edit');
    Route::post('company-settings', [CompanySettingController::class, 'update'])->name('company.settings.update');

    // Leave Approvals
   // Admin Leave Approvals
    Route::get('leaves', [LeaveApprovalController::class, 'index'])->name('leaves.pending');
    Route::post('leaves/{id}/approve', [LeaveApprovalController::class, 'approve'])->name('leaves.approve');
    Route::post('leaves/{id}/reject', [LeaveApprovalController::class, 'reject'])->name('leaves.reject');

    // ================== Department Routes ==================
    Route::get('/department', [DepartmentController::class, 'index'])->name('department.index');
    Route::get('/department/create', [DepartmentController::class, 'create'])->name('department.create');
    Route::post('/department', [DepartmentController::class, 'store'])->name('department.store');
    Route::get('/department/{id}/edit', [DepartmentController::class, 'edit'])->name('department.edit');
    Route::post('/department/{id}/edit', [DepartmentController::class, 'update'])->name('department.update');
    Route::post('/department/{id}', [DepartmentController::class, 'destroy'])->name('department.destroy');
    // ================== LeaveType Routes ==================
    Route::get('/leavetype', [LeaveTypeController::class, 'index'])->name('leavetype.index');
    Route::get('/leavetype/create', [LeaveTypeController::class, 'create'])->name('leavetype.create');
    Route::post('/leavetype', [LeaveTypeController::class, 'store'])->name('leavetype.store');      
    Route::get('/leavetype/{id}/edit', [LeaveTypeController::class, 'edit'])->name('leavetype.edit');
    Route::post('/leavetype/{id}/edit', [LeaveTypeController::class, 'update'])->name('leavetype.update');
    Route::post('/leavetype/{id}', [LeaveTypeController::class, 'destroy'])->name('leavetype.destroy');
    Route::post('/leavetype-create', [LeaveTypeController::class, 'store'])->name('leavetype.store');
    

    // ================== Holiday Routes ==================
// Holiday Routes
// ================== Holiday Routes ==================
Route::get('holiday', [HolidayController::class, 'index'])->name('holiday.index');          // List
Route::get('holiday/create', [HolidayController::class, 'create'])->name('holiday.create'); // Add form
Route::post('holiday', [HolidayController::class, 'store'])->name('holiday.store');         // Store new

Route::get('holiday/{holiday}/edit', [HolidayController::class, 'edit'])->name('holiday.edit');  // Edit form
Route::put('holiday/{holiday}', [HolidayController::class, 'update'])->name('holiday.update');   // Update record

Route::post('holiday/{holiday}', [HolidayController::class, 'destroy'])->name('holiday.destroy'); // Delete


});

// ================== EMPLOYEE ROUTES ==================


Route::prefix('employee')->name('employee.')->middleware(['auth','role:employee'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
    Route::get('leaves', [LeaveSheetController::class, 'index'])->name('leaves.index');
    Route::get('pending-leaves', [PendingLeaveController::class, 'index'])->name('pendingleaves.index');
    
 Route::get('leaves/applications', [LeaveApplicationController::class, 'index'])->name('leaveapplication.index');

 Route::get('leaves/apply', [LeaveApplicationController::class, 'create'])->name('leaveapplications.create');

 Route::post('leaves', [LeaveApplicationController::class, 'store']) ->name('leaveapplications.store');

  Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
  Route::get('attendance/records', [AttendanceController::class, 'records'])->name('attendance.records');

    Route::post('attendance/checkin', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('attendance/checkout', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');
     Route::get('/holiday', [App\Http\Controllers\Employee\HolidayController::class, 'index'])->name('employee.holiday');


 

});




 // ================== Leave ==================

