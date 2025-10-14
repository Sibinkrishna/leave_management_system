<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\CompanySettingController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\LeaveApprovalController;
use App\Http\Controllers\Admin\LeaveBalanceController;
use App\Http\Controllers\Admin\LeaveTypeController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Employee\LeaveController;
use Illuminate\Support\Facades\Route;




Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login.submit');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('change-password', [AuthController::class,'showChangePassword'])->name('password.change');
Route::post('change-password', [AuthController::class,'changePassword'])->name('password.update');

Route::get('/dashboard', [DashboardController::class,'index'])->middleware('auth')->name('dashboard');

Route::prefix('admin')->name('admin.')->middleware(['auth','role:admin'])->group(function(){
    Route::get('company-settings', [CompanySettingController::class,'edit'])->name('company.settings.edit');
    Route::post('company-settings', [CompanySettingController::class,'update'])->name('company.settings.update');

    Route::get('leaves/pending', [LeaveApprovalController::class,'index'])->name('leaves.pending');
    Route::post('leaves/{leave}/approve', [LeaveApprovalController::class,'approve'])->name('leaves.approve');
    Route::post('leaves/{leave}/reject', [LeaveApprovalController::class,'reject'])->name('leaves.reject');

});
Route::prefix('employee')->name('employee.')->middleware(['auth','role:employee'])->group(function(){
    Route::resource('leaves', LeaveController::class);
});
