<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\LoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

// Helper untuk format props auth_user
$getAuthUser = function () {
    if (!auth()->check()) return null;
    return [
        'id' => auth()->id(),
        'name' => auth()->user()->name,
        'email' => auth()->user()->email,
        'roles' => auth()->user()->getRoleNames(),
        'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
    ];
};

// Landing & Login Page
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('login');

// Protected Routes (Harus Login)
Route::middleware(['auth'])->group(function () use ($getAuthUser) {
    
    // Dashboard Profile
    Route::get('/dashboard', function () use ($getAuthUser) {
        return Inertia::render('Dashboard', [
            'auth_user' => $getAuthUser()
        ]);
    })->name('dashboard');

    // Group Route Admin (Spatie Role 'admin')
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () use ($getAuthUser) {
        Route::get('/users', function () use ($getAuthUser) {
            return Inertia::render('Admin/Users', [
                'auth_user' => $getAuthUser()
            ]);
        })->name('users');

        Route::get('/roles', function () use ($getAuthUser) {
            return Inertia::render('Admin/Roles', [
                'auth_user' => $getAuthUser()
            ]);
        })->name('roles');

        Route::get('/permissions', function () use ($getAuthUser) {
            return Inertia::render('Admin/Permissions', [
                'auth_user' => $getAuthUser()
            ]);
        })->name('permissions');

        Route::get('/settings', function () use ($getAuthUser) {
            return Inertia::render('Admin/Settings', [
                'auth_user' => $getAuthUser()
            ]);
        })->middleware('permission:manage system')->name('settings');
    });

    // Group Route Operations Control
    Route::prefix('ops')->name('ops.')->group(function () use ($getAuthUser) {
        
        // Execution Engine
        Route::get('/execution', function () use ($getAuthUser) {
            return Inertia::render('Ops/Execution', [
                'auth_user' => $getAuthUser()
            ]);
        })->middleware('permission:execute operations')->name('execution');

        // Control Center
        Route::get('/control-center', function () use ($getAuthUser) {
            return Inertia::render('Ops/ControlCenter', [
                'auth_user' => $getAuthUser()
            ]);
        })->middleware('permission:operations control center')->name('control-center');

        // System Audit Logs Viewer
        Route::get('/logs', function () use ($getAuthUser) {
            return Inertia::render('Ops/Logs', [
                'logs' => LoginLog::with('user:id,name,email')->latest('login_at')->paginate(15),
                'auth_user' => $getAuthUser()
            ]);
        })->middleware('permission:read operations')->name('logs');
    });

});

// Auth Manual (Login & Logout)
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');

// Auth SSO Google
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);