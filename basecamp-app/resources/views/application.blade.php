<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Enrollment | The Basecamp School</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "tertiary-fixed": "#80b2ff",
                    "surface-bright": "#f2f7f9",
                    "on-secondary-fixed-variant": "#005f6b",
                    "tertiary-fixed-dim": "#65a4ff",
                    "surface": "#f2f7f9",
                    "primary": "#006479",
                    "outline-variant": "#a8aeb0",
                    "surface-container-lowest": "#ffffff",
                    "on-secondary": "#d8f8ff",
                    "inverse-on-surface": "#989ea0",
                    "on-primary-fixed": "#002a34",
                    "surface-container-high": "#dce4e6",
                    "tertiary": "#005bae",
                    "tertiary-container": "#80b2ff",
                    "secondary-fixed-dim": "#88d8e7",
                    "surface-dim": "#cdd6d9",
                    "surface-container-low": "#ecf2f4",
                    "surface-container-highest": "#d6dee1",
                    "surface-tint": "#006479",
                    "primary-fixed": "#40cef3",
                    "on-error": "#ffefee",
                    "on-surface-variant": "#575c5e",
                    "on-primary": "#e0f6ff",
                    "inverse-primary": "#40cef3",
                    "inverse-surface": "#0a0f11",
                    "secondary-dim": "#005863",
                    "secondary-fixed": "#96e6f6",
                    "secondary-container": "#96e6f6",
                    "on-tertiary": "#eff2ff",
                    "on-tertiary-fixed-variant": "#003971",
                    "tertiary-dim": "#004f98",
                    "error-dim": "#9f0519",
                    "primary-dim": "#00576a",
                    "surface-container": "#e3e9ec",
                    "on-tertiary-container": "#003061",
                    "on-secondary-container": "#005560",
                    "on-primary-fixed-variant": "#004a5a",
                    "on-primary-container": "#00414f",
                    "on-tertiary-fixed": "#001835",
                    "primary-container": "#40cef3",
                    "on-error-container": "#570008",
                    "primary-fixed-dim": "#28c0e4",
                    "on-surface": "#2a3031",
                    "outline": "#72787a",
                    "secondary": "#006572",
                    "error-container": "#fb5151",
                    "error": "#b31b25",
                    "on-secondary-fixed": "#004049",
                    "background": "#f2f7f9",
                    "surface-variant": "#d6dee1"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "1.5rem",
                    "full": "9999px"
            },
            "fontFamily": {
                    "headline": ["Space Grotesk"],
                    "display": ["Space Grotesk"],
                    "body": ["Space Grotesk"],
                    "label": ["Space Grotesk"]
            }
          },
        },
      }
    </script>
