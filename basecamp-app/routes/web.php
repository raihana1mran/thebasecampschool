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
    
    // Restrict access: student must have an approved admission with enrollment number
    $admission = \App\Models\Admission::where('user_id', $user->id)->first();
    $hasApprovedAdmission = $admission && $admission->status === 'Approved';
    $hasEnrollmentNumber = (bool) $user->enrollment_number;
    
    // If no approved admission or no enrollment number, show onboarding/status page
    if (!$hasApprovedAdmission || !$hasEnrollmentNumber) {
        $statusResult = $admission ? [
            'full_name' => $admission->full_name,
            'course_type' => $admission->course_type,
            'status' => $admission->status,
            'reference_number' => $admission->reference_number,
            'message' => $hasEnrollmentNumber
                ? 'Your admission is being reviewed. Please wait for approval.'
                : ($admission && $admission->status === 'Approved'
                    ? 'Your admission is approved! Admin will share your enrollment number and password shortly via email.'
                    : 'Your admission is being processed. Check back later.'),
        ] : null;
        return view('student-onboarding', compact('statusResult', 'admission'));
    }
    
    // Mark student as active on first successful dashboard access
    if (!$user->first_login_at) {
        $user->update(['first_login_at' => now()]);
    }

    $unlockedProducts = $user->unlocked_products ?? [];

    $tmaCount = \App\Models\Product::where('category', 'tma')->count();
    $resourceCount = \App\Models\Product::where('category', '!=', 'tma')->count();
    $mockTestCount = \App\Models\MockTest::count();
    
    $tmas = \App\Models\Product::where('category', 'tma')->latest()->take(5)->get();
    $resources = \App\Models\Product::where('category', '!=', 'tma')->latest()->take(5)->get();
    $allResources = \App\Models\Product::where('category', '!=', 'tma')->latest()->take(10)->get();
    $allResourceCount = $allResources->count();
    
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
    
    $videoLessons = \App\Models\VideoLesson::all();
    
    // Show student dashboard directly
    return view('dashboard', compact('tmaCount', 'resourceCount', 'mockTestCount', 'tmas', 'resources', 'allResources', 'allResourceCount', 'broadcasts', 'unlockedProducts', 'videoLessons'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/subpage/{slug}', function ($slug) {
    if (view()->exists('subpages.' . $slug)) {
        return view('subpages.' . $slug, ['slug' => $slug]);
    }
    // Universal intercept: load the immersive learning path view for all subjects
    return view('subpages.12th-biology');
})->middleware(['auth', 'verified'])->name('subpage');

