<x-student-layout>
    <div x-data="mockTestApp" class="space-y-8 relative pb-20">

        <!-- ==================== STEP 1: CLASS SELECTION ==================== -->
        <div x-show="viewMode === 'class_select'" class="space-y-10 animate-fade-in">
            <!-- Header Banner -->
            <div class="glass-panel p-8 md:p-10 rounded-[2rem] bg-gradient-to-r from-cyan-800 to-cyan-950 text-white shadow-xl relative overflow-hidden">
                <div class="absolute right-0 top-0 w-80 h-80 bg-cyan-600/20 rounded-full blur-[80px] pointer-events-none"></div>
                <div class="relative z-10 space-y-3 max-w-2xl">
                    <span class="text-[10px] font-black tracking-[0.2em] uppercase text-cyan-400">Assessed Examination System</span>
                    <h2 class="text-3xl md:text-5xl font-black tracking-tight leading-none">Access Mocktest Wise Class</h2>
                    <p class="text-sm md:text-base text-cyan-200/80 font-medium">Select your grade level to access categorized subject preparation examinations.</p>
                </div>
            </div>

            <!-- Two large Class Selection Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- 10th Standard Card -->
                <button @click="selectClass('10th')"
                    class="glass-panel p-8 rounded-[2.5rem] bg-white border border-slate-200/60 shadow-lg shadow-slate-200/30 text-left hover:scale-[1.02] hover:shadow-xl hover:border-cyan-500/25 transition-all duration-300 group cursor-pointer flex flex-col justify-between h-80">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center shadow-inner group-hover:bg-cyan-600 group-hover:text-white transition-all duration-300">
                            <span class="material-symbols-outlined text-[32px]">school</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-slate-800 tracking-tight">10th Standard</h3>
                            <p class="text-xs text-cyan-600 font-bold uppercase tracking-wider mt-1">Secondary Education</p>
                        </div>
                        <p class="text-sm text-slate-500 leading-relaxed font-medium">Practice with chapter-wise and full syllabus exams for Science, Mathematics, Social Science, Hindi, and English.</p>
                    </div>
                    <div class="flex items-center gap-2 text-cyan-700 font-bold text-sm tracking-tight pt-4 group-hover:translate-x-1.5 transition-transform duration-300">
                        Explore Subjects <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </div>
                </button>

                <!-- 12th Standard Card -->
                <button @click="selectClass('12th')"
                    class="glass-panel p-8 rounded-[2.5rem] bg-white border border-slate-200/60 shadow-lg shadow-slate-200/30 text-left hover:scale-[1.02] hover:shadow-xl hover:border-cyan-500/25 transition-all duration-300 group cursor-pointer flex flex-col justify-between h-80">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center shadow-inner group-hover:bg-cyan-600 group-hover:text-white transition-all duration-300">
                            <span class="material-symbols-outlined text-[32px]">workspace_premium</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-slate-800 tracking-tight">12th Standard</h3>
                            <p class="text-xs text-cyan-600 font-bold uppercase tracking-wider mt-1">Senior Secondary Education</p>
                        </div>
                        <p class="text-sm text-slate-500 leading-relaxed font-medium">Practice with chapter-wise and full syllabus tests tailored for Physics, Chemistry, Biology, and Mathematics.</p>
                    </div>
                    <div class="flex items-center gap-2 text-cyan-700 font-bold text-sm tracking-tight pt-4 group-hover:translate-x-1.5 transition-transform duration-300">
                        Explore Subjects <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </div>
                </button>
            </div>
        </div>

        <!-- ==================== STEP 2: SUBJECT SELECTION ==================== -->
        <div x-show="viewMode === 'subject_select'" class="space-y-8 animate-fade-in" style="display:none;">
            <!-- Back navigation button -->
            <button @click="goBack()" class="flex items-center gap-1.5 text-slate-500 hover:text-slate-800 font-bold text-xs cursor-pointer group">
                <span class="material-symbols-outlined text-sm group-hover:-translate-x-0.5 transition-transform">arrow_back</span> Back to Classes
            </button>

            <!-- Header card -->
            <div class="glass-panel p-8 rounded-3xl bg-white border border-slate-200/50 shadow-sm">
                <span class="text-[10px] font-bold text-cyan-600 uppercase tracking-widest block" x-text="`${selectedClass} Standard Secondary`"></span>
                <h2 class="text-3xl font-black text-slate-800 tracking-tight mt-1">Select Subject</h2>
                <p class="text-sm font-medium text-slate-500 mt-1">Explore and select a syllabus subject to review available mock tests.</p>
            </div>

            <!-- Subject Cards Grid (Compact layout for large lists) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <template x-for="subj in filteredSubjects" :key="subj.name">
                    <button @click="selectSubject(subj.name)"
                        class="glass-panel p-4 rounded-2xl bg-white border border-slate-200/50 shadow-sm text-left hover:scale-[1.02] hover:shadow-md hover:border-cyan-500/25 transition-all duration-200 cursor-pointer flex gap-3 items-center">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 border" :class="[subj.bg, subj.border]">
                            <span class="material-symbols-outlined text-[20px]" :class="subj.text" x-text="subj.icon"></span>
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="font-bold text-slate-800 text-xs sm:text-sm tracking-tight truncate" x-text="subj.name"></h4>
                        </div>
                    </button>
                </template>
            </div>
        </div>

        <!-- ==================== STEP 3: TESTS LISTING ==================== -->
        <div x-show="viewMode === 'test_list'" class="space-y-8 animate-fade-in" style="display:none;">
            <!-- Back navigation -->
            <button @click="goBack()" class="flex items-center gap-1.5 text-slate-500 hover:text-slate-800 font-bold text-xs cursor-pointer group">
                <span class="material-symbols-outlined text-sm group-hover:-translate-x-0.5 transition-transform">arrow_back</span> Back to Subjects
            </button>

            <!-- Header banner -->
            <div class="glass-panel p-8 rounded-3xl bg-white border border-slate-200/50 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="flex items-center gap-2 text-[10px] font-bold text-cyan-600 uppercase tracking-widest">
                        <span x-text="`${selectedClass} Standard`"></span>
                        <span>•</span>
                        <span x-text="selectedSubject"></span>
                    </div>
                    <h2 class="text-3xl font-black text-slate-800 tracking-tight mt-1" x-text="`List Chapterwise Mocktest`"></h2>
                </div>

                <!-- Search bar inside tests list -->
                <div class="relative w-full sm:w-72">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-base">search</span>
                    <input type="text" x-model="searchQuery" placeholder="Search chapterwise tests..."
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:border-cyan-500 focus:bg-white focus:ring-1 focus:ring-cyan-500/50 outline-none text-xs font-semibold placeholder:text-slate-400" />
                </div>
            </div>

            <!-- Tests listing cards grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="test in filteredTests" :key="test.id">
                    <div class="glass-panel p-6 rounded-3xl border border-slate-200/60 shadow-sm flex flex-col justify-between hover:shadow-md hover:border-slate-300 transition-all duration-350 bg-white/70">
                        <div>
                            <!-- Header tags -->
                            <div class="flex justify-between items-start mb-4">
                                <span :class="test.type === 'Full Syllabus' ? 'bg-indigo-50 border-indigo-100 text-indigo-700' : 'bg-cyan-50 border-cyan-100 text-cyan-700'"
                                    class="px-2.5 py-1 border rounded-lg text-[9px] font-bold uppercase tracking-wider"
                                    x-text="test.type">
                                </span>
                                <span class="text-[10px] text-slate-400 font-bold tracking-wider uppercase" x-text="test.subject"></span>
                            </div>

                            <!-- Title -->
                            <h4 class="text-base font-bold text-slate-800 tracking-tight leading-snug mb-3" x-text="test.title"></h4>

                            <!-- Quick Stats -->
                            <div class="flex gap-4 mb-6 text-slate-500 text-xs font-semibold">
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm text-slate-400">schedule</span>
                                    <span x-text="`${test.duration} Mins`"></span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm text-slate-400">quiz</span>
                                    <span x-text="`${test.questions ? test.questions.length : 0} Questions`"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Start Button -->
                        <button @click="startTest(test)"
                            class="w-full py-3 bg-gradient-to-r from-cyan-700 to-cyan-500 text-white font-bold rounded-xl shadow-md shadow-cyan-900/10 hover:shadow-lg hover:scale-[0.99] transition-all flex items-center justify-center gap-2 cursor-pointer">
                            Start Mock Test <span class="material-symbols-outlined text-sm">play_arrow</span>
                        </button>
                    </div>
                </template>

                <!-- Empty state -->
                <div x-show="filteredTests.length === 0" class="col-span-full py-16 text-center">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <span class="material-symbols-outlined text-2xl">sentiment_dissatisfied</span>
                    </div>
                    <h5 class="text-base font-bold text-slate-700">No mock tests available</h5>
                    <p class="text-xs text-slate-400 mt-1">Try again later or search for another chapterwise test.</p>
                </div>
            </div>
        </div>

        <!-- ==================== STEP 4: ACTIVE TEST TAKING ==================== -->
        <div x-show="viewMode === 'testing'" class="grid grid-cols-1 lg:grid-cols-12 gap-8 animate-fade-in" style="display:none;">
            <!-- Left panel: Question display -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Test Meta Header -->
                <div class="glass-panel p-5 rounded-2xl flex justify-between items-center shadow-sm bg-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-cyan-100 text-cyan-700 flex items-center justify-center font-bold" x-text="`Q${currentQuestionIndex + 1}`"></div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm md:text-base" x-text="currentTest ? currentTest.title : ''"></h3>
                            <p class="text-[10px] font-bold text-cyan-600 uppercase tracking-widest mt-0.5" x-text="currentTest ? `${currentTest.subject} (Class ${currentTest.class_standard})` : ''"></p>
                        </div>
                    </div>

                    <!-- Time Counter -->
                    <div :class="timeLeft < 120 ? 'bg-red-50 border-red-200 text-red-600 animate-pulse' : 'bg-slate-100 border-slate-200 text-slate-700'"
                        class="flex items-center gap-2 px-4 py-2 border rounded-xl font-mono text-sm font-bold shadow-inner">
                        <span class="material-symbols-outlined text-base">timer</span>
                        <span x-text="formatTime(timeLeft)"></span>
                    </div>
                </div>

                <!-- Main Question Box -->
                <div class="glass-panel p-8 rounded-3xl border border-slate-200/60 bg-white shadow-sm space-y-6" x-show="currentTest && currentTest.questions && currentTest.questions[currentQuestionIndex]">
                    <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest" x-text="`Question ${currentQuestionIndex + 1} of ${currentTest ? currentTest.questions.length : 0}`"></span>
                        <button @click="toggleMarkForReview()"
                            :class="markedForReview[currentQuestionIndex] ? 'bg-amber-100 border-amber-200 text-amber-700' : 'bg-slate-50 border-slate-200/60 text-slate-500 hover:bg-slate-100'"
                            class="flex items-center gap-1.5 px-3 py-1.5 border rounded-lg text-xs font-bold transition-all">
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;" x-show="markedForReview[currentQuestionIndex]">star</span>
                            <span class="material-symbols-outlined text-sm" x-show="!markedForReview[currentQuestionIndex]">star_border</span>
                            <span x-text="markedForReview[currentQuestionIndex] ? 'Marked' : 'Mark for Review'"></span>
                        </button>
                    </div>

                    <!-- Question text -->
                    <p class="text-base md:text-lg font-bold text-slate-800 leading-relaxed" x-text="currentTest && currentTest.questions[currentQuestionIndex] ? currentTest.questions[currentQuestionIndex].questionText : ''"></p>

                    <!-- Question options -->
                    <div class="space-y-3 pt-2">
                        <template x-for="(opt, oIdx) in (currentTest && currentTest.questions[currentQuestionIndex] ? currentTest.questions[currentQuestionIndex].options : [])" :key="oIdx">
                            <button @click="selectOption(opt)"
                                :class="answers[currentQuestionIndex] === opt ? 'bg-cyan-50 border-2 border-cyan-600 text-cyan-900 shadow-sm' : 'bg-slate-50/50 hover:bg-slate-100 border border-slate-200/80 text-slate-700'"
                                class="w-full text-left p-4 rounded-xl flex items-center gap-3 transition-all duration-200 group cursor-pointer">
                                <div :class="answers[currentQuestionIndex] === opt ? 'bg-cyan-600 border-cyan-600 text-white' : 'bg-white border-slate-300 text-slate-500'"
                                    class="w-6 h-6 rounded-full border flex items-center justify-center font-bold text-xs shrink-0 transition-colors"
                                    x-text="String.fromCharCode(65 + oIdx)">
                                </div>
                                <span class="text-sm font-semibold tracking-tight" x-text="opt"></span>
                            </button>
                        </template>
                    </div>

                    <!-- Bottom Nav -->
                    <div class="flex justify-between items-center pt-6 border-t border-slate-100 mt-8 gap-3">
                        <div class="flex gap-2">
                            <button @click="clearResponse()"
                                class="px-5 py-2.5 rounded-lg bg-slate-50 border border-slate-200 text-xs font-bold text-slate-500 hover:bg-slate-100 transition-colors cursor-pointer">
                                Clear Response
                            </button>
                        </div>
                        <div class="flex gap-2">
                            <button @click="prevQuestion()" :disabled="currentQuestionIndex === 0"
                                class="flex items-center gap-1.5 px-4 py-2.5 border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 rounded-lg disabled:opacity-40 disabled:hover:bg-transparent cursor-pointer">
                                <span class="material-symbols-outlined text-sm">arrow_back</span> Previous
                            </button>
                            <button @click="nextQuestion()" x-show="currentQuestionIndex < (currentTest ? currentTest.questions.length - 1 : 0)"
                                class="flex items-center gap-1.5 px-4 py-2.5 bg-slate-800 text-white text-xs font-bold hover:bg-slate-900 rounded-lg cursor-pointer">
                                Next <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </button>
                            <button @click="submitExam()" x-show="currentQuestionIndex === (currentTest ? currentTest.questions.length - 1 : 0)"
                                class="flex items-center gap-1.5 px-6 py-2.5 bg-green-600 text-white text-xs font-bold hover:bg-green-700 rounded-lg cursor-pointer shadow-md shadow-green-500/10">
                                Submit Exam <span class="material-symbols-outlined text-sm">check</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right panel: Questions status panel -->
            <div class="lg:col-span-4 space-y-6">
                <div class="glass-panel p-6 rounded-3xl border border-slate-200/60 bg-white shadow-sm flex flex-col justify-between h-full min-h-[400px]">
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm tracking-tight mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-slate-400">grid_on</span> Question Palette
                        </h4>

                        <!-- Palette Grid -->
                        <div class="grid grid-cols-5 gap-2.5">
                            <template x-for="(q, qIdx) in (currentTest ? currentTest.questions : [])" :key="qIdx">
                                <button @click="currentQuestionIndex = qIdx"
                                    :class="[
                                        currentQuestionIndex === qIdx ? 'ring-2 ring-cyan-700' : '',
                                        markedForReview[qIdx] ? 'bg-amber-500 border-amber-600 text-white font-bold' :
                                        (answers[qIdx] !== undefined ? 'bg-green-600 border-green-700 text-white font-bold' : 'bg-slate-100 border-slate-200 text-slate-600')
                                    ]"
                                    class="w-10 h-10 border rounded-xl flex items-center justify-center text-xs font-semibold transition-all cursor-pointer"
                                    x-text="qIdx + 1">
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Color guides -->
                    <div class="pt-6 border-t border-slate-100 mt-6 grid grid-cols-2 gap-3 text-[11px] font-bold text-slate-500">
                        <div class="flex items-center gap-2">
                            <span class="w-3.5 h-3.5 rounded-md bg-green-600 border border-green-700 block"></span> Answered
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3.5 h-3.5 rounded-md bg-amber-500 border border-amber-600 block"></span> Review
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3.5 h-3.5 rounded-md bg-slate-100 border border-slate-200 block"></span> Not Attempted
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3.5 h-3.5 rounded-md ring-2 ring-cyan-700 bg-white block"></span> Selected
                        </div>
                    </div>

                    <!-- Final Submission Button -->
                    <div class="pt-6 border-t border-slate-100 mt-6">
                        <button @click="submitExam()"
                            class="w-full py-3 bg-red-50 hover:bg-red-100 border border-red-200 text-red-700 font-bold rounded-xl text-xs flex items-center justify-center gap-2 transition-all cursor-pointer">
                            <span class="material-symbols-outlined text-sm">logout</span> Terminate &amp; Submit Test
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== STEP 5: REVIEW RESPONSES ==================== -->
        <div x-show="viewMode === 'review'" class="space-y-8 animate-fade-in" style="display:none;">
            <!-- Header cards -->
            <div class="glass-panel p-8 rounded-3xl flex flex-col md:flex-row justify-between items-start md:items-center gap-6 shadow-sm bg-white border border-slate-200/50">
                <div>
                    <h2 class="text-3xl font-black text-slate-800 tracking-tight">Review Answers &amp; Solutions</h2>
                    <p class="text-sm font-medium text-slate-500 mt-1" x-text="currentTest ? `${currentTest.title} assessment report` : ''"></p>
                </div>
                <button @click="viewMode = 'test_list'"
                    class="px-6 py-2.5 bg-slate-800 text-white font-bold rounded-xl text-xs flex items-center gap-2 hover:bg-slate-900 transition-all cursor-pointer">
                    <span class="material-symbols-outlined text-sm">arrow_back</span> Back to Mock Tests
                </button>
            </div>

            <!-- Detailed feedback report -->
            <div class="space-y-6">
                <template x-for="(item, idx) in (scoreData ? scoreData.results : [])" :key="idx">
                    <div class="glass-panel p-6 rounded-2xl border border-slate-200 bg-white space-y-4 shadow-sm"
                        :class="item.isCorrect ? 'border-l-4 border-l-green-500' : (item.selectedAnswer ? 'border-l-4 border-l-red-500' : 'border-l-4 border-l-slate-400')">
                        <div class="flex justify-between items-start">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest" x-text="`Question ${idx + 1}`"></span>
                            <span :class="item.isCorrect ? 'bg-green-50 text-green-700 border-green-200' : (item.selectedAnswer ? 'bg-red-50 text-red-700 border-red-200' : 'bg-slate-50 text-slate-500 border-slate-200')"
                                class="px-2.5 py-1 border rounded-lg text-[9px] font-bold uppercase tracking-wider"
                                x-text="item.isCorrect ? 'Correct' : (item.selectedAnswer ? 'Incorrect' : 'Unattempted')">
                            </span>
                        </div>

                        <!-- Question text -->
                        <p class="text-base font-bold text-slate-800" x-text="currentTest && currentTest.questions[idx] ? currentTest.questions[idx].questionText : ''"></p>

                        <!-- Answer states -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                            <div class="p-4 rounded-xl border border-slate-100"
                                 :class="item.isCorrect ? 'bg-green-50/55 border-green-200/50' : (item.selectedAnswer ? 'bg-red-50/55 border-red-200/50' : 'bg-slate-50 border-slate-200/50')">
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Your Selection</span>
                                <span class="text-sm font-semibold" :class="item.isCorrect ? 'text-green-800' : (item.selectedAnswer ? 'text-red-800' : 'text-slate-500')" x-text="item.selectedAnswer || 'Not answered'"></span>
                            </div>
                            <div class="p-4 rounded-xl bg-green-50/30 border border-green-200/30">
                                <span class="text-[9px] font-bold text-green-600 uppercase tracking-widest block mb-1">Correct Answer</span>
                                <span class="text-sm font-bold text-green-800" x-text="item.correctAnswer"></span>
                            </div>
                        </div>

                        <!-- Explanation -->
                        <div x-show="item.explanation" class="p-4 rounded-xl bg-cyan-50/30 border border-cyan-100/30 mt-3">
                            <span class="text-[9px] font-bold text-cyan-600 uppercase tracking-widest block mb-1 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">info</span> Solution &amp; Explanation
                            </span>
                            <p class="text-xs font-semibold text-cyan-900 leading-relaxed" x-text="item.explanation"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- ==================== SCORE DIALOG POPUP ==================== -->
        <div x-show="showScorePopup" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-md" style="display:none;" x-transition>
            <div class="glass-panel w-full max-w-md bg-white p-8 rounded-[2.5rem] border border-slate-200/80 shadow-2xl relative text-center flex flex-col justify-between items-center transform scale-100 transition-all duration-300"
                 @click.away="closeScorePopup()" x-show="showScorePopup" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                
                <!-- Success icon/confetti state -->
                <div class="w-20 h-20 rounded-full flex items-center justify-center mb-6 shadow-lg shadow-cyan-500/20 bg-gradient-to-br from-cyan-600 to-cyan-500 text-white">
                    <span class="material-symbols-outlined text-[36px]" x-text="scoreData && (scoreData.score / scoreData.total) >= 0.5 ? 'emoji_events' : 'school'"></span>
                </div>

                <!-- Title feedback -->
                <h3 class="text-2xl font-black text-slate-800 tracking-tight"
                    x-text="scoreData && (scoreData.score / scoreData.total) >= 0.8 ? 'Outstanding Job!' : (scoreData && (scoreData.score / scoreData.total) >= 0.5 ? 'Good Progress!' : 'Keep Practicing!')">
                </h3>
                <p class="text-sm font-semibold text-slate-400 mt-1">You have completed the mock test assessment.</p>

                <!-- Glowing circular score display -->
                <div class="my-8 relative w-40 h-40 flex items-center justify-center">
                    <svg class="w-full h-full transform -rotate-90">
                        <circle cx="80" cy="80" r="70" stroke="#f1f5f9" stroke-width="12" fill="transparent" />
                        <circle cx="80" cy="80" r="70" stroke="#006479" stroke-width="12" fill="transparent"
                                :stroke-dasharray="440"
                                :stroke-dashoffset="440 - (scoreData ? (scoreData.score / scoreData.total) * 440 : 0)"
                                class="transition-all duration-1000 ease-out" />
                    </svg>
                    <div class="absolute flex flex-col items-center">
                        <span class="text-4xl font-black text-slate-800 tabular-nums" x-text="scoreData ? `${scoreData.score}/${scoreData.total}` : '0/0'"></span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Score</span>
                    </div>
                </div>

                <!-- Stats breakdown details -->
                <div class="w-full grid grid-cols-3 gap-3 bg-slate-50 border border-slate-100 rounded-2xl p-4 mb-6 text-center">
                    <div>
                        <span class="text-base font-black text-green-600" x-text="scoreData ? scoreData.score : 0"></span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block mt-0.5">Correct</span>
                    </div>
                    <div class="border-x border-slate-200">
                        <span class="text-base font-black text-red-500" x-text="scoreData ? (scoreData.total - scoreData.score) : 0"></span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block mt-0.5">Incorrect</span>
                    </div>
                    <div>
                        <span class="text-base font-black text-cyan-800" x-text="scoreData ? `${Math.round((scoreData.score / scoreData.total) * 100)}%` : '0%'"></span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block mt-0.5">Ratio</span>
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="w-full flex gap-3">
                    <button @click="closeScorePopup(); viewMode = 'review';"
                        class="flex-1 py-3.5 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl text-xs transition-colors cursor-pointer">
                        Review Answers
                    </button>
                    <button @click="closeScorePopup(); viewMode = 'test_list';"
                        class="flex-1 py-3.5 border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-xs transition-colors cursor-pointer">
                        Back to Tests
                    </button>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('mockTestApp', () => ({
                viewMode: 'class_select',
                selectedClass: '{{ $admission && $admission->course_type === 'Secondary' ? '10th' : '12th' }}',
                selectedSubject: '',
                searchQuery: '',

                // Test taking state
                allTests: @json($mockTests),
                currentTest: null,
                currentQuestionIndex: 0,
                answers: {},
                markedForReview: {},
                timeLeft: 0,
                timerInterval: null,

                // Score state
                showScorePopup: false,
                scoreData: null,

                // Methods
                selectClass(c) {
                    this.selectedClass = c;
                    this.selectedSubject = '';
                    this.viewMode = 'subject_select';
                },
                selectSubject(s) {
                    this.selectedSubject = s;
                    this.viewMode = 'test_list';
                },
                goBack() {
                    if (this.viewMode === 'subject_select') {
                        this.viewMode = 'class_select';
                        this.selectedClass = '';
                    } else if (this.viewMode === 'test_list') {
                        this.viewMode = 'subject_select';
                        this.selectedSubject = '';
                    } else if (this.viewMode === 'review') {
                        this.viewMode = 'test_list';
                    }
                },
                get filteredSubjects() {
                    if (this.selectedClass === '10th') {
                        return [
                            { name: 'Mathematics (211)', icon: 'calculate', bg: 'from-blue-500/10 to-indigo-500/10', border: 'border-blue-200/50', text: 'text-blue-700' },
                            { name: 'Science & Technology (212)', icon: 'science', bg: 'from-emerald-500/10 to-teal-500/10', border: 'border-emerald-200/50', text: 'text-emerald-700' },
                            { name: 'Social Science (213)', icon: 'public', bg: 'from-amber-500/10 to-orange-500/10', border: 'border-amber-200/50', text: 'text-amber-700' },
                            { name: 'Economics (214)', icon: 'payments', bg: 'from-rose-500/10 to-red-500/10', border: 'border-rose-200/50', text: 'text-rose-700' },
                            { name: 'Business Studies (215)', icon: 'business_center', bg: 'from-indigo-500/10 to-purple-500/10', border: 'border-indigo-200/50', text: 'text-indigo-700' },
                            { name: 'Home Science (216)', icon: 'home', bg: 'from-pink-500/10 to-rose-500/10', border: 'border-pink-200/50', text: 'text-pink-700' },
                            { name: 'Psychology (222)', icon: 'psychology', bg: 'from-violet-500/10 to-purple-500/10', border: 'border-violet-200/50', text: 'text-violet-700' },
                            { name: 'Indian Culture & Heritage (223)', icon: 'account_balance', bg: 'from-orange-500/10 to-yellow-500/10', border: 'border-orange-200/50', text: 'text-orange-700' },
                            { name: 'Accountancy (224)', icon: 'account_balance_wallet', bg: 'from-teal-500/10 to-cyan-500/10', border: 'border-teal-200/50', text: 'text-teal-700' },
                            { name: 'Painting (225)', icon: 'palette', bg: 'from-fuchsia-500/10 to-pink-500/10', border: 'border-fuchsia-200/50', text: 'text-fuchsia-700' },
                            { name: 'Data Entry Operations (229)', icon: 'keyboard', bg: 'from-slate-500/10 to-slate-700/10', border: 'border-slate-200/50', text: 'text-slate-700' },
                            { name: 'Hindustani Music (242)', icon: 'music_note', bg: 'from-yellow-500/10 to-amber-500/10', border: 'border-yellow-200/50', text: 'text-yellow-700' },
                            { name: 'Carnatic Sangeet (243)', icon: 'library_music', bg: 'from-red-500/10 to-rose-500/10', border: 'border-red-200/50', text: 'text-red-700' },
                            { name: 'Hindi (201)', icon: 'translate', bg: 'from-cyan-500/10 to-blue-500/10', border: 'border-cyan-200/50', text: 'text-cyan-700' },
                            { name: 'English (202)', icon: 'menu_book', bg: 'from-purple-500/10 to-fuchsia-500/10', border: 'border-purple-200/50', text: 'text-purple-700' },
                            { name: 'Bengali (203)', icon: 'translate', bg: 'from-indigo-500/10 to-blue-500/10', border: 'border-indigo-200/50', text: 'text-indigo-700' },
                            { name: 'Marathi (204)', icon: 'translate', bg: 'from-sky-500/10 to-blue-500/10', border: 'border-sky-200/50', text: 'text-sky-700' },
                            { name: 'Telugu (205)', icon: 'translate', bg: 'from-teal-500/10 to-cyan-500/10', border: 'border-teal-200/50', text: 'text-teal-700' },
                            { name: 'Urdu (206)', icon: 'translate', bg: 'from-emerald-500/10 to-teal-500/10', border: 'border-emerald-200/50', text: 'text-emerald-700' },
                            { name: 'Gujarati (207)', icon: 'translate', bg: 'from-amber-500/10 to-yellow-500/10', border: 'border-amber-200/50', text: 'text-amber-700' },
                            { name: 'Kannada (208)', icon: 'translate', bg: 'from-orange-500/10 to-amber-500/10', border: 'border-orange-200/50', text: 'text-orange-700' },
                            { name: 'Sanskrit (209)', icon: 'translate', bg: 'from-rose-500/10 to-pink-500/10', border: 'border-rose-200/50', text: 'text-rose-700' },
                            { name: 'Punjabi (210)', icon: 'translate', bg: 'from-red-500/10 to-rose-500/10', border: 'border-red-200/50', text: 'text-red-700' },
                            { name: 'Assamese (228)', icon: 'translate', bg: 'from-purple-500/10 to-indigo-500/10', border: 'border-purple-200/50', text: 'text-purple-700' },
                            { name: 'Nepali (231)', icon: 'translate', bg: 'from-fuchsia-500/10 to-pink-500/10', border: 'border-fuchsia-200/50', text: 'text-fuchsia-700' },
                            { name: 'Malayalam (232)', icon: 'translate', bg: 'from-violet-500/10 to-purple-500/10', border: 'border-violet-200/50', text: 'text-violet-700' },
                            { name: 'Odia (233)', icon: 'translate', bg: 'from-indigo-500/10 to-purple-500/10', border: 'border-indigo-200/50', text: 'text-indigo-700' },
                            { name: 'Arabic (235)', icon: 'translate', bg: 'from-slate-500/10 to-slate-700/10', border: 'border-slate-200/50', text: 'text-slate-700' },
                            { name: 'Persian (236)', icon: 'translate', bg: 'from-zinc-500/10 to-zinc-700/10', border: 'border-zinc-200/50', text: 'text-zinc-700' },
                            { name: 'Tamil (237)', icon: 'translate', bg: 'from-neutral-500/10 to-neutral-700/10', border: 'border-neutral-200/50', text: 'text-neutral-700' },
                            { name: 'Sindhi (238)', icon: 'translate', bg: 'from-stone-500/10 to-stone-700/10', border: 'border-stone-200/50', text: 'text-stone-700' }
                        ];
                    } else {
                        return [
                            { name: 'Mathematics (311)', icon: 'calculate', bg: 'from-blue-500/10 to-indigo-500/10', border: 'border-blue-200/50', text: 'text-blue-700' },
                            { name: 'Physics (312)', icon: 'bolt', bg: 'from-amber-500/10 to-yellow-500/10', border: 'border-amber-200/50', text: 'text-amber-700' },
                            { name: 'Chemistry (313)', icon: 'science', bg: 'from-teal-500/10 to-emerald-500/10', border: 'border-emerald-200/50', text: 'text-emerald-700' },
                            { name: 'Biology (314)', icon: 'biotech', bg: 'from-rose-500/10 to-pink-500/10', border: 'border-pink-200/50', text: 'text-rose-700' },
                            { name: 'Environmental Science (333)', icon: 'eco', bg: 'from-green-500/10 to-emerald-500/10', border: 'border-green-200/50', text: 'text-green-700' },
                            { name: 'Computer Science (330)', icon: 'computer', bg: 'from-indigo-500/10 to-purple-500/10', border: 'border-indigo-200/50', text: 'text-indigo-700' },
                            { name: 'History (315)', icon: 'history', bg: 'from-amber-500/10 to-orange-500/10', border: 'border-amber-200/50', text: 'text-amber-700' },
                            { name: 'Geography (316)', icon: 'map', bg: 'from-sky-500/10 to-cyan-500/10', border: 'border-sky-200/50', text: 'text-sky-700' },
                            { name: 'Political Science (317)', icon: 'gavel', bg: 'from-purple-500/10 to-violet-500/10', border: 'border-purple-200/50', text: 'text-purple-700' },
                            { name: 'Economics (318)', icon: 'payments', bg: 'from-rose-500/10 to-red-500/10', border: 'border-rose-200/50', text: 'text-rose-700' },
                            { name: 'Business Studies (319)', icon: 'business_center', bg: 'from-slate-500/10 to-slate-700/10', border: 'border-slate-200/50', text: 'text-slate-700' },
                            { name: 'Accountancy (320)', icon: 'account_balance_wallet', bg: 'from-teal-500/10 to-cyan-500/10', border: 'border-teal-200/50', text: 'text-teal-700' },
                            { name: 'Home Science (321)', icon: 'home', bg: 'from-pink-500/10 to-rose-500/10', border: 'border-pink-200/50', text: 'text-pink-700' },
                            { name: 'Psychology (328)', icon: 'psychology', bg: 'from-violet-500/10 to-purple-500/10', border: 'border-violet-200/50', text: 'text-violet-700' },
                            { name: 'Sociology (331)', icon: 'groups', bg: 'from-orange-500/10 to-yellow-500/10', border: 'border-orange-200/50', text: 'text-orange-700' },
                            { name: 'Mass Communication (335)', icon: 'settings_input_antenna', bg: 'from-blue-500/10 to-cyan-500/10', border: 'border-blue-200/50', text: 'text-blue-700' },
                            { name: 'Data Entry Operations (336)', icon: 'keyboard', bg: 'from-slate-500/10 to-slate-700/10', border: 'border-slate-200/50', text: 'text-slate-700' },
                            { name: 'Tourism (337)', icon: 'flight_takeoff', bg: 'from-sky-500/10 to-teal-500/10', border: 'border-sky-200/50', text: 'text-sky-700' },
                            { name: 'Painting (332)', icon: 'palette', bg: 'from-fuchsia-500/10 to-pink-500/10', border: 'border-fuchsia-200/50', text: 'text-fuchsia-700' },
                            { name: 'Hindi (301)', icon: 'translate', bg: 'from-cyan-500/10 to-blue-500/10', border: 'border-cyan-200/50', text: 'text-cyan-700' },
                            { name: 'English (302)', icon: 'menu_book', bg: 'from-purple-500/10 to-fuchsia-500/10', border: 'border-purple-200/50', text: 'text-purple-700' },
                            { name: 'Bengali (303)', icon: 'translate', bg: 'from-indigo-500/10 to-blue-500/10', border: 'border-indigo-200/50', text: 'text-indigo-700' },
                            { name: 'Tamil (304)', icon: 'translate', bg: 'from-sky-500/10 to-blue-500/10', border: 'border-sky-200/50', text: 'text-sky-700' },
                            { name: 'Odia (305)', icon: 'translate', bg: 'from-teal-500/10 to-cyan-500/10', border: 'border-teal-200/50', text: 'text-teal-700' },
                            { name: 'Urdu (306)', icon: 'translate', bg: 'from-emerald-500/10 to-teal-500/10', border: 'border-emerald-200/50', text: 'text-emerald-700' },
                            { name: 'Gujarati (307)', icon: 'translate', bg: 'from-amber-500/10 to-yellow-500/10', border: 'border-amber-200/50', text: 'text-amber-700' },
                            { name: 'Sanskrit (309)', icon: 'translate', bg: 'from-rose-500/10 to-pink-500/10', border: 'border-rose-200/50', text: 'text-rose-700' },
                            { name: 'Punjabi (310)', icon: 'translate', bg: 'from-red-500/10 to-rose-500/10', border: 'border-red-200/50', text: 'text-red-700' }
                        ];
                    }
                },
                get filteredTests() {
                    return this.allTests.filter(test => {
                        const matchesClass = (test.class_standard || '12th') === this.selectedClass;
                        
                        const cleanTestSubj = test.subject ? test.subject.replace(/\s*\(\d+\)/g, '').trim().toLowerCase() : '';
                        const cleanSelectedSubj = this.selectedSubject ? this.selectedSubject.replace(/\s*\(\d+\)/g, '').trim().toLowerCase() : '';
                        
                        let matchesSubject = test.subject === this.selectedSubject || cleanTestSubj === cleanSelectedSubj;
                        // Special handling for Science vs Science & Technology (212)
                        if (!matchesSubject && cleanTestSubj === 'science' && cleanSelectedSubj === 'science & technology') {
                            matchesSubject = true;
                        }
                        
                        const matchesSearch = test.title.toLowerCase().includes(this.searchQuery.toLowerCase());
                        return matchesClass && matchesSubject && matchesSearch;
                    });
                },
                startTest(test) {
                    this.currentTest = test;
                    this.answers = {};
                    this.markedForReview = {};
                    this.currentQuestionIndex = 0;
                    this.timeLeft = test.duration * 60;
                    this.viewMode = 'testing';
                    this.startTimer();
                },
                startTimer() {
                    if (this.timerInterval) clearInterval(this.timerInterval);
                    this.timerInterval = setInterval(() => {
                        if (this.timeLeft > 0) {
                            this.timeLeft--;
                        } else {
                            clearInterval(this.timerInterval);
                            this.submitExam(true);
                        }
                    }, 1000);
                },
                formatTime(seconds) {
                    const m = Math.floor(seconds / 60);
                    const s = seconds % 60;
                    return `${m}:${s < 10 ? '0' + s : s}`;
                },
                selectOption(opt) {
                    this.answers[this.currentQuestionIndex] = opt;
                },
                clearResponse() {
                    delete this.answers[this.currentQuestionIndex];
                },
                toggleMarkForReview() {
                    this.markedForReview[this.currentQuestionIndex] = !this.markedForReview[this.currentQuestionIndex];
                },
                prevQuestion() {
                    if (this.currentQuestionIndex > 0) this.currentQuestionIndex--;
                },
                nextQuestion() {
                    if (this.currentQuestionIndex < this.currentTest.questions.length - 1) {
                        this.currentQuestionIndex++;
                    }
                },
                submitExam(isAuto = false) {
                    if (!isAuto && !confirm('Are you sure you want to submit your mock test answers?')) return;

                    clearInterval(this.timerInterval);

                    const payload = {
                        answers: this.answers
                    };

                    fetch(`/mocktests/${this.currentTest.id}/submit`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.scoreData = data;
                            this.showScorePopup = true;
                        } else {
                            alert('Submission failed: ' + (data.message || 'Error occurred'));
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Submission failed. Check your network connection.');
                    });
                },
                closeScorePopup() {
                    this.showScorePopup = false;
                }
            }));
        });
    </script>
</x-student-layout>