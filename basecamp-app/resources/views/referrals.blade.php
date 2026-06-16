<x-student-layout>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .signature-gradient {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
        }
        .reward-card-12 {
            background: linear-gradient(135deg, #006479 0%, #0891b2 100%);
        }
        .reward-card-10 {
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
        }
        .progress-bar-track {
            background: rgba(0,0,0,0.08);
            border-radius: 999px;
            height: 10px;
            overflow: hidden;
        }
        .progress-bar-fill {
            height: 100%;
            border-radius: 999px;
            transition: width 0.8s ease;
        }
        .milestone-dot.done {
            background: linear-gradient(135deg, #006479, #40cef3);
        }
        .milestone-dot.current {
            background: linear-gradient(135deg, #006479, #40cef3);
            box-shadow: 0 0 0 6px rgba(0,100,121,0.15);
            transform: scale(1.2);
        }
        .milestone-dot.todo {
            background: #e2e8f0;
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(64,206,243,0.4); }
            50% { box-shadow: 0 0 0 10px rgba(64,206,243,0); }
        }
        .eligible-badge { animation: pulse-glow 2s infinite; }
    </style>

    <div class="py-12 px-4 max-w-7xl mx-auto space-y-10 relative z-10 w-full overflow-x-hidden">

        {{-- ── Reward Program Cards ── --}}
        <section>
            <h2 class="text-2xl font-extrabold text-primary mb-6 tracking-tight">Referral Reward Programs</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Class 12 Card --}}
                <div class="reward-card-12 rounded-2xl p-7 text-white relative overflow-hidden shadow-xl">
                    <div class="absolute -top-8 -right-8 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="relative z-10">
                        <span class="bg-white/20 text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full">Class 12</span>
                        <div class="flex items-center gap-4 mt-5 mb-2">
                            <span class="material-symbols-outlined text-5xl opacity-90">currency_rupee</span>
                            <div>
                                <h3 class="text-2xl font-extrabold leading-tight">100% Fee Refund</h3>
                                <p class="text-white/75 text-sm mt-1">Refer <span class="font-bold text-white">10 students</span> and get your full Class 12 admission fee refunded.</p>
                            </div>
                        </div>
                        <div class="mt-5 flex items-center gap-3">
                            <span class="material-symbols-outlined text-white/60 text-sm">info</span>
                            <p class="text-xs text-white/60">Referrals must complete enrolment. Processed within 5 business days.</p>
                        </div>
                    </div>
                </div>

                {{-- Class 10 Card --}}
                <div class="reward-card-10 rounded-2xl p-7 text-white relative overflow-hidden shadow-xl">
                    <div class="absolute -top-8 -right-8 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="relative z-10">
                        <span class="bg-white/20 text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full">Class 10</span>
                        <div class="flex items-center gap-4 mt-5 mb-2">
                            <span class="material-symbols-outlined text-5xl opacity-90">school</span>
                            <div>
                                <h3 class="text-2xl font-extrabold leading-tight">Free Class 12 Admission</h3>
                                <p class="text-white/75 text-sm mt-1">Refer <span class="font-bold text-white">10 students</span> and secure your Class 12 seat — absolutely free.</p>
                            </div>
                        </div>
                        <div class="mt-5 flex items-center gap-3">
                            <span class="material-symbols-outlined text-white/60 text-sm">info</span>
                            <p class="text-xs text-white/60">Subject to seat availability. Enrolment must happen before March 31.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── Hero + Code Share ── --}}
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            <div class="lg:col-span-7 glass-card rounded-xl p-8 flex flex-col justify-between relative overflow-hidden shadow-lg shadow-primary/5 border border-outline-variant/20">
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-primary/10 rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    <span class="font-bold uppercase tracking-widest text-cyan-700 text-xs bg-cyan-100 px-3 py-1 rounded-full">Ambassador Program</span>
                    <h1 class="text-4xl md:text-5xl font-sans font-extrabold text-primary tracking-tighter mt-4 mb-2">Base Camp Entry</h1>
                    <p class="text-lg text-on-surface-variant font-medium max-w-md">Unlock excellence together. Refer 10 peers to earn your reward — a fee refund or a free Class 12 seat, depending on your grade.</p>
                </div>

                <div class="mt-12 flex flex-col sm:flex-row items-center gap-4 relative z-10">
                    <div class="flex-1 w-full bg-surface-container-low/50 border border-outline-variant/15 p-4 rounded-xl flex items-center justify-between">
                        <div>
                            <p class="text-[10px] uppercase tracking-wider text-outline font-bold">Your Unique Code</p>
                            <p id="referral-code-display" class="text-2xl font-mono font-bold text-primary tracking-widest">BCS-XXXX-2024</p>
                        </div>
                        <button id="copy-code-btn" onclick="copyReferralCode()" class="p-3 bg-surface-container-lowest rounded-lg shadow-sm hover:scale-105 transition-transform active:scale-95">
                            <span class="material-symbols-outlined text-primary" id="copy-icon">content_copy</span>
                        </button>
                    </div>
                    <button onclick="shareInvite()" class="w-full sm:w-auto px-8 py-4 signature-gradient rounded-xl text-white font-bold shadow-lg shadow-primary/20 flex items-center justify-center gap-2 hover:scale-105 transition-transform">
                        Invite Now <span class="material-symbols-outlined">send</span>
                    </button>
                </div>
            </div>

            <div class="lg:col-span-5 flex flex-col gap-4">
                <div class="glass-card rounded-xl p-6 flex-1 shadow-lg shadow-primary/5 border border-outline-variant/20">
                    <h3 class="text-lg font-bold mb-4 text-primary">Share the Spark</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <button onclick="shareViaWhatsApp()" class="flex items-center justify-center gap-2 p-4 rounded-xl bg-[#25D366]/10 text-[#25D366] font-bold border border-[#25D366]/20 hover:bg-[#25D366]/20 transition-all">
                            <span class="material-symbols-outlined text-sm">chat</span> WhatsApp
                        </button>
                        <button onclick="shareViaEmail()" class="flex items-center justify-center gap-2 p-4 rounded-xl bg-primary/10 text-primary font-bold border border-primary/20 hover:bg-primary/20 transition-all">
                            <span class="material-symbols-outlined text-sm">mail</span> Email
                        </button>
                        <button onclick="shareViaTwitter()" class="flex items-center justify-center gap-2 p-4 rounded-xl bg-[#1DA1F2]/10 text-[#1DA1F2] font-bold border border-[#1DA1F2]/20 hover:bg-[#1DA1F2]/20 transition-all">
                            <span class="material-symbols-outlined text-sm">share</span> Twitter
                        </button>
                        <button onclick="copyReferralCode()" class="flex items-center justify-center gap-2 p-4 rounded-xl bg-on-background/5 text-on-surface font-bold border border-outline-variant/15 hover:bg-on-background/10 transition-all">
                            <span class="material-symbols-outlined text-sm">link</span> Copy Link
                        </button>
                    </div>
                </div>

                <div class="glass-card rounded-xl p-6 bg-surface-container-high/40 shadow-lg shadow-primary/5 border border-outline-variant/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <p id="referrals-count-display" class="text-3xl font-sans font-extrabold text-primary">0 / 10</p>
                            <p class="text-xs text-outline font-bold uppercase tracking-wide mt-1">Referrals Completed</p>
                        </div>
                        <div class="h-12 w-12 bg-primary/10 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">group_add</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── Progress Tracker ── --}}
        <section class="glass-card rounded-xl p-8 shadow-lg shadow-primary/5 border border-outline-variant/20">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-primary">Milestone Progress</h2>
                    <p id="progress-subtitle" class="text-on-surface-variant font-medium">Loading your progress…</p>
                </div>
                <div id="reward-badge" class="bg-primary/10 text-primary px-4 py-2 rounded-lg font-bold text-sm tracking-wide">
                    REWARD: LOADING…
                </div>
            </div>

            {{-- Progress bar --}}
            <div class="progress-bar-track mb-6">
                <div id="progress-bar-fill" class="progress-bar-fill signature-gradient" style="width: 0%"></div>
            </div>

            {{-- Milestone dots --}}
            <div class="relative pt-10 pb-6 w-full hidden sm:flex justify-between items-center">
                <div class="absolute top-1/2 left-0 w-full h-1 bg-surface-variant/50 -translate-y-1/2 rounded-full"></div>
                <div id="active-progress-line" class="absolute top-1/2 left-0 h-1.5 signature-gradient -translate-y-1/2 rounded-full shadow-[0_0_15px_rgba(0,100,121,0.3)] transition-all duration-700" style="width: 0%"></div>

                <div class="relative flex justify-between items-center w-full">
                    @foreach([0, 2, 5, 7, 10] as $m)
                    <div class="flex flex-col items-center gap-2 z-10" data-milestone="{{ $m }}">
                        <div class="milestone-dot todo h-8 w-8 rounded-full border-4 border-white shadow-md flex items-center justify-center transition-all duration-500">
                            <span class="material-symbols-outlined text-[13px] text-white check-icon hidden">check</span>
                            <span class="dot-number text-xs font-bold text-slate-400">{{ $m }}</span>
                        </div>
                        <span class="text-[10px] font-bold text-outline uppercase absolute top-12">
                            @if($m === 0) Start @elseif($m === 10) 🎯 Goal @else {{ $m }} Refs @endif
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Claim button (hidden until eligible) --}}
            <div id="claim-section" class="hidden mt-8 pt-6 border-t border-outline-variant/20 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-green-700">🎉 You're Eligible!</h3>
                    <p id="claim-description" class="text-sm text-on-surface-variant mt-1"></p>
                </div>
                <button id="claim-btn" onclick="claimReward()" class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl shadow-lg transition-all hover:scale-105 eligible-badge flex items-center gap-2">
                    <span class="material-symbols-outlined">redeem</span> Claim Reward
                </button>
            </div>
        </section>

        {{-- ── Referral List + Leaderboard ── --}}
        <section class="grid grid-cols-1 md:grid-cols-12 gap-6 pb-[100px]">
            <div class="md:col-span-8 space-y-4">
                <h2 class="text-xl font-bold px-2 text-primary">Successful Referrals</h2>
                <div id="referral-list" class="space-y-3">
                    <div class="glass-card p-6 text-center text-outline text-sm">Loading referrals…</div>
                </div>
            </div>

            <div class="md:col-span-4 space-y-6">
                <h2 class="text-xl font-bold px-2 text-primary">Leaderboard</h2>
                <div class="glass-card rounded-xl overflow-hidden shadow-sm border border-outline-variant/20">
                    <div class="p-4 bg-primary text-white flex items-center justify-between">
                        <span class="text-xs font-bold tracking-widest uppercase">Global Rank</span>
                        <span class="text-xl font-bold">#24</span>
                    </div>
                    <div class="p-4 space-y-4">
                        @foreach([['Priya S.', 24], ['Karan M.', 21], ['Ishita K.', 19]] as $i => $entry)
                        <div class="flex items-center justify-between group">
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold text-outline">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</span>
                                <div class="h-8 w-8 rounded-full bg-primary/20 flex items-center justify-center">
                                    <span class="text-primary font-bold text-sm">{{ substr($entry[0], 0, 1) }}</span>
                                </div>
                                <span class="text-sm font-bold text-on-surface">{{ $entry[0] }}</span>
                            </div>
                            <span class="text-xs font-bold text-primary group-hover:scale-110 transition-transform">{{ $entry[1] }} Refs</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="p-4 border-t border-outline-variant/10">
                        <button class="w-full text-center text-xs font-bold text-primary hover:underline underline-offset-4">VIEW FULL LEADERBOARD</button>
                    </div>
                </div>

                <div class="glass-card rounded-xl p-6 border-dashed border-primary/40 bg-primary/5">
                    <div class="flex items-start gap-4">
                        <span class="material-symbols-outlined text-primary text-3xl mt-1">lightbulb</span>
                        <div>
                            <h4 class="font-bold text-primary">Pro Tip</h4>
                            <p class="text-xs text-on-surface-variant font-medium leading-relaxed">Referrals shared via WhatsApp have a 3× higher conversion rate. Try sharing your success stories!</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
    // ── Config ──────────────────────────────────────────────────────────
    const API_BASE = 'http://localhost:5000/api';
    const TOKEN    = localStorage.getItem('token');
    const MILESTONES = [0, 2, 5, 7, 10];

    // ── Bootstrap ────────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        loadReferralData();
    });

    async function apiGet(path) {
        const res = await fetch(API_BASE + path, {
            headers: { Authorization: `Bearer ${TOKEN}` }
        });
        return res.json();
    }

    async function apiPost(path, body = {}) {
        const res = await fetch(API_BASE + path, {
            method: 'POST',
            headers: { Authorization: `Bearer ${TOKEN}`, 'Content-Type': 'application/json' },
            body: JSON.stringify(body),
        });
        return res.json();
    }

    // ── Load Data ────────────────────────────────────────────────────────
    async function loadReferralData() {
        if (!TOKEN) return showNoAuth();

        const data = await apiGet('/referrals/me');
        if (!data.success) return;

        const { rewardStatus, data: referrals } = data;

        // Referral code (comes from user profile in real app; mocked here)
        const codeEl = document.getElementById('referral-code-display');
        codeEl.textContent = data.referralCode || 'BCS-XXXX-2024';

        // Count display
        const total = rewardStatus ? rewardStatus.referralsRequired : 10;
        document.getElementById('referrals-count-display').textContent =
            `${data.referralsCount} / ${total}`;

        // Reward badge + subtitle
        if (rewardStatus) {
            document.getElementById('reward-badge').textContent =
                `REWARD: ${rewardStatus.rewardLabel.toUpperCase()}`;
            const done = rewardStatus.referralsCount;
            const rem  = rewardStatus.remaining;
            document.getElementById('progress-subtitle').textContent =
                rewardStatus.eligible
                    ? `✅ All ${total} referrals complete! Claim your reward now.`
                    : `${done} of ${total} completed — ${rem} more to unlock your ${rewardStatus.rewardLabel}!`;
        }

        // Progress bar
        const pct = rewardStatus ? rewardStatus.progress : 0;
        document.getElementById('progress-bar-fill').style.width = pct + '%';
        document.getElementById('active-progress-line').style.width = pct + '%';

        // Milestone dots
        const count = data.referralsCount || 0;
        document.querySelectorAll('[data-milestone]').forEach(el => {
            const m   = parseInt(el.dataset.milestone);
            const dot = el.querySelector('.milestone-dot');
            const chk = el.querySelector('.check-icon');
            const num = el.querySelector('.dot-number');
            dot.classList.remove('done', 'current', 'todo');
            if (count >= m && m < count) {
                dot.classList.add('done');
                chk.classList.remove('hidden'); num.classList.add('hidden');
            } else if (count === m || (m === Math.max(...MILESTONES.filter(x => x <= count)))) {
                dot.classList.add('current');
                num.textContent = m; num.classList.remove('hidden'); chk.classList.add('hidden');
            } else {
                dot.classList.add('todo');
                num.classList.remove('hidden'); chk.classList.add('hidden');
            }
        });

        // Claim button
        if (rewardStatus && rewardStatus.eligible && !rewardStatus.claimed) {
            const claimSection = document.getElementById('claim-section');
            claimSection.classList.remove('hidden');
            document.getElementById('claim-description').textContent = rewardStatus.description;
        }

        // Referral list
        renderReferralList(referrals);
    }

    // ── Render Referrals ─────────────────────────────────────────────────
    function renderReferralList(referrals) {
        const container = document.getElementById('referral-list');
        if (!referrals || referrals.length === 0) {
            container.innerHTML = `<div class="glass-card p-8 text-center text-outline text-sm rounded-xl">
                <span class="material-symbols-outlined text-3xl block mb-2">group</span>
                No referrals yet. Share your code to get started!
            </div>`;
            return;
        }

        container.innerHTML = referrals.map((r, i) => {
            const ref    = r.referredUserId;
            const name   = ref ? ref.name : 'Unknown';
            const email  = ref ? ref.email : '—';
            const joined = ref ? new Date(ref.createdAt).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '—';
            const isSuccessful = r.status === 'Successful';
            const badgeClass = isSuccessful
                ? 'bg-green-100 text-green-700'
                : 'bg-surface-container-highest text-outline';
            const badgeIcon  = isSuccessful ? 'verified' : 'schedule';
            const badgeLabel = isSuccessful ? 'Enrolled' : 'Pending';
            return `
            <div class="glass-card hover:bg-white/80 transition-all p-4 flex flex-wrap items-center justify-between gap-4 rounded-xl group shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-xl signature-gradient flex items-center justify-center text-white font-extrabold text-lg flex-shrink-0">
                        ${name.charAt(0).toUpperCase()}
                    </div>
                    <div>
                        <h4 class="font-bold text-on-surface">${name}</h4>
                        <p class="text-xs text-outline font-medium">Joined ${joined}</p>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <div class="text-right hidden sm:block">
                        <p class="text-[10px] uppercase tracking-tighter text-outline font-bold">Email</p>
                        <p class="text-sm font-medium text-primary">${email}</p>
                    </div>
                    <div class="${badgeClass} px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">${badgeIcon}</span> ${badgeLabel}
                    </div>
                </div>
            </div>`;
        }).join('');
    }

    // ── Claim Reward ─────────────────────────────────────────────────────
    async function claimReward() {
        const btn = document.getElementById('claim-btn');
        btn.disabled = true;
        btn.textContent = 'Processing…';

        const res = await apiPost('/referrals/claim-reward');
        if (res.success) {
            document.getElementById('claim-section').innerHTML = `
                <div class="w-full p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 font-medium text-sm">
                    ✅ ${res.message}
                </div>`;
        } else {
            btn.disabled = false;
            btn.innerHTML = `<span class="material-symbols-outlined">redeem</span> Claim Reward`;
            alert(res.message || 'Something went wrong. Please try again.');
        }
    }

    // ── Copy + Share helpers ──────────────────────────────────────────────
    function copyReferralCode() {
        const code = document.getElementById('referral-code-display').textContent;
        navigator.clipboard.writeText(`Join thebasecampschool with my code: ${code} → https://basecamp.school/join`).then(() => {
            const icon = document.getElementById('copy-icon');
            icon.textContent = 'check_circle';
            setTimeout(() => icon.textContent = 'content_copy', 2000);
        });
    }

    function getShareText() {
        const code = document.getElementById('referral-code-display').textContent;
        return encodeURIComponent(`Join thebasecampschool using my referral code ${code} and let's grow together! 🚀 https://basecamp.school/join`);
    }

    function shareViaWhatsApp() { window.open(`https://wa.me/?text=${getShareText()}`, '_blank'); }
    function shareViaTwitter()  { window.open(`https://twitter.com/intent/tweet?text=${getShareText()}`, '_blank'); }
    function shareViaEmail()    { window.location.href = `mailto:?subject=Join thebasecampschool!&body=${getShareText()}`; }
    function shareInvite()      { shareViaWhatsApp(); }

    function showNoAuth() {
        document.getElementById('referral-list').innerHTML =
            `<div class="glass-card p-6 text-outline text-sm rounded-xl">Please log in to see your referral data.</div>`;
    }
    </script>
</x-student-layout>
