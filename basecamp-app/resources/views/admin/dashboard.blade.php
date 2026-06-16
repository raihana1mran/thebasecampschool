<x-admin-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6 sm:mb-8">
        <div class="text-lg sm:text-xl md:text-2xl font-bold">{{ __('overview_title') }}</div>
        <div class="flex items-center gap-2 sm:gap-4 w-full sm:w-auto">
            <button class="p-1.5 sm:p-2 rounded-xl hover:bg-cyan-50 transition-all">
                <span class="material-symbols-outlined text-slate-600 text-[20px] sm:text-[24px]">notifications</span>
            </button>
            <button class="signature-gradient hover:opacity-90 hover:scale-[1.02] text-on-primary px-3 sm:px-5 py-1.5 sm:py-2 rounded-xl text-[11px] sm:text-xs md:text-sm font-bold transition-all shadow-lg shadow-cyan-500/20 flex items-center gap-1.5 whitespace-nowrap">
                <span class="material-symbols-outlined text-sm">add</span>
                New Enrollment
            </button>
        </div>
    </header>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-6 mb-6 sm:mb-8">
        <div class="glass-panel p-4 sm:p-5 md:p-6 rounded-2xl">
            <p class="text-[9px] sm:text-[10px] font-bold uppercase tracking-widest text-primary mb-1 sm:mb-2">TOTAL STUDENTS</p>
            <p class="text-xl sm:text-2xl md:text-4xl font-extrabold text-cyan-700">{{ $studentCount ?? 892 }}</p>
        </div>
        <div class="glass-panel p-4 sm:p-5 md:p-6 rounded-2xl">
            <p class="text-[9px] sm:text-[10px] font-bold uppercase tracking-widest text-green-600 mb-1 sm:mb-2">REVENUE</p>
            <p class="text-xl sm:text-2xl md:text-4xl font-extrabold text-green-600">₹42.8L</p>
        </div>
        <div class="glass-panel p-4 sm:p-5 md:p-6 rounded-2xl col-span-1 sm:col-span-2 lg:col-span-1">
            <p class="text-[9px] sm:text-[10px] font-bold uppercase tracking-widest text-amber-600 mb-1 sm:mb-2">PENDING ADMISSIONS</p>
            <p class="text-xl sm:text-2xl md:text-4xl font-extrabold text-amber-600">{{ $pendingAdmissions ?? 15 }}</p>
        </div>
    </div>

    <!-- Table -->
    <div class="glass-panel rounded-2xl overflow-hidden">
        <div class="p-3 sm:p-4 md:p-6 border-b border-slate-200">
            <h3 class="text-base sm:text-lg font-bold">Student CRM</h3>
        </div>
        <div class="overflow-x-auto -mx-3 sm:mx-0">
            <table class="w-full text-left min-w-[480px] sm:min-w-0">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase">Name</th>
                        <th class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase">Status</th>
                        <th class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase">Course</th>
                        <th class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t border-slate-100">
                        <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-sm font-medium">Amitav G. Shahi</td>
                        <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4"><span class="px-1.5 sm:px-2 py-0.5 sm:py-1 bg-green-100 text-green-700 rounded-full text-[10px] sm:text-xs font-bold">Verified</span></td>
                        <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-sm">12th Science</td>
                        <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4"><button class="text-cyan-600 hover:underline text-sm font-medium">View</button></td>
                    </tr>
                    <tr class="border-t border-slate-100">
                        <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-sm font-medium">Priya Malhotra</td>
                        <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4"><span class="px-1.5 sm:px-2 py-0.5 sm:py-1 bg-blue-100 text-blue-700 rounded-full text-[10px] sm:text-xs font-bold">Enrolled</span></td>
                        <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-sm">10th Secondary</td>
                        <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4"><button class="text-cyan-600 hover:underline text-sm font-medium">View</button></td>
                    </tr>
                    <tr class="border-t border-slate-100">
                        <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-sm font-medium">Vikram Seth</td>
                        <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4"><span class="px-1.5 sm:px-2 py-0.5 sm:py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] sm:text-xs font-bold">Applied</span></td>
                        <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-sm">12th Commerce</td>
                        <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4"><button class="text-cyan-600 hover:underline text-sm font-medium">View</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>