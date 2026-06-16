<x-admin-layout>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .bg-blob {
            filter: blur(80px);
            opacity: 0.15;
            z-index: -1;
        }
    </style>

    <!-- Background Decorative Elements -->
    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary rounded-full bg-blob pointer-events-none"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[30%] h-[30%] bg-secondary rounded-full bg-blob pointer-events-none"></div>

    <div class="p-8 max-w-7xl mx-auto space-y-12">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-cyan-600">Content Management System</span>
                <h2 class="text-4xl font-bold tracking-tight text-on-surface mt-2 font-headline">The Prep Archive</h2>
                <p class="text-on-surface-variant max-w-lg mt-2">Centralized vault for solved TMAs, practical manuals, and specialized exam boosters for medical aspirants.</p>
            </div>
            <div class="flex gap-4">
                <div class="glass-card px-6 py-4 rounded-xl flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 rounded-lg bg-cyan-100 flex items-center justify-center text-cyan-700">
                        <span class="material-symbols-outlined">description</span>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-slate-500">Total Resources</p>
                        <p class="text-2xl font-bold text-on-surface">{{ $products->count() }}</p>
                    </div>
                </div>
                <div class="glass-card px-6 py-4 rounded-xl flex items-center gap-4 shadow-sm border-primary/10">
                    <div class="w-12 h-12 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-700">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-slate-500">Store Value</p>
                        <p class="text-2xl font-bold text-on-surface">₹{{ number_format($products->sum('price'), 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Layout Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Upload Section (Bento Main) -->
            <div class="lg:col-span-5">
                <form action="/admin/products" method="POST" enctype="multipart/form-data" class="glass-card p-8 rounded-xl h-full border-primary/10">
                    @csrf
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xl font-bold flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">cloud_upload</span>
                            Add New Resource
                        </h3>
                        <span class="text-[10px] font-bold py-1 px-3 bg-primary-container text-on-primary-container rounded-full">DRAFT MODE</span>
                    </div>
                    <div class="space-y-6">
                        <!-- Drag & Drop -->
                        <div class="group cursor-pointer border-2 border-dashed border-outline-variant/30 rounded-xl p-10 flex flex-col items-center justify-center text-center transition-all hover:bg-white/50 hover:border-primary/50 bg-slate-50/30 relative">
                            <input type="file" name="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
                            <div class="w-16 h-16 rounded-full signature-gradient/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-3xl text-primary">upload_file</span>
                            </div>
                            <h4 class="font-bold text-on-surface">Drop PDF Archive</h4>
                            <p class="text-xs text-slate-500 mt-1 uppercase tracking-tighter">Support for PDF, DOCX up to 50MB</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2 space-y-2">
                                <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Resource Title</label>
                                <input name="name" class="w-full bg-white/50 border-outline-variant/20 rounded-lg p-3 text-sm focus:ring-primary focus:border-primary" placeholder="e.g. Physics Solved TMA 2024" type="text" required/>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Category</label>
                                <select name="category" class="w-full bg-white/50 border-outline-variant/20 rounded-lg p-3 text-sm focus:ring-primary focus:border-primary">
                                    <option value="pdf">PDF Notes</option>
                                    <option value="tma">TMA Assignment</option>
                                    <option value="Class 12th">Class 12th</option>
                                    <option value="Class 10th">Class 10th</option>
                                    <option value="Competitive">Competitive</option>
                                    <option value="General">General</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Subject</label>
                                <select name="subject" class="w-full bg-white/50 border-outline-variant/20 rounded-lg p-3 text-sm focus:ring-primary focus:border-primary">
                                    <option>Physics</option>
                                    <option>Chemistry</option>
                                    <option>Biology</option>
                                    <option>Mathematics</option>
                                </select>
                            </div>
                            <div class="col-span-2 space-y-2">
                                <label class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Price (INR)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-slate-400">₹</span>
                                    <input name="price" class="w-full bg-white/50 border-outline-variant/20 rounded-lg p-3 pl-8 text-sm focus:ring-primary focus:border-primary" placeholder="0.00" type="number" step="0.01" required/>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="w-full signature-gradient text-white py-4 rounded-xl font-bold shadow-xl shadow-cyan-900/10 flex items-center justify-center gap-2 mt-4 hover:brightness-110 transition-all">
                            <span class="material-symbols-outlined">publish</span>
                            Publish to Archive
                        </button>
                    </div>
                </form>
            </div>

            <!-- Library Table (Bento Secondary) -->
            <div class="lg:col-span-7">
                <div class="glass-card p-0 rounded-xl overflow-hidden border-slate-200/50 h-full flex flex-col">
                    <div class="p-8 border-b border-outline-variant/10 flex justify-between items-center">
                        <h3 class="text-xl font-bold">Recent Uploads</h3>
                        <div class="flex gap-2">
                            <button class="px-3 py-1 bg-surface-container-low text-[10px] font-bold uppercase rounded hover:bg-surface-container-high transition-colors">Export CSV</button>
                        </div>
                    </div>
                    <div class="flex-1 overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-surface-container-low/30">
                                <tr>
                                    <th class="px-8 py-4 text-[10px] uppercase tracking-widest font-bold text-slate-500">Resource Name</th>
                                    <th class="px-4 py-4 text-[10px] uppercase tracking-widest font-bold text-slate-500 text-center">Price</th>
                                    <th class="px-4 py-4 text-[10px] uppercase tracking-widest font-bold text-slate-500">Status</th>
                                    <th class="px-8 py-4 text-[10px] uppercase tracking-widest font-bold text-slate-500 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/10">
                                @forelse($products as $product)
                                <tr class="hover:bg-white/40 transition-colors">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded bg-cyan-50 flex items-center justify-center text-cyan-600">
                                                <span class="material-symbols-outlined">picture_as_pdf</span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-on-surface leading-none">{{ $product->title ?? $product->name }}</p>
                                                <p class="text-[10px] text-slate-400 mt-1 uppercase">{{ $product->category ?? 'General' }} • Updated {{ $product->updated_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-5 text-center">
                                        <span class="text-sm font-bold text-on-surface">₹{{ number_format($product->price, 2) }}</span>
                                    </td>
                                    <td class="px-4 py-5">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            PUBLISHED
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <div class="flex justify-end gap-2">
                                            <button class="w-8 h-8 rounded-lg hover:bg-primary/10 text-primary transition-colors flex items-center justify-center">
                                                <span class="material-symbols-outlined text-lg">edit</span>
                                            </button>
                                            <form action="/admin/products/{{ $product->id }}" method="POST" onsubmit="return confirm('Delete this resource?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-lg hover:bg-error/10 text-error transition-colors flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-lg">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-5 text-center text-slate-500 text-sm">No resources uploaded yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 bg-surface-container-low/50 flex items-center justify-center gap-4">
                        <button class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/80"><span class="material-symbols-outlined text-sm">chevron_left</span></button>
                        <span class="text-xs font-bold text-on-surface">END OF LIST</span>
                        <button class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/80"><span class="material-symbols-outlined text-sm">chevron_right</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