Route::get('/learning/{id}', function($id) {
    $lesson = \App\Models\VideoLesson::findOrFail($id);
    return view('learning', compact('lesson'));
})->middleware(['auth', 'verified'])->name('learning.video');

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
    Route::get('/exams', [AdminController::class, 'examsView'])->name('admin.exams');
    Route::get('/pcp', [AdminController::class, 'pcpView'])->name('admin.pcp');
    Route::get('/tma', [AdminController::class, 'tmaView'])->name('admin.tma');
    Route::get('/study-material', [AdminController::class, 'studyMaterialView'])->name('admin.study_material');
    Route::get('/results', [AdminController::class, 'resultsView'])->name('admin.results');
    Route::get('/notifications', [AdminController::class, 'notificationsView'])->name('admin.notifications');
    Route::get('/reports', [AdminController::class, 'reportsView'])->name('admin.reports');
    Route::get('/payments', [AdminController::class, 'paymentsView'])->name('admin.payments');
    Route::get('/referrals', [AdminController::class, 'referralsView'])->name('admin.referrals');
    Route::get('/settings', [AdminController::class, 'settingsView'])->name('admin.settings');
    Route::get('/video-lessons', [AdminController::class, 'videoLessonsView'])->name('admin.video-lessons');
    Route::post('/video-lessons/upload', [AdminController::class, 'uploadVideoLesson'])->name('admin.video-lessons.upload');
    Route::delete('/video-lessons/{id}', [AdminController::class, 'deleteVideoLesson'])->name('admin.video-lessons.delete');
    Route::delete('/broadcasts/{id}', [AdminController::class, 'deleteBroadcast'])->name('admin.broadcasts.delete');
    Route::post('/message', [AdminController::class, 'message'])->name('admin.message');
    Route::put('/admissions/{id}/status', [App\Http\Controllers\AdmissionController::class, 'updateAdmissionStatus'])->name('admin.admissions.status');
    Route::patch('/students/{id}/enrollment', [AdminController::class, 'updateEnrollmentNumber'])->name('admin.students.enrollment');
    Route::put('/tma-submissions/{id}/marks', [AdminController::class, 'updateTmaMarks'])->name('admin.tma.marks');
    Route::post('/student-message', [AdminController::class, 'sendStudentMessage'])->name('admin.student.message');
    // Dashboard action routes
    Route::post('/documents/verify', [AdminController::class, 'verifyDocument'])->name('admin.documents.verify');
    Route::post('/documents/request-reupload', [AdminController::class, 'requestReupload'])->name('admin.documents.reupload');
    Route::post('/tma/upload', [AdminController::class, 'uploadTma'])->name('admin.tma.upload');
    Route::get('/invoices/download', [AdminController::class, 'downloadInvoices'])->name('admin.invoices.download');
    Route::post('/exams/notification', [AdminController::class, 'postExamNotification'])->name('admin.exams.notification');
    Route::post('/exams/hall-ticket', [AdminController::class, 'uploadHallTicket'])->name('admin.exams.hallticket');
    Route::get('/exams/eligible-list', [AdminController::class, 'generateEligibleList'])->name('admin.exams.eligible');
    Route::post('/pcp/schedule', [AdminController::class, 'createPcpSchedule'])->name('admin.pcp.schedule');
    Route::post('/study-material/upload', [AdminController::class, 'uploadStudyMaterial'])->name('admin.study.upload');
    Route::post('/results/publish', [AdminController::class, 'publishResult'])->name('admin.results.publish');
    Route::get('/reports/admissions', [AdminController::class, 'generateAdmissionReport'])->name('admin.reports.admissions');
    Route::get('/reports/revenue', [AdminController::class, 'generateRevenueReport'])->name('admin.reports.revenue');
});

use App\Http\Controllers\AdmissionController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Student Dashboard Routes
    
    Route::post('/admissions', [AdmissionController::class, 'submitAdmission'])->name('admissions.submit');
    Route::post('/tma/{productId}/submit', [TmaController::class, 'submit'])->name('tma.submit');
    
    Route::post('/student/message', function () {
        $data = request()->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);
        \App\Models\BroadcastMessage::create([
            'audience' => auth()->user()->email,
            'subject' => '[Student Query] ' . $data['subject'],
            'message' => $data['message'],
        ]);
        return response()->json(['success' => true]);
    })->name('student.message');
    
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
    
    Route::post('/products/{id}/unlock', [ProductController::class, 'unlockProduct'])->name('products.unlock');

    Route::post('/payments/tma-late-fee/{productId}', function ($productId) {
        $user = auth()->user();
        \App\Models\Payment::create([
            'user_id' => $user->id,
            'amount' => 1200.00,
            'payment_id' => 'tma_late_' . $productId . '_' . strtoupper(\Illuminate\Support\Str::random(8)),
            'status' => 'Success',
            'type' => 'TMA',
        ]);
        return redirect()->back()->with('success', 'TMA late fee paid successfully! You can now submit your assignment.');
    })->name('payments.tma-late-fee');

    Route::get('/tma', function () {
        $tmas = \App\Models\Product::where('category', 'tma')->latest()->get();
        $mySubmissions = \App\Models\TmaSubmission::where('user_id', auth()->id())
            ->get()->keyBy('product_id');
        return view('tma', compact('tmas', 'mySubmissions'));
    })->name('tma');
    
    Route::get('/downloads', function () {
        $products = \App\Models\Product::latest()->get();
        return view('downloads', compact('products'));
    })->name('downloads');
    
    Route::post('/shop/purchase', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
            'amount' => 'required|numeric|min:0',
        ]);
        
        $user = auth()->user();
        $products = \App\Models\Product::whereIn('id', $validated['product_ids'])->get();
        $downloadUrls = [];
        
        foreach ($products as $product) {
            \App\Models\Payment::create([
                'user_id' => $user->id,
                'amount' => $product->price,
                'payment_id' => 'TXN_' . strtoupper(\Illuminate\Support\Str::random(12)),
                'status' => 'Success',
                'type' => 'Product',
            ]);
            
            $urls = $product->file_urls;
            if (is_string($urls)) $urls = json_decode($urls, true) ?: [];
            if (!is_array($urls)) $urls = [];
            
            if (count($urls) > 0) {
                $downloadUrls[$product->id] = [
                    'title' => $product->title,
                    'urls' => array_map(fn($u) => str_starts_with($u, 'http') ? $u : asset('storage/' . $u), $urls),
                ];
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Purchase complete! Download your files below.',
            'downloads' => $downloadUrls,
        ]);
    })->middleware(['auth', 'verified'])->name('shop.purchase');
    
    Route::get('/membership', function () {
        return view('membership');
    })->name('membership');

    Route::get('/identity-card', function () {
        $user = auth()->user();
        $admission = \App\Models\Admission::where('user_id', $user->id)->first();
        return view('identity-card', compact('user', 'admission'));
    })->name('identity.card');
});

