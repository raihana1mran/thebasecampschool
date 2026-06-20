<x-student-layout>
    @php
        $colorMap = [
            'cyan' => [
                'border' => 'border-t-cyan-500',
                'bg' => 'bg-cyan-50',
                'border_inner' => 'border-cyan-100',
                'text' => 'text-cyan-600',
                'text_dark' => 'text-cyan-700',
                'progress' => 'bg-cyan-500',
                'btn' => 'bg-cyan-600 hover:bg-cyan-700 shadow-cyan-600/20',
                'glow' => 'shadow-[0_0_8px_rgba(6,182,212,0.4)]',
                'hover_syllabus' => 'hover:bg-cyan-50 group-hover/btn:text-cyan-600'
            ],
            'emerald' => [
                'border' => 'border-t-emerald-500',
                'bg' => 'bg-emerald-50',
                'border_inner' => 'border-emerald-100',
                'text' => 'text-emerald-600',
                'text_dark' => 'text-emerald-700',
                'progress' => 'bg-emerald-500',
                'btn' => 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-600/20',
                'glow' => 'shadow-[0_0_8px_rgba(16,185,129,0.4)]',
                'hover_syllabus' => 'hover:bg-emerald-50 group-hover/btn:text-emerald-600'
            ],
            'indigo' => [
                'border' => 'border-t-indigo-500',
                'bg' => 'bg-indigo-50',
                'border_inner' => 'border-indigo-100',
                'text' => 'text-indigo-600',
                'text_dark' => 'text-indigo-700',
                'progress' => 'bg-indigo-500',
                'btn' => 'bg-indigo-600 hover:bg-indigo-700 shadow-indigo-600/20',
                'glow' => 'shadow-[0_0_8px_rgba(99,102,241,0.4)]',
                'hover_syllabus' => 'hover:bg-indigo-50 group-hover/btn:text-indigo-600'
            ],
            'purple' => [
                'border' => 'border-t-purple-500',
                'bg' => 'bg-purple-50',
                'border_inner' => 'border-purple-100',
                'text' => 'text-purple-600',
                'text_dark' => 'text-purple-700',
                'progress' => 'bg-purple-500',
                'btn' => 'bg-purple-600 hover:bg-purple-700 shadow-purple-600/20',
                'glow' => 'shadow-[0_0_8px_rgba(168,85,247,0.4)]',
                'hover_syllabus' => 'hover:bg-purple-50 group-hover/btn:text-purple-600'
            ],
            'amber' => [
                'border' => 'border-t-amber-500',
                'bg' => 'bg-amber-50',
                'border_inner' => 'border-amber-100',
                'text' => 'text-amber-600',
                'text_dark' => 'text-amber-700',
                'progress' => 'bg-amber-500',
                'btn' => 'bg-amber-500 hover:bg-amber-600 shadow-amber-500/20',
                'glow' => 'shadow-[0_0_8px_rgba(245,158,11,0.4)]',
                'hover_syllabus' => 'hover:bg-amber-50 group-hover/btn:text-amber-600'
            ],
            'rose' => [
                'border' => 'border-t-rose-500',
                'bg' => 'bg-rose-50',
                'border_inner' => 'border-rose-100',
                'text' => 'text-rose-600',
                'text_dark' => 'text-rose-700',
                'progress' => 'bg-rose-500',
                'btn' => 'bg-rose-500 hover:bg-rose-600 shadow-rose-500/20',
                'glow' => 'shadow-[0_0_8px_rgba(244,63,94,0.4)]',
                'hover_syllabus' => 'hover:bg-rose-50 group-hover/btn:text-rose-600'
            ],
            'teal' => [
                'border' => 'border-t-teal-500',
                'bg' => 'bg-teal-50',
                'border_inner' => 'border-teal-100',
                'text' => 'text-teal-600',
                'text_dark' => 'text-teal-700',
                'progress' => 'bg-teal-500',
                'btn' => 'bg-teal-600 hover:bg-teal-700 shadow-teal-600/20',
                'glow' => 'shadow-[0_0_8px_rgba(20,184,166,0.4)]',
                'hover_syllabus' => 'hover:bg-teal-50 group-hover/btn:text-teal-600'
            ],
        ];

        $tenthCore = [
            ['code' => '211', 'name' => 'Mathematics', 'icon' => 'functions', 'color' => 'cyan', 'category' => 'Core Academic', 'desc' => 'Comprehensive coverage of Algebra, Geometry, and Trigonometry with practice sets.'],
            ['code' => '212', 'name' => 'Science & Tech', 'icon' => 'science', 'color' => 'indigo', 'category' => 'Core Academic', 'desc' => 'Interactive modules for Physics, Chemistry, and Biology experiments and theory.'],
            ['code' => '213', 'name' => 'Social Science', 'icon' => 'public', 'color' => 'amber', 'category' => 'Core Academic', 'desc' => 'Exploration of History, Geography, Political Science, and Economics.'],
            ['code' => '214', 'name' => 'Economics', 'icon' => 'trending_up', 'color' => 'emerald', 'category' => 'Core Academic', 'desc' => 'Fundamental principles of micro and macroeconomics.'],
            ['code' => '215', 'name' => 'Business Studies', 'icon' => 'business', 'color' => 'purple', 'category' => 'Core Academic', 'desc' => 'Introduction to trade, service enterprises, and business structures.'],
            ['code' => '216', 'name' => 'Home Science', 'icon' => 'home', 'color' => 'rose', 'category' => 'Core Academic', 'desc' => 'Family resource management, food science, and child development.'],
            ['code' => '222', 'name' => 'Psychology', 'icon' => 'psychology', 'color' => 'purple', 'category' => 'Core Academic', 'desc' => 'Basic introduction to human mind, thoughts, behavior, and methods.'],
            ['code' => '224', 'name' => 'Accountancy', 'icon' => 'account_balance', 'color' => 'teal', 'category' => 'Core Academic', 'desc' => 'Basic accounting theory, bookkeeping practices, and financial statements.'],
        ];

        $tenthLanguages = [
            ['code' => '201', 'name' => 'Hindi', 'icon' => 'language', 'color' => 'teal', 'category' => 'Languages', 'desc' => 'Detailed study of prose, poetry, grammar, and comprehension in Hindi.'],
            ['code' => '202', 'name' => 'English', 'icon' => 'local_library', 'color' => 'rose', 'category' => 'Languages', 'desc' => 'Developing advanced reading, writing, and analytical skills in English literature.'],
            ['code' => '203', 'name' => 'Bengali', 'icon' => 'menu_book', 'color' => 'amber', 'category' => 'Languages', 'desc' => 'Prose, poetry, and linguistic development in Bengali.'],
            ['code' => '204', 'name' => 'Marathi', 'icon' => 'menu_book', 'color' => 'purple', 'category' => 'Languages', 'desc' => 'Prose, poetry, and linguistic development in Marathi.'],
            ['code' => '205', 'name' => 'Telugu', 'icon' => 'menu_book', 'color' => 'indigo', 'category' => 'Languages', 'desc' => 'Prose, poetry, and linguistic development in Telugu.'],
            ['code' => '206', 'name' => 'Urdu', 'icon' => 'menu_book', 'color' => 'emerald', 'category' => 'Languages', 'desc' => 'Prose, poetry, and linguistic development in Urdu.'],
            ['code' => '207', 'name' => 'Gujarati', 'icon' => 'menu_book', 'color' => 'cyan', 'category' => 'Languages', 'desc' => 'Prose, poetry, and linguistic development in Gujarati.'],
            ['code' => '208', 'name' => 'Kannada', 'icon' => 'menu_book', 'color' => 'rose', 'category' => 'Languages', 'desc' => 'Prose, poetry, and linguistic development in Kannada.'],
            ['code' => '209', 'name' => 'Sanskrit', 'icon' => 'menu_book', 'color' => 'teal', 'category' => 'Languages', 'desc' => 'Prose, poetry, and linguistic development in Sanskrit.'],
            ['code' => '210', 'name' => 'Punjabi', 'icon' => 'menu_book', 'color' => 'amber', 'category' => 'Languages', 'desc' => 'Prose, poetry, and linguistic development in Punjabi.'],
            ['code' => '228', 'name' => 'Assamese', 'icon' => 'menu_book', 'color' => 'emerald', 'category' => 'Languages', 'desc' => 'Prose, poetry, and linguistic development in Assamese.'],
            ['code' => '231', 'name' => 'Nepali', 'icon' => 'menu_book', 'color' => 'purple', 'category' => 'Languages', 'desc' => 'Prose, poetry, and linguistic development in Nepali.'],
            ['code' => '232', 'name' => 'Malayalam', 'icon' => 'menu_book', 'color' => 'cyan', 'category' => 'Languages', 'desc' => 'Prose, poetry, and linguistic development in Malayalam.'],
            ['code' => '233', 'name' => 'Odia', 'icon' => 'menu_book', 'color' => 'rose', 'category' => 'Languages', 'desc' => 'Prose, poetry, and linguistic development in Odia.'],
            ['code' => '235', 'name' => 'Arabic', 'icon' => 'menu_book', 'color' => 'teal', 'category' => 'Languages', 'desc' => 'Prose, poetry, and linguistic development in Arabic.'],
            ['code' => '236', 'name' => 'Persian', 'icon' => 'menu_book', 'color' => 'amber', 'category' => 'Languages', 'desc' => 'Prose, poetry, and linguistic development in Persian.'],
            ['code' => '237', 'name' => 'Tamil', 'icon' => 'menu_book', 'color' => 'cyan', 'category' => 'Languages', 'desc' => 'Prose, poetry, and linguistic development in Tamil.'],
            ['code' => '238', 'name' => 'Sindhi', 'icon' => 'menu_book', 'color' => 'rose', 'category' => 'Languages', 'desc' => 'Prose, poetry, and linguistic development in Sindhi.'],
        ];

        $tenthVocational = [
            ['code' => '229', 'name' => 'Data Entry Operations', 'icon' => 'keyboard', 'color' => 'emerald', 'category' => 'Vocational', 'desc' => 'Practical training on computer keyboarding, word processing, and spreadsheets.'],
            ['code' => '223', 'name' => 'Indian Culture & Heritage', 'icon' => 'museum', 'color' => 'amber', 'category' => 'Vocational', 'desc' => 'Exploration of historical culture, architecture, fine arts, and heritage of India.'],
            ['code' => '225', 'name' => 'Painting', 'icon' => 'palette', 'color' => 'rose', 'category' => 'Vocational', 'desc' => 'Art theory, sketch techniques, still life, and composition methods.'],
            ['code' => '230', 'name' => 'Indian Sign Language', 'icon' => 'sign_language', 'color' => 'indigo', 'category' => 'Vocational', 'desc' => 'Basics of visual sign language communication.'],
            ['code' => '242', 'name' => 'Hindustani Sangeet', 'icon' => 'music_note', 'color' => 'indigo', 'category' => 'Vocational', 'desc' => 'Fundamentals of Hindustani classical music raga and rhythm.'],
            ['code' => '243', 'name' => 'Carnatic Sangeet', 'icon' => 'music_note', 'color' => 'purple', 'category' => 'Vocational', 'desc' => 'Fundamentals of Carnatic classical music compositions.'],
            ['code' => '244', 'name' => 'Folk Art', 'icon' => 'brush', 'color' => 'rose', 'category' => 'Vocational', 'desc' => 'Introduction to traditional folk paintings, craft, and decoration designs.'],
            ['code' => '249', 'name' => 'Entrepreneurship', 'icon' => 'lightbulb', 'color' => 'cyan', 'category' => 'Vocational', 'desc' => 'Developing small business ideas, planning, and basic operations.'],
            ['code' => '285', 'name' => 'Natyakala', 'icon' => 'theater_comedy', 'color' => 'indigo', 'category' => 'Vocational', 'desc' => 'Foundations of theatrical expression, acting, movement, and dramaturgy.'],
        ];

        $tenthTraditional = [
            ['code' => '245', 'name' => 'Veda Adhyan', 'icon' => 'menu_book', 'color' => 'amber', 'category' => 'Traditional', 'desc' => 'Traditional study of ancient Vedic scriptures, chants, and pronunciation.'],
            ['code' => '246', 'name' => 'Sanskrit Vyakarana', 'icon' => 'menu_book', 'color' => 'teal', 'category' => 'Traditional', 'desc' => 'Grammatical rules and structured composition syntax of Sanskrit language.'],
            ['code' => '247', 'name' => 'Bharatiya Darshan', 'icon' => 'menu_book', 'color' => 'purple', 'category' => 'Traditional', 'desc' => 'Basic introduction to major Indian schools of philosophy.'],
            ['code' => '248', 'name' => 'Sanskrit Sahitya', 'icon' => 'menu_book', 'color' => 'rose', 'category' => 'Traditional', 'desc' => 'Literary analysis of classical Sanskrit poetry, plays, and prose.'],
        ];

        $twelfthScience = [
            ['code' => '314', 'name' => 'Biology', 'icon' => 'biotech', 'color' => 'emerald', 'category' => 'Science', 'desc' => 'Comprehensive study of Human Physiology, Genetics, and Evolutionary theory.'],
            ['code' => '312', 'name' => 'Physics', 'icon' => 'electric_bolt', 'color' => 'cyan', 'category' => 'Science', 'desc' => 'Advanced mechanics, electromagnetism, and modern physics.'],
            ['code' => '313', 'name' => 'Chemistry', 'icon' => 'science', 'color' => 'indigo', 'category' => 'Science', 'desc' => 'Deep dive into Organic reaction mechanisms, Inorganic properties, and Physical chemistry.'],
            ['code' => '311', 'name' => 'Mathematics', 'icon' => 'functions', 'color' => 'purple', 'category' => 'Science', 'desc' => 'Advanced Calculus, Algebra, Vectors, and 3D Geometry.'],
            ['code' => '333', 'name' => 'Environmental Science', 'icon' => 'eco', 'color' => 'teal', 'category' => 'Science', 'desc' => 'Ecology, natural resource management, pollution issues, and sustainability.'],
        ];

        $twelfthCommerce = [
            ['code' => '320', 'name' => 'Accountancy', 'icon' => 'account_balance', 'color' => 'emerald', 'category' => 'Commerce', 'desc' => 'Double-entry bookkeeping, financial statements, and partnership accounting.'],
            ['code' => '319', 'name' => 'Business Studies', 'icon' => 'business', 'color' => 'amber', 'category' => 'Commerce', 'desc' => 'Principles of management, business environment, marketing, and finance.'],
            ['code' => '318', 'name' => 'Economics', 'icon' => 'trending_up', 'color' => 'indigo', 'category' => 'Commerce', 'desc' => 'Microeconomics, macroeconomics, and development statistics of India.'],
        ];

        $twelfthHumanities = [
            ['code' => '315', 'name' => 'History', 'icon' => 'history', 'color' => 'amber', 'category' => 'Humanities', 'desc' => 'Ancient, medieval, and modern world history and Indian national movement.'],
            ['code' => '316', 'name' => 'Geography', 'icon' => 'public', 'color' => 'teal', 'category' => 'Humanities', 'desc' => 'Physical geography, human resource distributions, and map practice.'],
            ['code' => '317', 'name' => 'Political Science', 'icon' => 'how_to_vote', 'color' => 'rose', 'category' => 'Humanities', 'desc' => 'Indian constitution, governance, and contemporary world politics.'],
            ['code' => '328', 'name' => 'Psychology', 'icon' => 'psychology', 'color' => 'purple', 'category' => 'Humanities', 'desc' => 'Foundations of human behavior, cognitive psychology, and developmental stages.'],
            ['code' => '331', 'name' => 'Sociology', 'icon' => 'groups', 'color' => 'indigo', 'category' => 'Humanities', 'desc' => 'Structure, dynamics, and development of human society.'],
            ['code' => '332', 'name' => 'Fine Arts', 'icon' => 'palette', 'color' => 'rose', 'category' => 'Humanities', 'desc' => 'Practical drawing, clay modeling, painting, and history of art.'],
            ['code' => '335', 'name' => 'Mass Media', 'icon' => 'clarify', 'color' => 'amber', 'category' => 'Humanities', 'desc' => 'Print media, radio, television, journalism, and public relations.'],
            ['code' => '338', 'name' => 'Legal Studies', 'icon' => 'gavel', 'color' => 'cyan', 'category' => 'Humanities', 'desc' => 'Overview of the Indian legal framework, rights, and court structures.'],
            ['code' => '339', 'name' => 'Library & Info Science', 'icon' => 'library_books', 'color' => 'teal', 'category' => 'Humanities', 'desc' => 'Library classification, organization, and digital information management.'],
            ['code' => '373', 'name' => 'Physical Education', 'icon' => 'sports_soccer', 'color' => 'emerald', 'category' => 'Humanities', 'desc' => 'Principles of fitness, sports, anatomy, nutrition, and first-aid.'],
            ['code' => '374', 'name' => 'Military Studies', 'icon' => 'shield', 'color' => 'amber', 'category' => 'Humanities', 'desc' => 'National security, defense organizations, and armed forces structures.'],
            ['code' => '375', 'name' => 'Military History', 'icon' => 'menu_book', 'color' => 'rose', 'category' => 'Humanities', 'desc' => 'Historical analysis of ancient and modern military conflicts and strategists.'],
            ['code' => '376', 'name' => 'Early Childhood Care', 'icon' => 'child_care', 'color' => 'indigo', 'category' => 'Humanities', 'desc' => 'Preschool education, child development stages, and nutrition.'],
        ];

        $twelfthVocational = [
            ['code' => '321', 'name' => 'Home Science', 'icon' => 'home', 'color' => 'rose', 'category' => 'Vocational', 'desc' => 'Nutrition, human development, family resource management, and textiles.'],
            ['code' => '330', 'name' => 'Computer Science', 'icon' => 'computer', 'color' => 'cyan', 'category' => 'Vocational', 'desc' => 'Basic coding paradigms, databases, and Python programming foundations.'],
            ['code' => '336', 'name' => 'Data Entry Operations', 'icon' => 'keyboard', 'color' => 'emerald', 'category' => 'Vocational', 'desc' => 'Advanced spreadsheets, database entry methods, and presentation software.'],
            ['code' => '337', 'name' => 'Tourism', 'icon' => 'flight_takeoff', 'color' => 'amber', 'category' => 'Vocational', 'desc' => 'Basics of tourism, hotel management operations, and marketing.'],
            ['code' => '383', 'name' => 'Krishi', 'icon' => 'agriculture', 'color' => 'teal', 'category' => 'Vocational', 'desc' => 'Basics of agriculture science, soil management, and crops.'],
            ['code' => '385', 'name' => 'Natyakala', 'icon' => 'theater_comedy', 'color' => 'indigo', 'category' => 'Vocational', 'desc' => 'Theatrical expressions, acting, and dramaturgy.'],
        ];

        $twelfthLanguages = [
            ['code' => '301', 'name' => 'Hindi', 'icon' => 'language', 'color' => 'teal', 'category' => 'Languages', 'desc' => 'Advanced Hindi literature, language history, essays, and composition.'],
            ['code' => '302', 'name' => 'English Core', 'icon' => 'local_library', 'color' => 'amber', 'category' => 'Languages', 'desc' => 'Senior literature studies focusing on comprehension, advanced writing, and critical analysis.'],
            ['code' => '303', 'name' => 'Bengali', 'icon' => 'menu_book', 'color' => 'rose', 'category' => 'Languages', 'desc' => 'Bengali prose, poetry, composition, and language study.'],
            ['code' => '304', 'name' => 'Tamil', 'icon' => 'menu_book', 'color' => 'cyan', 'category' => 'Languages', 'desc' => 'Tamil literature analysis and grammatical structure study.'],
            ['code' => '305', 'name' => 'Odia', 'icon' => 'menu_book', 'color' => 'rose', 'category' => 'Languages', 'desc' => 'Odia prose and poetry selections and composition.'],
            ['code' => '306', 'name' => 'Urdu', 'icon' => 'menu_book', 'color' => 'emerald', 'category' => 'Languages', 'desc' => 'Urdu poetry, prose classics, and syntax structures.'],
            ['code' => '307', 'name' => 'Gujarati', 'icon' => 'menu_book', 'color' => 'teal', 'category' => 'Languages', 'desc' => 'Gujarati literary works, essays, and grammar principles.'],
            ['code' => '309', 'name' => 'Sanskrit', 'icon' => 'menu_book', 'color' => 'purple', 'category' => 'Languages', 'desc' => 'Sanskrit literature, grammar, and translation exercises.'],
            ['code' => '310', 'name' => 'Punjabi', 'icon' => 'menu_book', 'color' => 'amber', 'category' => 'Languages', 'desc' => 'Punjabi literary analysis and language history.'],
            ['code' => '341', 'name' => 'Arabic', 'icon' => 'menu_book', 'color' => 'indigo', 'category' => 'Languages', 'desc' => 'Arabic language, composition, and literature readings.'],
            ['code' => '342', 'name' => 'Persian', 'icon' => 'menu_book', 'color' => 'rose', 'category' => 'Languages', 'desc' => 'Persian prose, poetry translation, and grammar.'],
            ['code' => '343', 'name' => 'Malayalam', 'icon' => 'menu_book', 'color' => 'cyan', 'category' => 'Languages', 'desc' => 'Malayalam prose, poetry, and linguistic development.'],
            ['code' => '344', 'name' => 'Sindhi', 'icon' => 'menu_book', 'color' => 'purple', 'category' => 'Languages', 'desc' => 'Sindhi literature selections and grammar.'],
        ];

        $twelfthTraditional = [
            ['code' => '345', 'name' => 'Veda Adhyyan', 'icon' => 'menu_book', 'color' => 'amber', 'category' => 'Traditional', 'desc' => 'Traditional study of ancient Vedic scriptures, chants, and pronunciation.'],
            ['code' => '346', 'name' => 'Sanskrit Vyakarana', 'icon' => 'menu_book', 'color' => 'teal', 'category' => 'Traditional', 'desc' => 'Grammatical rules and structured composition syntax of Sanskrit language.'],
            ['code' => '347', 'name' => 'Bharatiya Darshan', 'icon' => 'menu_book', 'color' => 'purple', 'category' => 'Traditional', 'desc' => 'Basic introduction to major Indian schools of philosophy.'],
            ['code' => '348', 'name' => 'Sanskrit Sahitya', 'icon' => 'menu_book', 'color' => 'rose', 'category' => 'Traditional', 'desc' => 'Literary analysis of classical Sanskrit poetry, plays, and prose.'],
        ];
    @endphp

    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.4s;
        }
        .glass-card:hover {
            background: rgba(255, 255, 255, 0.75);
            transform: translateY(-4px) scale(1.02);
        }
        .signature-gradient {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
        }
    </style>

    <!-- Decorative backgrounds -->
    <div class="fixed top-40 -left-20 w-96 h-96 bg-[#40cef3]/10 rounded-full blur-[120px] pointer-events-none z-0"></div>
    <div class="fixed bottom-20 -right-20 w-80 h-80 bg-[#80b2ff]/10 rounded-full blur-[100px] pointer-events-none z-0"></div>

    <div x-data="{
        selectedClass: '{{ $classStandard === 'Senior Secondary (12th)' ? '12th' : '10th' }}',
        searchQuery: ''
    }" class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-10 relative z-10">

        <!-- Header -->
        <header class="mb-10 text-center relative z-10 mt-2">
            <div class="inline-block px-4 py-1.5 mb-4 rounded-full glass-panel border-slate-200/60 shadow-sm">
                <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#006479]">Academic Curriculum</span>
            </div>
            <h1 class="text-[clamp(1.75rem,5vw,3.5rem)] font-bold tracking-tighter mb-4 text-slate-800 leading-none">Peak Performance <br/><span class="text-transparent bg-clip-text signature-gradient">Syllabus & Curriculum</span></h1>
            <p class="text-slate-500 max-w-2xl mx-auto text-xs sm:text-base leading-relaxed font-semibold px-2 mb-6">Navigate academic streams, launch interactive lessons, and download officially proxy-indexed NIOS syllabus PDFs.</p>
            
            <!-- Search bar -->
            <div class="max-w-md mx-auto mb-6 relative z-10">
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-4 text-slate-400">search</span>
                    <input type="text" x-model="searchQuery" placeholder="Search subjects by name or code..." class="w-full pl-12 pr-4 py-3 bg-white/70 backdrop-blur-md border border-slate-200/80 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#006479] focus:border-transparent transition-all shadow-sm text-sm" />
                    <button x-show="searchQuery" @click="searchQuery = ''" class="absolute right-4 text-slate-450 hover:text-slate-650 transition-colors flex items-center justify-center">
                        <span class="material-symbols-outlined text-base">close</span>
                    </button>
                </div>
            </div>
        </header>

        <!-- Segmented Tab Control -->
        <div class="flex justify-center mb-10 relative z-10">
            <div class="glass-panel p-1.5 rounded-2xl flex gap-1 shadow-sm border-slate-200/50">
                <button @click="selectedClass = '10th'" :class="selectedClass === '10th' ? 'bg-[#006479] text-white shadow' : 'text-slate-600 hover:text-slate-800'" class="px-6 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all">
                    Class 10th (Secondary)
                </button>
                <button @click="selectedClass = '12th'" :class="selectedClass === '12th' ? 'bg-[#006479] text-white shadow' : 'text-slate-600 hover:text-slate-800'" class="px-6 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all">
                    Class 12th (Sr. Secondary)
                </button>
            </div>
        </div>

        <!-- Class 10th Section -->
        <div x-show="selectedClass === '10th'" x-cloak class="space-y-12">
            <!-- Core Academic & Science -->
            <section class="space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-200/60 pb-4">
                    <div class="p-2 bg-cyan-50 rounded-xl border border-cyan-100">
                        <span class="material-symbols-outlined text-cyan-600 text-2xl">science</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold tracking-tight text-slate-800">Core Academic & Science</h2>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-0.5">Mathematics, Sciences & Social Studies</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($tenthCore as $sub)
                        @php
                            $colors = $colorMap[$sub['color'] ?? 'cyan'] ?? $colorMap['cyan'];
                        @endphp
                        <div x-show="!searchQuery || '{{ $sub['name'] }}'.toLowerCase().includes(searchQuery.toLowerCase()) || '{{ $sub['code'] }}'.includes(searchQuery)" class="glass-card p-5 rounded-3xl flex flex-col justify-between group shadow-sm bg-white/60 {{ $colors['border'] }} border-t-4">
                            <div class="mb-4">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="h-10 w-10 rounded-xl {{ $colors['bg'] }} border {{ $colors['border_inner'] }} flex items-center justify-center">
                                        <span class="material-symbols-outlined {{ $colors['text'] }} text-xl">{{ $sub['icon'] }}</span>
                                    </div>
                                    <span class="{{ $colors['bg'] }} {{ $colors['text_dark'] }} px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider border {{ $colors['border_inner'] }}">{{ $sub['code'] }}</span>
                                </div>
                                <h3 class="text-base font-bold mb-1 text-slate-800 tracking-tight">{{ $sub['name'] }}</h3>
                                <p class="text-slate-500 text-[11px] font-medium leading-relaxed mb-2">{{ $sub['desc'] }}</p>
                            </div>
                            <div class="space-y-2 mt-auto">
                                <a href="{{ route('lessons.chapters', $sub['code']) }}" class="flex items-center justify-center gap-1.5 w-full py-2.5 bg-slate-900 text-white hover:{{ $colors['btn'] }} rounded-xl transition-all hover:scale-[1.02] shadow-md shadow-slate-900/10 active:scale-95 min-h-[38px] text-[10px] font-bold uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-white text-base">play_circle</span>
                                    Start Learning
                                </a>
                                <a href="{{ route('syllabus.download', $sub['code']) }}" download class="flex items-center justify-center gap-1 w-full py-2.5 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition-all group/btn shadow-sm min-h-[38px] text-[10px] font-bold text-slate-600 hover:text-[#006479] uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-slate-400 text-sm group-hover/btn:{{ $colors['text'] }}">download</span>
                                    Download Syllabus
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Global Languages -->
            <section class="space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-200/60 pb-4">
                    <div class="p-2 bg-indigo-50 rounded-xl border border-indigo-100">
                        <span class="material-symbols-outlined text-indigo-600 text-2xl">translate</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold tracking-tight text-slate-800">Global Languages</h2>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-0.5">Communication & Literature</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($tenthLanguages as $sub)
                        @php
                            $colors = $colorMap[$sub['color'] ?? 'cyan'] ?? $colorMap['cyan'];
                        @endphp
                        <div x-show="!searchQuery || '{{ $sub['name'] }}'.toLowerCase().includes(searchQuery.toLowerCase()) || '{{ $sub['code'] }}'.includes(searchQuery)" class="glass-card p-5 rounded-3xl flex flex-col justify-between group shadow-sm bg-white/60 {{ $colors['border'] }} border-t-4">
                            <div class="mb-4">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="h-10 w-10 rounded-xl {{ $colors['bg'] }} border {{ $colors['border_inner'] }} flex items-center justify-center">
                                        <span class="material-symbols-outlined {{ $colors['text'] }} text-xl">{{ $sub['icon'] }}</span>
                                    </div>
                                    <span class="{{ $colors['bg'] }} {{ $colors['text_dark'] }} px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider border {{ $colors['border_inner'] }}">{{ $sub['code'] }}</span>
                                </div>
                                <h3 class="text-base font-bold mb-1 text-slate-800 tracking-tight">{{ $sub['name'] }}</h3>
                                <p class="text-slate-500 text-[11px] font-medium leading-relaxed mb-2">{{ $sub['desc'] }}</p>
                            </div>
                            <div class="space-y-2 mt-auto">
                                <a href="{{ route('lessons.chapters', $sub['code']) }}" class="flex items-center justify-center gap-1.5 w-full py-2.5 bg-slate-900 text-white hover:{{ $colors['btn'] }} rounded-xl transition-all hover:scale-[1.02] shadow-md shadow-slate-900/10 active:scale-95 min-h-[38px] text-[10px] font-bold uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-white text-base">play_circle</span>
                                    Start Learning
                                </a>
                                <a href="{{ route('syllabus.download', $sub['code']) }}" download class="flex items-center justify-center gap-1 w-full py-2.5 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition-all group/btn shadow-sm min-h-[38px] text-[10px] font-bold text-slate-600 hover:text-[#006479] uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-slate-400 text-sm group-hover/btn:{{ $colors['text'] }}">download</span>
                                    Download Syllabus
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Vocational & Practical Studies -->
            <section class="space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-200/60 pb-4">
                    <div class="p-2 bg-emerald-50 rounded-xl border border-emerald-100">
                        <span class="material-symbols-outlined text-emerald-600 text-2xl">work</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold tracking-tight text-slate-800">Vocational & Practical Studies</h2>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-0.5">Skills & Applied Learning</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($tenthVocational as $sub)
                        @php
                            $colors = $colorMap[$sub['color'] ?? 'cyan'] ?? $colorMap['cyan'];
                        @endphp
                        <div x-show="!searchQuery || '{{ $sub['name'] }}'.toLowerCase().includes(searchQuery.toLowerCase()) || '{{ $sub['code'] }}'.includes(searchQuery)" class="glass-card p-5 rounded-3xl flex flex-col justify-between group shadow-sm bg-white/60 {{ $colors['border'] }} border-t-4">
                            <div class="mb-4">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="h-10 w-10 rounded-xl {{ $colors['bg'] }} border {{ $colors['border_inner'] }} flex items-center justify-center">
                                        <span class="material-symbols-outlined {{ $colors['text'] }} text-xl">{{ $sub['icon'] }}</span>
                                    </div>
                                    <span class="{{ $colors['bg'] }} {{ $colors['text_dark'] }} px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider border {{ $colors['border_inner'] }}">{{ $sub['code'] }}</span>
                                </div>
                                <h3 class="text-base font-bold mb-1 text-slate-800 tracking-tight">{{ $sub['name'] }}</h3>
                                <p class="text-slate-500 text-[11px] font-medium leading-relaxed mb-2">{{ $sub['desc'] }}</p>
                            </div>
                            <div class="space-y-2 mt-auto">
                                <a href="{{ route('lessons.chapters', $sub['code']) }}" class="flex items-center justify-center gap-1.5 w-full py-2.5 bg-slate-900 text-white hover:{{ $colors['btn'] }} rounded-xl transition-all hover:scale-[1.02] shadow-md shadow-slate-900/10 active:scale-95 min-h-[38px] text-[10px] font-bold uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-white text-base">play_circle</span>
                                    Start Learning
                                </a>
                                <a href="{{ route('syllabus.download', $sub['code']) }}" download class="flex items-center justify-center gap-1 w-full py-2.5 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition-all group/btn shadow-sm min-h-[38px] text-[10px] font-bold text-slate-600 hover:text-[#006479] uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-slate-400 text-sm group-hover/btn:{{ $colors['text'] }}">download</span>
                                    Download Syllabus
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Sanskrit & Traditional Studies -->
            <section class="space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-200/60 pb-4">
                    <div class="p-2 bg-amber-50 rounded-xl border border-amber-100">
                        <span class="material-symbols-outlined text-amber-600 text-2xl">history_edu</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold tracking-tight text-slate-800">Sanskrit & Traditional Studies</h2>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-0.5">Ancient Literature & Vedas</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($tenthTraditional as $sub)
                        @php
                            $colors = $colorMap[$sub['color'] ?? 'cyan'] ?? $colorMap['cyan'];
                        @endphp
                        <div x-show="!searchQuery || '{{ $sub['name'] }}'.toLowerCase().includes(searchQuery.toLowerCase()) || '{{ $sub['code'] }}'.includes(searchQuery)" class="glass-card p-5 rounded-3xl flex flex-col justify-between group shadow-sm bg-white/60 {{ $colors['border'] }} border-t-4">
                            <div class="mb-4">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="h-10 w-10 rounded-xl {{ $colors['bg'] }} border {{ $colors['border_inner'] }} flex items-center justify-center">
                                        <span class="material-symbols-outlined {{ $colors['text'] }} text-xl">{{ $sub['icon'] }}</span>
                                    </div>
                                    <span class="{{ $colors['bg'] }} {{ $colors['text_dark'] }} px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider border {{ $colors['border_inner'] }}">{{ $sub['code'] }}</span>
                                </div>
                                <h3 class="text-base font-bold mb-1 text-slate-800 tracking-tight">{{ $sub['name'] }}</h3>
                                <p class="text-slate-500 text-[11px] font-medium leading-relaxed mb-2">{{ $sub['desc'] }}</p>
                            </div>
                            <div class="space-y-2 mt-auto">
                                <a href="{{ route('lessons.chapters', $sub['code']) }}" class="flex items-center justify-center gap-1.5 w-full py-2.5 bg-slate-900 text-white hover:{{ $colors['btn'] }} rounded-xl transition-all hover:scale-[1.02] shadow-md shadow-slate-900/10 active:scale-95 min-h-[38px] text-[10px] font-bold uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-white text-base">play_circle</span>
                                    Start Learning
                                </a>
                                <a href="{{ route('syllabus.download', $sub['code']) }}" download class="flex items-center justify-center gap-1 w-full py-2.5 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition-all group/btn shadow-sm min-h-[38px] text-[10px] font-bold text-slate-600 hover:text-[#006479] uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-slate-400 text-sm group-hover/btn:{{ $colors['text'] }}">download</span>
                                    Download Syllabus
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <!-- Class 12th Section -->
        <div x-show="selectedClass === '12th'" x-cloak class="space-y-12">
            <!-- Science Stream -->
            <section class="space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-200/60 pb-4">
                    <div class="p-2 bg-emerald-50 rounded-xl border border-emerald-100">
                        <span class="material-symbols-outlined text-emerald-600 text-2xl">biotech</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold tracking-tight text-slate-800">Science Stream</h2>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-0.5">Medical & Non-Medical Core</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($twelfthScience as $sub)
                        @php
                            $colors = $colorMap[$sub['color'] ?? 'cyan'] ?? $colorMap['cyan'];
                        @endphp
                        <div x-show="!searchQuery || '{{ $sub['name'] }}'.toLowerCase().includes(searchQuery.toLowerCase()) || '{{ $sub['code'] }}'.includes(searchQuery)" class="glass-card p-5 rounded-3xl flex flex-col justify-between group shadow-sm bg-white/60 {{ $colors['border'] }} border-t-4">
                            <div class="mb-4">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="h-10 w-10 rounded-xl {{ $colors['bg'] }} border {{ $colors['border_inner'] }} flex items-center justify-center">
                                        <span class="material-symbols-outlined {{ $colors['text'] }} text-xl">{{ $sub['icon'] }}</span>
                                    </div>
                                    <span class="{{ $colors['bg'] }} {{ $colors['text_dark'] }} px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider border {{ $colors['border_inner'] }}">{{ $sub['code'] }}</span>
                                </div>
                                <h3 class="text-base font-bold mb-1 text-slate-800 tracking-tight">{{ $sub['name'] }}</h3>
                                <p class="text-slate-500 text-[11px] font-medium leading-relaxed mb-2">{{ $sub['desc'] }}</p>
                            </div>
                            <div class="space-y-2 mt-auto">
                                <a href="{{ route('lessons.chapters', $sub['code']) }}" class="flex items-center justify-center gap-1.5 w-full py-2.5 bg-slate-900 text-white hover:{{ $colors['btn'] }} rounded-xl transition-all hover:scale-[1.02] shadow-md shadow-slate-900/10 active:scale-95 min-h-[38px] text-[10px] font-bold uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-white text-base">play_circle</span>
                                    Start Learning
                                </a>
                                <a href="{{ route('syllabus.download', $sub['code']) }}" download class="flex items-center justify-center gap-1 w-full py-2.5 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition-all group/btn shadow-sm min-h-[38px] text-[10px] font-bold text-slate-600 hover:text-[#006479] uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-slate-400 text-sm group-hover/btn:{{ $colors['text'] }}">download</span>
                                    Download Syllabus
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Commerce Stream -->
            <section class="space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-200/60 pb-4">
                    <div class="p-2 bg-amber-50 rounded-xl border border-amber-100">
                        <span class="material-symbols-outlined text-amber-600 text-2xl">balance</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold tracking-tight text-slate-800">Commerce & Law</h2>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-0.5">Finance, Audit & Economics</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($twelfthCommerce as $sub)
                        @php
                            $colors = $colorMap[$sub['color'] ?? 'cyan'] ?? $colorMap['cyan'];
                        @endphp
                        <div x-show="!searchQuery || '{{ $sub['name'] }}'.toLowerCase().includes(searchQuery.toLowerCase()) || '{{ $sub['code'] }}'.includes(searchQuery)" class="glass-card p-5 rounded-3xl flex flex-col justify-between group shadow-sm bg-white/60 {{ $colors['border'] }} border-t-4">
                            <div class="mb-4">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="h-10 w-10 rounded-xl {{ $colors['bg'] }} border {{ $colors['border_inner'] }} flex items-center justify-center">
                                        <span class="material-symbols-outlined {{ $colors['text'] }} text-xl">{{ $sub['icon'] }}</span>
                                    </div>
                                    <span class="{{ $colors['bg'] }} {{ $colors['text_dark'] }} px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider border {{ $colors['border_inner'] }}">{{ $sub['code'] }}</span>
                                </div>
                                <h3 class="text-base font-bold mb-1 text-slate-800 tracking-tight">{{ $sub['name'] }}</h3>
                                <p class="text-slate-500 text-[11px] font-medium leading-relaxed mb-2">{{ $sub['desc'] }}</p>
                            </div>
                            <div class="space-y-2 mt-auto">
                                <a href="{{ route('lessons.chapters', $sub['code']) }}" class="flex items-center justify-center gap-1.5 w-full py-2.5 bg-slate-900 text-white hover:{{ $colors['btn'] }} rounded-xl transition-all hover:scale-[1.02] shadow-md shadow-slate-900/10 active:scale-95 min-h-[38px] text-[10px] font-bold uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-white text-base">play_circle</span>
                                    Start Learning
                                </a>
                                <a href="{{ route('syllabus.download', $sub['code']) }}" download class="flex items-center justify-center gap-1 w-full py-2.5 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition-all group/btn shadow-sm min-h-[38px] text-[10px] font-bold text-slate-600 hover:text-[#006479] uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-slate-400 text-sm group-hover/btn:{{ $colors['text'] }}">download</span>
                                    Download Syllabus
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Humanities Stream -->
            <section class="space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-200/60 pb-4">
                    <div class="p-2 bg-rose-50 rounded-xl border border-rose-100">
                        <span class="material-symbols-outlined text-rose-600 text-2xl">theater_comedy</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold tracking-tight text-slate-800">Humanities & Social Arts</h2>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-0.5">History, Polity & Geography</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($twelfthHumanities as $sub)
                        @php
                            $colors = $colorMap[$sub['color'] ?? 'cyan'] ?? $colorMap['cyan'];
                        @endphp
                        <div x-show="!searchQuery || '{{ $sub['name'] }}'.toLowerCase().includes(searchQuery.toLowerCase()) || '{{ $sub['code'] }}'.includes(searchQuery)" class="glass-card p-5 rounded-3xl flex flex-col justify-between group shadow-sm bg-white/60 {{ $colors['border'] }} border-t-4">
                            <div class="mb-4">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="h-10 w-10 rounded-xl {{ $colors['bg'] }} border {{ $colors['border_inner'] }} flex items-center justify-center">
                                        <span class="material-symbols-outlined {{ $colors['text'] }} text-xl">{{ $sub['icon'] }}</span>
                                    </div>
                                    <span class="{{ $colors['bg'] }} {{ $colors['text_dark'] }} px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider border {{ $colors['border_inner'] }}">{{ $sub['code'] }}</span>
                                </div>
                                <h3 class="text-base font-bold mb-1 text-slate-800 tracking-tight">{{ $sub['name'] }}</h3>
                                <p class="text-slate-500 text-[11px] font-medium leading-relaxed mb-2">{{ $sub['desc'] }}</p>
                            </div>
                            <div class="space-y-2 mt-auto">
                                <a href="{{ route('lessons.chapters', $sub['code']) }}" class="flex items-center justify-center gap-1.5 w-full py-2.5 bg-slate-900 text-white hover:{{ $colors['btn'] }} rounded-xl transition-all hover:scale-[1.02] shadow-md shadow-slate-900/10 active:scale-95 min-h-[38px] text-[10px] font-bold uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-white text-base">play_circle</span>
                                    Start Learning
                                </a>
                                <a href="{{ route('syllabus.download', $sub['code']) }}" download class="flex items-center justify-center gap-1 w-full py-2.5 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition-all group/btn shadow-sm min-h-[38px] text-[10px] font-bold text-slate-600 hover:text-[#006479] uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-slate-400 text-sm group-hover/btn:{{ $colors['text'] }}">download</span>
                                    Download Syllabus
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Global Languages -->
            <section class="space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-200/60 pb-4">
                    <div class="p-2 bg-indigo-50 rounded-xl border border-indigo-100">
                        <span class="material-symbols-outlined text-indigo-600 text-2xl">translate</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold tracking-tight text-slate-800">Global Languages</h2>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-0.5">Communication & Literature</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($twelfthLanguages as $sub)
                        @php
                            $colors = $colorMap[$sub['color'] ?? 'cyan'] ?? $colorMap['cyan'];
                        @endphp
                        <div x-show="!searchQuery || '{{ $sub['name'] }}'.toLowerCase().includes(searchQuery.toLowerCase()) || '{{ $sub['code'] }}'.includes(searchQuery)" class="glass-card p-5 rounded-3xl flex flex-col justify-between group shadow-sm bg-white/60 {{ $colors['border'] }} border-t-4">
                            <div class="mb-4">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="h-10 w-10 rounded-xl {{ $colors['bg'] }} border {{ $colors['border_inner'] }} flex items-center justify-center">
                                        <span class="material-symbols-outlined {{ $colors['text'] }} text-xl">{{ $sub['icon'] }}</span>
                                    </div>
                                    <span class="{{ $colors['bg'] }} {{ $colors['text_dark'] }} px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider border {{ $colors['border_inner'] }}">{{ $sub['code'] }}</span>
                                </div>
                                <h3 class="text-base font-bold mb-1 text-slate-800 tracking-tight">{{ $sub['name'] }}</h3>
                                <p class="text-slate-500 text-[11px] font-medium leading-relaxed mb-2">{{ $sub['desc'] }}</p>
                            </div>
                            <div class="space-y-2 mt-auto">
                                <a href="{{ route('lessons.chapters', $sub['code']) }}" class="flex items-center justify-center gap-1.5 w-full py-2.5 bg-slate-900 text-white hover:{{ $colors['btn'] }} rounded-xl transition-all hover:scale-[1.02] shadow-md shadow-slate-900/10 active:scale-95 min-h-[38px] text-[10px] font-bold uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-white text-base">play_circle</span>
                                    Start Learning
                                </a>
                                <a href="{{ route('syllabus.download', $sub['code']) }}" download class="flex items-center justify-center gap-1 w-full py-2.5 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition-all group/btn shadow-sm min-h-[38px] text-[10px] font-bold text-slate-600 hover:text-[#006479] uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-slate-400 text-sm group-hover/btn:{{ $colors['text'] }}">download</span>
                                    Download Syllabus
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Vocational & Elective Studies -->
            <section class="space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-200/60 pb-4">
                    <div class="p-2 bg-emerald-50 rounded-xl border border-emerald-100">
                        <span class="material-symbols-outlined text-emerald-600 text-2xl">work</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold tracking-tight text-slate-800">Vocational & Elective Studies</h2>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-0.5">Skills & Applied Learning</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($twelfthVocational as $sub)
                        @php
                            $colors = $colorMap[$sub['color'] ?? 'cyan'] ?? $colorMap['cyan'];
                        @endphp
                        <div x-show="!searchQuery || '{{ $sub['name'] }}'.toLowerCase().includes(searchQuery.toLowerCase()) || '{{ $sub['code'] }}'.includes(searchQuery)" class="glass-card p-5 rounded-3xl flex flex-col justify-between group shadow-sm bg-white/60 {{ $colors['border'] }} border-t-4">
                            <div class="mb-4">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="h-10 w-10 rounded-xl {{ $colors['bg'] }} border {{ $colors['border_inner'] }} flex items-center justify-center">
                                        <span class="material-symbols-outlined {{ $colors['text'] }} text-xl">{{ $sub['icon'] }}</span>
                                    </div>
                                    <span class="{{ $colors['bg'] }} {{ $colors['text_dark'] }} px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider border {{ $colors['border_inner'] }}">{{ $sub['code'] }}</span>
                                </div>
                                <h3 class="text-base font-bold mb-1 text-slate-800 tracking-tight">{{ $sub['name'] }}</h3>
                                <p class="text-slate-500 text-[11px] font-medium leading-relaxed mb-2">{{ $sub['desc'] }}</p>
                            </div>
                            <div class="space-y-2 mt-auto">
                                <a href="{{ route('lessons.chapters', $sub['code']) }}" class="flex items-center justify-center gap-1.5 w-full py-2.5 bg-slate-900 text-white hover:{{ $colors['btn'] }} rounded-xl transition-all hover:scale-[1.02] shadow-md shadow-slate-900/10 active:scale-95 min-h-[38px] text-[10px] font-bold uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-white text-base">play_circle</span>
                                    Start Learning
                                </a>
                                <a href="{{ route('syllabus.download', $sub['code']) }}" download class="flex items-center justify-center gap-1 w-full py-2.5 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition-all group/btn shadow-sm min-h-[38px] text-[10px] font-bold text-slate-600 hover:text-[#006479] uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-slate-400 text-sm group-hover/btn:{{ $colors['text'] }}">download</span>
                                    Download Syllabus
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Sanskrit & Traditional Studies -->
            <section class="space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-200/60 pb-4">
                    <div class="p-2 bg-amber-50 rounded-xl border border-amber-100">
                        <span class="material-symbols-outlined text-amber-600 text-2xl">history_edu</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold tracking-tight text-slate-800">Sanskrit & Traditional Studies</h2>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-0.5">Ancient Literature & Vedas</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($twelfthTraditional as $sub)
                        @php
                            $colors = $colorMap[$sub['color'] ?? 'cyan'] ?? $colorMap['cyan'];
                        @endphp
                        <div x-show="!searchQuery || '{{ $sub['name'] }}'.toLowerCase().includes(searchQuery.toLowerCase()) || '{{ $sub['code'] }}'.includes(searchQuery)" class="glass-card p-5 rounded-3xl flex flex-col justify-between group shadow-sm bg-white/60 {{ $colors['border'] }} border-t-4">
                            <div class="mb-4">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="h-10 w-10 rounded-xl {{ $colors['bg'] }} border {{ $colors['border_inner'] }} flex items-center justify-center">
                                        <span class="material-symbols-outlined {{ $colors['text'] }} text-xl">{{ $sub['icon'] }}</span>
                                    </div>
                                    <span class="{{ $colors['bg'] }} {{ $colors['text_dark'] }} px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider border {{ $colors['border_inner'] }}">{{ $sub['code'] }}</span>
                                </div>
                                <h3 class="text-base font-bold mb-1 text-slate-800 tracking-tight">{{ $sub['name'] }}</h3>
                                <p class="text-slate-500 text-[11px] font-medium leading-relaxed mb-2">{{ $sub['desc'] }}</p>
                            </div>
                            <div class="space-y-2 mt-auto">
                                <a href="{{ route('lessons.chapters', $sub['code']) }}" class="flex items-center justify-center gap-1.5 w-full py-2.5 bg-slate-900 text-white hover:{{ $colors['btn'] }} rounded-xl transition-all hover:scale-[1.02] shadow-md shadow-slate-900/10 active:scale-95 min-h-[38px] text-[10px] font-bold uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-white text-base">play_circle</span>
                                    Start Learning
                                </a>
                                <a href="{{ route('syllabus.download', $sub['code']) }}" download class="flex items-center justify-center gap-1 w-full py-2.5 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition-all group/btn shadow-sm min-h-[38px] text-[10px] font-bold text-slate-600 hover:text-[#006479] uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-slate-400 text-sm group-hover/btn:{{ $colors['text'] }}">download</span>
                                    Download Syllabus
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <!-- Custom Video Playlists Section (Merged from previous work) -->
        @if($videoLessons && $videoLessons->count() > 0)
        <div class="mt-16 glass-panel p-6 sm:p-8 rounded-[2rem] border border-slate-200/60 shadow-sm">
            <h3 class="text-xl font-bold flex items-center gap-3 mb-6">
                <span class="material-symbols-outlined text-[#006479] text-2xl">ondemand_video</span>
                <span>Custom Video Playlists</span>
                <span class="text-[9px] font-bold bg-[#006479]/10 text-[#006479] px-2.5 py-1 rounded-full uppercase tracking-wider">Uploaded by Admin</span>
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($videoLessons as $lesson)
                <div class="bg-white rounded-2xl p-5 border border-slate-100 hover:border-cyan-200 hover:shadow-xl hover:shadow-cyan-900/5 transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-10 h-10 rounded-xl bg-cyan-50 flex items-center justify-center text-cyan-600 shadow-sm border border-cyan-100">
                                <span class="material-symbols-outlined text-xl">play_circle</span>
                            </div>
                            <span class="bg-cyan-50 text-cyan-700 text-[9px] font-bold px-2 py-0.5 rounded border border-cyan-100 uppercase tracking-widest">{{ $lesson->class_level }}</span>
                        </div>
                        <h4 class="font-bold text-slate-800 text-sm mb-1">{{ $lesson->subject }}</h4>
                        <p class="text-[11px] text-slate-400 mb-6">Full playlist of customized video lectures uploaded specifically for {{ $lesson->subject }}.</p>
                    </div>
                    <a href="{{ route('learning.video', $lesson->id) }}" class="w-full flex items-center justify-center gap-2 bg-[#006479] text-white hover:bg-cyan-600 py-2 rounded-xl font-bold text-xs uppercase tracking-wider transition-colors shadow-md shadow-cyan-900/10">
                        Watch Playlist
                        <span class="material-symbols-outlined text-sm">smart_display</span>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</x-student-layout>
