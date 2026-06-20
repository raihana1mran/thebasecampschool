<x-admin-layout>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(32px);
            -webkit-backdrop-filter: blur(32px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .ghost-border {
            border: 1px solid rgba(168, 174, 176, 0.15);
        }

        .active-cyan-gradient {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 100, 121, 0.1);
            border-radius: 10px;
        }

        .sidebar-active {
            background: rgba(0, 100, 121, 0.05);
        }
    </style>

    <!-- Background Atmospheric Blob -->
    <div class="fixed -top-24 -right-24 w-96 h-96 bg-primary-container/20 rounded-full blur-[120px] pointer-events-none -z-10"></div>
    <div class="fixed -bottom-24 -left-24 w-96 h-96 bg-secondary-container/20 rounded-full blur-[120px] pointer-events-none -z-10"></div>

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
            })) }},
            getInitials(name) {
                if (!name || name === 'N/A') return 'ST';
                return name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
            }
        }" 
        class="w-full space-y-8"
    >
        <!-- Page Header -->
        <div class="mb-10">
            <h1 class="text-4xl font-display font-extrabold text-on-surface tracking-[-0.02em] leading-tight">Financial Management Hub</h1>
            <p class="text-base text-on-surface-variant font-body mt-2 flex items-center gap-2">
                <span class="w-8 h-[1px] bg-primary/30"></span>
                Track fees, service charges, and refund protocols.
            </p>
        </div>

        <!-- KPI Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- KPI 1 -->
            <div class="glass-card p-6 rounded-2xl relative overflow-hidden group hover:scale-[1.02] transition-all duration-500">
                <div class="absolute top-0 right-0 w-24 h-24 bg-primary/5 rounded-full -mr-12 -mt-12 transition-transform duration-700 group-hover:scale-150"></div>
                <div class="flex justify-between items-start mb-4">
                    <span class="material-symbols-outlined text-primary text-3xl">payments</span>
                    <span class="text-label-sm font-bold text-primary px-2 py-0.5 rounded-full bg-primary/10 tracking-widest uppercase">+12%</span>
                </div>
                <p class="text-outline text-label-md tracking-wider uppercase mb-1">Total Revenue</p>
                <h3 class="text-3xl font-display font-bold text-on-surface">₹{{ number_format($totalRevenue, 2) }}</h3>
            </div>
            <!-- KPI 2 -->
            <div class="glass-card p-6 rounded-2xl relative overflow-hidden group hover:scale-[1.02] transition-all duration-500">
                <div class="absolute top-0 right-0 w-24 h-24 bg-error/5 rounded-full -mr-12 -mt-12 transition-transform duration-700 group-hover:scale-150"></div>
                <div class="flex justify-between items-start mb-4">
                    <span class="material-symbols-outlined text-error text-3xl">pending_actions</span>
                    <span class="text-label-sm font-bold text-error px-2 py-0.5 rounded-full bg-error/10 tracking-widest uppercase">
                        @php
                            $totalCount = $payments->count();
                            $pendingCount = $payments->where('status', 'Pending')->count();
                            $pendingPercent = $totalCount > 0 ? round(($pendingCount / $totalCount) * 100, 1) : 0;
                        @endphp
                        {{ $pendingPercent }}% Pending
                    </span>
                </div>
                <p class="text-outline text-label-md tracking-wider uppercase mb-1">Pending Fees</p>
                <h3 class="text-3xl font-display font-bold text-on-surface">
                    ₹{{ number_format($payments->where('status', 'Pending')->sum('amount'), 2) }}
                </h3>
            </div>
            <!-- KPI 3 -->
            <div class="glass-card p-6 rounded-2xl relative overflow-hidden group hover:scale-[1.02] transition-all duration-500">
                <div class="absolute top-0 right-0 w-24 h-24 bg-secondary/5 rounded-full -mr-12 -mt-12 transition-transform duration-700 group-hover:scale-150"></div>
                <div class="flex justify-between items-start mb-4">
                    <span class="material-symbols-outlined text-secondary text-3xl">check_circle</span>
                    <span class="text-label-sm font-bold text-secondary px-2 py-0.5 rounded-full bg-secondary/10 tracking-widest uppercase">
                        @php
                            $successCount = $payments->where('status', 'Success')->count();
                            $successRate = $totalCount > 0 ? round(($successCount / $totalCount) * 100) : 100;
                        @endphp
                        {{ $successRate }}% Success
                    </span>
                </div>
                <p class="text-outline text-label-md tracking-wider uppercase mb-1">Success Txns</p>
                <h3 class="text-3xl font-display font-bold text-on-surface">{{ $successCount }}</h3>
            </div>
            <!-- KPI 4 -->
            <div class="glass-card p-6 rounded-2xl relative overflow-hidden group hover:scale-[1.02] transition-all duration-500">
                <div class="absolute top-0 right-0 w-24 h-24 bg-tertiary/5 rounded-full -mr-12 -mt-12 transition-transform duration-700 group-hover:scale-150"></div>
                <div class="flex justify-between items-start mb-4">
                    <span class="material-symbols-outlined text-tertiary text-3xl">restart_alt</span>
                    <span class="text-label-sm font-bold text-tertiary px-2 py-0.5 rounded-full bg-tertiary/10 tracking-widest uppercase">
                        @php
                            $refundedCount = $payments->where('status', 'Refunded')->count();
                        @endphp
                        {{ $refundedCount }} Active
                    </span>
                </div>
                <p class="text-outline text-label-md tracking-wider uppercase mb-1">Active Refunds</p>
                <h3 class="text-3xl font-display font-bold text-on-surface">
                    ₹{{ number_format($payments->where('status', 'Refunded')->sum('amount'), 2) }}
                </h3>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-8 items-start">
            <!-- Left: Fee Categories & History (8 Cols) -->
            <div class="col-span-12 lg:col-span-8 space-y-8">
                <!-- Fee Categories Section -->
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-display font-bold text-on-surface">Fee Structures</h2>
                        <div class="flex gap-2 p-1 glass-card rounded-full bg-surface-container-low/40">
                            <button @click="typeFilter = 'All'" 
                                    class="px-4 py-1.5 rounded-full text-xs font-medium transition-all duration-300"
                                    :class="typeFilter === 'All' ? 'active-cyan-gradient text-white shadow-lg shadow-primary/20' : 'text-on-surface-variant hover:bg-white/50'">
                                Overview
                            </button>
                            <button @click="typeFilter = 'Admission'" 
                                    class="px-4 py-1.5 rounded-full text-xs font-medium transition-all duration-300"
                                    :class="typeFilter === 'Admission' ? 'active-cyan-gradient text-white shadow-lg shadow-primary/20' : 'text-on-surface-variant hover:bg-white/50'">
                                Admission Only
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <!-- Category Card -->
                        <div @click="typeFilter = (typeFilter === 'Admission' ? 'All' : 'Admission')" 
                             class="glass-card p-5 rounded-2xl ghost-border hover:bg-white transition-all duration-300 cursor-pointer select-none"
                             :class="typeFilter === 'Admission' ? 'ring-2 ring-primary/50 bg-white' : ''">
                            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center mb-4">
                                <span class="material-symbols-outlined text-primary">school</span>
                            </div>
                            <p class="text-label-sm font-bold text-outline uppercase tracking-wider">Secondary Fee</p>
                            <p class="text-xl font-bold mt-1 text-on-surface">₹5,500</p>
                            <p class="text-[10px] text-on-surface-variant mt-2 font-medium">Standard Class 10</p>
                        </div>

                        <div @click="typeFilter = (typeFilter === 'Admission' ? 'All' : 'Admission')" 
                             class="glass-card p-5 rounded-2xl ghost-border hover:bg-white transition-all duration-300 cursor-pointer select-none"
                             :class="typeFilter === 'Admission' ? 'ring-2 ring-primary/50 bg-white' : ''">
                            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center mb-4">
                                <span class="material-symbols-outlined text-primary">school</span>
                            </div>
                            <p class="text-label-sm font-bold text-outline uppercase tracking-wider">Sr. Secondary Fee</p>
                            <p class="text-xl font-bold mt-1 text-on-surface">₹6,500</p>
                            <p class="text-[10px] text-on-surface-variant mt-2 font-medium">Standard Class 12</p>
                        </div>
                        
                        <div @click="typeFilter = (typeFilter === 'Product' ? 'All' : 'Product')" 
                             class="glass-card p-5 rounded-2xl ghost-border hover:bg-white transition-all duration-300 cursor-pointer select-none"
                             :class="typeFilter === 'Product' ? 'ring-2 ring-secondary/50 bg-white' : ''">
                            <div class="w-10 h-10 rounded-xl bg-secondary/10 flex items-center justify-center mb-4">
                                <span class="material-symbols-outlined text-secondary">assignment_ind</span>
                            </div>
                            <p class="text-label-sm font-bold text-outline uppercase tracking-wider">Public Exam Fee</p>
                            <p class="text-xl font-bold mt-1 text-on-surface">₹3,500</p>
                            <p class="text-[10px] text-on-surface-variant mt-2 font-medium">Per subject unit</p>
                        </div>
                        
                        <div @click="typeFilter = (typeFilter === 'Membership' ? 'All' : 'Membership')" 
                             class="glass-card p-5 rounded-2xl ghost-border hover:bg-white transition-all duration-300 cursor-pointer select-none"
                             :class="typeFilter === 'Membership' ? 'ring-2 ring-tertiary/50 bg-white' : ''">
                            <div class="w-10 h-10 rounded-xl bg-tertiary/10 flex items-center justify-center mb-4">
                                <span class="material-symbols-outlined text-tertiary">edit_note</span>
                            </div>
                            <p class="text-label-sm font-bold text-outline uppercase tracking-wider">TMA Fee</p>
                            <p class="text-xl font-bold mt-1 text-on-surface">₹1,200</p>
                            <p class="text-[10px] text-on-surface-variant mt-2 font-medium">Internal assessment</p>
                        </div>
                    </div>
                </section>

                <!-- Payment History Table -->
                <section class="glass-card rounded-2xl overflow-hidden ghost-border">
                    <div class="px-8 py-6 border-b border-outline-variant/10 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white/40">
                        <h2 class="text-xl font-display font-bold text-on-surface">Transaction Ledger</h2>
                        
                        <!-- Search and Filters inside Ledger Header -->
                        <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                            <div class="relative flex-1 sm:flex-initial sm:w-60">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline text-lg">search</span>
                                <input type="text" 
                                       x-model="search"
                                       placeholder="Search transactions..." 
                                       class="w-full pl-10 pr-4 py-2 border border-outline-variant/20 rounded-xl bg-surface-container-low/40 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-sm transition-all font-body" />
                            </div>

                            <select x-model="typeFilter"
                                    class="p-2 border border-outline-variant/20 rounded-xl bg-surface-container-low/40 text-sm font-bold text-on-surface-variant focus:bg-white transition-all outline-none">
                                <option value="All">All Categories</option>
                                <option value="Admission">Admission</option>
                                <option value="Product">Product</option>
                                <option value="Membership">Membership</option>
                            </select>

                            <a href="{{ route('admin.invoices.download') }}" 
                               class="flex items-center gap-2 text-primary hover:bg-primary/5 px-4 py-2 rounded-xl transition-all duration-300 text-sm font-bold border border-primary/20">
                                <span class="material-symbols-outlined text-sm">download</span> Export
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-surface-container-low/30">
                                <tr>
                                    <th class="px-8 py-4 text-label-md font-bold text-outline uppercase tracking-[0.1em]">Student Name</th>
                                    <th class="px-6 py-4 text-label-md font-bold text-outline uppercase tracking-[0.1em]">Transaction ID</th>
                                    <th class="px-6 py-4 text-label-md font-bold text-outline uppercase tracking-[0.1em]">Category</th>
                                    <th class="px-6 py-4 text-label-md font-bold text-outline uppercase tracking-[0.1em]">Amount</th>
                                    <th class="px-6 py-4 text-label-md font-bold text-outline uppercase tracking-[0.1em]">Status</th>
                                    <th class="px-8 py-4 text-label-md font-bold text-outline uppercase tracking-[0.1em] text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/10">
                                <template x-for="p in payments.filter(x => {
                                    const matchSearch = x.student_name.toLowerCase().includes(search.toLowerCase()) || 
                                                        x.student_email.toLowerCase().includes(search.toLowerCase()) || 
                                                        x.payment_id.toLowerCase().includes(search.toLowerCase());
                                    const matchType = typeFilter === 'All' || x.type === typeFilter;
                                    return matchSearch && matchType;
                                })" :key="p.id">
                                    <tr class="hover:bg-primary/5 transition-colors duration-300 group">
                                        <td class="px-8 py-5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-surface-container-highest flex items-center justify-center text-xs font-bold text-primary" x-text="getInitials(p.student_name)"></div>
                                                <div>
                                                    <p class="font-bold text-sm text-on-surface" x-text="p.student_name"></p>
                                                    <p class="text-xs text-outline" x-text="p.student_email"></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 text-sm font-mono text-outline" x-text="p.payment_id"></td>
                                        <td class="px-6 py-5">
                                            <span class="text-xs font-bold px-2.5 py-1 rounded-lg bg-surface-container text-on-surface-variant" x-text="p.type"></span>
                                        </td>
                                        <td class="px-6 py-5 text-sm font-bold text-on-surface" x-text="'₹' + Number(p.amount).toLocaleString('en-IN')"></td>
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-1.5" 
                                                 :class="{
                                                     'text-secondary': p.status === 'Success' || p.status === 'Paid',
                                                     'text-primary': p.status === 'Pending',
                                                     'text-tertiary': p.status === 'Refunded',
                                                     'text-error': p.status === 'Failed'
                                                 }">
                                                <span class="w-1.5 h-1.5 rounded-full" 
                                                      :class="{
                                                          'bg-secondary': p.status === 'Success' || p.status === 'Paid',
                                                          'bg-primary animate-pulse': p.status === 'Pending',
                                                          'bg-tertiary': p.status === 'Refunded',
                                                          'bg-error': p.status === 'Failed'
                                                      }"></span>
                                                <span class="text-xs font-bold uppercase tracking-wider" x-text="p.status === 'Success' ? 'Paid' : p.status"></span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5 text-right">
                                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                <!-- Paid/Success actions -->
                                                <template x-if="p.status === 'Success' || p.status === 'Paid'">
                                                    <div class="flex gap-2">
                                                        <a href="{{ route('admin.invoices.download') }}" class="p-1.5 hover:bg-primary/10 rounded-lg text-primary transition-colors" title="Download Invoices CSV">
                                                            <span class="material-symbols-outlined text-lg">download</span>
                                                        </a>
                                                        <button class="p-1.5 hover:bg-error/10 rounded-lg text-error transition-colors" title="Process Refund" @click="alert('Refund initiated for transaction: ' + p.payment_id)">
                                                            <span class="material-symbols-outlined text-lg">history</span>
                                                        </button>
                                                    </div>
                                                </template>
                                                <!-- Pending actions -->
                                                <template x-if="p.status === 'Pending'">
                                                    <div class="flex gap-2">
                                                        <button class="p-1.5 hover:bg-primary/10 rounded-lg text-primary transition-colors" title="Notify Parent" @click="alert('Notification sent to parent of ' + p.student_name)">
                                                            <span class="material-symbols-outlined text-lg">notifications</span>
                                                        </button>
                                                        <button class="p-1.5 hover:bg-error/10 rounded-lg text-error transition-colors" title="Cancel Transaction" @click="alert('Transaction cancelled')">
                                                            <span class="material-symbols-outlined text-lg">close</span>
                                                        </button>
                                                    </div>
                                                </template>
                                                <!-- Refunded actions -->
                                                <template x-if="p.status === 'Refunded'">
                                                    <button class="p-1.5 hover:bg-primary/10 rounded-lg text-primary transition-colors" title="View Info" @click="alert('Refund details for: ' + p.payment_id)">
                                                        <span class="material-symbols-outlined text-lg">info</span>
                                                    </button>
                                                </template>
                                                <!-- Failed actions -->
                                                <template x-if="p.status === 'Failed'">
                                                    <button class="p-1.5 hover:bg-primary/10 rounded-lg text-primary transition-colors" title="Retry" @click="alert('Retrying transaction: ' + p.payment_id)">
                                                        <span class="material-symbols-outlined text-lg">replay</span>
                                                    </button>
                                                </template>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                                <!-- Empty state -->
                                <tr x-show="payments.filter(x => {
                                    const matchSearch = x.student_name.toLowerCase().includes(search.toLowerCase()) || 
                                                        x.student_email.toLowerCase().includes(search.toLowerCase()) || 
                                                        x.payment_id.toLowerCase().includes(search.toLowerCase());
                                    const matchType = typeFilter === 'All' || x.type === typeFilter;
                                    return matchSearch && matchType;
                                }).length === 0">
                                    <td colspan="6" class="px-8 py-12 text-center text-outline font-medium">
                                        No transactions found matching your criteria.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="px-8 py-4 bg-surface-container-low/20 border-t border-outline-variant/10 flex items-center justify-between">
                        <p class="text-xs text-outline font-medium">
                            Showing <span x-text="payments.filter(x => {
                                const matchSearch = x.student_name.toLowerCase().includes(search.toLowerCase()) || 
                                                    x.student_email.toLowerCase().includes(search.toLowerCase()) || 
                                                    x.payment_id.toLowerCase().includes(search.toLowerCase());
                                    const matchType = typeFilter === 'All' || x.type === typeFilter;
                                return matchSearch && matchType;
                            }).length"></span> of <span x-text="payments.length"></span> transactions
                        </p>
                    </div>
                </section>
            </div>

            <!-- Right: Alerts Panel (4 Cols) -->
            <div class="col-span-12 lg:col-span-4 space-y-6">
                <!-- Pending Payment Alerts -->
                <section class="glass-card rounded-2xl ghost-border overflow-hidden p-6">
                    <div class="flex items-center gap-2 mb-6">
                        <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 1;">error</span>
                        <h2 class="text-xl font-display font-bold text-on-surface">Payment Alerts</h2>
                    </div>
                    <div class="space-y-4">
                        @php
                            $pendingPayments = $payments->where('status', 'Pending')->take(3);
                        @endphp
                        @forelse($pendingPayments as $p)
                            <div class="p-4 rounded-xl bg-error-container/10 border-l-4 border-error space-y-3 transition-transform hover:translate-x-1 duration-300">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold text-sm text-on-surface">Pending {{ $p->type }} Fee</p>
                                        <p class="text-[10px] text-outline uppercase tracking-wider mt-0.5">Student ID: #BC-{{ 9000 + $p->user_id }}</p>
                                    </div>
                                    <span class="text-error font-bold text-xs">{{ $p->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="text-lg font-display font-bold text-error">₹{{ number_format($p->amount, 2) }}</p>
                                    <button onclick="alert('Notification sent to parent of {{ addslashes($p->user?->name) }}')" class="px-3 py-1 bg-error/10 hover:bg-error/20 text-error rounded-lg text-[10px] font-bold uppercase transition-colors">Notify Parent</button>
                                </div>
                            </div>
                        @empty
                            <!-- Mock Alert Item 1 -->
                            <div class="p-4 rounded-xl bg-error-container/10 border-l-4 border-error space-y-3 transition-transform hover:translate-x-1 duration-300">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold text-sm text-on-surface">Overdue Admission Fee</p>
                                        <p class="text-[10px] text-outline uppercase tracking-wider mt-0.5">Student ID: #BC-9902</p>
                                    </div>
                                    <span class="text-error font-bold text-xs">5 Days</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="text-lg font-display font-bold text-error">₹25,000</p>
                                    <button onclick="alert('Notification sent to parent of Aditi Kapoor')" class="px-3 py-1 bg-error/10 hover:bg-error/20 text-error rounded-lg text-[10px] font-bold uppercase transition-colors">Notify Parent</button>
                                </div>
                            </div>
                            <!-- Mock Alert Item 2 -->
                            <div class="p-4 rounded-xl bg-surface-container-high/40 border-l-4 border-primary space-y-3 transition-transform hover:translate-x-1 duration-300">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold text-sm text-on-surface">Exam Fee Discrepancy</p>
                                        <p class="text-[10px] text-outline uppercase tracking-wider mt-0.5">Student ID: #BC-8721</p>
                                    </div>
                                    <span class="text-primary font-bold text-xs">Active</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="text-lg font-display font-bold text-primary">₹3,500</p>
                                    <button onclick="alert('Verification docs requested')" class="px-3 py-1 bg-primary/10 hover:bg-primary/20 text-primary rounded-lg text-[10px] font-bold uppercase transition-colors">Verify Docs</button>
                                </div>
                            </div>
                            <!-- Mock Alert Item 3 -->
                            <div class="p-4 rounded-xl bg-error-container/10 border-l-4 border-error space-y-3 transition-transform hover:translate-x-1 duration-300">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold text-sm text-on-surface">Partial TMA Payment</p>
                                        <p class="text-[10px] text-outline uppercase tracking-wider mt-0.5">Student ID: #BC-1104</p>
                                    </div>
                                    <span class="text-error font-bold text-xs">2 Days</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="text-lg font-display font-bold text-error">₹600</p>
                                    <button onclick="alert('Follow up initiated for Student #BC-1104')" class="px-3 py-1 bg-error/10 hover:bg-error/20 text-error rounded-lg text-[10px] font-bold uppercase transition-colors">Follow Up</button>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <button onclick="alert('Showing all alerts')" class="w-full mt-8 py-3 rounded-xl border border-dashed border-outline-variant text-outline hover:text-primary hover:border-primary/50 hover:bg-primary/5 transition-all duration-300 font-bold text-sm">
                        View All (24) Alerts
                    </button>
                </section>

                <!-- Quick Summary Visual -->
                <div class="glass-card rounded-2xl overflow-hidden p-6 relative">
                    <div class="absolute top-0 right-0 w-32 h-32 active-cyan-gradient opacity-10 rounded-full -mr-16 -mt-16"></div>
                    <h3 class="text-label-md font-bold text-outline uppercase tracking-widest mb-6">Collection Status</h3>
                    <div class="space-y-6">
                        @php
                            $totalAmount = $payments->sum('amount');
                            $collectedAmount = $payments->where('status', 'Success')->sum('amount');
                            $refundedAmount = $payments->where('status', 'Refunded')->sum('amount');
                            
                            $collectedPercent = $totalAmount > 0 ? round(($collectedAmount / $totalAmount) * 100) : 88;
                            $refundedPercent = $totalAmount > 0 ? round(($refundedAmount / $totalAmount) * 100) : 4;
                        @endphp
                        <div>
                            <div class="flex justify-between text-sm font-bold mb-2">
                                <span>Collected</span>
                                <span class="text-primary">{{ $collectedPercent }}%</span>
                            </div>
                            <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
                                <div class="h-full active-cyan-gradient rounded-full" style="width: {{ $collectedPercent }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm font-bold mb-2">
                                <span>Refunded</span>
                                <span class="text-tertiary">{{ $refundedPercent }}%</span>
                            </div>
                            <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
                                <div class="h-full bg-tertiary rounded-full" style="width: {{ $refundedPercent }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Helpful Graphic -->
                <div class="relative rounded-2xl overflow-hidden h-48 group">
                    <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" data-alt="A futuristic, high-end educational dashboard concept showing abstract glowing charts and payment flows. The aesthetic is clean and modern, using the Lumine Glace theme with frosted glass textures and vibrant cyan data visualizations against a soft, bright architectural background. It evokes a sense of financial clarity and institutional excellence." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBxwgndbXxAIYTCQQex7sv8EVjEN9xlOQh3Dw3bC4WqJeOmNvcg1ytWm8c_bM9XAhTyGKehNqlQGE4HnkFbA8kO6UFBxCvV0tVOhioV-EnvuTHyIUg3o7mrlAbRQJ3wPShxDtPk598H8iHvtycy_gEX3mCtDwgx9axW2c_wiJdNMOtnmAyJ5qIeD0LjDxk_qbyzTliNIXBTVPnkvPHNPivS9WMQn5gWUDZCREFcjHLEbWMOY0hhcg1kZnbsVGyEqgKIZIC6ybpAuU4"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent flex flex-col justify-end p-6">
                        <p class="text-white font-bold">Annual Audit Report</p>
                        <a href="{{ route('admin.reports.revenue') }}" class="text-white/70 text-[10px] uppercase tracking-widest hover:underline">Ready for Review • FY 23-24</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Floating Action Button -->
        <button onclick="alert('Manual payment records management is available on request.')" 
                class="fixed bottom-8 right-8 w-16 h-16 rounded-full active-cyan-gradient text-white shadow-2xl shadow-primary/40 flex items-center justify-center group hover:scale-110 transition-all duration-500 z-50">
            <span class="material-symbols-outlined text-3xl group-hover:rotate-90 transition-transform duration-500">add</span>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Smooth reveal animation for cards
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                        entry.target.classList.remove('opacity-0', 'translate-y-10');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.glass-card').forEach(card => {
                card.classList.add('transition-all', 'duration-700', 'opacity-0', 'translate-y-10');
                observer.observe(card);
            });
        });
    </script>
</x-admin-layout>
