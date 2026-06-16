<x-admin-layout>
    <div x-data="{ 
            search: '', 
            typeFilter: 'All',
            payments: {{ json_encode($payments->map(function($p) {
                return [
                    'id' => $p->id,
                    'student_name' => $p->user->name ?? 'N/A',
                    'student_email' => $p->user->email ?? 'N/A',
                    'amount' => $p->amount,
                    'payment_id' => $p->payment_id,
                    'type' => $p->type,
                    'status' => $p->status,
                    'date' => $p->created_at->format('Y-m-d H:i')
                ];
            })) }}
        }" 
        class="space-y-8"
    >
        <!-- Header -->
        <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-8">
            <div>
                <h1 class="text-4xl font-sans font-extrabold text-cyan-800 tracking-tight mb-2">Revenue & Payments</h1>
                <p class="text-lg text-slate-500 font-medium">Track transactions, student payments, and overall platform revenue.</p>
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="glass-panel p-6 rounded-3xl bg-white border border-slate-200/50 shadow-sm flex items-center gap-5">
                <div class="w-14 h-14 bg-emerald-500/10 text-emerald-600 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">payments</span>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-1">TOTAL REVENUE</p>
                    <p class="text-3xl font-extrabold text-emerald-600">₹{{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
            
            <div class="glass-panel p-6 rounded-3xl bg-white border border-slate-200/50 shadow-sm flex items-center gap-5">
                <div class="w-14 h-14 bg-cyan-500/10 text-cyan-600 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">receipt_long</span>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-1">TOTAL TRANSACTIONS</p>
                    <p class="text-3xl font-extrabold text-cyan-700">{{ $paymentsCount }}</p>
                </div>
            </div>

            <div class="glass-panel p-6 rounded-3xl bg-white border border-slate-200/50 shadow-sm flex items-center gap-5">
                <div class="w-14 h-14 bg-amber-500/10 text-amber-600 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">analytics</span>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-1">AVG TRANSACTION</p>
                    <p class="text-3xl font-extrabold text-amber-600">
                        ₹{{ $paymentsCount > 0 ? number_format($totalRevenue / $paymentsCount, 2) : '0.00' }}
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
                        placeholder="Search student or email..." 
                        class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-cyan-500 focus:bg-white outline-none text-slate-700 transition-all text-sm font-medium"
                    />
                </div>

                <div class="flex items-center gap-3 w-full md:w-auto">
                    <label class="text-sm font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Filter Type:</label>
                    <select 
                        x-model="typeFilter"
                        class="w-full md:w-48 p-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-cyan-500 focus:bg-white outline-none text-slate-700 text-sm font-bold transition-all"
                    >
                        <option value="All">All Types</option>
                        <option value="Admission">Admission</option>
                        <option value="Product">Product</option>
                        <option value="Membership">Membership</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto bg-white">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="uppercase text-slate-400 text-xs font-bold border-b border-slate-100 bg-slate-50">
                            <th class="py-5 px-8">Student</th>
                            <th class="py-5 px-8">Type</th>
                            <th class="py-5 px-8">Amount</th>
                            <th class="py-5 px-8">Payment ID</th>
                            <th class="py-5 px-8">Date</th>
                            <th class="py-5 px-8">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="p in payments.filter(x => {
                            const matchSearch = x.student_name.toLowerCase().includes(search.toLowerCase()) || x.student_email.toLowerCase().includes(search.toLowerCase()) || x.payment_id.toLowerCase().includes(search.toLowerCase());
                            const matchType = typeFilter === 'All' || x.type === typeFilter;
                            return matchSearch && matchType;
                        })" :key="p.id">
                            <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                                <td class="py-5 px-8">
                                    <div class="font-bold text-slate-800" x-text="p.student_name"></div>
                                    <div class="text-xs text-slate-400" x-text="p.student_email"></div>
                                </td>
                                <td class="py-5 px-8 text-[15px] font-medium text-slate-600" x-text="p.type"></td>
                                <td class="py-5 px-8 font-bold text-emerald-600" x-text="'₹' + Number(p.amount).toFixed(2)"></td>
                                <td class="py-5 px-8 text-sm font-mono text-slate-500" x-text="p.payment_id"></td>
                                <td class="py-5 px-8 text-[15px] text-slate-500" x-text="p.date"></td>
                                <td class="py-5 px-8">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-100 text-emerald-800 rounded-full text-xs font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        Success
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
