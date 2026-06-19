<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admission;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $studentCount = User::where('role', 'student')->count();
        $activeStudents = User::where('role', 'student')
            ->whereNotNull('first_login_at')
            ->whereHas('admissions', fn($q) => $q->where('status', 'Approved'))
            ->count();
        $pendingAdmissions = Admission::where('status', 'Pending')->count();
        $approvedAdmissions = Admission::where('status', 'Approved')->count();
        $rejectedAdmissions = Admission::where('status', 'Rejected')->count();
        $digitalProducts = \App\Models\Product::count();
        $totalRevenue = \App\Models\Payment::where('status', 'Success')->sum('amount');
        $pendingTma = \App\Models\TmaSubmission::where('status', 'submitted')->count();
        $upcomingPcp = 0;
        $upcomingExams = 0;

        $recentAdmissions = Admission::with('user')
            ->orderBy('created_at', 'desc')->take(5)->get();

        $newEnrollments = Admission::with('user')
            ->orderBy('created_at', 'desc')->take(10)->get();

        $activeStudentsList = User::where('role', 'student')
            ->whereNotNull('first_login_at')
            ->whereHas('admissions', fn($q) => $q->where('status', 'Approved'))
            ->with(['admissions' => fn($q) => $q->where('status', 'Approved')->latest()])
            ->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'studentCount', 'activeStudents', 'pendingAdmissions', 'approvedAdmissions',
            'rejectedAdmissions', 'digitalProducts', 'recentAdmissions', 'newEnrollments',
            'activeStudentsList', 'totalRevenue', 'pendingTma', 'upcomingPcp', 'upcomingExams'
        ));
    }

    public function stats()
    {
        $studentCount = User::where('role', 'student')->count();
        $pendingAdmissions = Admission::where('status', 'Pending')->count();

        return response()->json([
            'success' => true,
            'data' => [
                'studentCount' => $studentCount,
                'pendingAdmissions' => $pendingAdmissions,
            ]
        ]);
    }

    public function studentsView()
    {
        $students = User::where('role', 'student')
            ->with(['admissions', 'tmaSubmissions.product'])
            ->latest()->get();
        $pendingCount = \App\Models\Admission::where('status', 'Pending')->count();
        $recentAdmissions = \App\Models\Admission::latest()->take(5)->get();
        $allTmas = \App\Models\Product::where('category', 'tma')->latest()->get();
        return view('admin.students', compact('students', 'pendingCount', 'recentAdmissions', 'allTmas'));
    }

    public function updateEnrollmentNumber(Request $request, $userId)
    {
        $validated = $request->validate([
            'enrollment_number' => 'required|string|max:100',
        ]);

        $student = User::where('role', 'student')->findOrFail($userId);

        // Check uniqueness (ignore self)
        $exists = User::where('enrollment_number', $validated['enrollment_number'])
            ->where('id', '!=', $userId)->exists();
        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Enrollment number already in use.'], 422);
        }

        $student->update(['enrollment_number' => $validated['enrollment_number']]);

        return response()->json(['success' => true, 'message' => 'Enrollment number updated.']);
    }

    public function updateTmaMarks(Request $request, $submissionId)
    {
        $validated = $request->validate([
            'tma_marks'       => 'nullable|integer|min:0|max:100',
            'practical_marks' => 'nullable|integer|min:0|max:50',
            'admin_remarks'   => 'nullable|string|max:500',
        ]);

        $submission = \App\Models\TmaSubmission::findOrFail($submissionId);
        $submission->update(array_merge($validated, ['status' => 'graded']));

        return response()->json(['success' => true, 'message' => 'Marks saved successfully.']);
    }

    public function admissionsView()
    {
        $admissions = Admission::with('user')->latest()->get();
        $pendingCount = Admission::where('status', 'Pending')->count();
        $todayCount = Admission::whereDate('created_at', \Carbon\Carbon::today())->count();
        return view('admin.admissions', compact('admissions', 'pendingCount', 'todayCount'));
    }

    public function productsView()
    {
        $products = \App\Models\Product::latest()->get();
        return view('admin.products', compact('products'));
    }

    public function mocktestsView()
    {
        $mockTests = \App\Models\MockTest::latest()->get();
        return view('admin.mocktests', compact('mockTests'));
    }

    public function settingsView()
    {
        return view('admin.settings');
    }

    public function students()
    {
        $students = User::where('role', 'student')
            ->select('name', 'email', 'created_at')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $students->count(),
            'data' => $students
        ]);
    }

    public function message(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string',
            'message' => 'required|string',
            'audience' => 'required|string',
        ]);

        \App\Models\BroadcastMessage::create([
            'audience' => $validated['audience'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);

        return response()->json([
            'success' => true,
            'message' => "Message broadcasted successfully to {$validated['audience']}"
        ]);
    }

    public function sendStudentMessage(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        \App\Models\BroadcastMessage::create([
            'audience' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);

        return response()->json(['success' => true, 'message' => 'Message sent.']);
    }

    public function createStudent(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'student',
        ]);

        return redirect()->back()->with('success', 'Student added successfully.');
    }

    public function paymentsView()
    {
        $payments = \App\Models\Payment::with('user')->latest()->get();
        $totalRevenue = \App\Models\Payment::where('status', 'Success')->sum('amount');
        $paymentsCount = \App\Models\Payment::count();
        return view('admin.payments', compact('payments', 'totalRevenue', 'paymentsCount'));
    }

    public function referralsView()
    {
        $referrals = \App\Models\Referral::with(['referrer', 'referredUser'])->latest()->get();
        $referralsCount = \App\Models\Referral::count();
        $successfulCount = \App\Models\Referral::where('status', 'Successful')->count();
        return view('admin.referrals', compact('referrals', 'referralsCount', 'successfulCount'));
    }

    public function showEnrollmentForm()
    {
        return view('admin.enroll', ['errorStep' => old('_errorStep', 1)]);
    }

    public function submitEnrollmentForm(Request $request)
    {
        $validated = $request->validate([
            'courseType' => 'required|in:10th,12th,Secondary,Senior Secondary,Vocational',
            'fullName' => 'required|string|max:255',
            'fatherName' => 'required|string|max:255',
            'motherName' => 'required|string|max:255',
            'gender' => 'required|string',
            'dateOfBirth' => 'required|date',
            'aadhaarNumber' => 'required|string',
            'address' => 'required|string',
            'previousQualification' => 'required|string',
            'mobileNumber' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'photo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'signature' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'idProof' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'previousMarksheet' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'state' => 'required|string',
            'identityType' => 'required|string',
            'socialCategory' => 'required|string',
            'selectedSubjects' => 'nullable|array',
            'addressProof' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'categoryCertificate' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'studyCentreCountry' => 'required|string|max:255',
            'studyCentreState' => 'required|string|max:255',
            'studyCentreDistrict' => 'required|string|max:255',
            'studyCentre' => 'required|string|max:255',
        ]);

        // Create student user
        $enrollmentNumber = 'TBC-' . date('Y') . '-' . strtoupper(\Illuminate\Support\Str::random(6));
        $temporaryPassword = \Illuminate\Support\Str::random(8);

        $student = User::create([
            'name'              => $validated['fullName'],
            'email'             => $validated['email'],
            'password'          => \Illuminate\Support\Facades\Hash::make($temporaryPassword),
            'enrollment_number' => $enrollmentNumber,
            'role'              => 'student',
        ]);

        $documents = [
            'photo' => '',
            'signature' => '',
            'idProof' => '',
            'addressProof' => '',
            'previousMarksheet' => '',
            'categoryCertificate' => '',
            'state' => $validated['state'] ?? '',
            'identityType' => $validated['identityType'] ?? '',
            'socialCategory' => $validated['socialCategory'] ?? '',
            'selectedSubjects' => $validated['selectedSubjects'] ?? [],
            'studyCentreCountry' => $validated['studyCentreCountry'] ?? '',
            'studyCentreState' => $validated['studyCentreState'] ?? '',
            'studyCentreDistrict' => $validated['studyCentreDistrict'] ?? '',
            'studyCentre' => $validated['studyCentre'] ?? '',
        ];

        // Handle file uploads
        if ($request->hasFile('photo')) {
            $documents['photo'] = $request->file('photo')->store('admissions/photos', 'public');
        }
        if ($request->hasFile('signature')) {
            $documents['signature'] = $request->file('signature')->store('admissions/signatures', 'public');
        }
        if ($request->hasFile('idProof')) {
            $documents['idProof'] = $request->file('idProof')->store('admissions/id_proofs', 'public');
        }
        if ($request->hasFile('addressProof')) {
            $documents['addressProof'] = $request->file('addressProof')->store('admissions/address_proofs', 'public');
        }
        if ($request->hasFile('previousMarksheet')) {
            $documents['previousMarksheet'] = $request->file('previousMarksheet')->store('admissions/marksheets', 'public');
        }
        if ($request->hasFile('categoryCertificate')) {
            $documents['categoryCertificate'] = $request->file('categoryCertificate')->store('admissions/category_certificates', 'public');
        }

        $referenceNumber = 'REF-' . date('Y') . '-' . strtoupper(\Illuminate\Support\Str::random(6));

        Admission::create([
            'user_id' => $student->id,
            'course_type' => $validated['courseType'],
            'full_name' => $validated['fullName'],
            'father_name' => $validated['fatherName'],
            'mother_name' => $validated['motherName'],
            'gender' => $validated['gender'],
            'date_of_birth' => $validated['dateOfBirth'],
            'aadhaar_number' => $validated['aadhaarNumber'],
            'address' => $validated['address'],
            'previous_qualification' => $validated['previousQualification'],
            'mobile_number' => $validated['mobileNumber'],
            'email' => $validated['email'],
            'documents' => $documents,
            'reference_number' => $referenceNumber,
            'status' => 'Approved', // Auto-approve because admin created it!
        ]);

        return redirect()->route('admin.admissions')->with('success', "Student registered successfully. Enrollment No: {$enrollmentNumber}, Temporary Password: {$temporaryPassword}");
    }

    // ========== Dashboard Action Handlers ==========

    public function verifyDocument(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|exists:admissions,id',
            'document'     => 'required|string',
            'action'       => 'required|in:approve,reject',
        ]);

        $admission = Admission::findOrFail($validated['admission_id']);
        $docs = $admission->documents ?? [];
        $statusKey = $validated['document'] . '_status';
        $docs[$statusKey] = $validated['action'] === 'approve' ? 'Approved' : 'Rejected';
        $admission->documents = $docs;
        $admission->save();

        return response()->json(['success' => true, 'message' => 'Document ' . ($validated['action'] === 'approve' ? 'approved' : 'rejected') . '.']);
    }

    public function requestReupload(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|exists:admissions,id',
            'documents'    => 'required|array',
        ]);

        $admission = Admission::findOrFail($validated['admission_id']);
        $admission->status = 'Document Error';
        $admission->save();

        \App\Models\BroadcastMessage::create([
            'audience' => $admission->email,
            'subject'  => 'Document Re-upload Required',
            'message'  => 'Please re-upload the following documents: ' . implode(', ', $validated['documents']),
        ]);

        return response()->json(['success' => true, 'message' => 'Re-upload requested. Student notified.']);
    }

    public function uploadTma(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'deadline'  => 'required|date',
            'file'      => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $fileUrls = [];
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('tma_uploads', 'public');
            $fileUrls[] = $path;
        }

        \App\Models\Product::create([
            'title'      => $validated['title'],
            'category'   => 'tma',
            'file_urls'  => $fileUrls,
            'price'      => 0,
            'deadline'   => $validated['deadline'],
        ]);

        return response()->json(['success' => true, 'message' => 'TMA assignment uploaded.']);
    }

    public function downloadInvoices(Request $request)
    {
        $payments = \App\Models\Payment::where('status', 'Success')->get();
        // Generate a simple CSV of payments
        $csv = "ID,Student,Amount,Date\n";
        foreach ($payments as $p) {
            $csv .= "{$p->id},{$p->user?->name},{$p->amount},{$p->created_at->format('Y-m-d')}\n";
        }
        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="invoices.csv"',
        ]);
    }

    public function postExamNotification(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        \App\Models\BroadcastMessage::create([
            'audience' => 'all',
            'subject'  => $validated['title'],
            'message'  => $validated['message'],
        ]);

        return response()->json(['success' => true, 'message' => 'Exam notification sent to all students.']);
    }

    public function uploadHallTicket(Request $request)
    {
        $validated = $request->validate([
            'exam_name' => 'required|string|max:255',
            'file'      => 'required|file|mimes:pdf|max:20480',
        ]);

        $path = $request->file('file')->store('hall_tickets', 'public');

        \App\Models\BroadcastMessage::create([
            'audience' => 'active',
            'subject'  => 'Hall Ticket: ' . $validated['exam_name'],
            'message'  => 'Hall ticket for ' . $validated['exam_name'] . ' is now available. Download from the student portal.',
        ]);

        return response()->json(['success' => true, 'message' => 'Hall ticket uploaded and students notified.']);
    }

    public function createPcpSchedule(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'date'         => 'required|date',
            'study_center' => 'required|string|max:255',
        ]);

        \App\Models\BroadcastMessage::create([
            'audience' => 'active',
            'subject'  => 'PCP Scheduled: ' . $validated['title'],
            'message'  => 'PCP program "' . $validated['title'] . '" scheduled on ' . $validated['date'] . ' at ' . $validated['study_center'] . '.',
        ]);

        return response()->json(['success' => true, 'message' => 'PCP schedule created and students notified.']);
    }

    public function uploadStudyMaterial(Request $request)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'level'    => 'required|in:secondary,senior_secondary',
            'subject'  => 'required|string|max:255',
            'file'     => 'required|file|mimes:pdf|max:51200',
        ]);

        $path = $request->file('file')->store('study_materials/' . $validated['level'], 'public');

        \App\Models\Product::create([
            'title'     => $validated['title'],
            'category'  => 'pdf',
            'price'     => 0,
            'file_urls' => [$path],
        ]);

        return response()->json(['success' => true, 'message' => 'Study material uploaded.']);
    }

    public function publishResult(Request $request)
    {
        $validated = $request->validate([
            'exam_name' => 'required|string|max:255',
            'link'      => 'required|url',
        ]);

        \App\Models\BroadcastMessage::create([
            'audience' => 'all',
            'subject'  => 'Result Published: ' . $validated['exam_name'],
            'message'  => 'Results for ' . $validated['exam_name'] . ' are now available. Check your result at: ' . $validated['link'],
        ]);

        return response()->json(['success' => true, 'message' => 'Result published and students notified.']);
    }

    public function generateEligibleList(Request $request)
    {
        $students = User::where('role', 'student')
            ->whereHas('admissions', fn($q) => $q->where('status', 'Approved'))
            ->get();

        $csv = "Name,Email,Enrollment Number\n";
        foreach ($students as $s) {
            $csv .= "{$s->name},{$s->email},{$s->enrollment_number}\n";
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="eligible-students.csv"',
        ]);
    }

    public function generateAdmissionReport(Request $request)
    {
        $admissions = Admission::all();
        $csv = "ID,Name,Email,Course,Status,Date\n";
        foreach ($admissions as $a) {
            $csv .= "{$a->id},{$a->full_name},{$a->email},{$a->course_type},{$a->status},{$a->created_at->format('Y-m-d')}\n";
        }
        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="admission-report.csv"',
        ]);
    }

    public function generateRevenueReport(Request $request)
    {
        $payments = \App\Models\Payment::with('user')->where('status', 'Success')->get();
        $csv = "ID,Student,Amount,Type,Date\n";
        foreach ($payments as $p) {
            $csv .= "{$p->id},{$p->user?->name},{$p->amount},{$p->type},{$p->created_at->format('Y-m-d')}\n";
        }
        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="revenue-report.csv"',
        ]);
    }
}
