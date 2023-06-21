<?php

use App\Http\Controllers\admin\AdminPanelController;
use App\Http\Controllers\admin\AdminUsersController;
use App\Http\Controllers\admin\categories\CategoryController;
use App\Http\Controllers\admin\ContactMessagesController;
use App\Http\Controllers\admin\country\CountriesController;
use App\Http\Controllers\admin\PermissionsController;
use App\Http\Controllers\admin\RolesController;
use App\Http\Controllers\admin\SettingsController;
use App\Http\Controllers\admin\statics\PagesController;
use App\Http\Controllers\admin\stores\StoreController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'AdminPanel', 'middleware' => ['role:admin', 'auth']], function () {
    Route::get('/', [AdminPanelController::class, 'index'])->name('admin.index');

    Route::get('/read-all-notifications', [AdminPanelController::class, 'readAllNotifications'])->name('admin.notifications.readAll');
    Route::get('/notification/{id}/details', [AdminPanelController::class, 'notificationDetails'])->name('admin.notification.details');

    Route::get('/my-profile', [AdminPanelController::class, 'edit'])->name('myProfile.edit');
    Route::post('/my-profile', [AdminPanelController::class, 'update'])->name('myProfile.update');
    Route::get('/my-password', [AdminPanelController::class, 'EditPassword'])->name('myPassword.edit');
    Route::post('/my-password', [AdminPanelController::class, 'UpdatePassword'])->name('myPassword.update');
    Route::get('/notifications-settings', [AdminPanelController::class, 'EditNotificationsSettings'])->name('admin.notificationsSettings');
    Route::post('/notifications-settings', [AdminPanelController::class, 'UpdateNotificationsSettings'])->name('admin.notificationsSettings.update');

    Route::group(['prefix' => 'admins'], function () {
        Route::get('/', [AdminUsersController::class, 'index'])->name('admin.adminUsers');
        Route::get('/create', [AdminUsersController::class, 'create'])->name('admin.adminUsers.create');
        Route::post('/create', [AdminUsersController::class, 'store'])->name('admin.adminUsers.store');
        Route::get('/{id}/block/{action}', [AdminUsersController::class, 'blockAction'])->name('admin.adminUsers.block');
        Route::get('/{id}/edit', [AdminUsersController::class, 'edit'])->name('admin.adminUsers.edit');
        Route::post('/{id}/edit', [AdminUsersController::class, 'update'])->name('admin.adminUsers.update');
        Route::get('/{id}/delete', [AdminUsersController::class, 'delete'])->name('admin.adminUsers.delete');
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', [RolesController::class, 'index'])->name('roles.index');
        Route::post('/create', [RolesController::class, 'store'])->name('roles.store');
        Route::post('/{role}/edit', [RolesController::class, 'update'])->name('roles.update');
        Route::get('/{role}/delete', [RolesController::class, 'delete'])->name('roles.delete');
    });

    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/', [PermissionsController::class, 'index'])->name('permissions.index');
        Route::post('/create', [PermissionsController::class, 'store'])->name('permissions.store');
        Route::post('/{permission}/edit', [PermissionsController::class, 'update'])->name('permissions.update');
        Route::get('/{permission}/delete', [PermissionsController::class, 'delete'])->name('permissions.delete');
    });

    Route::group(['prefix' => 'contact-messages'], function () {
        Route::get('/', [ContactMessagesController::class, 'index'])->name('admin.contactmessages');
        Route::get('/{id}/details', [ContactMessagesController::class, 'details'])->name('admin.contactmessages.details');
        Route::get('/{id}/delete', [ContactMessagesController::class, 'delete'])->name('admin.contactmessages.delete');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/', [SettingsController::class, 'update'])->name('settings.update');
        Route::get('/{key}/deletePhoto', [SettingsController::class, 'deleteSettingPhoto'])->name('settings.deletePhoto');
    });

    Route::resource('pages', PagesController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('stores', StoreController::class);
    Route::resource('countries', CountriesController::class);

});
