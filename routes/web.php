<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\HospitalAuthController;
use App\Http\Controllers\Auth\PatientAuthController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Patient Auth
Route::prefix('patient')->name('patient.')->group(function () {
    Route::get('login', [PatientAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [PatientAuthController::class, 'login'])->name('login.submit');
    Route::get('register', [PatientAuthController::class, 'showRegister'])->name('register');
    Route::post('register', [PatientAuthController::class, 'register'])->name('register.submit');
    Route::post('logout', [PatientAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:web')->group(function () {
        Route::get('dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
        Route::get('search', [PatientController::class, 'search'])->name('search');
        Route::get('search-results', [PatientController::class, 'searchHospitals'])->name('search.submit');
        Route::get('book/{hospitalId}', [PatientController::class, 'bookForm'])->name('book');
        Route::post('book', [PatientController::class, 'book'])->name('book.submit');
        Route::get('appointments', [PatientController::class, 'appointments'])->name('appointments');
        Route::get('profile', [PatientController::class, 'profile'])->name('profile');
        Route::post('profile/update', [PatientController::class, 'updateProfile'])->name('profile.update');
        Route::post('profile/delete', [PatientController::class, 'deleteAccount'])->name('profile.delete');
    });
});

// Hospital Auth
Route::prefix('hospital')->name('hospital.')->group(function () {
    Route::get('login', [HospitalAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [HospitalAuthController::class, 'login'])->name('login.submit');
    Route::get('register', [HospitalAuthController::class, 'showRegister'])->name('register');
    Route::post('register', [HospitalAuthController::class, 'register'])->name('register.submit');
    Route::post('logout', [HospitalAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:hospital')->group(function () {
        Route::get('dashboard', [HospitalController::class, 'dashboard'])->name('dashboard');
        Route::get('requests', [HospitalController::class, 'requests'])->name('requests');
        Route::post('requests/{id}/approve', [HospitalController::class, 'approve'])->name('request.approve');
        Route::post('requests/{id}/reject', [HospitalController::class, 'reject'])->name('request.reject');
        Route::post('requests/{id}/test-result', [HospitalController::class, 'updateTestResult'])->name('request.test-result');
        Route::post('requests/{id}/vaccination', [HospitalController::class, 'updateVaccinationStatus'])->name('request.vaccination');
    });
});

// Admin Auth
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:web')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('hospitals', [AdminController::class, 'hospitals'])->name('hospitals');
        Route::post('hospitals/{id}/approve', [AdminController::class, 'approveHospital'])->name('hospital.approve');
        Route::post('hospitals/{id}/reject', [AdminController::class, 'rejectHospital'])->name('hospital.reject');
        Route::get('vaccines', [AdminController::class, 'vaccines'])->name('vaccines');
        Route::post('vaccines', [AdminController::class, 'storeVaccine'])->name('vaccines.store');
        Route::get('vaccines/{id}/toggle', [AdminController::class, 'toggleVaccine'])->name('vaccines.toggle');
        Route::get('reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('export', [AdminController::class, 'export'])->name('export');
    });
});
