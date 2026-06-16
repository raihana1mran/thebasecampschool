<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/application', function () {
    return view('application');
})->middleware('auth')->name('application');

Route::get('/courses', function () {
    return redirect('/admissions');
})->name('courses');

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/privacy', function () {
    return view('privacy');
});

Route::get('/terms', function () {
    return view('terms');
});

Route::get('/refund', function () {
    return view('refund');
});

Route::get('/admission-policy', function () {
    return view('admission-policy');
});

Route::get('/admissions', function () {
    return view('admissions');
})->name('admissions.public');

Route::get('/admission-status', function () {
    return view('admission-status');
})->name('admission.status');

Route::post('/admission-status/check', [App\Http\Controllers\AdmissionController::class, 'checkStatus'])->name('admission.status.check');

Route::get('/registration-success', function () {
    return view('registration-success');
})->name('registration.success');

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TmaController;
use App\Http\Middleware\EnsureIsAdmin;

Route::get('/dashboard', function () {
    $user = auth()->user();
    
    // If admin, go to admin dashboard
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    
    $tmaCount = \App\Models\Product::where('category', 'tma')->count();
    $resourceCount = \App\Models\Product::where('category', '!=', 'tma')->count();
    $mockTestCount = \App\Models\MockTest::count();
    
    $tmas = \App\Models\Product::where('category', 'tma')->latest()->take(5)->get();
    $resources = \App\Models\Product::where('category', '!=', 'tma')->latest()->take(5)->get();
    
    $admission = \App\Models\Admission::where('user_id', $user->id)->first();
    
    $isBlock1 = false;
    $isBlock2 = false;
    if ($admission && $admission->created_at) {
        $month = $admission->created_at->month;
        if ($month >= 3 && $month <= 9) {
            $isBlock1 = true;
        } else {
            $isBlock2 = true;
        }
    }
    
    $broadcasts = \App\Models\BroadcastMessage::where(function ($query) use ($user, $admission, $isBlock1, $isBlock2) {
        // General broadcasts last 24 hours
        $query->where(function ($q) use ($admission, $isBlock1, $isBlock2) {
            $q->where(function ($sub) use ($admission, $isBlock1, $isBlock2) {
                $sub->where('audience', 'all');
                
                if ($admission && $admission->status !== 'Rejected') {
                    $sub->orWhere('audience', 'active');
                }
                
                if ($isBlock1) {
                    $sub->orWhere('audience', 'block_1');
                }
                
                if ($isBlock2) {
                    $sub->orWhere('audience', 'block_2');
                }
            })->where('created_at', '>=', \Carbon\Carbon::now()->subHours(24));
        });

        // Specific student personalized message last 3 days
        $query->orWhere(function ($q) use ($user) {
            $q->where('audience', $user->email)
              ->where('created_at', '>=', \Carbon\Carbon::now()->subDays(3));
        });
    })->latest()->get();
    
    // Show student dashboard directly
    return view('dashboard', compact('tmaCount', 'resourceCount', 'mockTestCount', 'tmas', 'resources', 'broadcasts'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/subpage/{slug}', function ($slug) {
    if (view()->exists('subpages.' . $slug)) {
        return view('subpages.' . $slug, ['slug' => $slug]);
    }
    // Universal intercept: load the immersive learning path view for all subjects
    return view('subpages.12th-biology');
})->middleware(['auth', 'verified'])->name('subpage');

use App\Http\Controllers\MockTestController;
use App\Http\Controllers\ProductController;

Route::middleware(['auth', 'verified', EnsureIsAdmin::class])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/students', [AdminController::class, 'studentsView'])->name('admin.students');
    Route::post('/students', [AdminController::class, 'createStudent'])->name('admin.students.create');
    Route::get('/admissions', [AdminController::class, 'admissionsView'])->name('admin.admissions');
    Route::get('/admissions/create', [AdminController::class, 'showEnrollmentForm'])->name('admin.admissions.create');
    Route::post('/admissions/create', [AdminController::class, 'submitEnrollmentForm'])->name('admin.admissions.store');
    Route::get('/products', [AdminController::class, 'productsView'])->name('admin.products');
    Route::post('/products', [ProductController::class, 'createProduct']);
    Route::delete('/products/{id}', [ProductController::class, 'deleteProduct']);
    Route::get('/mocktests', [AdminController::class, 'mocktestsView'])->name('admin.mocktests');
    Route::post('/mocktests', [MockTestController::class, 'createMockTest']);
    Route::delete('/mocktests/{id}', [MockTestController::class, 'deleteMockTest']);
    Route::get('/payments', [AdminController::class, 'paymentsView'])->name('admin.payments');
    Route::get('/referrals', [AdminController::class, 'referralsView'])->name('admin.referrals');
    Route::get('/settings', [AdminController::class, 'settingsView'])->name('admin.settings');
    Route::post('/message', [AdminController::class, 'message'])->name('admin.message');
    Route::put('/admissions/{id}/status', [App\Http\Controllers\AdmissionController::class, 'updateAdmissionStatus'])->name('admin.admissions.status');
    Route::patch('/students/{id}/enrollment', [AdminController::class, 'updateEnrollmentNumber'])->name('admin.students.enrollment');
    Route::put('/tma-submissions/{id}/marks', [AdminController::class, 'updateTmaMarks'])->name('admin.tma.marks');
});

use App\Http\Controllers\AdmissionController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Student Dashboard Routes
    
    Route::post('/admissions', [AdmissionController::class, 'submitAdmission'])->name('admissions.submit');
    Route::post('/tma/{productId}/submit', [TmaController::class, 'submit'])->name('tma.submit');
    
    Route::get('/mocktests', function () {
        $user = auth()->user();
        $admission = \App\Models\Admission::where('user_id', $user->id)->first();
        
        $mockTests = \App\Models\MockTest::all()->map(function ($test) {
            $test->questions = collect($test->questions)->map(function ($q) {
                unset($q['correctAnswer'], $q['explanation']);
                return $q;
            })->toArray();
            return $test;
        });

        return view('mocktests', compact('mockTests', 'admission'));
    })->name('mocktests');
    
    Route::post('/mocktests/{id}/submit', [MockTestController::class, 'submitMockTest'])->name('mocktests.submit');
    
    Route::get('/mocktests/pass', function () {
        return view('mocktest-pass');
    })->name('mocktests.pass');
    
    Route::get('/referrals', function () {
        return view('referrals');
    })->name('referrals');
    
    Route::get('/tma', function () {
        $tmas = \App\Models\Product::where('category', 'tma')->latest()->get();
        $mySubmissions = \App\Models\TmaSubmission::where('user_id', auth()->id())
            ->get()->keyBy('product_id');
        return view('tma', compact('tmas', 'mySubmissions'));
    })->name('tma');
    
    Route::get('/downloads', function () {
        $category = request()->query('category');
        if ($category) {
            $products = \App\Models\Product::where('category', $category)->latest()->get();
        } else {
            $products = \App\Models\Product::latest()->get();
        }
        return view('downloads', compact('products'));
    })->name('downloads');
    
    Route::get('/downloads/add', function () {
        return view('downloads-add');
    })->name('downloads.add');
    
    Route::get('/membership', function () {
        return view('membership');
    })->name('membership');
});

Route::get('/learning', function () {
    return view('learning');
})->name('learning');

Route::get('/language/{locale}', function (string $locale) {
    if (in_array($locale, ['en','hi','bn','te','mr','ta','gu','kn','ml','pa','ur'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('language.switch');

require __DIR__.'/auth.php';
