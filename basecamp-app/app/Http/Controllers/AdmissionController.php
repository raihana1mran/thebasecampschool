<?php

namespace App\Http\Controllers;

use App\Mail\EnrollmentCredentials;
use App\Models\Admission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AdmissionController extends Controller
{
    public function submitAdmission(Request $request)
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
            'email' => 'required|string|email',
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

        $user = $request->user();

        // Check if the user already has an approved admission
        $approvedAdmission = Admission::where('user_id', $user->id)
            ->where('status', 'Approved')
            ->first();

        if ($approvedAdmission) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You already have an approved admission application',
                ], 400);
            }
            return back()->with('error', 'You already have an approved admission application');
        }

        $admission = Admission::where('user_id', $user->id)->first();

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

        // If updating, preserve existing documents unless new ones are uploaded
        if ($admission && is_array($admission->documents)) {
            $documents = array_merge($documents, $admission->documents);
        }

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

        if ($admission) {
            $admission->update([
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
                'status' => 'Pending',
            ]);
        } else {
            $admission = Admission::create([
                'user_id' => $user->id,
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
                'reference_number' => 'REF-' . date('Y') . '-' . strtoupper(\Illuminate\Support\Str::random(6)),
                'status' => 'Pending',
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $admission,
            ], 201);
        }
        
        return back()->with('success', 'Your admission application has been submitted successfully and is pending review. Your Reference Number is: ' . $admission->reference_number);
    }

    public function getMyAdmissions(Request $request)
    {
        $admissions = Admission::where('user_id', $request->user()->id)->get();

        return response()->json([
            'success' => true,
            'count' => $admissions->count(),
            'data' => $admissions,
        ]);
    }

    public function getAdmissions()
    {
        $admissions = Admission::with('user:id,name,email')->get();

        return response()->json([
            'success' => true,
            'count' => $admissions->count(),
            'data' => $admissions,
        ]);
    }

    public function updateAdmissionStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected,Document Error,Need to Pay Fees',
        ]);

        $admission = Admission::find($id);

        if (!$admission) {
            return response()->json([
                'success' => false,
                'message' => 'Admission not found'
            ], 404);
        }

        $admission->status = $request->status;
        $admission->save();

        // When approved, generate enrollment number & password for the student user
        if ($request->status === 'Approved' && $admission->user) {
            $user = $admission->user;
            if (!$user->enrollment_number) {
                $user->enrollment_number = 'TBC-' . date('Y') . '-' . strtoupper(\Illuminate\Support\Str::random(6));
            }
            $temporaryPassword = \Illuminate\Support\Str::random(8);
            $user->password = \Illuminate\Support\Facades\Hash::make($temporaryPassword);
            $user->save();

            Mail::to($user->email)->send(new EnrollmentCredentials($user, $temporaryPassword));

            return response()->json([
                'success' => true,
                'data' => $admission,
                'credentials' => [
                    'enrollment_number' => $user->enrollment_number,
                    'password' => $temporaryPassword,
                ]
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $admission,
        ]);
    }

    public function checkStatus(Request $request)
    {
        $request->validate([
            'reference_number' => 'required|string',
        ]);

        $admission = Admission::where('reference_number', $request->reference_number)->first();

        if (!$admission) {
            return back()->with('error', 'No admission found with that Reference Number.');
        }

        $messages = \App\Models\BroadcastMessage::where('audience', $admission->email)
            ->where('created_at', '>=', \Carbon\Carbon::now()->subDays(7))
            ->latest()->get();

        return back()->with('status_result', [
            'full_name' => $admission->full_name,
            'course_type' => $admission->course_type,
            'status' => $admission->status,
            'reference_number' => $admission->reference_number,
            'email' => $admission->email,
            'messages' => $messages,
        ]);
    }
}
