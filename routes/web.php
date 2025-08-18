<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GalleryShowController;
use App\Http\Controllers\GenericController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\SliderHomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
    return redirect()->route('login');
});

// Auth::routes(['verify' => true, 'reset' => true]);

// Route::middleware('guest')->group(function () {
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'login_process'])->name('login_process');
Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/register', [RegisterController::class, 'register_process'])->name('register_process');
// });

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/beranda')->with('verified', 'Email berhasil diverifikasi!');
})->middleware(['auth'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Link verifikasi telah dikirim ulang!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::post('/email/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

// Logout Route
// Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');


// Navbar 
Route::get('/beranda', [GalleryShowController::class, 'showAllPengguna'])->name('beranda');
Route::get('/wisata', [PackageController::class, 'showLayanan'])->name('wisata');
Route::get('/agenda', [AgendaController::class, 'showAgenda'])->name('agenda');
Route::get('/tentangKami', [GenericController::class, 'aboutUs'])->name('tentangKami');

// Agenda 
Route::get('/agenda/mendatang/{id}', [AgendaController::class, 'showMendatang'])->name('agenda.mendatang');
Route::get('/agenda/lalu/{id}', [AgendaController::class, 'showLalu'])->name('agenda.lalu');

// Wisata
Route::get('/wisata/{id}', [TravelController::class, 'show'])->name('wisata.show');
Route::post('/wisata/{id}/like', [TravelController::class, 'like'])->name('wisata.like');

// Galeri
Route::post('/galeri/{id}/like', [GalleryController::class, 'like'])->name('gallery.like');
Route::post('/artikel/{id}/like', [ArticleController::class, 'like'])->name('artikel.like');

// Kategori
Route::get('/kategori', [CategoryController::class, 'index'])->name('kategori.index');
Route::get('/kategori/{id}', [CategoryController::class, 'cariMakananDariKategori'])->name('kategori.makanan');

// Hidangan
Route::get('/hidangan/{id}', [MenuController::class, 'cariMenuDariId'])->name('menu.hidangan.show');
Route::post('/hidangan/{menu}/like', [MenuController::class, 'like'])->name('menu.hidangan.like');

// Paket
Route::get('/paket/{id}', [PackageController::class, 'show'])->name('menu.paket.show');
Route::post('/paket/{id}/like', [PackageController::class, 'like'])->name('menu.paket.like');
Route::middleware('auth', 'verified')->group(function () {
    Route::middleware('staff')->group(function () {
        Route::get('/admin', [UserController::class, 'showAdminPage'])->name('admin.index');

        // Admin CRUD Wisata
        Route::get('/admin/wisata', [TravelController::class, 'index'])->name('wisata.index');
        Route::get('/admin/wisata/create', [TravelController::class, 'create'])->name('wisata.create');
        Route::post('/admin/wisata/create', [TravelController::class, 'store'])->name('wisata.store');
        Route::get('/admin/wisata/edit/{wisata}', [TravelController::class, 'edit'])->name('wisata.edit');
        Route::post('/admin/wisata/edit/{wisata}', [TravelController::class, 'update'])->name('wisata.update');
        Route::post('/admin/wisata/{wisata}', [TravelController::class, 'unactive'])->name('wisata.unactive');
        Route::get('/admin/wisata/staff', [TravelController::class, 'staff'])->name('wisata.staff');

        Route::get('/admin/wisata/galeri', [TravelController::class, 'indexTravelGallery'])->name('wisata.galeri.index');
        Route::post('/admin/wisata/galeri/edit-form', [TravelController::class, 'editTravelGallery'])->name('wisata.galeri.edit');
        Route::get('/admin/wisata/galeri/edit-form', [TravelController::class, 'editTravelGallery']);
        Route::post('/admin/wisata/galeri/edit', [TravelController::class, 'updateTravelGallery'])->name('wisata.galeri.update');
        Route::get('/admin/wisata/galeri/create', [TravelController::class, 'createTravelGallery'])->name('wisata.galeri.create');
        Route::post('/admin/wisata/galeri/create', [TravelController::class, 'storeTravelGallery'])->name('wisata.galeri.store');
        Route::post('admin/wisata/galeri/{travel}', [TravelController::class, 'unactiveTravelGallery'])->name('wisata.galeri.unactive');

        Route::middleware('admin')->group(function () {
            // Admin CRUD Staff
            Route::get('/admin/staf', [UserController::class, 'index'])->name('staf.index');
            Route::get('/admin/staf/create', [UserController::class, 'create'])->name('staf.create');
            Route::post('/admin/staf/create', [UserController::class, 'store'])->name('staf.store');
            Route::get('/admin/staf/edit/{user}', [UserController::class, 'edit'])->name('staf.edit');
            Route::post('/admin/staf/edit/{user}', [UserController::class, 'update'])->name('staf.update');
            Route::post('/admin/staf/{user}', [UserController::class, 'unactivate'])->name('staf.unactive');
        });

        //Admin CRUD Generic 
        Route::get('/admin/generic', [GenericController::class, 'index'])->name('generic.index');
        Route::post('/admin/generic/create', [GenericController::class, 'store'])->name('generic.store');
        Route::get('/admin/generic/create', [GenericController::class, 'create'])->name('generic.create');
        Route::get('/admin/generic/edit/{generic}', [GenericController::class, 'edit'])->name('generic.edit');
        Route::post('/admin/generic/edit/{generic}', [GenericController::class, 'update'])->name('generic.update');
        Route::post('/admin/generic/{generic}', [GenericController::class, 'unactive'])->name('generic.unactive');

        // Admin CRUD Galeri
        Route::get('/admin/galeri', [GalleryController::class, 'index'])->name('galeri.index');
        Route::post('/admin/galeri/create', [GalleryController::class, 'store'])->name('galeri.store');
        Route::get('/admin/galeri/create', [GalleryController::class, 'create'])->name('galeri.create');
        Route::get('/admin/galeri/edit/{gallery}', [GalleryController::class, 'edit'])->name('galeri.edit');
        Route::post('/admin/galeri/edit/{gallery}', [GalleryController::class, 'update'])->name('galeri.update');
        Route::post('/admin/galeri/{gallery}', [GalleryController::class, 'unactive'])->name('galeri.unactive');

        //Admin CRUD Galeri Show 
        Route::get('/admin/galeri-show', [GalleryShowController::class, 'index'])->name('galeri.show.index');
        Route::post('/admin/galeri-show/create', [GalleryShowController::class, 'store'])->name('galeri.show.store');
        Route::get('/admin/galeri-show/create', [GalleryShowController::class, 'create'])->name('galeri.show.create');
        Route::get('/admin/galeri-show/edit/{gallery}', [GalleryShowController::class, 'edit'])->name('galeri.show.edit');
        Route::post('/admin/galeri-show/edit/{gallery}', [GalleryShowController::class, 'update'])->name('galeri.show.update');
        Route::post('/admin/galeri-show/{gallery}', [GalleryShowController::class, 'unactive'])->name('galeri.show.unactive');

        //Admin CRUD Galeri Slider 
        Route::get('/admin/galeri-slider', [SliderHomeController::class, 'index'])->name('galeri.slider.index');
        Route::post('/admin/galeri-slider/create', [SliderHomeController::class, 'store'])->name('galeri.slider.store');
        Route::get('/admin/galeri-slider/create', [SliderHomeController::class, 'create'])->name('galeri.slider.create');
        Route::get('/admin/galeri-slider/edit/{gallery}', [SliderHomeController::class, 'edit'])->name('galeri.slider.edit');
        Route::post('/admin/galeri-slider/edit/{gallery}', [SliderHomeController::class, 'update'])->name('galeri.slider.update');
        Route::post('/admin/galeri-slider/{gallery}', [SliderHomeController::class, 'unactive'])->name('galeri.slider.unactive');

        // Admin CRUD Hidangan
        Route::get('/admin/menu', [MenuController::class, 'index'])->name('menu.index');
        Route::get('/admin/hidangan/create', [MenuController::class, 'create'])->name('menu.hidangan.create');
        Route::post('/admin/hidangan/create', [MenuController::class, 'store'])->name('menu.hidangan.store');
        Route::get('/admin/hidangan/edit/{hidangan}', [MenuController::class, 'edit'])->name('menu.hidangan.edit');
        Route::post('/admin/hidangan/edit/{hidangan}', [MenuController::class, 'update'])->name('menu.hidangan.update');
        Route::post('/admin/hidangan/{hidangan}', [MenuController::class, 'unactive'])->name('menu.hidangan.unactive');

        Route::get('/admin/kategori', [CategoryController::class, 'indexAdmin'])->name('kategori.index');
        Route::get('/admin/kategori/create', [CategoryController::class, 'create'])->name('kategori.create');
        Route::post('/admin/kategori/create', [CategoryController::class, 'store'])->name('kategori.store');
        Route::get('/admin/kategori/edit/{kategori}', [CategoryController::class, 'edit'])->name('kategori.edit');
        Route::post('/admin/kategori/edit/{kategori}', [CategoryController::class, 'update'])->name('kategori.update');
        Route::post('/admin/kategori/{kategori}', [CategoryController::class, 'unactive'])->name('kategori.unactive');

        // Admin CRUD Paket
        Route::get('/admin/paket/create', [PackageController::class, 'create'])->name('menu.paket.create');
        Route::post('/admin/paket/create', [PackageController::class, 'store'])->name('menu.paket.store');
        Route::get('/admin/paket/edit/{package}', [PackageController::class, 'edit'])->name('menu.paket.edit');
        Route::post('/admin/paket/edit/{package}', [PackageController::class, 'update'])->name('menu.paket.update');
        Route::post('/admin/paket/{package}', [PackageController::class, 'unactive'])->name('menu.paket.unactive');

        //Paket Menu
        Route::get('/admin/paket-menu', [PackageController::class, 'indexPackageMenu'])->name('menu.menupaket.index');
        Route::get('/admin/paket-menu/create', [PackageController::class, 'createPackageMenu'])->name('menu.menupaket.create');
        Route::post('/admin/paket-menu/create', [PackageController::class, 'storePackageMenu'])->name('menu.menupaket.store');
        Route::get('/admin/paket-menu/edit/{packagemenu}', [PackageController::class, 'editPackageMenu'])->name('menu.menupaket.edit');
        Route::post('/admin/paket-menu/edit/{packagemenu}', [PackageController::class, 'updatePackageMenu'])->name('menu.menupaket.update');
        Route::post('/admin/paket-menu/{packagemenu}', [PackageController::class, 'unactivePackageMenu'])->name('menu.menupaket.unactive');

        // Admin CRUD Agenda
        Route::get('/admin/agenda', [AgendaController::class, 'index'])->name('agenda.index');
        Route::get('/admin/agenda/create', [AgendaController::class, 'create'])->name('agenda.create');
        Route::post('/admin/agenda/create', [AgendaController::class, 'store'])->name('agenda.store');
        Route::get('/admin/agenda/edit/{agenda}', [AgendaController::class, 'edit'])->name('agenda.edit');
        Route::post('/admin/agenda/edit/{agenda}', [AgendaController::class, 'update'])->name('agenda.update');
        Route::post('/admin/agenda/{agenda}', [AgendaController::class, 'unactive'])->name('agenda.unactive');

        // Admin CRUD Artikel
        Route::get('/admin/artikel', [ArticleController::class, 'index'])->name('artikel.index');
        Route::get('/admin/artikel/create', [ArticleController::class, 'create'])->name('artikel.create');
        Route::post('/admin/artikel/create', [ArticleController::class, 'store'])->name('artikel.store');
        Route::get('/admin/artikel/edit/{artikel}', [ArticleController::class, 'edit'])->name('artikel.edit');
        Route::post('/admin/artikel/edit/{artikel}', [ArticleController::class, 'update'])->name('artikel.update');
        Route::post('/admin/artikel/{artikel}', [ArticleController::class, 'unactive'])->name('artikel.unactive');

        // Admin CRUD Artikel Galeri
        Route::get('/admin/artikel/galeri', [ArticleController::class, 'indexArticleGallery'])->name('artikel.galeri.index');
        Route::post('/admin/artikel/galeri/edit-form', [ArticleController::class, 'editArticleGallery'])->name('artikel.galeri.edit');
        Route::get('/admin/artikel/galeri/edit-form', [ArticleController::class, 'editArticleGallery']);
        Route::post('/admin/artikel/galeri/edit', [ArticleController::class, 'updateArticleGallery'])->name('artikel.galeri.update');
        Route::get('/admin/artikel/galeri/create', [ArticleController::class, 'createArticleGallery'])->name('artikel.galeri.create');
        Route::post('/admin/artikel/galeri/create', [ArticleController::class, 'storeArticleGallery'])->name('artikel.galeri.store');
        Route::post('/admin/artikel/galeri/{artikel}', [ArticleController::class, 'unactiveArticleGallery'])->name('artikel.galeri.unactive');
    });
});
