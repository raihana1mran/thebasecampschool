<x-student-layout>
    @php
        $status = $statusResult['status'] ?? 'Unknown';
        $statusColor = match($status) {
            'Approved' => 'bg-green-100 text-green-800 border-green-200',
            'Pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'Rejected' => 'bg-red-100 text-red-800 border-red-200',
            'Document Error' => 'bg-orange-100 text-orange-800 border-orange-200',
            'Need to Pay Fees' => 'bg-purple-100 text-purple-800 border-purple-200',
            default => 'bg-slate-100 text-slate-800 border-slate-200',
        };
        $statusIcon = match($status) {
            'Approved' => 'check_circle',
            'Pending' => 'hourglass_empty',
            'Rejected' => 'cancel',
            'Document Error' => 'warning',
            'Need to Pay Fees' => 'payments',
            default => 'info',
        };
    @endphp

    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
    </style>

    <div class="max-w-2xl mx-auto py-8 sm:py-12 relative z-10">
        <!-- Status Card -->
        <div class="glass-panel rounded-2xl sm:rounded-3xl p-6 sm:p-10 shadow-sm border border-slate-200/60 text-center">
            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-cyan-50 flex items-center justify-center mx-auto mb-4 sm:mb-6">
                <span class="material-symbols-outlined text-3xl sm:text-4xl text-cyan-600" style="font-variation-settings:'FILL' 1;">policy</span>
            </div>

            <h1 class="text-xl sm:text-3xl font-bold tracking-tight text-slate-800 mb-2">Admission Status</h1>
            <p class="text-sm text-slate-500 mb-6 sm:mb-8">Track your enrollment progress</p>

            @if($statusResult)
            <div class="bg-white/80 rounded-2xl p-5 sm:p-6 border border-slate-100 shadow-sm mb-6 text-left">
                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                        <span class="text-sm text-slate-500">Applicant Name</span>
                        <span class="text-sm font-bold text-slate-800">{{ $statusResult['full_name'] }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                        <span class="text-sm text-slate-500">Course</span>
                        <span class="text-sm font-bold text-slate-800">{{ $statusResult['course_type'] }}</span>
                    </div>
                    @if($statusResult['reference_number'] ?? false)
                    <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                        <span class="text-sm text-slate-500">Reference No.</span>
                        <span class="text-sm font-mono font-bold text-slate-800">{{ $statusResult['reference_number'] }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center pt-1">
                        <span class="text-sm text-slate-500">Current Status</span>
                        <span class="text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider inline-flex items-center gap-1.5 {{ $statusColor }}">
                            <span class="material-symbols-outlined text-sm">{{ $statusIcon }}</span>
                            {{ $status }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Message / Next Steps -->
            <div class="bg-cyan-50/80 border border-cyan-100 rounded-2xl p-5 sm:p-6 text-left mb-6">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-cyan-600 shrink-0 mt-0.5">info</span>
                    <div>
                        <h3 class="font-bold text-sm text-cyan-900 mb-1">
                            @if($status === 'Approved' && !(Auth::user()->enrollment_number ?? false))
                                Enrollment Credentials Pending
                            @elseif($status === 'Approved')
                                Welcome Aboard!
                            @elseif($status === 'Document Error')
                                Action Required: Document Issue
                            @elseif($status === 'Need to Pay Fees')
                                Payment Required
                            @elseif($status === 'Rejected')
                                Application Not Approved
                            @else
                                Application Under Review
                            @endif
                        </h3>
                        <p class="text-xs sm:text-sm text-cyan-800 leading-relaxed">
                            @if($status === 'Approved' && !(Auth::user()->enrollment_number ?? false))
                                Your admission is approved! The administration will share your enrollment number and dashboard password via email shortly. Please check your registered email.
                            @elseif($status === 'Approved')
                                Your admission is fully approved and your enrollment is active. You can now access your student dashboard to view TMAs, resources, and more.
                            @elseif($status === 'Document Error')
                                There was an issue with your uploaded documents. Please visit the study center or contact support to rectify the documents.
                            @elseif($status === 'Need to Pay Fees')
                                Your admission requires fee payment. Please complete the payment to proceed with enrollment.
                            @elseif($status === 'Rejected')
                                Unfortunately, your application could not be approved at this time. Please contact the administration for further details.
                            @else
                                Your application is currently being reviewed by the administration. This typically takes 24-48 hours. You will be notified once the status is updated.
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            @else
            <div class="bg-amber-50/80 border border-amber-100 rounded-2xl p-5 sm:p-6 text-left mb-6">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-amber-600 shrink-0 mt-0.5">hourglass_empty</span>
                    <div>
                        <h3 class="font-bold text-sm text-amber-900 mb-1">No Application Found</h3>
                        <p class="text-xs sm:text-sm text-amber-800 leading-relaxed">
                            You haven't submitted an admission application yet. 
                            <a href="{{ route('application') }}" class="font-bold underline">Apply now</a> to get started.
                        </p>
                    </div>
                </div>
            </div>
            @endif

            @if($status === 'Approved' && (Auth::user()->enrollment_number ?? false))
            <a href="{{ url('/dashboard') }}" 
               class="inline-flex items-center gap-2 bg-gradient-to-r from-cyan-600 to-cyan-500 text-white px-6 py-3 rounded-xl font-bold text-sm shadow-lg shadow-cyan-500/25 hover:scale-[1.02] transition-all">
                <span class="material-symbols-outlined text-sm">dashboard</span>
                Go to Dashboard
            </a>
            @elseif(!$statusResult)
            <a href="{{ route('application') }}" 
               class="inline-flex items-center gap-2 bg-gradient-to-r from-cyan-600 to-cyan-500 text-white px-6 py-3 rounded-xl font-bold text-sm shadow-lg shadow-cyan-500/25 hover:scale-[1.02] transition-all">
                <span class="material-symbols-outlined text-sm">edit_document</span>
                Apply Now
            </a>
            @endif

            <div class="mt-6 text-center">
                <p class="text-xs text-slate-400">Need help? <a href="{{ url('/contact') }}" class="text-cyan-600 font-bold hover:underline">Contact Support</a></p>
            </div>
        </div>
    </div>
</x-student-layout>