Route::get('/learning', function () {
    $videoLessons = collect();
    $admission = \App\Models\Admission::where('user_id', auth()->id())->first();
    $classStandard = 'Secondary (10th)';
    if ($admission) {
        $classStandard = match(strtolower($admission->course_type)) {
            'secondary' => 'Secondary (10th)',
            'senior secondary' => 'Senior Secondary (12th)',
            default => 'Secondary (10th)'
        };
        $videoLessons = \App\Models\VideoLesson::where('class_level', $classStandard)->get();
    }
    return view('learning-hub', compact('videoLessons', 'admission', 'classStandard'));
})->name('learning');

Route::get('/lessons/{code}', function ($code) {
    $subjectCodes = ['201','202','203','204','205','206','207','208','209','210','211','212','213','214','215','216','222','223','224','225','228','229','230','231','232','233','235','236','237','238','242','243','244','245','246','247','248','249','285','301','302','303','304','305','306','307','309','310','311','312','313','314','315','316','317','318','319','320','321','328','330','331','332','333','335','336','337','338','339','341','342','343','344','345','346','347','348','373','374','375','376','383','385'];

    if (!in_array($code, $subjectCodes)) {
        abort(404, 'Subject not found.');
    }

    $subjectNames = [
        '201'=>'Hindi','202'=>'English','203'=>'Bengali','204'=>'Marathi','205'=>'Telugu',
        '206'=>'Urdu','207'=>'Gujarati','208'=>'Kannada','209'=>'Sanskrit','210'=>'Punjabi',
        '211'=>'Mathematics','212'=>'Science and Technology','213'=>'Social Science','214'=>'Economics',
        '215'=>'Business Studies','216'=>'Home Science','222'=>'Psychology','223'=>'Indian Culture & Heritage',
        '224'=>'Accountancy','225'=>'Painting','228'=>'Assamese','229'=>'Data Entry Operations',
        '230'=>'Indian Sign Language','231'=>'Nepali','232'=>'Malayalam','233'=>'Odia',
        '235'=>'Arabic','236'=>'Persian','237'=>'Tamil','238'=>'Sindhi',
        '242'=>'Hindustani Sangeet','243'=>'Carnatic Sangeet','244'=>'Folk Art','245'=>'Veda Adhyan',
        '246'=>'Sanskrit Vyakarana','247'=>'Bharatiya Darshan','248'=>'Sanskrit Sahitya',
        '249'=>'Entrepreneurship','285'=>'Natyakala',
        '301'=>'Hindi','302'=>'English Core','303'=>'Bengali','304'=>'Tamil','305'=>'Odia',
        '306'=>'Urdu','307'=>'Gujarati','309'=>'Sanskrit','310'=>'Punjabi',
        '311'=>'Mathematics','312'=>'Physics','313'=>'Chemistry','314'=>'Biology',
        '315'=>'History','316'=>'Geography','317'=>'Political Science','318'=>'Economics',
        '319'=>'Business Studies','320'=>'Accountancy','321'=>'Home Science','328'=>'Psychology',
        '330'=>'Computer Science','331'=>'Sociology','332'=>'Fine Arts','333'=>'Environmental Science',
        '335'=>'Mass Media','336'=>'Data Entry Operations','337'=>'Tourism','338'=>'Legal Studies',
        '339'=>'Library & Info Science','341'=>'Arabic','342'=>'Persian','343'=>'Malayalam',
        '344'=>'Sindhi','345'=>'Veda Adhyyan','346'=>'Sanskrit Vyakarana','347'=>'Bharatiya Darshan',
        '348'=>'Sanskrit Sahitya','373'=>'Physical Education','374'=>'Military Studies',
        '375'=>'Military History','376'=>'Early Childhood Care','383'=>'Krishi','385'=>'Natyakala',
    ];

    $subjectName = $subjectNames[$code] ?? 'Unknown';
    $classLevel = (int)$code < 300 ? 'Class 10th' : 'Class 12th';

    $chapters = [];
    for ($i = 1; $i <= 12; $i++) {
        $embedUrl = "https://www.youtube.com/embed/PLACEHOLDER_{$code}_CH{$i}";
        if ($code === '314') {
            $index = $i - 1;
            $embedUrl = "https://www.youtube.com/embed/videoseries?list=PLJtCpape_TuiytvOVnvffWeWFSimU5aiT&index={$index}";
        }
        $chapters[] = [
            'number' => $i,
            'title' => "Chapter {$i}",
            'description' => "Video lesson covering Chapter {$i} concepts and topics.",
            'embed_url' => $embedUrl,
        ];
    }

    // Subject-wise resources: match by name in title or class-level category
    $allResources = \App\Models\Product::where('category', '!=', 'tma')->latest()->get()->filter(function ($p) use ($subjectName, $classLevel) {
        $matchesSubject = str_contains(strtolower($p->title), strtolower($subjectName))
            || str_contains(strtolower($p->description ?? ''), strtolower($subjectName))
            || str_contains(strtolower($p->category ?? ''), strtolower(explode(' ', $subjectName)[0]));
        $matchesLevel = in_array($p->category, [$classLevel, 'pdf', 'General', 'Competitive']);
        return $matchesSubject || $matchesLevel;
    });

    // Parse chapter number from product title/description
    $resourcesData = [];
    foreach ($allResources as $r) {
        $chNum = null;
        if (preg_match('/\b(?:chapter|ch|module|lesson|unit)\s*[.:#]?\s*(\d+)\b/i', $r->title, $m)) {
            $chNum = (int)$m[1];
        } elseif (preg_match('/\b(?:chapter|ch|module|lesson|unit)\s*[.:#]?\s*(\d+)\b/i', $r->description ?? '', $m)) {
            $chNum = (int)$m[1];
        }
        $urls = $r->file_urls;
        if (is_string($urls)) $urls = json_decode($urls, true) ?: [];
        $fileUrl = '#';
        if (is_array($urls) && count($urls) > 0) {
            $fileUrl = str_starts_with($urls[0], 'http') ? $urls[0] : asset('storage/' . $urls[0]);
        }
        $resourcesData[] = [
            'id' => $r->id,
            'title' => $r->title,
            'category' => $r->category,
            'price' => (float)$r->price,
            'file_url' => $fileUrl,
            'chapter' => $chNum && $chNum >= 1 && $chNum <= 12 ? $chNum : 0,
        ];
    }

    // Subject-wise mock tests
    $allMockTests = \App\Models\MockTest::latest()->get()->filter(function ($m) use ($subjectName) {
        return str_contains(strtolower($m->subject ?? ''), strtolower($subjectName))
            || str_contains(strtolower($m->title), strtolower($subjectName));
    });

    // Parse chapter number from mock test title
    $mockTestsData = [];
    foreach ($allMockTests as $m) {
        $chNum = null;
        if (preg_match('/\b(?:chapter|ch|module|lesson|unit|test)\s*[.:#]?\s*(\d+)\b/i', $m->title, $match)) {
            $chNum = (int)$match[1];
        }
        $mockTestsData[] = [
            'id' => $m->id,
            'title' => $m->title,
            'type' => $m->type ?? 'Mock Test',
            'duration' => $m->duration,
            'questions_count' => $m->questions ? count($m->questions) : 0,
            'chapter' => $chNum && $chNum >= 1 && $chNum <= 12 ? $chNum : 0,
        ];
    }

    return view('lessons.index', compact('code', 'chapters', 'resourcesData', 'mockTestsData', 'classLevel', 'subjectName'));
})->middleware(['auth', 'verified'])->name('lessons.chapters');

