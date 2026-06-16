<x-student-layout>
    <div class="max-w-3xl mx-auto relative z-10">
        <!-- Header -->
        <div class="mb-8">
            <a href="/downloads" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-cyan-600 mb-2 font-bold">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Back to Downloads
            </a>
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Add New Resource</h2>
            <p class="text-slate-500">Upload study materials, notes, or assignments for your digital library.</p>
        </div>

        <!-- Add Resource Form -->
        <form class="space-y-6">
            <!-- Resource Title -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Resource Title *</label>
                <input type="text" placeholder="e.g., Biology Chapter 5 Notes" 
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100 outline-none"/>
            </div>

            <!-- Category -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Category *</label>
                <select class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-cyan-500 outline-none">
                    <option value="">Select Category</option>
                    <option value="pdf">PDF Notes</option>
                    <option value="tma">TMA Assignment</option>
                </select>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                <textarea rows="4" placeholder="Brief description of the resource..." 
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100 outline-none"></textarea>
            </div>

            <!-- File Upload -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Upload File *</label>
                <div class="border-2 border-dashed border-slate-300 rounded-xl p-8 text-center hover:border-cyan-400 hover:bg-cyan-50 transition cursor-pointer">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                        <span class="material-symbols-outlined text-3xl">cloud_upload</span>
                    </div>
                    <p class="font-bold text-slate-700 mb-1">Click to upload or drag and drop</p>
                    <p class="text-sm text-slate-500">PDF, DOC, PPT, or Image (max 25MB)</p>
                    <input type="file" class="hidden" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png"/>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <a href="/downloads" class="px-6 py-3 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 text-center sm:text-left">
                    Cancel
                </a>
                <button type="submit" class="flex-1 px-6 py-3 rounded-xl bg-cyan-600 text-white font-bold hover:bg-cyan-700 transition flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">upload</span>
                    Upload Resource
                </button>
            </div>
        </form>

        <!-- Recent Uploads -->
        <div class="mt-12 pt-8 border-t border-slate-200">
            <h3 class="text-lg font-bold mb-4">Recent Uploads</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center text-red-600 flex-shrink-0">
                            <span class="material-symbols-outlined">picture_as_pdf</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-slate-800">Physics Formula Sheet</h4>
                            <p class="text-xs text-slate-500">PDF | 2.5 MB</p>
                        </div>
                    </div>
                    <button class="text-slate-400 hover:text-cyan-600">
                        <span class="material-symbols-outlined">download</span>
                    </button>
                </div>
                <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                            <span class="material-symbols-outlined">article</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-slate-800">Chemistry Notes Ch 3</h4>
                            <p class="text-xs text-slate-500">DOCX | 1.2 MB</p>
                        </div>
                    </div>
                    <button class="text-slate-400 hover:text-cyan-600">
                        <span class="material-symbols-outlined">download</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-student-layout>