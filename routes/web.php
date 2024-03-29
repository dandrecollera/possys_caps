<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AccountsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'loginScreen'])->name('loginScreen');
Route::post('loginProcess', [LoginController::class, 'loginProcess'])->name('loginProcess');
Route::get('/logoutProcess', [LoginController::class, 'logoutProcess'])->name('logoutProcess');

Route::group(['middleware' => 'axuauth'], function(){
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Settings
    Route::get('settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('savesettings', [AdminController::class, 'savesettings'])->name('savesettings');
    Route::get('systemdefault', [AdminController::class, 'systemdefault'])->name('systemdefault');
    Route::get('settings_addbranch', [AdminController::class, 'settings_addbranch'])->name('settings_addbranch');
    Route::post('settings_addbranchprocess', [AdminController::class, 'settings_addbranchprocess'])->name('settings_addbranchprocess');
    Route::get('settings_editbranch', [AdminController::class, 'settings_editbranch'])->name('settings_editbranch');
    Route::post('settings_editbranchprocess', [AdminController::class, 'settings_editbranchprocess'])->name('settings_editbranchprocess');
    Route::get('settings_lockunlockprocess', [AdminController::class, 'settings_lockunlockprocess'])->name('settings_lockunlockprocess');

    // Accounts
    Route::get('accounts', [AccountsController::class, 'accounts'])->name('accounts');
    Route::get('accounts_add', [AccountsController::class, 'accounts_add'])->name('accounts_add');
    Route::post('accounts_addprocess', [AccountsController::class, 'accounts_addprocess'])->name('accounts_addprocess');
    Route::get('accounts_edit', [AccountsController::class, 'accounts_edit'])->name('accounts_edit');
    Route::post('accounts_editprocess', [AccountsController::class, 'accounts_editprocess'])->name('accounts_editprocess');
    Route::post('accounts_passprocess', [AccountsController::class, 'accounts_passprocess'])->name('accounts_passprocess');
    Route::post('accounts_imageprocess', [AccountsController::class, 'accounts_imageprocess'])->name('accounts_imageprocess');
    Route::get('accounts_lockunlockprocess', [AccountsController::class, 'accounts_lockunlockprocess'])->name('accounts_lockunlockprocess');
});
