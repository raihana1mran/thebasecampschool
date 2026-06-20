<x-admin-layout>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(32px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 40px 60px rgba(42, 48, 49, 0.04);
        }
        .ghost-border { border: 1px solid rgba(168, 174, 176, 0.15); }
        .cyan-glow {
            box-shadow: 0 0 20px rgba(64, 206, 243, 0.15);
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
    </style>

    <!-- Atmospheric Background Blobs -->
    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary-container/20 rounded-full blur-[120px] pointer-events-none -z-10 transition-transform duration-300" id="blob1"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-secondary-container/10 rounded-full blur-[120px] pointer-events-none -z-10 transition-transform duration-300" id="blob2"></div>

    <div x-data="studyManager" class="w-full space-y-8 pb-20">
        <!-- Header & Introduction -->
        <section class="flex flex-col gap-2">
            <p class="text-primary font-bold tracking-[0.2em] text-xs uppercase">Administrative Portal</p>
            <h3 class="font-display text-4xl font-extrabold text-on-surface tracking-tighter">Study Material Management</h3>
        </section>

        <!-- Quick Actions & Subheader -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 mt-4 mb-10">
            <div class="max-w-2xl">
                <p class="text-sm text-on-surface-variant/80 leading-relaxed font-semibold">
                    Manage academic archives, lecture notes, and examination papers. Organize cross-departmental resources with atmospheric precision.
                </p>
            </div>
            <div class="flex items-center gap-4 shrink-0 font-semibold">
                <!-- Segmented Control -->
                <div class="bg-surface-container-low/60 p-1.5 rounded-2xl flex gap-1 border border-outline-variant/10">
                    <button @click="filterLevel = 'all'" :class="filterLevel === 'all' ? 'bg-white shadow-sm text-primary' : 'text-on-surface-variant/60'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all">All Levels</button>
                    <button @click="filterLevel = 'secondary'" :class="filterLevel === 'secondary' ? 'bg-white shadow-sm text-primary' : 'text-on-surface-variant/60'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all">Secondary</button>
                    <button @click="filterLevel = 'senior_secondary'" :class="filterLevel === 'senior_secondary' ? 'bg-white shadow-sm text-primary' : 'text-on-surface-variant/60'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all">Senior Secondary</button>
                </div>
                <button @click="openUploadModal()" class="flex items-center gap-2 bg-gradient-to-br from-primary to-primary-container text-on-primary px-6 py-3 rounded-2xl font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all text-xs">
                    <span class="material-symbols-outlined text-lg">upload_file</span>
                    UPLOAD NEW RESOURCE
                </button>
            </div>
        </div>

        <!-- Bento Layout Grid -->
        <div class="grid grid-cols-12 gap-6">
            <!-- Primary Table Section -->
            <div class="col-span-12 lg:col-span-8 glass-card rounded-[2rem] p-8 border border-outline-variant/10">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-xl font-bold flex items-center gap-3">
                        <span class="w-2 h-8 bg-primary rounded-full"></span>
                        Resource Inventory
                    </h3>
                    <div class="flex gap-3">
                        <select x-model="filterSubject" class="bg-surface-container-low/40 border-none rounded-xl text-xs font-bold text-on-surface-variant py-2 pl-4 pr-10 focus:ring-1 ring-primary/20">
                            <option value="all">Subject-wise: ALL</option>
                            <option value="physics">Physics 312</option>
                            <option value="mathematics">Mathematics 311</option>
                            <option value="chemistry">Chemistry 313</option>
                        </select>
                        <button @click="alert('Filters applied')" class="p-2 rounded-xl bg-surface-container-low/40 text-on-surface-variant hover:bg-surface-container-high/60 transition-all">
                            <span class="material-symbols-outlined text-lg">filter_list</span>
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-bold text-on-surface-variant/50 uppercase tracking-[0.2em] border-b border-outline-variant/10">
                                <th class="pb-4 pl-4">Resource Name</th>
                                <th class="pb-4">Subject</th>
                                <th class="pb-4">Category</th>
                                <th class="pb-4">Status</th>
                                <th class="pb-4 text-right pr-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/5">
                            @forelse($materials as $material)
                                @php
                                    $fileUrl = '#';
                                    if (is_array($material->file_urls) && count($material->file_urls) > 0) {
                                        $fileUrl = asset('storage/' . $material->file_urls[0]);
                                    }
                                @endphp
                                <tr class="group hover:bg-surface-container-lowest/50 transition-all duration-300">
                                    <td class="py-5 pl-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-primary-container/20 flex items-center justify-center text-primary">
                                                <span class="material-symbols-outlined">description</span>
                                            </div>
                                            <div>
                                                <p class="font-bold text-sm text-on-surface">{{ $material->title }}</p>
                                                <p class="text-[10px] text-on-surface-variant/60">Uploaded: {{ $material->created_at->format('d M, Y') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-5">
                                        <span class="text-xs font-medium px-3 py-1 rounded-full bg-primary/5 text-primary">PDF Notes</span>
                                    </td>
                                    <td class="py-5">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant/80">{{ ucfirst(str_replace('_', ' ', $material->description ?? 'Document')) }}</span>
                                    </td>
                                    <td class="py-5">
                                        <div class="flex items-center gap-1.5 text-xs text-primary font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                                            LIVE
                                        </div>
                                    </td>
                                    <td class="py-5 pr-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            @if($fileUrl !== '#')
                                                <a href="{{ $fileUrl }}" target="_blank" class="p-2 hover:bg-surface-container-high/80 rounded-lg text-on-surface-variant transition-colors" title="View Document">
                                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                                </a>
                                            @endif
                                            <button @click="deleteResource({{ $material->id }})" class="p-2 hover:bg-error-container/10 rounded-lg text-error transition-colors" title="Delete Resource">
                                                <span class="material-symbols-outlined text-lg">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <!-- Mock Row 1 -->
                                <tr x-show="filterLevel === 'all' || filterLevel === 'senior_secondary'" class="group hover:bg-surface-container-lowest/50 transition-all duration-300">
                                    <td class="py-5 pl-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-error-container/10 flex items-center justify-center text-error">
                                                <span class="material-symbols-outlined">picture_as_pdf</span>
                                            </div>
                                            <div>
                                                <p class="font-bold text-sm">Physics_Mechanics_Notes.pdf</p>
                                                <p class="text-[10px] text-on-surface-variant/60">Uploaded: Oct 24, 2026</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-5">
                                        <span class="text-xs font-medium px-3 py-1 rounded-full bg-primary/5 text-primary font-bold">Physics 312</span>
                                    </td>
                                    <td class="py-5">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant/80">Lecture Note</span>
                                    </td>
                                    <td class="py-5">
                                        <div class="flex items-center gap-1.5 text-xs text-primary font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                                            LIVE
                                        </div>
                                    </td>
                                    <td class="py-5 pr-4 text-right">
                                        <button @click="alert('Viewing Physics Mechanics notes...')" class="p-2 hover:bg-surface-container-high/80 rounded-lg text-on-surface-variant transition-colors"><span class="material-symbols-outlined text-lg">visibility</span></button>
                                    </td>
                                </tr>
                                <!-- Mock Row 2 -->
                                <tr x-show="filterLevel === 'all' || filterLevel === 'senior_secondary'" class="group hover:bg-surface-container-lowest/50 transition-all duration-300">
                                    <td class="py-5 pl-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-secondary-container/10 flex items-center justify-center text-secondary">
                                                <span class="material-symbols-outlined">description</span>
                                            </div>
                                            <div>
                                                <p class="font-bold text-sm">Calc_Integration_Mastery.docx</p>
                                                <p class="text-[10px] text-on-surface-variant/60">Uploaded: Oct 20, 2026</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-5">
                                        <span class="text-xs font-medium px-3 py-1 rounded-full bg-primary/5 text-primary font-bold">Mathematics 311</span>
                                    </td>
                                    <td class="py-5">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant/80">Worksheet</span>
                                    </td>
                                    <td class="py-5">
                                        <div class="flex items-center gap-1.5 text-xs text-on-surface-variant/40 font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-on-surface-variant/40"></span>
                                            DRAFT
                                        </div>
                                    </td>
                                    <td class="py-5 pr-4 text-right">
                                        <button @click="alert('Viewing calculus integration worksheet...')" class="p-2 hover:bg-surface-container-high/80 rounded-lg text-on-surface-variant transition-colors"><span class="material-symbols-outlined text-lg">visibility</span></button>
                                    </td>
                                </tr>
                                <!-- Mock Row 3 -->
                                <tr x-show="filterLevel === 'all' || filterLevel === 'secondary'" class="group hover:bg-surface-container-lowest/50 transition-all duration-300">
                                    <td class="py-5 pl-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-primary-container/20 flex items-center justify-center text-[#006479]">
                                                <span class="material-symbols-outlined">history_edu</span>
                                            </div>
                                            <div>
                                                <p class="font-bold text-sm">Science_Class10_PYQ.pdf</p>
                                                <p class="text-[10px] text-on-surface-variant/60">Uploaded: Oct 18, 2026</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-5">
                                        <span class="text-xs font-medium px-3 py-1 rounded-full bg-primary/5 text-primary font-bold">General Science</span>
                                    </td>
                                    <td class="py-5">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant/80">Previous Year</span>
                                    </td>
                                    <td class="py-5">
                                        <div class="flex items-center gap-1.5 text-xs text-primary font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                                            LIVE
                                        </div>
                                    </td>
                                    <td class="py-5 pr-4 text-right">
                                        <button @click="alert('Viewing Science PYQ notes...')" class="p-2 hover:bg-surface-container-high/80 rounded-lg text-on-surface-variant transition-colors"><span class="material-symbols-outlined text-lg">visibility</span></button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Utility Panel -->
            <div class="col-span-12 lg:col-span-4 space-y-6">
                <!-- Drop Zone Card -->
                <div class="glass-card rounded-[2rem] p-8 border border-outline-variant/10 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-primary/5 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                    <h3 class="text-lg font-bold mb-6 relative z-10">Upload Protocol</h3>
                    <div @click="openUploadModal()" class="border-2 border-dashed border-primary/20 hover:border-primary/40 rounded-2xl p-10 flex flex-col items-center justify-center text-center cursor-pointer transition-all duration-300 relative z-10">
                        <div class="w-16 h-16 rounded-full bg-primary-container/20 flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-3xl text-primary">cloud_upload</span>
                        </div>
                        <p class="text-sm font-bold text-on-surface mb-1">Drag &amp; Drop Files Here</p>
                        <p class="text-[10px] text-on-surface-variant/60 uppercase tracking-widest font-bold">Supports PDF, DOCX (Max 50MB)</p>
                        <button class="mt-6 text-xs font-bold text-primary underline underline-offset-4">Browse Local Storage</button>
                    </div>
                </div>

                <!-- Active Uploads / Progress -->
                <div class="glass-card rounded-[2rem] p-8 border border-outline-variant/10">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-sm font-bold">Active Processing</h3>
                        <span class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded">2 FILES</span>
                    </div>
                    <div class="space-y-6 font-semibold">
                        <!-- Progress Item 1 -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-on-surface-variant/80">Biology_Genetics_Final.pdf</span>
                                <span class="font-bold text-primary">78%</span>
                            </div>
                            <div class="h-1.5 w-full bg-surface-container-high rounded-full overflow-hidden">
                                <div class="h-full bg-primary rounded-full transition-all duration-700" style="width: 78%"></div>
                            </div>
                            <p class="text-[9px] text-on-surface-variant/40 uppercase tracking-tighter">Uploading to Cloud Archive...</p>
                        </div>
                        <!-- Progress Item 2 -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-on-surface-variant/80">Entrance_Exams_Math_2024.pdf</span>
                                <span class="font-bold text-secondary">Encrypting</span>
                            </div>
                            <div class="h-1.5 w-full bg-surface-container-high rounded-full overflow-hidden">
                                <div class="h-full bg-secondary rounded-full animate-pulse" style="width: 100%"></div>
                            </div>
                            <p class="text-[9px] text-on-surface-variant/40 uppercase tracking-tighter">Performing Security Compliance Check...</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Metadata Card -->
                <div class="bg-gradient-to-br from-inverse-surface to-on-background rounded-[2rem] p-8 text-on-primary shadow-2xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity pointer-events-none">
                        <span class="material-symbols-outlined text-6xl rotate-12">auto_awesome</span>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-lg font-bold mb-2">Storage Summary</h3>
                        <p class="text-xs text-on-primary/60 mb-6 leading-relaxed font-semibold">Your school has utilized 14.2 GB of the available 100 GB archival storage space.</p>
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <p class="text-2xl font-bold">{{ count($materials) > 0 ? count($materials) : '1,248' }}</p>
                                <p class="text-[10px] uppercase tracking-widest text-on-primary/40 font-bold">Total Files</p>
                            </div>
                            <div class="flex-1">
                                <p class="text-2xl font-bold">24</p>
                                <p class="text-[10px] uppercase tracking-widest text-on-primary/40 font-bold">Subjects</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== UPLOAD RESOURCE MODAL ==================== -->
        <div x-show="isUploadModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div @click="isUploadModalOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div class="glass-card w-full max-w-lg bg-white p-8 rounded-2xl border border-outline-variant/30 shadow-2xl relative z-10 text-on-surface">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold font-display text-primary">Upload Study Material</h3>
                    <button @click="isUploadModalOpen = false" class="material-symbols-outlined text-slate-400 hover:text-slate-800">close</button>
                </div>
                <div class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Resource Title</label>
                        <input type="text" x-model="uploadTitle" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-xs font-semibold" placeholder="e.g. Physics Mechanics Formulas Notes"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Academic Level</label>
                        <select x-model="uploadLevel" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 text-xs font-bold focus:bg-white transition-all outline-none">
                            <option value="secondary">Secondary (Class 10th)</option>
                            <option value="senior_secondary">Senior Secondary (Class 12th)</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Subject Name</label>
                        <input type="text" x-model="uploadSubject" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-xs font-semibold" placeholder="e.g. Physics 312"/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Resource Category</label>
                        <select x-model="uploadMaterialType" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 text-xs font-bold focus:bg-white transition-all outline-none">
                            <option value="lecture_note">Lecture Note</option>
                            <option value="worksheet">Worksheet / Assignment</option>
                            <option value="previous_year">Previous Year Paper</option>
                            <option value="reference_book">Reference Book Extract</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">File (PDF/DOCX)</label>
                        <label class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-outline-variant/30 bg-slate-50 hover:bg-slate-100 rounded-xl cursor-pointer transition-colors group">
                            <span class="material-symbols-outlined text-3xl text-outline mb-2 group-hover:scale-110 duration-200">upload_file</span>
                            <span class="text-xs font-bold text-slate-600" x-text="uploadFileName || 'Choose Resource Document'"></span>
                            <input type="file" ref="uploadFile" class="hidden" accept=".pdf,.doc,.docx" @change="uploadFileName = $refs.uploadFile.files[0]?.name || ''"/>
                        </label>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant/10">
                        <button @click="isUploadModalOpen = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl border border-slate-200">Cancel</button>
                        <button @click="submitResource()" class="px-5 py-2.5 cyan-glow-button text-on-primary text-xs font-bold rounded-xl">Upload Document</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('studyManager', () => ({
                isUploadModalOpen: false,
                filterLevel: 'all',
                filterSubject: 'all',

                uploadTitle: '',
                uploadLevel: 'secondary',
                uploadSubject: '',
                uploadMaterialType: 'lecture_note',
                uploadFileName: '',

                openUploadModal() {
                    this.uploadTitle = '';
                    this.uploadLevel = 'secondary';
                    this.uploadSubject = '';
                    this.uploadMaterialType = 'lecture_note';
                    this.uploadFileName = '';
                    this.isUploadModalOpen = true;
                },

                submitResource() {
                    if (!this.uploadTitle || !this.uploadSubject || !this.$refs.uploadFile.files[0]) {
                        alert('Title, Subject, and File are required.');
                        return;
                    }
                    let formData = new FormData();
                    formData.append('title', this.uploadTitle);
                    formData.append('level', this.uploadLevel);
                    formData.append('subject', this.uploadSubject);
                    formData.append('materialType', this.uploadMaterialType);
                    formData.append('file', this.$refs.uploadFile.files[0]);

                    fetch('{{ route("admin.study.upload") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message || 'Study material uploaded successfully.');
                            this.isUploadModalOpen = false;
                            location.reload();
                        } else {
                            alert('Error uploading document.');
                        }
                    });
                },

                deleteResource(id) {
                    if (!confirm('Are you sure you want to delete this study material resource?')) return;
                    fetch('/admin/products/' + id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success || data.message) {
                            alert(data.message || 'Resource deleted.');
                            location.reload();
                        } else {
                            alert('Error deleting resource.');
                        }
                    });
                }
            }));

            // Parallax effect for blobs
            window.addEventListener('mousemove', (e) => {
                const blob1 = document.getElementById('blob1');
                const blob2 = document.getElementById('blob2');
                const x = e.clientX / window.innerWidth;
                const y = e.clientY / window.innerHeight;
                if (blob1) blob1.style.transform = `translate(${x * 20}px, ${y * 20}px)`;
                if (blob2) blob2.style.transform = `translate(${x * 40}px, ${y * 40}px)`;
            });
        });
    </script>
</x-admin-layout>
