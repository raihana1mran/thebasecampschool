<x-admin-layout>
    <div x-data="adminMockTestApp" class="py-12 px-4 max-w-7xl mx-auto space-y-8 relative z-10">
        <!-- ==================== STEP 1: CLASS SELECTION ==================== -->
        <div x-show="viewMode === 'class_select'" class="space-y-10 animate-fade-in">
            <!-- Header Banner -->
            <div class="glass-panel p-8 md:p-10 rounded-[2rem] bg-gradient-to-r from-slate-800 to-slate-950 text-white shadow-xl relative overflow-hidden">
                <div class="absolute right-0 top-0 w-80 h-80 bg-slate-600/20 rounded-full blur-[80px] pointer-events-none"></div>
                <div class="relative z-10 space-y-3 max-w-2xl">
                    <span class="text-[10px] font-black tracking-[0.2em] uppercase text-slate-400">Mock Tests Engine</span>
                    <h2 class="text-3xl md:text-5xl font-black tracking-tight leading-none">Create Mocktest Wise Class</h2>
                    <p class="text-sm md:text-base text-slate-200/80 font-medium">Select a grade standard to configure, search, and manage student mock tests.</p>
                </div>
            </div>

            <!-- Two large Class Selection Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- 10th Standard Card -->
                <button @click="selectClass('10th')"
                    class="glass-panel p-8 rounded-[2.5rem] bg-white border border-slate-200/60 shadow-lg shadow-slate-200/30 text-left hover:scale-[1.02] hover:shadow-xl hover:border-primary/25 transition-all duration-300 group cursor-pointer flex flex-col justify-between h-80">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-slate-50 text-primary flex items-center justify-center shadow-inner group-hover:bg-primary group-hover:text-white transition-all duration-300">
                            <span class="material-symbols-outlined text-[32px]">school</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-slate-800 tracking-tight">10th Standard</h3>
                            <p class="text-xs text-primary font-bold uppercase tracking-wider mt-1">Secondary Education</p>
                        </div>
                        <p class="text-sm text-slate-500 leading-relaxed font-medium">Manage, edit, and organize chapterwise and full syllabus tests for all 10th Secondary grade subjects.</p>
                    </div>
                    <div class="flex items-center justify-between w-full pt-4">
                        <span class="px-4 py-1.5 bg-slate-100 rounded-full text-xs font-bold text-slate-600" x-text="`${count10th} Tests Configured`"></span>
                        <div class="flex items-center gap-2 text-primary font-bold text-sm tracking-tight group-hover:translate-x-1.5 transition-transform duration-300">
                            Manage Subjects <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </div>
                    </div>
                </button>

                <!-- 12th Standard Card -->
                <button @click="selectClass('12th')"
                    class="glass-panel p-8 rounded-[2.5rem] bg-white border border-slate-200/60 shadow-lg shadow-slate-200/30 text-left hover:scale-[1.02] hover:shadow-xl hover:border-primary/25 transition-all duration-300 group cursor-pointer flex flex-col justify-between h-80">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-slate-50 text-primary flex items-center justify-center shadow-inner group-hover:bg-primary group-hover:text-white transition-all duration-300">
                            <span class="material-symbols-outlined text-[32px]">workspace_premium</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-slate-800 tracking-tight">12th Standard</h3>
                            <p class="text-xs text-primary font-bold uppercase tracking-wider mt-1">Senior Secondary Education</p>
                        </div>
                        <p class="text-sm text-slate-500 leading-relaxed font-medium">Manage, edit, and organize chapterwise and full syllabus tests for all 12th Senior Secondary grade subjects.</p>
                    </div>
                    <div class="flex items-center justify-between w-full pt-4">
                        <span class="px-4 py-1.5 bg-slate-100 rounded-full text-xs font-bold text-slate-600" x-text="`${count12th} Tests Configured`"></span>
                        <div class="flex items-center gap-2 text-primary font-bold text-sm tracking-tight group-hover:translate-x-1.5 transition-transform duration-300">
                            Manage Subjects <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </div>
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
            <div class="glass-panel p-8 rounded-3xl bg-white border border-slate-200/50 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <span class="text-[10px] font-bold text-primary uppercase tracking-widest block" x-text="`${selectedClass} Standard Secondary`"></span>
                    <h2 class="text-3xl font-black text-slate-800 tracking-tight mt-1">Select Subject</h2>
                    <p class="text-sm font-medium text-slate-500 mt-1">Select a subject directory to view and manage its tests.</p>
                </div>
                <!-- Universal New Test Button -->
                <button @click="openCreateModal()"
                    class="px-6 py-3 bg-primary text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all flex items-center gap-3 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:rotate-90 transition-transform"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
                    New Test
                </button>
            </div>

            <!-- Subject Cards Grid (Compact layout for large lists) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <template x-for="subj in filteredSubjectsList" :key="subj.name">
                    <button @click="selectSubject(subj.name)"
                        class="glass-panel p-4 rounded-2xl bg-white border border-slate-200/50 shadow-sm text-left hover:scale-[1.02] hover:shadow-md hover:border-primary/25 transition-all duration-200 cursor-pointer flex justify-between items-center w-full">
                        <div class="flex gap-3 items-center overflow-hidden">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 border" :class="[subj.bg, subj.border]">
                                <span class="material-symbols-outlined text-[20px]" :class="subj.text" x-text="subj.icon"></span>
                            </div>
                            <div class="overflow-hidden mr-2">
                                <h4 class="font-bold text-slate-800 text-xs sm:text-sm tracking-tight truncate" x-text="subj.name"></h4>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-600 shrink-0" x-text="`${getSubjectTestCount(subj.name)} Tests`"></span>
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
            <div class="glass-panel p-8 rounded-3xl bg-white border border-slate-200/50 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <div class="flex items-center gap-2 text-[10px] font-bold text-primary uppercase tracking-widest">
                        <span x-text="`${selectedClass} Standard`"></span>
                        <span>•</span>
                        <span x-text="selectedSubject"></span>
                    </div>
                    <h2 class="text-3xl font-black text-slate-800 tracking-tight mt-1">Manage Chapterwise Mocktests</h2>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                    <!-- Search bar -->
                    <div class="relative w-full sm:w-72">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-base">search</span>
                        <input type="text" x-model="searchQuery" placeholder="Search mock tests..."
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:border-primary/50 focus:bg-white focus:ring-1 focus:ring-primary/50 outline-none text-xs font-semibold placeholder:text-slate-400" />
                    </div>
                    
                    <!-- Create Test button -->
                    <button @click="openCreateModal()"
                        class="px-6 py-3 bg-primary text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all flex items-center gap-3 group shrink-0 w-full sm:w-auto justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:rotate-90 transition-transform"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
                        New Test
                    </button>
                </div>
            </div>

            <!-- Tests Table -->
            <div class="glass-panel p-0 rounded-[2.5rem] bg-white border border-slate-200/50 shadow-sm overflow-hidden min-h-[300px]">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="uppercase text-slate-500 text-xs font-bold border-b border-slate-100 bg-slate-50/50">
                                <th class="py-5 px-8">Test Title</th>
                                <th class="py-5 px-8">Type</th>
                                <th class="py-5 px-8">Duration</th>
                                <th class="py-5 px-8">Questions</th>
                                <th class="py-5 px-8">Date Created</th>
                                <th class="py-5 px-8 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="test in filteredTests" :key="test.id">
                                <tr class="border-b border-slate-100 hover:bg-slate-50/40 transition-colors">
                                    <td class="py-5 px-8 font-bold text-slate-800 flex items-center gap-4">
                                        <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                        </div>
                                        <span x-text="test.title"></span>
                                    </td>
                                    <td class="py-5 px-8 text-[15px] font-medium text-slate-600">
                                        <span :class="test.type === 'Full Syllabus' ? 'bg-indigo-50 border-indigo-100 text-indigo-700' : 'bg-cyan-50 border-cyan-100 text-cyan-700'"
                                            class="px-2.5 py-1 border rounded-lg text-[10px] font-bold uppercase tracking-wider"
                                            x-text="test.type">
                                        </span>
                                    </td>
                                    <td class="py-5 px-8 text-[15px] font-medium text-slate-600" x-text="`${test.duration} mins`"></td>
                                    <td class="py-5 px-8 text-[15px] font-medium text-slate-600" x-text="test.questions ? test.questions.length : 0"></td>
                                    <td class="py-5 px-8 text-[15px] font-medium text-slate-600" x-text="formatDate(test.created_at)"></td>
                                    <td class="py-5 px-8 flex justify-end gap-2">
                                        <form method="POST" :action="'/admin/mocktests/' + test.id" onsubmit="return confirm('Are you sure you want to delete this test?');" class="inline">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="p-2.5 text-slate-400 hover:text-red-500 hover:bg-red-500/10 rounded-xl transition-colors border border-transparent hover:border-red-500/20" title="Delete Mock Test">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            </template>
                            
                            <!-- Empty row state -->
                            <tr x-show="filteredTests.length === 0">
                                <td colspan="6" class="py-16 text-center">
                                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                                        <span class="material-symbols-outlined text-2xl">sentiment_dissatisfied</span>
                                    </div>
                                    <h5 class="text-base font-bold text-slate-700">No mock tests available</h5>
                                    <p class="text-xs text-slate-400 mt-1">Try again or create a new test for this subject.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ==================== CREATE MOCK TEST MODAL ==================== -->
        <div x-show="isCreateModalOpen" class="fixed inset-0 z-50 flex items-center justify-center px-4 py-8" style="display: none;">
            <div 
                x-show="isCreateModalOpen"
                @click="isCreateModalOpen = false"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 backdrop-blur-none"
                x-transition:enter-end="opacity-100 backdrop-blur-md"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 backdrop-blur-md"
                x-transition:leave-end="opacity-0 backdrop-blur-none"
                class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"
            ></div>
            
            <div 
                x-show="isCreateModalOpen"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-10 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-10 scale-95"
                class="glass-panel w-full max-w-4xl bg-white p-10 rounded-[2.5rem] border border-slate-200/80 shadow-2xl relative z-10 flex flex-col h-full max-h-[90vh]"
            >
                <div class="flex justify-between items-center mb-8 flex-shrink-0">
                    <h2 class="text-3xl font-bold tracking-tight text-slate-800">Build New Mock Test</h2>
                    <button @click="isCreateModalOpen = false" class="p-3 hover:bg-slate-100 rounded-full text-slate-400 hover:text-slate-700 transition-colors border border-transparent hover:border-slate-200/30">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto pr-4 -mr-4 scrollbar-thin scrollbar-thumb-slate-200">
                    <form method="POST" action="/admin/mocktests" id="mocktest-form" class="space-y-8 pb-4">
                        @csrf
                        <div class="bg-slate-50 p-8 rounded-[2rem] border border-slate-100 shadow-inner">
                            <h3 class="font-bold tracking-tight text-xl mb-6 text-slate-800">Test Settings</h3>
                            <div class="grid md:grid-cols-3 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-bold tracking-wide uppercase text-slate-500 mb-2 ml-1">Test Title *</label>
                                    <input type="text" name="title" required class="w-full p-4 bg-white border border-slate-200 rounded-xl focus:border-primary/50 outline-none text-slate-800 font-medium placeholder:text-slate-400 shadow-sm" placeholder="e.g. Weekly Physics Quiz" />
                                </div>
                                <div>
                                    <label class="block text-sm font-bold tracking-wide uppercase text-slate-500 mb-2 ml-1">Duration (mins) *</label>
                                    <input type="number" name="duration" required min="1" value="60" class="w-full p-4 bg-white border border-slate-200 rounded-xl focus:border-primary/50 outline-none text-slate-800 font-medium shadow-sm" />
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-sm font-bold tracking-wide uppercase text-slate-500 mb-2 ml-1">Class / Standard *</label>
                                    <select name="class_standard" x-model="classStandard" @change="subjectModel = activeSubjects[0]" required class="w-full p-4 bg-white border border-slate-200 rounded-xl focus:border-primary/50 outline-none text-slate-800 font-medium appearance-none shadow-sm" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%23666%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1.2rem;">
                                        <option value="10th">10th Standard (Secondary)</option>
                                        <option value="12th">12th Standard (Senior Secondary)</option>
                                    </select>
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-sm font-bold tracking-wide uppercase text-slate-500 mb-2 ml-1">Subject *</label>
                                    <select name="subject" x-model="subjectModel" required class="w-full p-4 bg-white border border-slate-200 rounded-xl focus:border-primary/50 outline-none text-slate-800 font-medium appearance-none shadow-sm" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%23666%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1.2rem;">
                                        <template x-for="subj in activeSubjects" :key="subj">
                                            <option :value="subj" x-text="subj" :selected="subj === subjectModel"></option>
                                        </template>
                                    </select>
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-sm font-bold tracking-wide uppercase text-slate-500 mb-2 ml-1">Test Type</label>
                                    <select name="type" class="w-full p-4 bg-white border border-slate-200 rounded-xl focus:border-primary/50 outline-none text-slate-800 font-medium appearance-none shadow-sm" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%23666%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1.2rem;">
                                        <option value="Chapter-wise">Chapter-wise</option>
                                        <option value="Full Syllabus">Full Syllabus</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="flex justify-between items-center px-2">
                                <h3 class="font-bold tracking-tight text-xl text-slate-800" x-text="`Questions (${questions.length})`"></h3>
                                <button 
                                    type="button" 
                                    @click="questions.push({ questionText: '', options: ['', '', '', ''], correctAnswer: '', explanation: '' })"
                                    class="text-sm flex items-center gap-2 text-primary font-bold bg-slate-50 hover:bg-slate-100 px-4 py-2 border border-slate-200 rounded-xl transition-colors shadow-sm cursor-pointer"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg> 
                                    Add Question
                                </button>
                            </div>

                            <template x-for="(q, index) in questions" :key="index">
                                <div class="glass-panel p-8 border border-slate-200/80 rounded-[2rem] bg-slate-50/50 relative">
                                    <div class="absolute right-6 top-6">
                                        <button 
                                            type="button" 
                                            @click="if(questions.length > 1) questions.splice(index, 1)"
                                            :disabled="questions.length <= 1"
                                            class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-500/10 rounded-lg transition-colors border border-transparent hover:border-red-500/20 disabled:opacity-30 disabled:hover:bg-transparent disabled:hover:border-transparent disabled:hover:text-slate-400 cursor-pointer"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                        </button>
                                    </div>
                                    <h4 class="font-bold tracking-tight text-lg mb-6 text-slate-800" x-text="`Question ${index + 1}`"></h4>

                                    <div class="space-y-6">
                                        <div>
                                            <label class="block text-sm font-bold tracking-wide uppercase text-slate-500 mb-2 ml-1">Question Text</label>
                                            <textarea 
                                                required rows="2" 
                                                x-model="q.questionText"
                                                :name="`questions[${index}][questionText]`"
                                                class="w-full p-4 bg-white border border-slate-200 rounded-xl focus:border-primary/50 outline-none text-slate-800 font-medium resize-none shadow-sm"
                                            ></textarea>
                                        </div>

                                        <div class="grid md:grid-cols-2 gap-4">
                                            <template x-for="(opt, optIndex) in q.options" :key="optIndex">
                                                <div>
                                                    <label class="block text-xs font-bold tracking-wide uppercase text-slate-500 mb-2 ml-1" x-text="`Option ${String.fromCharCode(65 + optIndex)}`"></label>
                                                    <input 
                                                        type="text" required 
                                                        x-model="q.options[optIndex]"
                                                        :name="`questions[${index}][options][]`"
                                                        class="w-full p-3 bg-white border border-slate-200 rounded-lg focus:border-primary/50 outline-none text-slate-800 font-medium shadow-sm"
                                                    />
                                                </div>
                                            </template>
                                        </div>

                                        <div class="grid md:grid-cols-2 gap-6 pt-2">
                                            <div>
                                                <label class="block text-sm font-bold tracking-wide uppercase text-slate-500 mb-2 ml-1 flex items-center gap-3">
                                                    Correct Answer 
                                                    <span class="text-[9px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded-full border border-primary/20">Exact Match</span>
                                                </label>
                                                <input 
                                                    type="text" required 
                                                    x-model="q.correctAnswer"
                                                    :name="`questions[${index}][correctAnswer]`"
                                                    class="w-full p-4 bg-white border-2 border-primary/30 rounded-xl focus:border-primary outline-none text-slate-800 font-bold shadow-sm"
                                                />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-bold tracking-wide uppercase text-slate-500 mb-2 ml-1">Explanation (Optional)</label>
                                                <input 
                                                    type="text" 
                                                    x-model="q.explanation"
                                                    :name="`questions[${index}][explanation]`"
                                                    class="w-full p-4 bg-white border border-slate-200 rounded-xl focus:border-primary/50 outline-none text-slate-800 font-medium shadow-sm"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </form>
                </div>

                <div class="pt-8 flex justify-end gap-4 mt-2 flex-shrink-0 border-t border-slate-100">
                    <button type="button" @click="isCreateModalOpen = false" class="px-8 py-3 rounded-xl font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors border border-slate-200 cursor-pointer">
                        Cancel
                    </button>
                    <button type="submit" form="mocktest-form" class="px-8 py-3 rounded-xl font-bold bg-primary hover:bg-primary/90 text-white shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all min-w-[160px] flex items-center justify-center gap-2 cursor-pointer">
                        Publish Test
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                    </button>
                </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('adminMockTestApp', () => ({
                viewMode: 'class_select',
                selectedClass: '',
                selectedSubject: '',
                searchQuery: '',
                isCreateModalOpen: false,
                classStandard: '10th',
                subjectModel: '',
                allTests: @json($mockTests),
                questions: [{ questionText: '', options: ['', '', '', ''], correctAnswer: '', explanation: '' }],
                
                subjects10th: [
                    'Mathematics (211)', 'Science & Technology (212)', 'Social Science (213)', 'Economics (214)', 'Business Studies (215)', 'Home Science (216)', 'Psychology (222)', 'Indian Culture & Heritage (223)', 'Accountancy (224)', 'Painting (225)', 'Data Entry Operations (229)', 'Hindustani Music (242)', 'Carnatic Sangeet (243)', 'Hindi (201)', 'English (202)', 'Bengali (203)', 'Marathi (204)', 'Telugu (205)', 'Urdu (206)', 'Gujarati (207)', 'Kannada (208)', 'Sanskrit (209)', 'Punjabi (210)', 'Assamese (228)', 'Nepali (231)', 'Malayalam (232)', 'Odia (233)', 'Arabic (235)', 'Persian (236)', 'Tamil (237)', 'Sindhi (238)'
                ],
                subjects12th: [
                    'Mathematics (311)', 'Physics (312)', 'Chemistry (313)', 'Biology (314)', 'Environmental Science (333)', 'Computer Science (330)', 'History (315)', 'Geography (316)', 'Political Science (317)', 'Economics (318)', 'Business Studies (319)', 'Accountancy (320)', 'Home Science (321)', 'Psychology (328)', 'Sociology (331)', 'Mass Communication (335)', 'Data Entry Operations (336)', 'Tourism (337)', 'Painting (332)', 'Hindi (301)', 'English (302)', 'Bengali (303)', 'Tamil (304)', 'Odia (305)', 'Urdu (306)', 'Gujarati (307)', 'Sanskrit (309)', 'Punjabi (310)'
                ],
                get activeSubjects() {
                    return this.classStandard === '10th' ? this.subjects10th : this.subjects12th;
                },
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
                    }
                },
                get count10th() {
                    return this.allTests.filter(t => (t.class_standard || '12th') === '10th').length;
                },
                get count12th() {
                    return this.allTests.filter(t => (t.class_standard || '12th') === '12th').length;
                },
                getSubjectTestCount(subjName) {
                    const cleanSubj = subjName.replace(/\s*\(\d+\)/g, '').trim().toLowerCase();
                    return this.allTests.filter(t => {
                        const matchesClass = (t.class_standard || '12th') === this.selectedClass;
                        const cleanTSubj = t.subject ? t.subject.replace(/\s*\(\d+\)/g, '').trim().toLowerCase() : '';
                        let matchesSubject = t.subject === subjName || cleanTSubj === cleanSubj;
                        if (!matchesSubject && cleanTSubj === 'science' && cleanSubj === 'science & technology') {
                            matchesSubject = true;
                        }
                        return matchesClass && matchesSubject;
                    }).length;
                },
                get filteredSubjectsList() {
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
                        if (!matchesSubject && cleanTestSubj === 'science' && cleanSelectedSubj === 'science & technology') {
                            matchesSubject = true;
                        }
                        
                        const matchesSearch = test.title.toLowerCase().includes(this.searchQuery.toLowerCase());
                        return matchesClass && matchesSubject && matchesSearch;
                    });
                },
                openCreateModal() {
                    this.classStandard = this.selectedClass || '10th';
                    this.$nextTick(() => {
                        this.subjectModel = this.selectedSubject || this.activeSubjects[0] || '';
                    });
                    this.isCreateModalOpen = true;
                },
                formatDate(dateStr) {
                    if (!dateStr) return '';
                    const date = new Date(dateStr);
                    return date.toISOString().split('T')[0];
                }
            }));
        });
    </script>
</x-admin-layout>