<style>
        body { font-family: 'Space Grotesk', sans-serif; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .signature-gradient {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
        }
        .ghost-border {
            border: 1px solid rgba(168, 174, 176, 0.15);
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-surface text-on-surface min-h-screen flex flex-col selection:bg-primary-container selection:text-on-primary-container">
<!-- Background Decorative Blobs -->
<div class="fixed inset-0 overflow-hidden -z-10 pointer-events-none">
<div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-primary-container/20 rounded-full blur-[120px]"></div>
<div class="absolute top-[40%] -right-[5%] w-[30%] h-[30%] bg-tertiary-container/10 rounded-full blur-[100px]"></div>
<div class="absolute -bottom-[10%] left-[20%] w-[50%] h-[50%] bg-secondary-fixed/15 rounded-full blur-[150px]"></div>
</div>

@include('components.header-nav')

<!-- Main Content Canvas -->
<main class="flex-grow pt-24 pb-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
@php
    $existingAdmission = \App\Models\Admission::where('user_id', auth()->id())->first();
    
    // Automatically redirect back-ended errors to the correct step tab
    $errorStep = 1;
    if ($errors->has('courseType') || $errors->has('state') || $errors->has('identityType') || $errors->has('aadhaarNumber')) $errorStep = 1;
    elseif ($errors->has('fullName') || $errors->has('fatherName') || $errors->has('motherName') || $errors->has('gender') || $errors->has('dateOfBirth') || $errors->has('email') || $errors->has('mobileNumber') || $errors->has('address') || $errors->has('socialCategory')) $errorStep = 2;
    elseif ($errors->has('previousQualification') || $errors->has('selectedSubjects')) $errorStep = 3;
    elseif ($errors->has('photo') || $errors->has('signature') || $errors->has('idProof') || $errors->has('addressProof') || $errors->has('previousMarksheet') || $errors->has('categoryCertificate')) $errorStep = 4;
@endphp

@if($existingAdmission)
    <!-- If application already exists, display status summary -->
    <header class="mb-12 text-center md:text-left">
        <span class="label-md uppercase tracking-[0.2em] text-primary font-bold mb-2 block font-sans">Enrollment Status</span>
        <h1 class="text-[clamp(2rem,5vw,3.75rem)] font-bold tracking-tighter text-on-surface mb-4">Registration Locked</h1>
    </header>
    
    <div class="glass-panel p-10 rounded-2xl border border-outline-variant/20 shadow-md text-center max-w-2xl mx-auto">
        <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mb-6 mx-auto text-primary">
            <span class="material-symbols-outlined text-4xl">verified_user</span>
        </div>
        <h3 class="text-2xl font-bold text-on-surface mb-2">Application Already Submitted</h3>
        <p class="text-on-surface-variant font-medium mb-6">
            Your admission application is currently <span class="font-bold text-primary">{{ $existingAdmission->status }}</span>. We are processing your documents. You can track this verification progress in the dashboard panel.
        </p>
        <div class="flex gap-4 justify-center">
            <a href="/dashboard" class="px-6 py-3 rounded-xl bg-primary text-white font-bold hover:bg-primary/95 transition-all shadow-md">Go to Dashboard</a>
            <a href="/contact" class="px-6 py-3 rounded-xl border border-outline-variant/30 font-bold bg-white text-on-surface hover:bg-slate-50 transition-all">Support Live Chat</a>
        </div>
    </div>
@else
    <!-- Page Header -->
    <header class="mb-12 text-center md:text-left">
        <span class="label-md uppercase tracking-[0.2em] text-primary font-bold mb-2 block font-sans">Registration Portal</span>
        <h1 class="text-[clamp(2rem,5vw,3.75rem)] font-bold tracking-tighter text-on-surface mb-4">Enrollment for 2026</h1>
        <p class="text-on-surface-variant text-lg max-w-2xl leading-relaxed">Secure your place at the frontier of academic excellence. Please complete the streamlined registration wizard below.</p>
    </header>

    @if ($errors->any())
        <div class="mb-8 p-6 bg-error-container/10 border border-error/20 rounded-2xl text-error">
            <h4 class="font-bold text-sm mb-2 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">warning</span>
                Registration Form Validation Failed
            </h4>
            <ul class="list-disc list-inside text-xs font-semibold space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div x-data="{
        activeStep: {{ $errors->any() ? $errorStep : 1 }},
        courseType: '{{ old('courseType', 'Secondary') }}',
        fullName: '{{ old('fullName', auth()->user()->name ?? '') }}',
        aadhaarNumber: '{{ old('aadhaarNumber', '123456789012') }}',
        dateOfBirth: '{{ old('dateOfBirth', '2005-01-01') }}',
        email: '{{ old('email', auth()->user()->email ?? '') }}',
        mobileNumber: '{{ old('mobileNumber', '9876543210') }}',
        fatherName: '{{ old('fatherName', 'Robert Doe') }}',
        motherName: '{{ old('motherName', 'Jane Doe') }}',
        gender: '{{ old('gender', 'Male') }}',
        address: '{{ old('address', '') }}',
        previousQualification: '{{ old('previousQualification', '') }}',
        state: '{{ old('state', 'Delhi') }}',
        identityType: '{{ old('identityType', 'Aadhaar') }}',
        socialCategory: '{{ old('socialCategory', 'General') }}',
        medium: '{{ old('medium', 'English') }}',
        country: '{{ old('studyCentreCountry', 'India') }}',
        studyCentreState: '{{ old('studyCentreState', '') }}',
        studyCentreDistrict: '{{ old('studyCentreDistrict', '') }}',
        studyCentre: '{{ old('studyCentre', '') }}',
        showStep3Errors: false,
        locationsData: {
            'India': {
                'Delhi': {
                    'Central Delhi': [
                        'Accredited Institution 101 - Connaught Place Center',
                        'Central Delhi Academic Hub'
                    ],
                    'New Delhi': [
                        'Accredited Institution 102 - Basecamp Centre, Chanakyapuri'
                    ],
                    'South Delhi': [
                        'South Delhi Learning Point, Saket',
                        'Accredited Institution 108 - Nehru Place Academy'
                    ],
                    'North Delhi': [
                        'Accredited Institution 103 - Rohini Learning Hub',
                        'GTB Nagar Academic Hub'
                    ]
                },
                'Uttar Pradesh': {
                    'Gautam Buddha Nagar': [
                        'UP Regional Centre 201 - Noida Sector 62',
                        'Noida Academic Heights'
                    ],
                    'Ghaziabad': [
                        'Ghaziabad Open Learning Point, Indirapuram',
                        'Vasundhara Academic Centre'
                    ],
                    'Lucknow': [
                        'Lucknow Academic Academy, Hazratganj',
                        'Aliganj Study Circle'
                    ],
                    'Kanpur': [
                        'Kanpur Learning Centre, Civil Lines'
                    ]
                },
                'Maharashtra': {
                    'Mumbai': [
                        'Mumbai Academic Circle, Andheri',
                        'South Mumbai Education Hub'
                    ],
                    'Pune': [
                        'Pune Learning Hub, Kothrud',
                        'Hinjewadi Education Center'
                    ],
                    'Nagpur': [
                        'Nagpur Study Hub, Dharampeth'
                    ]
                },
                'Karnataka': {
                    'Bengaluru Urban': [
                        'Bengaluru Tech Academy, Koramangala',
                        'Indiranagar Learning Center'
                    ],
                    'Mysuru': [
                        'Mysuru Learning Hub, Gokulam'
                    ]
                }
            },
            'Nepal': {
                'Bagmati': {
                    'Kathmandu': [
                        'Kathmandu Central Academy',
                        'Lalitpur Study Hub'
                    ]
                }
            }
        },
        get availableStates() {
            if (!this.country) return [];
            return Object.keys(this.locationsData[this.country] || {});
        },
        get availableDistricts() {
            if (!this.country || !this.studyCentreState) return [];
            const stateData = this.locationsData[this.country]?.[this.studyCentreState];
            if (stateData) return Object.keys(stateData);
            return ['District 1', 'District 2'];
        },
        get availableStudyCentres() {
            if (!this.country || !this.studyCentreState || !this.studyCentreDistrict) return [];
            const stateData = this.locationsData[this.country]?.[this.studyCentreState];
            if (stateData && stateData[this.studyCentreDistrict]) {
                return stateData[this.studyCentreDistrict];
            }
            return [
                `Basecamp Centre - ${this.studyCentreDistrict} Hub`,
                `Accredited Institution - ${this.studyCentreDistrict} Point`
            ];
        },

        // Address splitting
        permStreet: '{{ old('permStreet', '123 Basecamp Lane') }}',
        permCity: '{{ old('permCity', 'New Delhi') }}',
        permState: '{{ old('permState', 'Delhi') }}',
        permPincode: '{{ old('permPincode', '110001') }}',
        permDistrict: '{{ old('permDistrict', 'Central Delhi') }}',
        corrSameAsPerm: true,
        corrStreet: '{{ old('corrStreet', '') }}',
        corrCity: '{{ old('corrCity', '') }}',
        corrState: '{{ old('corrState', 'Delhi') }}',
        corrPincode: '{{ old('corrPincode', '') }}',
        corrDistrict: '{{ old('corrDistrict', '') }}',

        // Previous school coordinates
        prevClass: '{{ old('prevClass', 'Class 8th') }}',
        prevBoard: '{{ old('prevBoard', 'CBSE') }}',
        prevYear: '{{ old('prevYear', '2025') }}',
        prevRoll: '{{ old('prevRoll', '12345678') }}',

        // File states
        photoName: '',
        signatureName: '',
        idProofName: '',
        addressProofName: '',
        marksheetName: '',
        categoryCertName: '',
        
        declarationChecked: false,
        selectedSubjects: [],
        get availableCoreSubjects() {
            if (this.prevClass === 'Class 8th') {
                return ['Mathematics (211)', 'Science & Technology (212)', 'Social Science (213)', 'Economics (214)', 'Business Studies (215)', 'Home Science (216)', 'Psychology (222)', 'Indian Culture & Heritage (223)', 'Accountancy (224)', 'Painting (225)', 'Data Entry Operations (229)', 'Hindustani Music (242)', 'Carnatic Sangeet (243)'];
            } else {
                return ['Mathematics (311)', 'Physics (312)', 'Chemistry (313)', 'Biology (314)', 'Environmental Science (333)', 'Computer Science (330)', 'History (315)', 'Geography (316)', 'Political Science (317)', 'Economics (318)', 'Business Studies (319)', 'Accountancy (320)', 'Home Science (321)', 'Psychology (328)', 'Sociology (331)', 'Mass Communication (335)', 'Data Entry Operations (336)', 'Tourism (337)', 'Painting (332)'];
            }
        },
        get availableElectiveSubjects() {
            if (this.prevClass === 'Class 8th') {
                return ['Hindi (201)', 'English (202)', 'Bengali (203)', 'Marathi (204)', 'Telugu (205)', 'Urdu (206)', 'Gujarati (207)', 'Kannada (208)', 'Sanskrit (209)', 'Punjabi (210)', 'Assamese (228)', 'Nepali (231)', 'Malayalam (232)', 'Odia (233)', 'Arabic (235)', 'Persian (236)', 'Tamil (237)', 'Sindhi (238)'];
            } else {
                return ['Hindi (301)', 'English (302)', 'Bengali (303)', 'Tamil (304)', 'Odia (305)', 'Urdu (306)', 'Gujarati (307)', 'Sanskrit (309)', 'Punjabi (310)'];
            }
        },

        // OTP Simulation
        otpSent: false,
        otpVerified: false,
        otpCode: '',
        otpLoading: false,
        otpError: false,
        countdown: 30,
        countdownInterval: null,

        init() {
            this.$watch('prevClass', (val, oldVal) => {
                if (oldVal !== undefined) this.selectedSubjects = [];
                this.updatePrevQualification();
            });
            this.$watch('prevBoard', () => this.updatePrevQualification());
            this.$watch('prevYear', () => this.updatePrevQualification());
            this.$watch('prevRoll', () => this.updatePrevQualification());
            this.updatePrevQualification();
            
            // Watch for address changes to build combined string
            const updateAddress = () => {
                let permStr = `Permanent: ${this.permStreet || ''}, ${this.permCity || ''}, ${this.permState || ''} - ${this.permPincode || ''} (District: ${this.permDistrict || ''})`;
                let corrStr = '';
                if (this.corrSameAsPerm) {
                    corrStr = permStr.replace('Permanent:', 'Correspondence:');
                } else {
                    corrStr = `Correspondence: ${this.corrStreet || ''}, ${this.corrCity || ''}, ${this.corrState || ''} - ${this.corrPincode || ''} (District: ${this.corrDistrict || ''})`;
                }
                this.address = `${permStr} | ${corrStr}`;
            };
            this.$watch('permStreet', updateAddress);
            this.$watch('permCity', updateAddress);
            this.$watch('permState', updateAddress);
            this.$watch('permPincode', updateAddress);
            this.$watch('permDistrict', updateAddress);
            this.$watch('corrSameAsPerm', updateAddress);
            this.$watch('corrStreet', updateAddress);
            this.$watch('corrCity', updateAddress);
            this.$watch('corrState', updateAddress);
            this.$watch('corrPincode', updateAddress);
            this.$watch('corrDistrict', updateAddress);
            updateAddress();

            // Default studyCentreState to Step 1 state selection if empty
            if (this.state && !this.studyCentreState) {
                this.studyCentreState = this.state;
            }
            this.$watch('state', (val) => {
                this.studyCentreState = val;
            });

            // Reset child selection when parent changes
            this.$watch('country', () => {
                this.studyCentreState = '';
                this.studyCentreDistrict = '';
                this.studyCentre = '';
            });
            this.$watch('studyCentreState', () => {
                this.studyCentreDistrict = '';
                this.studyCentre = '';
            });
            this.$watch('studyCentreDistrict', () => {
                this.studyCentre = '';
            });
        },
        updatePrevQualification() {
            if (this.prevClass || this.prevBoard || this.prevYear || this.prevRoll) {
                this.previousQualification = `${this.prevClass} | Board: ${this.prevBoard} | Year: ${this.prevYear} | Roll: ${this.prevRoll}`;
            } else {
                this.previousQualification = '';
            }
        },

        get identityPlaceholder() {
            if (this.identityType === 'Aadhaar') return 'Enter 12-digit Aadhaar Number (e.g. 123456789012)';
            if (this.identityType === 'Passport') return 'Enter Passport Number (e.g. Z1234567)';
            if (this.identityType === 'Voter ID') return 'Enter Voter ID (e.g. ABC1234567)';
            return 'Enter Document Identification Number';
        },
        get isIdentityValid() {
            if (!this.aadhaarNumber) return false;
            if (this.identityType === 'Aadhaar') return /^\d{12}$/.test(this.aadhaarNumber);
            if (this.identityType === 'Passport') return /^[A-Z][0-9]{7}$/i.test(this.aadhaarNumber);
            if (this.identityType === 'Voter ID') return /^[A-Z]{3}[0-9]{7}$/i.test(this.aadhaarNumber);
            return this.aadhaarNumber.trim().length >= 4;
        },

        sendOTP() {
            if (!this.email || !this.mobileNumber) {
                alert('Please enter your email and mobile number first.');
                return;
            }
            this.otpLoading = true;
            this.otpError = false;
            setTimeout(() => {
                this.otpLoading = false;
                this.otpSent = true;
                this.otpCode = '123456';
                this.otpVerified = true;
            }, 500);
        },
        verifyOTP() {
            if (this.otpCode === '123456' || this.otpCode.length === 6) {
                this.otpLoading = true;
                this.otpError = false;
                setTimeout(() => {
                    this.otpLoading = false;
                    this.otpVerified = true;
                    clearInterval(this.countdownInterval);
                }, 1000);
            } else {
                this.otpError = true;
            }
        },

        validateStep1() {
            return this.state && this.identityType && this.isIdentityValid && this.courseType;
        },
        validateStep2() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phoneRegex = /^[0-9]{10}$/;
            const isAddressValid = this.permStreet && this.permCity && this.permPincode && this.permDistrict && 
                (this.corrSameAsPerm || (this.corrStreet && this.corrCity && this.corrPincode && this.corrDistrict));
            return this.fullName && this.gender && this.fatherName && this.motherName && this.dateOfBirth && 
                emailRegex.test(this.email) && phoneRegex.test(this.mobileNumber) && isAddressValid && 
                this.socialCategory && this.otpVerified;
        },
        get subjectValidation() {
            const total = this.selectedSubjects.length;
            const langCount = this.selectedSubjects.filter(sub => this.availableElectiveSubjects.includes(sub)).length;
            const isTotalValid = total >= 5 && total <= 7;
            const isLangValid = langCount >= 1 && langCount <= 2;
            return {
                total,
                langCount,
                isValid: isTotalValid && isLangValid,
                isTotalValid,
                isLangValid
            };
        },
        validateStep3() {
            return this.prevClass && this.prevBoard && this.prevYear && this.prevRoll && this.subjectValidation.isValid && this.country && this.studyCentreState && this.studyCentreDistrict && this.studyCentre;
        },

        goToStep(step) {
            if (step > 1 && !this.validateStep1()) {
                alert('Please fill in all mandatory fields in Step 1 first.');
                this.activeStep = 1;
                return;
            }
            if (step > 2 && !this.validateStep2()) {
                alert('Please fill in all mandatory fields and verify your contact details in Step 2 first.');
                this.activeStep = 2;
                return;
            }
            if (step > 3 && !this.validateStep3()) {
                this.showStep3Errors = true;
                alert('Please fill in all academic details, select subjects, and choose a study center in Step 3 first.');
                this.activeStep = 3;
                return;
            }
            this.activeStep = step;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }">
        <!-- Streamlined 5-Step Progress Bar -->
        <div class="glass-panel rounded-xl p-5 mb-12 grid grid-cols-2 md:grid-cols-5 gap-4">
            <!-- Step 1 -->
            <button type="button" @click="goToStep(1)" class="flex items-center gap-3 text-left outline-none">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 transition-all"
                     :class="activeStep === 1 ? 'signature-gradient text-white shadow-md' : (activeStep > 1 ? 'bg-primary/20 text-primary font-bold' : 'bg-surface-container-high text-on-surface-variant')">1</div>
                <div class="flex flex-col">
                    <span class="text-[9px] uppercase tracking-wider font-bold" :class="activeStep >= 1 ? 'text-primary' : 'text-on-surface-variant/50'">Step 01</span>
                    <span class="text-xs font-bold" :class="activeStep === 1 ? 'text-primary' : 'text-on-surface-variant'">Course Selection</span>
                </div>
            </button>
            <!-- Step 2 -->
            <button type="button" @click="goToStep(2)" class="flex items-center gap-3 text-left outline-none">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 transition-all"
                     :class="activeStep === 2 ? 'signature-gradient text-white shadow-md' : (activeStep > 2 ? 'bg-primary/20 text-primary font-bold' : 'bg-surface-container-high text-on-surface-variant')">2</div>
                <div class="flex flex-col">
                    <span class="text-[9px] uppercase tracking-wider font-bold" :class="activeStep >= 2 ? 'text-primary' : 'text-on-surface-variant/50'">Step 02</span>
                    <span class="text-xs font-bold" :class="activeStep === 2 ? 'text-primary' : 'text-on-surface-variant'">Basic Details</span>
                </div>
            </button>
            <!-- Step 3 -->
            <button type="button" @click="goToStep(3)" class="flex items-center gap-3 text-left outline-none">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 transition-all"
                     :class="activeStep === 3 ? 'signature-gradient text-white shadow-md' : (activeStep > 3 ? 'bg-primary/20 text-primary font-bold' : 'bg-surface-container-high text-on-surface-variant')">3</div>
                <div class="flex flex-col">
                    <span class="text-[9px] uppercase tracking-wider font-bold" :class="activeStep >= 3 ? 'text-primary' : 'text-on-surface-variant/50'">Step 03</span>
                    <span class="text-xs font-bold" :class="activeStep === 3 ? 'text-primary' : 'text-on-surface-variant'">Academic</span>
                </div>
            </button>
            <!-- Step 4 -->
            <button type="button" @click="goToStep(4)" class="flex items-center gap-3 text-left outline-none">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 transition-all"
                     :class="activeStep === 4 ? 'signature-gradient text-white shadow-md' : (activeStep > 4 ? 'bg-primary/20 text-primary font-bold' : 'bg-surface-container-high text-on-surface-variant')">4</div>
                <div class="flex flex-col">
                    <span class="text-[9px] uppercase tracking-wider font-bold" :class="activeStep >= 4 ? 'text-primary' : 'text-on-surface-variant/50'">Step 04</span>
                    <span class="text-xs font-bold" :class="activeStep === 4 ? 'text-primary' : 'text-on-surface-variant'">Uploads</span>
                </div>
            </button>
            <!-- Step 5 -->
            <button type="button" @click="goToStep(5)" class="flex items-center gap-3 text-left outline-none col-span-2 md:col-span-1">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 transition-all"
                     :class="activeStep === 5 ? 'signature-gradient text-white shadow-md' : 'bg-surface-container-high text-on-surface-variant'">5</div>
                <div class="flex flex-col">
                    <span class="text-[9px] uppercase tracking-wider font-bold" :class="activeStep >= 5 ? 'text-primary' : 'text-on-surface-variant/50'">Step 05</span>
                    <span class="text-xs font-bold" :class="activeStep === 5 ? 'text-primary' : 'text-on-surface-variant'">Review &amp; Pay</span>
                </div>
            </button>
        </div>

        <form method="POST" action="{{ route('admissions.submit') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Left Column: Forms -->
                <div class="lg:col-span-8 space-y-8 animate-fade-in">

                    <!-- STEP 1: INITIAL VALIDATION & COURSE SELECTION -->
                    <div x-show="activeStep === 1" class="space-y-6">
                        <section class="glass-panel rounded-xl p-8 shadow-sm">
                            <div class="flex items-center gap-3 mb-8">
                                <span class="material-symbols-outlined text-primary text-3xl">badge</span>
                                <h2 class="text-2xl font-bold tracking-tight">Identity Details</h2>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold uppercase tracking-wider text-on-surface-variant">Select State / UT</label>
                                    <select name="state" x-model="state" class="w-full bg-surface-container-low/50 border-none rounded-lg p-4 focus:ring-2 focus:ring-primary/50 transition-all font-semibold text-on-surface">
                                        <option value="Andhra Pradesh">Andhra Pradesh</option>
                                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                        <option value="Assam">Assam</option>
                                        <option value="Bihar">Bihar</option>
                                        <option value="Chhattisgarh">Chhattisgarh</option>
                                        <option value="Goa">Goa</option>
                                        <option value="Gujarat">Gujarat</option>
                                        <option value="Haryana">Haryana</option>
                                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                                        <option value="Jharkhand">Jharkhand</option>
                                        <option value="Karnataka">Karnataka</option>
                                        <option value="Kerala">Kerala</option>
                                        <option value="Madhya Pradesh">Madhya Pradesh</option>
                                        <option value="Maharashtra">Maharashtra</option>
                                        <option value="Manipur">Manipur</option>
                                        <option value="Meghalaya">Meghalaya</option>
                                        <option value="Mizoram">Mizoram</option>
                                        <option value="Nagaland">Nagaland</option>
                                        <option value="Odisha">Odisha</option>
                                        <option value="Punjab">Punjab</option>
                                        <option value="Rajasthan">Rajasthan</option>
                                        <option value="Sikkim">Sikkim</option>
                                        <option value="Tamil Nadu">Tamil Nadu</option>
                                        <option value="Telangana">Telangana</option>
                                        <option value="Tripura">Tripura</option>
                                        <option value="Uttarakhand">Uttarakhand</option>
                                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                                        <option value="West Bengal">West Bengal</option>
                                        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                        <option value="Chandigarh">Chandigarh</option>
                                        <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                        <option value="Delhi">Delhi</option>
                                        <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                        <option value="Ladakh">Ladakh</option>
                                        <option value="Lakshadweep">Lakshadweep</option>
                                        <option value="Puducherry">Puducherry</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold uppercase tracking-wider text-on-surface-variant">Identity Document Type</label>
                                    <select name="identityType" x-model="identityType" class="w-full bg-surface-container-low/50 border-none rounded-lg p-4 focus:ring-2 focus:ring-primary/50 transition-all font-semibold text-on-surface">
                                        <option value="Aadhaar">Aadhaar</option>
                                        <option value="Passport">Passport</option>
                                        <option value="Voter ID">Voter ID</option>
                                        <option value="Birth Certificate">Birth Certificate</option>
                                    </select>
                                </div>
                                <div class="space-y-2 md:col-span-2">
                                    <div class="flex justify-between items-center">
                                        <label class="text-sm font-bold uppercase tracking-wider text-on-surface-variant">Identity Number</label>
                                        <span x-show="aadhaarNumber" class="flex items-center gap-1 text-xs" :class="isIdentityValid ? 'text-green-600' : 'text-red-500'">
                                            <span class="material-symbols-outlined text-sm" x-text="isIdentityValid ? 'check_circle' : 'error'"></span>
                                            <span x-text="isIdentityValid ? 'Format Validated' : 'Invalid Format'"></span>
                                        </span>
                                    </div>
                                    <input name="aadhaarNumber" x-model="aadhaarNumber" class="w-full bg-surface-container-low/50 border border-outline-variant/20 rounded-lg p-4 focus:ring-2 focus:ring-primary/50 transition-all font-bold text-on-surface" :placeholder="identityPlaceholder" type="text"/>
                                    @error('aadhaarNumber') <p class="text-xs text-error font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </section>

                        <section class="glass-panel rounded-xl p-8 shadow-sm">
                            <div class="flex items-center gap-3 mb-8">
                                <span class="material-symbols-outlined text-primary text-3xl">school</span>
                                <h2 class="text-2xl font-bold tracking-tight">Course Selection</h2>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold uppercase tracking-wider text-on-surface-variant">Course Applying For</label>
                                <select name="courseType" x-model="courseType" class="w-full bg-surface-container-low/50 border-none rounded-lg p-4 focus:ring-2 focus:ring-primary/50 transition-all font-semibold text-on-surface">
                                    <option value="Secondary">Secondary (Class 10th)</option>
                                    <option value="Senior Secondary">Senior Secondary (Class 12th)</option>
                                    <option value="Vocational">Vocational Course</option>
                                </select>
                            </div>
                            @error('courseType') <p class="text-xs text-error font-bold mt-2">{{ $message }}</p> @enderror
                        </section>

                        <div class="flex justify-end pt-4">
                            <button type="button" @click="goToStep(2)" class="px-6 py-3 rounded-xl signature-gradient text-white font-bold hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2 relative z-50 cursor-pointer">
                                Continue
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 2: BASIC & PERSONAL DETAILS -->
                    <div x-show="activeStep === 2" class="space-y-6" style="display: none;">
                        <section class="glass-panel rounded-xl p-8 shadow-sm">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="material-symbols-outlined text-primary text-3xl">account_circle</span>
                                <h2 class="text-2xl font-bold tracking-tight">Basic &amp; Personal Identity</h2>
                            </div>
                            
                            <!-- Birth Certificate Verification Notice -->
                            <div class="mb-8 p-4 bg-[#40cef3]/10 border border-[#40cef3]/25 rounded-2xl flex items-start gap-3">
                                <span class="material-symbols-outlined text-[#006479] shrink-0 mt-0.5">info</span>
                                <div>
                                    <h4 class="text-xs font-bold text-[#006479]">Verification Notice</h4>
                                    <p class="text-[11px] text-slate-600 mt-0.5 leading-relaxed">
                                        Please ensure your Full Legal Name, Father's Name, Mother's Name, Gender, and Date of Birth are filled in exactly <strong>as per your Birth Certificate</strong>. Mismatches will result in document verification failure.
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold uppercase tracking-wider text-on-surface-variant">Full Legal Name (as per Birth Certificate)</label>
                                    <input name="fullName" x-model="fullName" class="w-full bg-surface-container-low/50 border border-outline-variant/20 rounded-lg p-4 focus:ring-2 focus:ring-primary/50 transition-all font-semibold text-on-surface" placeholder="e.g. Johnathan Doe" type="text"/>
                                    @error('fullName') <p class="text-xs text-error font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold uppercase tracking-wider text-on-surface-variant">Gender (as per Birth Certificate)</label>
                                    <div class="flex items-center gap-6 py-3.5 px-4 bg-surface-container-low/50 rounded-lg">
                                        <label class="flex items-center gap-2 cursor-pointer font-semibold text-sm">
                                            <input type="radio" name="gender" value="Male" x-model="gender" class="text-primary focus:ring-primary"/> Male
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer font-semibold text-sm">
                                            <input type="radio" name="gender" value="Female" x-model="gender" class="text-primary focus:ring-primary"/> Female
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer font-semibold text-sm">
                                            <input type="radio" name="gender" value="Other" x-model="gender" class="text-primary focus:ring-primary"/> Other
                                        </label>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold uppercase tracking-wider text-on-surface-variant">Father's Name (as per Birth Certificate)</label>
                                    <input name="fatherName" x-model="fatherName" class="w-full bg-surface-container-low/50 border border-outline-variant/20 rounded-lg p-4 focus:ring-2 focus:ring-primary/50 transition-all font-semibold text-on-surface" placeholder="Father's Legal Name" type="text"/>
                                    @error('fatherName') <p class="text-xs text-error font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold uppercase tracking-wider text-on-surface-variant">Mother's Name (as per Birth Certificate)</label>
                                    <input name="motherName" x-model="motherName" class="w-full bg-surface-container-low/50 border border-outline-variant/20 rounded-lg p-4 focus:ring-2 focus:ring-primary/50 transition-all font-semibold text-on-surface" placeholder="Mother's Legal Name" type="text"/>
                                    @error('motherName') <p class="text-xs text-error font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold uppercase tracking-wider text-on-surface-variant">Date of Birth (as per Birth Certificate)</label>
                                    <input name="dateOfBirth" x-model="dateOfBirth" class="w-full bg-surface-container-low/50 border border-outline-variant/20 rounded-lg p-4 focus:ring-2 focus:ring-primary/50 transition-all font-semibold text-on-surface" type="date"/>
                                    @error('dateOfBirth') <p class="text-xs text-error font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold uppercase tracking-wider text-on-surface-variant">Category / Social Status</label>
                                    <select name="socialCategory" x-model="socialCategory" class="w-full bg-surface-container-low/50 border-none rounded-lg p-4 focus:ring-2 focus:ring-primary/50 transition-all font-semibold text-on-surface">
                                        <option value="General">General</option>
                                        <option value="OBC">OBC</option>
                                        <option value="SC">SC</option>
                                        <option value="ST">ST</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold uppercase tracking-wider text-on-surface-variant">Email Address</label>
                                    <input name="email" x-model="email" class="w-full bg-surface-container-low/50 border border-outline-variant/20 rounded-lg p-4 focus:ring-2 focus:ring-primary/50 transition-all font-semibold text-on-surface" placeholder="john@example.com" type="email"/>
                                    @error('email') <p class="text-xs text-error font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold uppercase tracking-wider text-on-surface-variant">Contact Mobile Number</label>
                                    <input name="mobileNumber" x-model="mobileNumber" class="w-full bg-surface-container-low/50 border border-outline-variant/20 rounded-lg p-4 focus:ring-2 focus:ring-primary/50 transition-all font-semibold text-on-surface" placeholder="e.g. 9876543210" type="tel"/>
                                    @error('mobileNumber') <p class="text-xs text-error font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                
                                <!-- Contact Verification OTP Simulation -->
                                <div class="col-span-1 md:col-span-2 p-6 bg-primary-container/10 border border-primary-container/20 rounded-2xl space-y-4">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-primary">verified_user</span>
                                        <h4 class="font-bold text-sm text-primary">Contact OTP Verification</h4>
                                    </div>
                                    <p class="text-xs text-on-surface-variant leading-relaxed">
                                        verification of your mobile number and email address is required to receive official updates. Use OTP <strong>123456</strong> for testing.
                                    </p>
                                    
                                    <div class="flex flex-wrap items-center gap-4">
                                        <!-- Verify Button -->
                                        <button type="button" @click="sendOTP()" x-show="!otpSent && !otpVerified" class="px-5 py-2.5 rounded-xl signature-gradient text-white text-xs font-bold hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2">
                                            <span class="material-symbols-outlined text-sm">sms</span>
                                            Send Verification OTP
                                        </button>
                                        
                                        <!-- Verification input -->
                                        <div x-show="otpSent && !otpVerified" class="flex flex-wrap items-center gap-3 w-full">
                                            <div class="relative flex-1 min-w-[200px]">
                                                <input type="text" x-model="otpCode" maxlength="6" class="w-full bg-white border border-outline-variant/30 rounded-lg px-4 py-2 text-xs font-bold text-center tracking-[0.5em] focus:ring-2 focus:ring-primary/20 outline-none placeholder:tracking-normal" placeholder="Enter 6-digit OTP"/>
                                            </div>
                                            <button type="button" @click="verifyOTP()" class="px-5 py-2.5 rounded-lg bg-primary hover:bg-primary/95 text-white text-xs font-bold flex items-center gap-2">
                                                Verify Code
                                            </button>
                                            <button type="button" @click="sendOTP()" :disabled="countdown > 0" :class="countdown > 0 ? 'opacity-50 cursor-not-allowed text-outline' : 'text-primary hover:underline'" class="text-xs font-bold">
                                                Resend <span x-show="countdown > 0" x-text="'(' + countdown + 's)'"></span>
                                            </button>
                                        </div>
                                        
                                        <!-- Verified Status -->
                                        <div x-show="otpVerified" class="flex items-center gap-2 text-green-600 bg-green-50 px-4 py-2 rounded-xl border border-green-200 w-full">
                                            <span class="material-symbols-outlined text-lg">check_circle</span>
                                            <span class="text-xs font-bold">Mobile &amp; Email Verified Successfully via OTP!</span>
                                        </div>
                                    </div>
                                    
                                    <!-- OTP Error / Feedback -->
                                    <p x-show="otpError" class="text-xs text-error font-bold mt-1">Invalid OTP code. Please enter the 6-digit code sent (e.g. 123456).</p>
                                    <p x-show="otpLoading" class="text-xs text-primary font-bold animate-pulse mt-1">Processing...</p>
                                </div>

                                <!-- Permanent Address Grid -->
                                <div class="col-span-1 md:col-span-2 space-y-4 pt-4 border-t border-outline-variant/10">
                                    <h4 class="text-sm font-bold text-primary">Permanent Address</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="md:col-span-2 space-y-2">
                                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Street Address</label>
                                            <input type="text" x-model="permStreet" class="w-full bg-surface-container-low/50 border border-outline-variant/20 rounded-lg p-3 text-xs font-semibold text-on-surface focus:ring-2 focus:ring-primary/50" placeholder="Flat, House no., Building, Street"/>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">City</label>
                                            <input type="text" x-model="permCity" class="w-full bg-surface-container-low/50 border border-outline-variant/20 rounded-lg p-3 text-xs font-semibold text-on-surface focus:ring-2 focus:ring-primary/50" placeholder="City"/>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">District</label>
                                            <input type="text" x-model="permDistrict" class="w-full bg-surface-container-low/50 border border-outline-variant/20 rounded-lg p-3 text-xs font-semibold text-on-surface focus:ring-2 focus:ring-primary/50" placeholder="District"/>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">State/UT</label>
                                            <input type="text" x-model="permState" class="w-full bg-surface-container-low/50 border border-outline-variant/20 rounded-lg p-3 text-xs font-semibold text-on-surface focus:ring-2 focus:ring-primary/50" placeholder="State"/>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Pincode</label>
                                            <input type="text" x-model="permPincode" maxlength="6" class="w-full bg-surface-container-low/50 border border-outline-variant/20 rounded-lg p-3 text-xs font-semibold text-on-surface focus:ring-2 focus:ring-primary/50" placeholder="6-digit Pincode"/>
                                        </div>
                                    </div>
                                </div>

                                <!-- Correspondence Same as Permanent Checkbox -->
                                <div class="col-span-1 md:col-span-2 flex items-center gap-2 pt-2">
                                    <input type="checkbox" x-model="corrSameAsPerm" id="corrSameAsPerm" class="rounded text-primary focus:ring-primary"/>
                                    <label for="corrSameAsPerm" class="text-xs font-bold text-on-surface-variant cursor-pointer select-none">Correspondence Address is same as Permanent Address</label>
                                </div>

                                <!-- Correspondence Address Grid -->
                                <div x-show="!corrSameAsPerm" class="col-span-1 md:col-span-2 space-y-4 pt-4 border-t border-outline-variant/10">
                                    <h4 class="text-sm font-bold text-primary">Correspondence Address</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="md:col-span-2 space-y-2">
                                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Street Address</label>
                                            <input type="text" x-model="corrStreet" class="w-full bg-surface-container-low/50 border border-outline-variant/20 rounded-lg p-3 text-xs font-semibold text-on-surface focus:ring-2 focus:ring-primary/50" placeholder="Flat, House no., Building, Street"/>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">City</label>
                                            <input type="text" x-model="corrCity" class="w-full bg-surface-container-low/50 border border-outline-variant/20 rounded-lg p-3 text-xs font-semibold text-on-surface focus:ring-2 focus:ring-primary/50" placeholder="City"/>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">District</label>
                                            <input type="text" x-model="corrDistrict" class="w-full bg-surface-container-low/50 border border-outline-variant/20 rounded-lg p-3 text-xs font-semibold text-on-surface focus:ring-2 focus:ring-primary/50" placeholder="District"/>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">State/UT</label>
                                            <input type="text" x-model="corrState" class="w-full bg-surface-container-low/50 border border-outline-variant/20 rounded-lg p-3 text-xs font-semibold text-on-surface focus:ring-2 focus:ring-primary/50" placeholder="State"/>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Pincode</label>
                                            <input type="text" x-model="corrPincode" maxlength="6" class="w-full bg-surface-container-low/50 border border-outline-variant/20 rounded-lg p-3 text-xs font-semibold text-on-surface focus:ring-2 focus:ring-primary/50" placeholder="6-digit Pincode"/>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="address" x-model="address"/>
                                <input type="hidden" name="studyCentreCountry" x-model="country"/>
                                <input type="hidden" name="studyCentreState" x-model="studyCentreState"/>
                                <input type="hidden" name="studyCentreDistrict" x-model="studyCentreDistrict"/>
                                <input type="hidden" name="studyCentre" x-model="studyCentre"/>
                            </div>
                        </section>

                        <div class="flex justify-between pt-4">
                            <button type="button" @click="activeStep = 1" class="px-6 py-3 rounded-xl border border-outline-variant/30 font-bold bg-white text-on-surface hover:bg-slate-50 transition-all flex items-center gap-2 relative z-50 cursor-pointer">
                                <span class="material-symbols-outlined text-sm">arrow_back</span>
                                Back
                            </button>
                            <button type="button" @click="goToStep(3)" class="px-6 py-3 rounded-xl signature-gradient text-white font-bold hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2 relative z-50 cursor-pointer">
                                Continue
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 3: ACADEMIC & SUBJECT SELECTION -->
                    <div x-show="activeStep === 3" class="space-y-6" style="display: none;">
                        <section class="glass-panel rounded-xl p-8 shadow-sm">
                            <div class="flex items-center gap-3 mb-8">
                                <span class="material-symbols-outlined text-primary text-3xl">menu_book</span>
                                <h2 class="text-2xl font-bold tracking-tight">Academic History &amp; Subject Selection</h2>
                            </div>
                            <div class="space-y-6">
                                <input type="hidden" name="previousQualification" x-model="previousQualification"/>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-surface-container-low/30 p-6 rounded-2xl border border-outline-variant/10">
                                    <div class="col-span-1 md:col-span-2">
                                        <h4 class="text-sm font-bold text-primary mb-2">Previous Qualification Details</h4>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Class Passed <span class="text-red-500">*</span></label>
                                        <select x-model="prevClass" class="w-full bg-white border border-outline-variant/20 rounded-lg p-3 text-xs font-semibold text-on-surface focus:ring-2 focus:ring-primary/50">
                                            <option value="Class 8th">Class 8th</option>
                                            <option value="Class 10th">Class 10th</option>
                                            <option value="Class 11th">Class 11th</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Board Name <span class="text-red-500">*</span></label>
                                        <input type="text" x-model="prevBoard" :class="showStep3Errors && !prevBoard ? 'border-red-500 focus:ring-red-500' : 'border-outline-variant/20 focus:ring-primary/50'" class="w-full bg-white border rounded-lg p-3 text-xs font-semibold text-on-surface focus:ring-2" placeholder="e.g. CBSE / State Board"/>
                                        <div x-show="showStep3Errors && !prevBoard" class="text-red-500 text-[10px] font-bold mt-1">Board name is required.</div>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Year of Passing <span class="text-red-500">*</span></label>
                                        <select x-model="prevYear" class="w-full bg-white border border-outline-variant/20 rounded-lg p-3 text-xs font-semibold text-on-surface focus:ring-2 focus:ring-primary/50">
                                            @for($y = 2026; $y >= 2010; $y--)
                                                <option value="{{ $y }}">{{ $y }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Roll Number <span class="text-red-500">*</span></label>
                                        <input type="text" x-model="prevRoll" :class="showStep3Errors && !prevRoll ? 'border-red-500 focus:ring-red-500' : 'border-outline-variant/20 focus:ring-primary/50'" class="w-full bg-white border rounded-lg p-3 text-xs font-bold text-on-surface focus:ring-2" placeholder="e.g. 10294812"/>
                                        <div x-show="showStep3Errors && !prevRoll" class="text-red-500 text-[10px] font-bold mt-1">Roll number is required.</div>
                                    </div>
                                </div>
                                @error('previousQualification') <p class="text-xs text-error font-bold mt-1">{{ $message }}</p> @enderror

                                <div class="space-y-4 pt-4 border-t border-outline-variant/10">
                                    <div class="flex justify-between items-baseline">
                                        <label class="text-sm font-bold uppercase tracking-wider text-on-surface-variant block">Subject Combination Selection (5 to 7 Subjects) <span class="text-red-500">*</span></label>
                                    </div>

                                    <!-- Enforced Rules Alert -->
                                    <div class="p-4 rounded-xl text-xs space-y-2 border" :class="subjectValidation.isValid ? 'bg-green-50 border-green-200 text-green-700' : (showStep3Errors ? 'bg-red-50 border-red-200 text-red-700' : 'bg-amber-50 border-amber-200 text-amber-700')">
                                        <div class="font-bold flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm" x-text="subjectValidation.isValid ? 'check_circle' : 'warning'"></span>
                                            Subject Combination Validation Rules:
                                        </div>
                                        <ul class="list-disc list-inside space-y-0.5 ml-2 font-medium">
                                            <li :class="subjectValidation.isTotalValid ? 'text-green-700 font-semibold' : (showStep3Errors ? 'text-red-700 font-bold' : 'text-amber-700')">
                                                Total Subjects Selected: <span class="font-bold" x-text="subjectValidation.total"></span> (Must be between 5 and 7)
                                            </li>
                                            <li :class="subjectValidation.isLangValid ? 'text-green-700 font-semibold' : (showStep3Errors ? 'text-red-700 font-bold' : 'text-amber-700')">
                                                Language Subjects Selected: <span class="font-bold" x-text="subjectValidation.langCount"></span> (Must be 1 or 2. Selected from Elective / Language Subjects list)
                                            </li>
                                        </ul>
                                    </div>
                                    
                                    <!-- Core Subjects Section -->
                                    <div class="space-y-2">
                                        <h5 class="text-xs font-extrabold tracking-wide uppercase text-primary mb-1">Core / Compulsory Subjects</h5>
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            <template x-for="(sub, index) in availableCoreSubjects" :key="'core-'+index">
                                                <label class="flex items-center gap-3 bg-surface-container-low/40 p-4 rounded-xl border border-outline-variant/10 cursor-pointer hover:bg-surface-container-low/80 transition-all">
                                                    <input type="checkbox" :value="sub" x-model="selectedSubjects" class="rounded text-primary focus:ring-primary"/>
                                                    <span class="text-sm font-bold text-on-surface leading-tight" x-text="sub"></span>
                                                </label>
                                            </template>
                                        </div>
                                    </div>

                                    <!-- Electives Section -->
                                    <div class="space-y-2 pt-2">
                                        <h5 class="text-xs font-extrabold tracking-wide uppercase text-primary mb-1">Elective / Language Subjects</h5>
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            <template x-for="(sub, index) in availableElectiveSubjects" :key="'elec-'+index">
                                                <label class="flex items-center gap-3 bg-surface-container-low/40 p-4 rounded-xl border border-outline-variant/10 cursor-pointer hover:bg-surface-container-low/80 transition-all">
                                                    <input type="checkbox" :value="sub" x-model="selectedSubjects" class="rounded text-primary focus:ring-primary"/>
                                                    <span class="text-sm font-bold text-on-surface leading-tight" x-text="sub"></span>
                                                </label>
                                            </template>
                                        </div>
                                    </div>
                                    
                                    <!-- Hidden Inputs to bind dynamic subject selection for backend submission -->
                                    <template x-for="(sub, index) in selectedSubjects" :key="index">
                                        <input type="hidden" name="selectedSubjects[]" :value="sub"/>
                                    </template>
                                    @error('selectedSubjects') <p class="text-xs text-error font-bold mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Dynamic Nearby Study Center Location Chain -->
                                <div class="space-y-6 pt-6 border-t border-outline-variant/10">
                                    <h4 class="text-sm font-bold text-primary flex items-center gap-2">
                                        <span class="material-symbols-outlined text-lg">pin_drop</span>
                                        Select Nearby Study Center
                                    </h4>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-surface-container-low/30 p-6 rounded-2xl border border-outline-variant/10">
                                        <!-- Country Selection -->
                                        <div class="space-y-2">
                                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Country <span class="text-red-500">*</span></label>
                                            <div class="relative">
                                                <select name="studyCentreCountry" x-model="country" class="w-full bg-white border border-outline-variant/20 rounded-lg p-3 text-xs font-semibold text-on-surface focus:ring-2 focus:ring-primary/50 appearance-none cursor-pointer">
                                                    <option value="India">India</option>
                                                    <option value="Nepal">Nepal</option>
                                                </select>
                                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-on-surface-variant">
                                                    <span class="material-symbols-outlined text-sm">expand_more</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- State Selection -->
                                        <div class="space-y-2">
                                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">State / UT <span class="text-red-500">*</span></label>
                                            <div class="relative">
                                                <select name="studyCentreState" x-model="studyCentreState" :class="showStep3Errors && !studyCentreState ? 'border-red-500 focus:ring-red-500' : 'border-outline-variant/20 focus:ring-primary/50'" class="w-full bg-white border rounded-lg p-3 text-xs font-semibold text-on-surface focus:ring-2 appearance-none cursor-pointer">
                                                    <option value="">-- Select State --</option>
                                                    <template x-for="st in availableStates" :key="st">
                                                        <option :value="st" x-text="st" :selected="studyCentreState === st"></option>
                                                    </template>
                                                    <!-- Dynamic fallback options if selected state is not in Locations Map -->
                                                    <template x-if="!availableStates.includes(studyCentreState) && studyCentreState">
                                                        <option :value="studyCentreState" x-text="studyCentreState" selected></option>
                                                    </template>
                                                </select>
                                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-on-surface-variant">
                                                    <span class="material-symbols-outlined text-sm">expand_more</span>
                                                </div>
                                            </div>
                                            <div x-show="showStep3Errors && !studyCentreState" class="text-red-500 text-[10px] font-bold mt-1">State is required.</div>
                                        </div>

                                        <!-- District Selection -->
                                        <div class="space-y-2">
                                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">District <span class="text-red-500">*</span></label>
                                            <div class="relative">
                                                <select name="studyCentreDistrict" x-model="studyCentreDistrict" :class="showStep3Errors && !studyCentreDistrict ? 'border-red-500 focus:ring-red-500' : 'border-outline-variant/20 focus:ring-primary/50'" class="w-full bg-white border rounded-lg p-3 text-xs font-semibold text-on-surface focus:ring-2 appearance-none cursor-pointer">
                                                    <option value="">-- Select District --</option>
                                                    <template x-for="dist in availableDistricts" :key="dist">
                                                        <option :value="dist" x-text="dist" :selected="studyCentreDistrict === dist"></option>
                                                    </template>
                                                </select>
                                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-on-surface-variant">
                                                    <span class="material-symbols-outlined text-sm">expand_more</span>
                                                </div>
                                            </div>
                                            <div x-show="showStep3Errors && !studyCentreDistrict" class="text-red-500 text-[10px] font-bold mt-1">District is required.</div>
                                        </div>

                                        <!-- Study Center Selection -->
                                        <div class="space-y-2">
                                            <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Study Center <span class="text-red-500">*</span></label>
                                            <div class="relative">
                                                <select name="studyCentre" x-model="studyCentre" :class="showStep3Errors && !studyCentre ? 'border-red-500 focus:ring-red-500' : 'border-outline-variant/20 focus:ring-primary/50'" class="w-full bg-white border rounded-lg p-3 text-xs font-semibold text-on-surface focus:ring-2 appearance-none cursor-pointer">
                                                    <option value="">-- Select Study Center --</option>
                                                    <template x-for="centre in availableStudyCentres" :key="centre">
                                                        <option :value="centre" x-text="centre" :selected="studyCentre === centre"></option>
                                                    </template>
                                                </select>
                                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-on-surface-variant">
                                                    <span class="material-symbols-outlined text-sm">expand_more</span>
                                                </div>
                                            </div>
                                            <div x-show="showStep3Errors && !studyCentre" class="text-red-500 text-[10px] font-bold mt-1">Study Center is required.</div>
                                        </div>
                                    </div>

                                    <!-- Validation error message alert -->
                                    <div x-show="showStep3Errors && !validateStep3()" class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-xs font-bold flex items-center gap-2">
                                        <span class="material-symbols-outlined text-lg">error_outline</span>
                                        <span>Please fill in all mandatory fields (marked with *) and select a valid subject combination (5-7 subjects) to continue.</span>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <div class="flex justify-between pt-4">
                            <button type="button" @click="activeStep = 2" class="px-6 py-3 rounded-xl border border-outline-variant/30 font-bold bg-white text-on-surface hover:bg-slate-50 transition-all flex items-center gap-2 relative z-50 cursor-pointer">
                                <span class="material-symbols-outlined text-sm">arrow_back</span>
                                Back
                            </button>
                            <button type="button" @click="if (validateStep3()) { goToStep(4); } else { showStep3Errors = true; window.scrollTo({ top: 300, behavior: 'smooth' }); }" class="px-6 py-3 rounded-xl signature-gradient text-white font-bold hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2 relative z-50 cursor-pointer">
                                Continue
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 4: DOCUMENT UPLOAD PORTAL -->
                    <div x-show="activeStep === 4" class="space-y-6" style="display: none;">
                        <section class="glass-panel rounded-xl p-8 shadow-sm">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="material-symbols-outlined text-primary text-3xl">upload_file</span>
                                <h2 class="text-2xl font-bold tracking-tight">Credentials Upload</h2>
                            </div>
                            <p class="text-xs text-on-surface-variant font-medium mb-8">Supported file formats: PDF, JPEG, PNG. Max file size: 2MB.</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Photo Upload -->
                                <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-6 flex flex-col items-center justify-center text-center hover:bg-primary/5 hover:border-primary/50 transition-all cursor-pointer group relative min-h-[160px]">
                                    <input type="file" name="photo" class="absolute inset-0 opacity-0 cursor-pointer" @change="photoName = $event.target.files[0]?.name || ''" accept="image/*"/>
                                    <span class="material-symbols-outlined text-4xl text-outline-variant group-hover:text-primary mb-2">account_box</span>
                                    <span class="font-bold text-sm mb-1 text-on-surface">Recent Passport Size Photograph</span>
                                    <span class="text-xs text-on-surface-variant font-semibold" x-text="photoName ? 'Selected: ' + photoName : 'Upload Photo (Image format only)'"></span>
                                    @error('photo') <p class="text-xs text-error font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <!-- Signature Upload -->
                                <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-6 flex flex-col items-center justify-center text-center hover:bg-primary/5 hover:border-primary/50 transition-all cursor-pointer group relative min-h-[160px]">
                                    <input type="file" name="signature" class="absolute inset-0 opacity-0 cursor-pointer" @change="signatureName = $event.target.files[0]?.name || ''" accept="image/*"/>
                                    <span class="material-symbols-outlined text-4xl text-outline-variant group-hover:text-primary mb-2">draw</span>
                                    <span class="font-bold text-sm mb-1 text-on-surface">Signature Scan</span>
                                    <span class="text-xs text-on-surface-variant font-semibold" x-text="signatureName ? 'Selected: ' + signatureName : 'Upload Signature (Image format only)'"></span>
                                    @error('signature') <p class="text-xs text-error font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <!-- Identity Proof Upload -->
                                <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-6 flex flex-col items-center justify-center text-center hover:bg-primary/5 hover:border-primary/50 transition-all cursor-pointer group relative min-h-[160px]">
                                    <input type="file" name="idProof" class="absolute inset-0 opacity-0 cursor-pointer" @change="idProofName = $event.target.files[0]?.name || ''" accept="image/*,application/pdf"/>
                                    <span class="material-symbols-outlined text-4xl text-outline-variant group-hover:text-primary mb-2">fingerprint</span>
                                    <span class="font-bold text-sm mb-1 text-on-surface">Identity Proof</span>
                                    <span class="text-xs text-on-surface-variant font-semibold" x-text="idProofName ? 'Selected: ' + idProofName : 'Identity Document copy matching Step 1'"></span>
                                    @error('idProof') <p class="text-xs text-error font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <!-- Address Proof Upload -->
                                <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-6 flex flex-col items-center justify-center text-center hover:bg-primary/5 hover:border-primary/50 transition-all cursor-pointer group relative min-h-[160px]">
                                    <input type="file" name="addressProof" class="absolute inset-0 opacity-0 cursor-pointer" @change="addressProofName = $event.target.files[0]?.name || ''" accept="image/*,application/pdf"/>
                                    <span class="material-symbols-outlined text-4xl text-outline-variant group-hover:text-primary mb-2">home</span>
                                    <span class="font-bold text-sm mb-1 text-on-surface">Address Proof</span>
                                    <span class="text-xs text-on-surface-variant font-semibold" x-text="addressProofName ? 'Selected: ' + addressProofName : 'Aadhar / Utility Bill / Rent Agreement'"></span>
                                    @error('addressProof') <p class="text-xs text-error font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <!-- Marksheet Upload (Dependency based on courseType) -->
                                <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-6 flex flex-col items-center justify-center text-center hover:bg-primary/5 hover:border-primary/50 transition-all cursor-pointer group relative min-h-[160px]">
                                    <input type="file" name="previousMarksheet" class="absolute inset-0 opacity-0 cursor-pointer" @change="marksheetName = $event.target.files[0]?.name || ''" accept="image/*,application/pdf"/>
                                    <span class="material-symbols-outlined text-4xl text-outline-variant group-hover:text-primary mb-2">description</span>
                                    <span class="font-bold text-sm mb-1 text-on-surface" x-text="courseType === 'Secondary' ? 'Class 8th Marksheet / Self-Certificate' : 'Class 10th Marksheet'"></span>
                                    <span class="text-xs text-on-surface-variant font-semibold" x-text="marksheetName ? 'Selected: ' + marksheetName : 'Upload academic marksheet transcript'"></span>
                                    @error('previousMarksheet') <p class="text-xs text-error font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <!-- Category Certificate (Conditional) -->
                                <div x-show="socialCategory !== 'General'" class="border-2 border-dashed border-outline-variant/30 rounded-xl p-6 flex flex-col items-center justify-center text-center hover:bg-primary/5 hover:border-primary/50 transition-all cursor-pointer group relative min-h-[160px]" style="display: none;">
                                    <input type="file" name="categoryCertificate" class="absolute inset-0 opacity-0 cursor-pointer" @change="categoryCertName = $event.target.files[0]?.name || ''" accept="image/*,application/pdf"/>
                                    <span class="material-symbols-outlined text-4xl text-outline-variant group-hover:text-primary mb-2">assignment_ind</span>
                                    <span class="font-bold text-sm mb-1 text-on-surface">Category/Social Certificate</span>
                                    <span class="text-xs text-on-surface-variant font-semibold" x-text="categoryCertName ? 'Selected: ' + categoryCertName : 'SC / ST / OBC Certificate Copy'"></span>
                                    @error('categoryCertificate') <p class="text-xs text-error font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </section>

                        <div class="flex justify-between pt-4">
                            <button type="button" @click="activeStep = 3" class="px-6 py-3 rounded-xl border border-outline-variant/30 font-bold bg-white text-on-surface hover:bg-slate-50 transition-all flex items-center gap-2 relative z-50 cursor-pointer">
                                <span class="material-symbols-outlined text-sm">arrow_back</span>
                                Back
                            </button>
                            <button type="button" @click="goToStep(5)" class="px-6 py-3 rounded-xl signature-gradient text-white font-bold hover:scale-[1.02] active:scale-95 transition-transform flex items-center gap-2 relative z-50 cursor-pointer">
                                Continue
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 5: REVIEW & DECLARATION -->
                    <div x-show="activeStep === 5" class="space-y-6" style="display: none;">
                        <!-- Summary Card 1: Identity & Course -->
                        <section class="glass-panel rounded-xl p-6 shadow-sm border border-outline-variant/15 relative">
                            <button type="button" @click="activeStep = 1" class="absolute top-6 right-6 text-xs font-bold text-primary hover:underline flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">edit</span> Edit
                            </button>
                            <h3 class="text-lg font-bold text-primary mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">badge</span> State &amp; Identity Selection
                            </h3>
                            <div class="grid grid-cols-2 gap-4 text-xs font-semibold text-on-surface-variant">
                                <div>
                                    <p class="uppercase text-[9px] font-bold text-outline">State/UT</p>
                                    <p class="text-on-surface text-sm mt-1" x-text="state"></p>
                                </div>
                                <div>
                                    <p class="uppercase text-[9px] font-bold text-outline">Identity Document</p>
                                    <p class="text-on-surface text-sm mt-1" x-text="identityType + ' - ' + aadhaarNumber"></p>
                                </div>
                                <div>
                                    <p class="uppercase text-[9px] font-bold text-outline">Course Option</p>
                                    <p class="text-primary text-sm mt-1 font-bold" x-text="courseType === 'Secondary' ? 'Secondary (Class 10th)' : (courseType === 'Senior Secondary' ? 'Senior Secondary (Class 12th)' : 'Vocational Course')"></p>
                                </div>
                            </div>
                        </section>

                        <!-- Summary Card 2: Personal Details -->
                        <section class="glass-panel rounded-xl p-6 shadow-sm border border-outline-variant/15 relative">
                            <button type="button" @click="activeStep = 2" class="absolute top-6 right-6 text-xs font-bold text-primary hover:underline flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">edit</span> Edit
                            </button>
                            <h3 class="text-lg font-bold text-primary mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">person</span> Basic &amp; Personal Details
                            </h3>
                            <div class="grid grid-cols-2 gap-4 text-xs font-semibold text-on-surface-variant">
                                <div>
                                    <p class="uppercase text-[9px] font-bold text-outline">Applicant Legal Name</p>
                                    <p class="text-on-surface text-sm mt-1" x-text="fullName"></p>
                                </div>
                                <div>
                                    <p class="uppercase text-[9px] font-bold text-outline">Parents</p>
                                    <p class="text-on-surface text-sm mt-1" x-text="'Father: ' + fatherName + ' | Mother: ' + motherName"></p>
                                </div>
                                <div>
                                    <p class="uppercase text-[9px] font-bold text-outline">Gender / Social Status</p>
                                    <p class="text-on-surface text-sm mt-1" x-text="gender + ' (' + socialCategory + ')'"></p>
                                </div>
                                <div>
                                    <p class="uppercase text-[9px] font-bold text-outline">Contact Coordinates</p>
                                    <p class="text-on-surface text-sm mt-1" x-text="mobileNumber + ' | ' + email"></p>
                                </div>
                                <div class="col-span-2">
                                    <p class="uppercase text-[9px] font-bold text-outline">Permanent Address</p>
                                    <p class="text-on-surface text-sm mt-1" x-text="permStreet + ', ' + permCity + ', ' + permState + ' - ' + permPincode + ' (Dist: ' + permDistrict + ')'"></p>
                                </div>
                                <div class="col-span-2">
                                    <p class="uppercase text-[9px] font-bold text-outline">Correspondence Address</p>
                                    <p class="text-on-surface text-sm mt-1" x-text="corrSameAsPerm ? 'Same as Permanent Address' : (corrStreet + ', ' + corrCity + ', ' + corrState + ' - ' + corrPincode + ' (Dist: ' + corrDistrict + ')')"></p>
                                </div>
                            </div>
                        </section>

                        <!-- Summary Card 3: Academic History -->
                        <section class="glass-panel rounded-xl p-6 shadow-sm border border-outline-variant/15 relative">
                            <button type="button" @click="activeStep = 3" class="absolute top-6 right-6 text-xs font-bold text-primary hover:underline flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">edit</span> Edit
                            </button>
                            <h3 class="text-lg font-bold text-primary mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">school</span> Academic Preferences
                            </h3>
                            <div class="grid grid-cols-2 gap-4 text-xs font-semibold text-on-surface-variant">
                                <div class="col-span-2">
                                    <p class="uppercase text-[9px] font-bold text-outline">Eligibility Details</p>
                                    <p class="text-on-surface text-sm mt-1" x-text="previousQualification"></p>
                                </div>
                                <div class="col-span-2">
                                    <p class="uppercase text-[9px] font-bold text-outline">Selected Subjects</p>
                                    <p class="text-on-surface text-sm mt-1 font-bold" x-text="selectedSubjects.join(', ')"></p>
                                </div>
                                <div class="col-span-2">
                                    <p class="uppercase text-[9px] font-bold text-outline">Selected Study Center</p>
                                    <p class="text-on-surface text-sm mt-1 font-bold" x-text="studyCentre ? (country + ' > ' + studyCentreState + ' > ' + studyCentreDistrict + ' > ' + studyCentre) : 'None Selected'"></p>
                                </div>
                            </div>
                        </section>

                        <!-- Summary Card 4: Uploaded Files -->
                        <section class="glass-panel rounded-xl p-6 shadow-sm border border-outline-variant/15 relative">
                            <button type="button" @click="activeStep = 4" class="absolute top-6 right-6 text-xs font-bold text-primary hover:underline flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">edit</span> Edit
                            </button>
                            <h3 class="text-lg font-bold text-primary mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">description</span> Uploaded Documents
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs font-semibold text-on-surface-variant">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                                    <span>Photo: <span x-text="photoName || 'Not Selected'" :class="photoName ? 'text-primary font-bold' : 'text-red-500'"></span></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                                    <span>Signature: <span x-text="signatureName || 'Not Selected'" :class="signatureName ? 'text-primary font-bold' : 'text-red-500'"></span></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                                    <span>Identity Proof: <span x-text="idProofName || 'Not Selected'" :class="idProofName ? 'text-primary font-bold' : 'text-red-500'"></span></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                                    <span>Address Proof: <span x-text="addressProofName || 'Not Selected'" :class="addressProofName ? 'text-primary font-bold' : 'text-red-500'"></span></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                                    <span>Academic Marksheet: <span x-text="marksheetName || 'Not Selected'" :class="marksheetName ? 'text-primary font-bold' : 'text-red-500'"></span></span>
                                </div>
                                <div x-show="socialCategory !== 'General'" class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-lg">check_circle</span>
                                    <span>Category Certificate: <span x-text="categoryCertName || 'Not Selected'" :class="categoryCertName ? 'text-primary font-bold' : 'text-red-500'"></span></span>
                                </div>
                            </div>
                        </section>

                        <!-- Declaration and Locking -->
                        <section class="glass-panel rounded-xl p-8 shadow-sm">
                            <div class="flex items-start gap-4">
                                <input type="checkbox" x-model="declarationChecked" id="declaration_box" class="rounded text-primary focus:ring-primary mt-1"/>
                                <label for="declaration_box" class="text-xs text-on-surface-variant leading-relaxed font-semibold cursor-pointer select-none">
                                    I hereby declare that all the information provided in this admission enrollment application is true, complete and accurate to the best of my knowledge. I understand that any discrepancy found may result in rejection of my NIOS registration.
                                </label>
                            </div>
                        </section>

                        <div class="flex justify-start pt-4">
                            <button type="button" @click="activeStep = 4" class="px-6 py-3 rounded-xl border border-outline-variant/30 font-bold bg-white text-on-surface hover:bg-slate-50 transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">arrow_back</span>
                                Back
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Payment & Summary -->
                <div class="lg:col-span-4 space-y-8 sticky top-28">
                    <!-- Dynamic Payment Gateway -->
                    <section class="glass-panel rounded-xl overflow-hidden shadow-lg border border-white/40">
                        <div class="signature-gradient p-6 text-on-primary">
                            <h2 class="text-xl font-bold tracking-tight mb-1">Enrollment Summary</h2>
                            <p class="text-xs opacity-80 uppercase tracking-widest">Transaction Ref: BCS-2026-X11</p>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-on-surface-variant font-medium" x-text="courseType === 'Secondary' ? 'Tuition (Secondary)' : (courseType === 'Senior Secondary' ? 'Tuition (Senior Secondary)' : 'Tuition (Vocational)')"></span>
                                    <span class="font-bold text-on-surface" x-text="courseType === 'Secondary' ? '₹5,500.00' : (courseType === 'Senior Secondary' ? '₹6,500.00' : '₹7,000.00')"></span>
                                </div>
                                <div class="h-px bg-outline-variant/10 w-full"></div>
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-on-surface">Total Amount Due</span>
                                    <span class="text-2xl font-black text-primary" x-text="courseType === 'Secondary' ? '₹5,500.00' : (courseType === 'Senior Secondary' ? '₹6,500.00' : '₹7,000.00')"></span>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Payment Method</label>
                                <div class="grid grid-cols-3 gap-3">
                                    <button type="button" class="flex flex-col items-center justify-center p-3 rounded-lg bg-surface-container-low border border-primary/20">
                                        <span class="material-symbols-outlined text-primary mb-1">qr_code</span>
                                        <span class="text-[10px] font-bold">UPI</span>
                                    </button>
                                    <button type="button" class="flex flex-col items-center justify-center p-3 rounded-lg bg-white/40 ghost-border hover:bg-surface-container-low transition-all">
                                        <span class="material-symbols-outlined text-on-surface-variant mb-1">credit_card</span>
                                        <span class="text-[10px] font-bold">CARD</span>
                                    </button>
                                    <button type="button" class="flex flex-col items-center justify-center p-3 rounded-lg bg-white/40 ghost-border hover:bg-surface-container-low transition-all">
                                        <span class="material-symbols-outlined text-on-surface-variant mb-1">account_balance</span>
                                        <span class="text-[10px] font-bold">NET</span>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Submit Form Gateway -->
                            <button type="submit" :disabled="!declarationChecked || activeStep !== 5" :class="(!declarationChecked || activeStep !== 5) ? 'opacity-50 cursor-not-allowed' : 'hover:scale-[1.02] active:scale-95'" class="w-full signature-gradient text-on-primary py-4 rounded-xl font-bold text-lg shadow-xl shadow-primary/20 transition-all flex items-center justify-center gap-2">
                                Securely Pay &amp; Register
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </button>
                            <div class="flex items-center justify-center gap-2 text-[10px] text-on-surface-variant font-medium">
                                <span class="material-symbols-outlined text-xs">verified_user</span>
                                SSL ENCRYPTED 256-BIT SECURE TRANSACTION
                            </div>
                        </div>
                    </section>
                    
                    <!-- Help/Support Card -->
                    <div class="glass-panel rounded-xl p-6 ghost-border">
                        <h4 class="font-bold text-sm mb-2 text-on-surface">Need assistance?</h4>
                        <p class="text-xs text-on-surface-variant leading-relaxed mb-4">Our admissions counselors are available 24/7 to guide you through the process.</p>
                        <a class="text-xs font-bold text-primary flex items-center gap-1 hover:underline" href="/contact">
                            Live Chat Support
                            <span class="material-symbols-outlined text-xs">chevron_right</span>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endif
</main>

@include('layouts.footer')

</body>
</html>