<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ActivityLogController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});
// login logout
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'loginPost']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
// register user
Route::get('/registration', [RegisterController::class, 'registration'])->name('register');
Route::post('/register', [RegisterController::class, 'registerPost']);

// Route::get('/admin/permissions/import', [PermissionController::class, 'import'])->name('admin.permissions.import')->middleware('auth');

// Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth','role:admin']], function () { //if admin role vako lai matra login diney vaye
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard.dashboard');
    })->name('dashboard');
    // Logo route
    Route::resource('logos', LogoController::class);

    Route::get('/permissions/search', [PermissionController::class, 'search'])->name('permissions.search');
    Route::get('/roles/search', [RoleController::class, 'search'])->name('roles.search');
    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
    Route::get('/activity_log/search', [ActivityLogController::class, 'search'])->name('activity_log.search');
    Route::get('/users/profile', [UserController::class, 'profile'])->name('users.profile');
    Route::post('/users/profileUpdate', [UserController::class, 'profileUpdate'])->name('users.profileUpdate');

    // Activity Log
    Route::get('/activity_log/index/{type}', [ActivityLogController::class, 'index'])->name('activity_log.index');

    // User
    // Route::resource('/users', UserController::class);
    // CRUD
    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('permission:view_user');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:create_user');
    Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('permission:create_user');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show')->middleware('permission:view_user');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:edit_user');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('permission:edit_user');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:delete_user');
    Route::post('/users/delete-selected', [UserController::class, 'deleteSelected'])->name('users.deleteSelected')->middleware('permission:delete_user');
    // Import Export Users
    Route::get('/users/import', [UserController::class, 'import'])->name('users.import')->middleware('permission:import_user');
    Route::post('/users/import', [UserController::class, 'importPermission'])->name('users.import.store')->middleware('permission:import_user');
    Route::post('/users/exportpdf', [UserController::class, 'exportpdf'])->name('users.exportpdf')->middleware('permission:export_user');
    Route::post('/users/exportselectedcsv', [UserController::class, 'exportselectedcsv'])->name('users.exportselectedcsv')->middleware('permission:export_user');
    Route::post('/users/{user}/restore', [UsersController::class, 'restore'])->name('users.restore');
    Route::delete('/users/{user}/force-delete', [UsersController::class, 'forceDelete'])->name('users.force-delete');
    // Permission
    // Route::resource('/permissions', PermissionController::class);
    // CRUD
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index')->middleware('permission:view_permission');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create')->middleware('permission:create_permission');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store')->middleware('permission:create_permission');
    Route::get('/permissions/{permission}', [PermissionController::class, 'show'])->name('permissions.show')->middleware('permission:view_permission');
    Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->middleware('permission:edit_permission');
    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update')->middleware('permission:edit_permission');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy')->middleware('permission:delete_permission');
    Route::post('/permissions/delete-selected', [PermissionController::class, 'deleteSelected'])->name('permissions.deleteSelected')->middleware('permission:delete_permission');
    // Route::get('/permissions/export', [PermissionController::class, 'export'])->name('permissions.export');
    // Import Export Permissions
    Route::get('/permissions/import', [PermissionController::class, 'import'])->name('permissions.import')->middleware('permission:import_permission');
    Route::post('/permissions/import', [PermissionController::class, 'importPermission'])->name('permissions.import.store')->middleware('permission:import_permission');
    Route::post('/permissions/exportpdf', [PermissionController::class, 'exportpdf'])->name('permissions.exportpdf')->middleware('permission:export_permission');
    Route::post('/permissions/exportselectedcsv', [PermissionController::class, 'exportselectedcsv'])->name('permissions.exportselectedcsv')->middleware('permission:export_permission');
    // Role
    // Route::resource('/roles', RoleController::class);
    // CRUD
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index')->middleware('permission:view_role');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create')->middleware('permission:create_role');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store')->middleware('permission:create_role');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show')->middleware('permission:view_role');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit')->middleware('permission:edit_role');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update')->middleware('permission:edit_role');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:delete_role');
    Route::post('/roles/delete-selected', [RoleController::class, 'deleteSelected'])->name('roles.deleteSelected')->middleware('permission:delete_role');
    // Import Export Roles
    Route::get('/roles/import', [RoleController::class, 'import'])->name('roles.import')->middleware('permission:import_role');
    Route::post('/roles/import', [RoleController::class, 'importRole'])->name('roles.import.store')->middleware('permission:import_role');
    Route::post('/roles/exportpdf', [RoleController::class, 'exportpdf'])->name('roles.exportpdf')->middleware('permission:export_role');
    Route::post('/roles/exportselectedcsv', [RoleController::class, 'exportselectedcsv'])->name('roles.exportselectedcsv')->middleware('permission:export_role');
});
