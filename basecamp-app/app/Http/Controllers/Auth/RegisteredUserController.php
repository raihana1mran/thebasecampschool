<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $enrollmentNumber = 'TBC-' . date('Y') . '-' . strtoupper(Str::random(6));

        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'enrollment_number' => $enrollmentNumber,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Determine which course was selected from the admissions page
        $courseApplied = $request->input('course', null);
        $courseLabel   = null;
        if ($courseApplied === '10th' || $courseApplied === 'Secondary') {
            $courseLabel = 'Secondary (Class 10) — ₹5,500';
        } elseif ($courseApplied === '12th' || $courseApplied === 'Senior Secondary') {
            $courseLabel = 'Sr. Secondary (Class 12) — ₹6,500';
        } elseif ($courseApplied) {
            $courseLabel = $courseApplied;
        }

        // Auto-create a pending admission application with a reference number
        $referenceNumber = 'REF-' . date('Y') . '-' . strtoupper(Str::random(6));

        Admission::create([
            'user_id'                => $user->id,
            'course_type'            => $courseLabel ?? 'Not specified',
            'full_name'              => $user->name,
            'father_name'            => '',
            'mother_name'            => '',
            'gender'                 => '',
            'date_of_birth'          => null,
            'aadhaar_number'         => '',
            'address'                => '',
            'previous_qualification' => '',
            'mobile_number'          => '',
            'email'                  => $user->email,
            'documents'              => [],
            'reference_number'       => $referenceNumber,
            'status'                 => 'Pending',
        ]);

        // Redirect to success page with key info in session flash
        return redirect()->route('registration.success')
            ->with('reference_number',  $referenceNumber)
            ->with('enrollment_number', $enrollmentNumber)
            ->with('course_applied',    $courseLabel);
    }
}
