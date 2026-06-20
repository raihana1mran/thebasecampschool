<x-admin-layout>
    <style>
        .glass-card { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(32px); border: 1px solid rgba(255, 255, 255, 0.2); box-shadow: 0 40px 60px rgba(42, 48, 49, 0.04); }
        .ghost-border { border: 1px solid rgba(168, 174, 176, 0.15); }
        .cyan-glow { box-shadow: 0 0 20px rgba(64, 206, 243, 0.15); }
    </style>
    <div x-data="videoManager" class="w-full space-y-8 pb-20">
        <section class="flex flex-col gap-2">
            <p class="text-primary font-bold tracking-[0.2em] text-xs uppercase">Administrative Portal</p>
            <h3 class="font-display text-4xl font-extrabold text-on-surface tracking-tighter">Video Lesson Management</h3>
        </section>
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 mt-4 mb-10">
            <div class="max-w-2xl">
                <p class="text-sm text-on-surface-variant/80 leading-relaxed font-semibold">
                    Manage subject-wise video lessons and YouTube playlists for Secondary and Senior Secondary classes.
                </p>
            </div>
            <div class="flex items-center gap-4 shrink-0 font-semibold">
                <button @click="openUploadModal()" class="flex items-center gap-2 bg-gradient-to-br from-primary to-primary-container text-on-primary px-6 py-3 rounded-2xl font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all text-xs">
                    <span class="material-symbols-outlined text-lg">add_link</span>
                    ADD NEW PLAYLIST
                </button>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 glass-card rounded-[2rem] p-8 border border-outline-variant/10">
                <h3 class="text-xl font-bold flex items-center gap-3 mb-8">
                    <span class="w-2 h-8 bg-primary rounded-full"></span>
                    Video Lessons Inventory
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-bold text-on-surface-variant/50 uppercase tracking-[0.2em] border-b border-outline-variant/10">
                                <th class="pb-4 pl-4">Subject</th>
                                <th class="pb-4">Class Level</th>
                                <th class="pb-4">Playlist URL</th>
                                <th class="pb-4 text-right pr-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/5">
                            @forelse($videoLessons as $lesson)
                                <tr class="group hover:bg-surface-container-lowest/50 transition-all duration-300">
                                    <td class="py-5 pl-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-error-container/20 flex items-center justify-center text-error">
                                                <span class="material-symbols-outlined">smart_display</span>
                                            </div>
                                            <div>
                                                <p class="font-bold text-sm text-on-surface">{{ $lesson['subject'] }}</p>
                                                <p class="text-[10px] text-on-surface-variant/60">Uploaded: {{ $lesson['uploaded_at']->format('d M, Y') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-5"><span class="text-xs font-medium px-3 py-1 rounded-full bg-primary/5 text-primary">{{ $lesson['class'] }}</span></td>
                                    <td class="py-5"><a href="{{ $lesson['playlist_url'] }}" target="_blank" class="text-xs font-bold text-cyan-600 hover:underline flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">link</span>View Playlist</a></td>
                                    <td class="py-5 pr-4 text-right"><button @click="deleteResource({{ $lesson['id'] }})" class="p-2 hover:bg-error-container/10 rounded-lg text-error transition-colors"><span class="material-symbols-outlined text-lg">delete</span></button></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="py-5 text-center text-sm font-bold text-slate-500">No video lessons found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div x-show="isUploadModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div @click="isUploadModalOpen = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div class="glass-card w-full max-w-lg bg-white p-8 rounded-2xl border border-outline-variant/30 shadow-2xl relative z-10 text-on-surface">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold font-display text-primary">Add Video Playlist</h3>
                    <button @click="isUploadModalOpen = false" class="material-symbols-outlined text-slate-400 hover:text-slate-800">close</button>
                </div>
                <form method="POST" action="{{ route('admin.video-lessons.upload') }}" class="space-y-4">
                    @csrf
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Subject Name</label>
                        <input type="text" name="subject" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-xs font-semibold" placeholder="e.g. Physics 312" required/>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Class Level</label>
                        <select name="class_level" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 text-xs font-bold focus:bg-white transition-all outline-none" required>
                            <option value="Secondary (10th)">Secondary (Class 10th)</option>
                            <option value="Senior Secondary (12th)">Senior Secondary (Class 12th)</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">YouTube Playlist URL</label>
                        <input type="url" name="playlist_url" class="w-full p-3 border border-outline-variant/20 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none text-xs font-semibold" placeholder="https://youtube.com/playlist?list=..." required/>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant/10">
                        <button type="button" @click="isUploadModalOpen = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl border border-slate-200">Cancel</button>
                        <button type="submit" class="px-5 py-2.5 bg-cyan-500 hover:bg-cyan-600 text-white shadow shadow-cyan-500/50 text-xs font-bold rounded-xl">Save Playlist</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('videoManager', () => ({
                isUploadModalOpen: false,
                openUploadModal() { this.isUploadModalOpen = true; },
                deleteResource(id) {
                    if (confirm('Are you sure you want to delete this video lesson playlist?')) {
                        fetch('/admin/video-lessons/' + id, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message || 'Video lesson deleted.');
                                location.reload();
                            } else {
                                alert('Error deleting video lesson.');
                            }
                        });
                    }
                }
            }));
        });
    </script>
</x-admin-layout>
