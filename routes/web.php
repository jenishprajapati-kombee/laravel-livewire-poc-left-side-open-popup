<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', App\Livewire\Auth\Login::class)->name('login');
Route::get('forgot-password', App\Livewire\Auth\ForgotPassword::class)->name('forgot-password');
Route::get('password/reset/{token}', App\Livewire\Auth\ResetPassword::class)->name('password.reset');
Route::get('/change-password', \App\Livewire\Auth\ChangePassword::class);
Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard'); //dashboard
Route::post('upload-editor-file', [\App\Http\Controllers\API\UserAPIController::class, 'uploadEditorFile'])->name('uploadEditorFile');
Route::post('upload-file', [\App\Http\Controllers\API\UserAPIController::class, 'uploadFile'])->name('uploadFile');
Route::get('permission', \App\Livewire\Permission\Edit::class)->name('permission');


Route::middleware(['adminAuth'])->group(function () {
    
            /* Admin - Role Module */
            Route::get('/role', \App\Livewire\Role\Index::class)->name('role.index'); // Role Listing
            Route::get('/role/create', \App\Livewire\Role\Create::class)->name('role.create'); // Create Role
            Route::get('/role/{id}/edit', \App\Livewire\Role\Edit::class)->name('role.edit'); // Edit Role
        
            Route::get('/role-imports', \App\Livewire\Role\Import\IndexImport::class)->name('role.imports'); // Import history
            
    
            /* Admin - User Module */
            Route::get('/user', \App\Livewire\User\Index::class)->name('user.index'); // User Listing
            Route::get('/user/create', \App\Livewire\User\Create::class)->name('user.create'); // Create User
            Route::get('/user/{id}/edit', \App\Livewire\User\Edit::class)->name('user.edit'); // Edit User
        
            Route::get('/user-imports', \App\Livewire\User\Import\IndexImport::class)->name('user.imports'); // Import history
            
    
            /* Admin - Brand Module */
            Route::get('/brand', \App\Livewire\Brand\Index::class)->name('brand.index'); // Brand Listing
            Route::get('/brand/create', \App\Livewire\Brand\Create::class)->name('brand.create'); // Create Brand
            Route::get('/brand/{id}/edit', \App\Livewire\Brand\Edit::class)->name('brand.edit'); // Edit Brand
        
            Route::get('/brand-imports', \App\Livewire\Brand\Import\IndexImport::class)->name('brand.imports'); // Import history
            
});