Route::get('/language/{locale}', function (string $locale) {
    if (in_array($locale, ['en','hi','bn','te','mr','ta','gu','kn','ml','pa','ur'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('language.switch');

Route::get('/syllabus-download/{code}', function ($code) {
    $map = [
        '201' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/201.pdf',
        '202' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/202.pdf',
        '203' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/203.pdf',
        '204' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/204.pdf',
        '205' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/205.pdf',
        '206' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/206.pdf',
        '207' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/207.pdf',
        '208' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/208.pdf',
        '209' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/209.pdf',
        '210' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/210.pdf',
        '211' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/211.pdf',
        '212' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/212.pdf',
        '213' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/213.pdf',
        '214' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/214.pdf',
        '215' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/215.pdf',
        '216' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/216.pdf',
        '222' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/222.pdf',
        '223' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/223.pdf',
        '224' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/224.pdf',
        '225' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/225.pdf',
        '228' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/228.pdf',
        '229' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/229.pdf',
        '230' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/230.pdf',
        '231' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/231.pdf',
        '232' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/232.pdf',
        '233' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/233.pdf',
        '235' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/235.pdf',
        '236' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/236.pdf',
        '237' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/237.pdf',
        '238' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/238.pdf',
        '242' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/242.pdf',
        '243' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/243.pdf',
        '244' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/244.pdf',
        '245' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/245.pdf',
        '246' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/246.pdf',
        '247' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/247.pdf',
        '248' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/248.pdf',
        '249' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/249.pdf',
        '285' => 'https://www.nios.ac.in/media/documents/Course_Bifurcation_2023/10th/285.pdf',
        // 12th class (Senior Secondary)
        '301' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/301Bifurcation_new.pdf',
        '302' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/302Bifurcation_new.pdf',
        '303' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/303Bifurcation.pdf',
        '304' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/304Bifurcation.pdf',
        '305' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/305Bifurcation.pdf',
        '306' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/306Bifurcation.pdf',
        '307' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/307Bifurcation.pdf',
        '309' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/309Bifurcation.pdf',
        '310' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/310Bifurcation.pdf',
        '311' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/311Bifurcation.pdf',
        '312' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/312Bifurcation.pdf',
        '313' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/313Bifurcation.pdf',
        '314' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/314Bifurcation.pdf',
        '315' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/315Bifurcation.pdf',
        '316' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/316Bifurcation_new.pdf',
        '317' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/317Bifurcation.pdf',
        '318' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/318Bifurcation.pdf',
        '319' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/319Bifurcation_new.pdf',
        '320' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/320Bifurcation.pdf',
        '321' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/321Bifurcation.pdf',
        '328' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/328Bifurcation_new.pdf',
        '330' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/330Bifurcation.pdf',
        '331' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/331Bifurcation.pdf',
        '332' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/332Bifurcation_new.pdf',
        '333' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/333Bifurcation.pdf',
        '335' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/335Bifurcation.pdf',
        '336' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/336Bifurcation.pdf',
        '337' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/337Bifurcation.pdf',
        '338' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/338Bifurcation.pdf',
        '339' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/339Bifurcation.pdf',
        '341' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/341Bifurcation.pdf',
        '342' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/342Bifurcation.pdf',
        '343' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/343Bifurcation.pdf',
        '344' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/344Bifurcation.pdf',
        '345' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/345Bifurcation.pdf',
        '346' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/346Bifurcation.pdf',
        '347' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/347Bifurcation.pdf',
        '348' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/348Bifurcation.pdf',
        '373' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/373Bifurcation.pdf',
        '374' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/374Bifurcation.pdf',
        '375' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/375Bifurcation.pdf',
        '376' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/376Bifurcation.pdf',
        '383' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/383Bifurcation.pdf',
        '385' => 'https://nios.ac.in/media/documents/Course_Bifurcation_2023/12th/385Bifurcation.pdf',
    ];

    if (!isset($map[$code])) {
        abort(404);
    }

    $url = $map[$code];
    $filename = "syllabus-{$code}.pdf";

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
    ]);
    $content = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($content === false || $httpCode !== 200) {
        abort(500, 'Could not download syllabus file.');
    }

    return response($content, 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        'Content-Length' => strlen($content),
    ]);
})->name('syllabus.download');

require __DIR__.'/auth.php';
