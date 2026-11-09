<?php

use App\Http\Controllers\Admin\AcademicController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\BillingController;
use App\Http\Controllers\Admin\DormitoryController;
use App\Http\Controllers\Admin\HealthController;
use App\Http\Controllers\Admin\InstitutionProfileSectionController as AdminInstitutionProfileSectionController;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ImageAttachmentController;
use App\Http\Controllers\InstitutionProfileController;
use App\Http\Controllers\ParentPortalController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/profil', [InstitutionProfileController::class, 'show'])->name('profil');

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user?->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    if ($user?->isParent()) {
        return redirect()->route('orangtua.dashboard');
    }

    if ($user?->isSantri()) {
        return redirect()->route('santri.dashboard');
    }

    if ($user?->isUstadz()) {
        return redirect()->route('ustadz.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'admin'])->name('admin.dashboard');

Route::get('/santri', function () {
    return view('santri.dashboard');
})->middleware(['auth', 'santri'])->name('santri.dashboard');

Route::get('/ustadz', function () {
    return view('ustadz.dashboard');
})->middleware(['auth', 'ustadz'])->name('ustadz.dashboard');

Route::get('/orangtua', [ParentPortalController::class, 'index'])
    ->middleware(['auth', 'parent'])
    ->name('orangtua.dashboard');

Route::get('/image-attachments/{imageAttachment}', [ImageAttachmentController::class, 'show'])->name('image-attachments.show');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/santri', [StudentController::class, 'index'])->name('admin.santri.index');
    Route::post('/admin/santri', [StudentController::class, 'store'])->name('admin.santri.store');
    Route::get('/admin/santri/{student}/edit', [StudentController::class, 'edit'])->name('admin.santri.edit');
    Route::patch('/admin/santri/{student}', [StudentController::class, 'update'])->name('admin.santri.update');
    Route::delete('/admin/santri/{student}', [StudentController::class, 'destroy'])->name('admin.santri.destroy');
    Route::post('/admin/santri/{student}/orang-tua', [StudentController::class, 'linkParent'])->name('admin.santri.parent.store');

    Route::get('/admin/profil', [AdminInstitutionProfileSectionController::class, 'index'])->name('admin.profil.index');
    Route::get('/admin/profil/create', [AdminInstitutionProfileSectionController::class, 'create'])->name('admin.profil.create');
    Route::post('/admin/profil', [AdminInstitutionProfileSectionController::class, 'store'])->name('admin.profil.store');
    Route::get('/admin/profil/{profileSection}/edit', [AdminInstitutionProfileSectionController::class, 'edit'])->name('admin.profil.edit');
    Route::patch('/admin/profil/{profileSection}', [AdminInstitutionProfileSectionController::class, 'update'])->name('admin.profil.update');
    Route::delete('/admin/profil/{profileSection}', [AdminInstitutionProfileSectionController::class, 'destroy'])->name('admin.profil.destroy');

    Route::get('/admin/master-data', [MasterDataController::class, 'index'])->name('admin.master-data.index');
    Route::post('/admin/master-data/jurusan', [MasterDataController::class, 'storeMajor'])->name('admin.master-data.major.store');
    Route::post('/admin/master-data/kelas', [MasterDataController::class, 'storeClass'])->name('admin.master-data.class.store');

    Route::get('/admin/kehadiran', [AttendanceController::class, 'index'])->name('admin.kehadiran.index');
    Route::post('/admin/kehadiran', [AttendanceController::class, 'store'])->name('admin.kehadiran.store');

    Route::get('/admin/akademik', [AcademicController::class, 'index'])->name('admin.akademik.index');
    Route::post('/admin/akademik', [AcademicController::class, 'store'])->name('admin.akademik.store');

    Route::get('/admin/tagihan', [BillingController::class, 'index'])->name('admin.tagihan.index');
    Route::post('/admin/tagihan', [BillingController::class, 'store'])->name('admin.tagihan.store');

    Route::get('/admin/asrama', [DormitoryController::class, 'index'])->name('admin.asrama.index');
    Route::post('/admin/asrama', [DormitoryController::class, 'store'])->name('admin.asrama.store');

    Route::get('/admin/kesehatan', [HealthController::class, 'index'])->name('admin.kesehatan.index');
    Route::post('/admin/kesehatan', [HealthController::class, 'store'])->name('admin.kesehatan.store');

    Route::get('/admin/laporan', [ReportController::class, 'index'])->name('admin.laporan.index');

    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users', [UserManagementController::class, 'store'])->name('admin.users.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
