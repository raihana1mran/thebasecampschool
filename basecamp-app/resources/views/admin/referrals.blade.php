<x-admin-layout>
    <div x-data="{ 
            search: '', 
            statusFilter: 'All',
            referrals: {{ json_encode($referrals->map(function($r) {
                return [
                    'id' => $r->id,
                    'referrer_name' => $r->referrer->name ?? 'N/A',
                    'referrer_email' => $r->referrer->email ?? 'N/A',
                    'referred_name' => $r->referredUser->name ?? 'N/A',
                    'referred_email' => $r->referredUser->email ?? 'N/A',
                    'status' => $r->status,
                    'date' => $r->created_at->format('Y-m-d H:i')
                ];
            })) }}
        }" 
        class="space-y-8"
    >
        <!-- Header -->
        <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-8">
            <div>
                <h1 class="text-4xl font-sans font-extrabold text-cyan-800 tracking-tight mb-2">Referrals Log</h1>
                <p class="text-lg text-slate-500 font-medium">Monitor student referrals, invite statuses, and registration counts.</p>
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="glass-panel p-6 rounded-3xl bg-white border border-slate-200/50 shadow-sm flex items-center gap-5">
                <div class="w-14 h-14 bg-cyan-500/10 text-cyan-600 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">share</span>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-1">TOTAL INVITES</p>
                    <p class="text-3xl font-extrabold text-cyan-750">{{ $referralsCount }}</p>
                </div>
            </div>
            
            <div class="glass-panel p-6 rounded-3xl bg-white border border-slate-200/50 shadow-sm flex items-center gap-5">
                <div class="w-14 h-14 bg-emerald-500/10 text-emerald-600 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">check_circle</span>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-1">SUCCESSFUL CONVERSIONS</p>
                    <p class="text-3xl font-extrabold text-emerald-600">{{ $successfulCount }}</p>
                </div>
            </div>

            <div class="glass-panel p-6 rounded-3xl bg-white border border-slate-200/50 shadow-sm flex items-center gap-5">
                <div class="w-14 h-14 bg-amber-500/10 text-amber-600 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">percent</span>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-1">CONVERSION RATE</p>
                    <p class="text-3xl font-extrabold text-amber-600">
                        {{ $referralsCount > 0 ? number_format(($successfulCount / $referralsCount) * 100, 1) : '0.0' }}%
                    </p>
                </div>
            </div>
        </div>

        <!-- Filters & CRM View -->
        <div class="glass-panel rounded-[2.5rem] bg-slate-50 border border-slate-200/50 shadow-none overflow-hidden">
            <div class="p-6 md:p-8 border-b border-slate-200/50 flex flex-col md:flex-row justify-between items-center gap-4 bg-white">
                <div class="relative w-full md:w-80">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                    <input 
                        type="text" 
                        x-model="search"
                        placeholder="Search referrer or referee..." 
                        class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-cyan-500 focus:bg-white outline-none text-slate-700 transition-all text-sm font-medium"
                    />
                </div>

                <div class="flex items-center gap-3 w-full md:w-auto">
                    <label class="text-sm font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Filter Status:</label>
                    <select 
                        x-model="statusFilter"
                        class="w-full md:w-48 p-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-cyan-500 focus:bg-white outline-none text-slate-700 text-sm font-bold transition-all"
                    >
                        <option value="All">All Statuses</option>
                        <option value="Successful">Successful</option>
                        <option value="Pending">Pending</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto bg-white">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="uppercase text-slate-400 text-xs font-bold border-b border-slate-100 bg-slate-50">
                            <th class="py-5 px-8">Referrer (Invited By)</th>
                            <th class="py-5 px-8">Referred Scholar</th>
                            <th class="py-5 px-8">Date Initiated</th>
                            <th class="py-5 px-8">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="r in referrals.filter(x => {
                            const matchSearch = x.referrer_name.toLowerCase().includes(search.toLowerCase()) || x.referrer_email.toLowerCase().includes(search.toLowerCase()) || x.referred_name.toLowerCase().includes(search.toLowerCase()) || x.referred_email.toLowerCase().includes(search.toLowerCase());
                            const matchStatus = statusFilter === 'All' || x.status === statusFilter;
                            return matchSearch && matchStatus;
                        })" :key="r.id">
                            <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                                <td class="py-5 px-8">
                                    <div class="font-bold text-slate-800" x-text="r.referrer_name"></div>
                                    <div class="text-xs text-slate-400" x-text="r.referrer_email"></div>
                                </td>
                                <td class="py-5 px-8">
                                    <div class="font-bold text-slate-800" x-text="r.referred_name"></div>
                                    <div class="text-xs text-slate-400" x-text="r.referred_email"></div>
                                </td>
                                <td class="py-5 px-8 text-[15px] text-slate-500" x-text="r.date"></td>
                                <td class="py-5 px-8">
                                    <span 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold"
                                        :class="r.status === 'Successful' ? 'bg-emerald-100 text-emerald-850' : 'bg-amber-105 bg-amber-100 text-amber-800'"
                                    >
                                        <span class="w-1.5 h-1.5 rounded-full" :class="r.status === 'Successful' ? 'bg-emerald-600' : 'bg-amber-500'"></span>
                                        <span x-text="r.status"></span>
                                    </span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
