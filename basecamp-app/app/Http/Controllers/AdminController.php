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
        $pendingAdmissions = Admission::where('status', 'Pending')->count();
        $digitalProducts = \App\Models\Product::count();
        $recentAdmissions = Admission::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('studentCount', 'pendingAdmissions', 'digitalProducts', 'recentAdmissions'));
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
        return view('admin.enroll');
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
}
