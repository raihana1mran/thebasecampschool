<x-student-layout>
    <style>
        .glass-panel { background: rgba(255,255,255,0.7); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); border: 1px solid rgba(255,255,255,0.4); }
        .signature-gradient { background: linear-gradient(135deg, #006479 0%, #40cef3 100%); }
        .basket-dot { animation: pop-in 0.3s cubic-bezier(0.68, -0.55, 0.27, 1.55); }
        @keyframes pop-in { 0% { transform: scale(0); } 80% { transform: scale(1.2); } 100% { transform: scale(1); } }
    </style>
    <div x-data="{
        basket: [],
        basketOpen: false,
        checkoutStep: 'basket',
        processing: false,
        purchased: {},

        get total() {
            return this.basket.reduce((sum, p) => sum + parseFloat(p.price), 0);
        },
        get count() {
            return this.basket.length;
        },
        addToBasket(product) {
            if (this.basket.find(p => p.id === product.id)) return;
            this.basket.push(product);
        },
        removeFromBasket(id) {
            this.basket = this.basket.filter(p => p.id !== id);
            if (this.basket.length === 0) this.basketOpen = false;
        },
        openCheckout() {
            if (this.basket.length === 0) return;
            this.checkoutStep = 'basket';
            this.basketOpen = true;
        },
        proceedToPay() {
            this.checkoutStep = 'payment';
        },
        async completePurchase() {
            if (this.processing) return;
            this.processing = true;
            try {
                const resp = await fetch('{{ route("shop.purchase") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: JSON.stringify({
                        product_ids: this.basket.map(p => p.id),
                        amount: this.total
                    })
                });
                const data = await resp.json();
                if (data.success) {
                    this.purchased = data.downloads;
                    this.checkoutStep = 'complete';
                    this.basket = [];
                } else {
                    alert(data.message || 'Purchase failed.');
                }
            } catch {
                alert('Network error. Please try again.');
            } finally {
                this.processing = false;
            }
        },
        closeCheckout() {
            this.basketOpen = false;
            if (this.checkoutStep === 'complete') this.purchased = {};
            this.checkoutStep = 'basket';
        }
    }">
        <div class="max-w-6xl mx-auto relative z-10 pb-28 sm:pb-32">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 sm:mb-8">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 mb-1">Resource Shop</h1>
                    <p class="text-xs sm:text-sm text-slate-500">Browse, purchase, and download study materials</p>
                </div>
                @if(Auth::user()->role === 'admin')
                <a href="/admin/products" class="px-4 py-2.5 bg-cyan-600 text-white rounded-xl text-xs font-bold hover:bg-cyan-700 flex items-center gap-2 min-h-[44px]">
                    <span class="material-symbols-outlined text-sm">add</span>
                    Add Resource
                </a>
                @endif
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-5">
                @forelse($products as $product)
                    @php
                        $colors = ['from-cyan-500/20 to-blue-500/20', 'from-purple-500/20 to-pink-500/20', 'from-emerald-500/20 to-teal-500/20', 'from-amber-500/20 to-orange-500/20', 'from-rose-500/20 to-red-500/20'];
                        $icons = ['picture_as_pdf', 'description', 'assignment', 'book', 'article'];
                        $c = $product->id % count($colors);
                    @endphp
                    <div class="glass-panel rounded-xl sm:rounded-2xl overflow-hidden border border-slate-100 hover:shadow-md transition-all group flex flex-col">
                        <div class="h-20 sm:h-28 bg-gradient-to-br {{ $colors[$c] }} flex items-center justify-center relative">
                            <span class="material-symbols-outlined text-slate-500/40 text-3xl sm:text-5xl">{{ $icons[$c] }}</span>
                            @if($product->price > 0)
                            <span class="absolute top-2 right-2 bg-amber-100 text-amber-700 px-1.5 py-0.5 rounded text-[9px] font-bold">₹{{ number_format($product->price, 0) }}</span>
                            @else
                            <span class="absolute top-2 right-2 bg-green-100 text-green-700 px-1.5 py-0.5 rounded text-[9px] font-bold">Free</span>
                            @endif
                            <span class="absolute top-2 left-2 bg-white/80 text-[9px] font-bold text-slate-500 px-1.5 py-0.5 rounded uppercase">{{ $product->category }}</span>
                        </div>
                        @php
                            $unlockedProducts = Auth::user()->unlocked_products ?? [];
                            $isUnlocked = in_array((string)$product->id, $unlockedProducts) || in_array($product->id, $unlockedProducts);
                            $isPaid = $product->price > 0;
                            $fileUrls = $product->file_urls;
                            if (is_string($fileUrls)) {
                                $fileUrls = json_decode($fileUrls, true) ?: [];
                            }
                            $fileUrl = '#';
                            if (is_array($fileUrls) && count($fileUrls) > 0) {
                                $fileUrl = str_starts_with($fileUrls[0], 'http') ? $fileUrls[0] : asset('storage/' . $fileUrls[0]);
                            }
                        @endphp
                        <div class="p-3 sm:p-4 flex flex-col flex-1">
                            <h3 class="font-bold text-xs sm:text-sm text-slate-800 mb-1 leading-tight">{{ $product->title }}</h3>
                            <p class="text-[9px] sm:text-[10px] text-slate-400 mb-3 flex-1 line-clamp-2">{{ $product->description ?? 'No description' }}</p>
                            
                            @if(!$isPaid || $isUnlocked)
                            <a href="{{ $fileUrl }}" target="_blank" class="w-full py-2 bg-cyan-600 text-white rounded-lg text-[10px] sm:text-xs font-bold hover:bg-cyan-700 flex items-center justify-center gap-1.5 min-h-[36px] sm:min-h-[40px] shadow-sm">
                                <span class="material-symbols-outlined text-sm">download</span>
                                <span>Download</span>
                            </a>
                            @else
                            <button @click="addToBasket({ id: {{ $product->id }}, title: '{{ addslashes($product->title) }}', price: '{{ $product->price }}', icon: '{{ $icons[$c] }}' })"
                                class="w-full py-2 rounded-lg text-[10px] sm:text-xs font-bold transition-all min-h-[36px] sm:min-h-[40px] flex items-center justify-center gap-1.5"
                                :class="basket.find(p => p.id === {{ $product->id }}) ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'signature-gradient text-white hover:opacity-90'">
                                <span class="material-symbols-outlined text-sm" x-text="basket.find(p => p.id === {{ $product->id }}) ? 'check' : 'lock_open'"></span>
                                <span x-text="basket.find(p => p.id === {{ $product->id }}) ? 'Added to Basket' : 'Unlock for ₹{{ $product->price }}'"></span>
                            </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center border-2 border-dashed border-slate-200 bg-white/40 rounded-3xl flex flex-col items-center justify-center">
                        <span class="material-symbols-outlined text-slate-300 text-4xl mb-3">inventory_2</span>
                        <h5 class="text-base font-bold text-slate-600">No resources available yet</h5>
                        <p class="text-xs text-slate-400 mt-1">Study materials will appear here once published.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Floating Basket Button -->
        <button @click="openCheckout()" x-show="count > 0" x-transition
            class="fixed bottom-6 right-6 z-40 w-14 h-14 rounded-full signature-gradient text-white shadow-2xl shadow-cyan-500/30 hover:scale-110 active:scale-95 transition-all flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">shopping_basket</span>
            <span x-text="count" class="absolute -top-1 -right-1 w-5 h-5 bg-rose-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center basket-dot"></span>
        </button>

        <!-- Floating Checkout Panel -->
        <div x-show="basketOpen" x-cloak class="fixed inset-0 z-50 flex items-end sm:items-center justify-center" @keydown.escape.window="closeCheckout()">
            <div @click="closeCheckout()" class="absolute inset-0 bg-black/30 backdrop-blur-sm"></div>
            <div @click.stop class="relative w-full sm:max-w-md bg-white rounded-t-3xl sm:rounded-3xl shadow-2xl border border-slate-200 max-h-[85dvh] flex flex-col overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between p-4 sm:p-6 border-b border-slate-100 shrink-0">
                    <h2 class="text-base sm:text-lg font-bold text-slate-800" x-text="checkoutStep === 'basket' ? 'Your Basket' : checkoutStep === 'payment' ? 'Checkout' : 'Get Files'"></h2>
                    <button @click="closeCheckout()" class="p-1.5 hover:bg-slate-100 rounded-full text-slate-400"><span class="material-symbols-outlined">close</span></button>
                </div>

                <!-- Basket Step -->
                <div x-show="checkoutStep === 'basket'" class="p-4 sm:p-6 space-y-3 overflow-y-auto flex-1">
                    <template x-if="basket.length === 0">
                        <div class="text-center py-8 text-slate-400"><span class="material-symbols-outlined text-3xl block mb-2">shopping_cart</span><p class="text-sm font-medium">Your basket is empty</p></div>
                    </template>
                    <template x-for="(item, idx) in basket" :key="item.id">
                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="material-symbols-outlined text-slate-400 text-lg" x-text="item.icon"></span>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs sm:text-sm font-semibold text-slate-700 truncate" x-text="item.title"></p>
                                <p class="text-[10px] text-slate-400" x-text="'₹' + parseFloat(item.price).toLocaleString()"></p>
                            </div>
                            <button @click="removeFromBasket(item.id)" class="p-1 text-slate-400 hover:text-red-500"><span class="material-symbols-outlined text-sm">remove_circle</span></button>
                        </div>
                    </template>

                    <div x-show="basket.length > 0" class="pt-3 border-t border-slate-100">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm font-bold text-slate-800">Total</span>
                            <span class="text-lg font-extrabold text-cyan-700" x-text="'₹' + total.toLocaleString()"></span>
                        </div>
                        <button @click="proceedToPay()" class="w-full py-3 rounded-xl signature-gradient text-white font-bold text-sm hover:opacity-90 transition-all min-h-[44px] flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-sm">lock</span>
                            Proceed to Pay
                        </button>
                    </div>
                </div>

                <!-- Payment Step -->
                <div x-show="checkoutStep === 'payment'" class="p-4 sm:p-6 space-y-4 overflow-y-auto flex-1">
                    <div class="bg-amber-50 rounded-xl p-4 border border-amber-100">
                        <p class="text-xs font-bold text-amber-800">Demo Payment</p>
                        <p class="text-[10px] text-amber-600 mt-1">This is a mock payment for demonstration. Click Pay to complete.</p>
                    </div>
                    <div class="space-y-2">
                        <template x-for="item in basket" :key="item.id">
                            <div class="flex justify-between text-sm"><span class="text-slate-600" x-text="item.title"></span><span class="font-semibold" x-text="'₹' + parseFloat(item.price).toLocaleString()"></span></div>
                        </template>
                    </div>
                    <div class="flex justify-between text-base font-bold border-t border-slate-100 pt-3">
                        <span>Total</span>
                        <span class="text-cyan-700" x-text="'₹' + total.toLocaleString()"></span>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <button @click="checkoutStep = 'basket'" class="py-3 rounded-xl border border-slate-200 text-slate-600 text-sm font-bold hover:bg-slate-50">Back</button>
                        <button @click="completePurchase()" :disabled="processing" class="py-3 rounded-xl signature-gradient text-white text-sm font-bold hover:opacity-90 disabled:opacity-50 min-h-[44px] flex items-center justify-center gap-2">
                            <span x-show="processing" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                            <span x-text="processing ? 'Processing...' : 'Pay ₹' + total.toLocaleString()"></span>
                        </button>
                    </div>
                </div>

                <!-- Complete Step -->
                <div x-show="checkoutStep === 'complete'" class="p-4 sm:p-6 space-y-3 overflow-y-auto flex-1">
                    <div class="bg-green-50 rounded-xl p-4 border border-green-100 text-center">
                        <span class="material-symbols-outlined text-green-600 text-3xl block mb-2">check_circle</span>
                        <p class="text-sm font-bold text-green-800">Purchase Successful!</p>
                        <p class="text-[10px] text-green-600 mt-1">Click below to download your files.</p>
                    </div>
                    <template x-for="(item, id) in purchased" :key="id">
                        <div class="p-3 bg-white rounded-xl border border-slate-100">
                            <p class="text-xs font-bold text-slate-700 mb-2" x-text="item.title"></p>
                            <div class="space-y-1.5">
                                <template x-for="(url, i) in item.urls" :key="i">
                                    <a :href="url" target="_blank" class="flex items-center gap-2 px-3 py-2 bg-cyan-50 text-cyan-700 rounded-lg text-[10px] font-bold hover:bg-cyan-100 transition-colors w-full">
                                        <span class="material-symbols-outlined text-sm">download</span>
                                        <span x-text="'Get ' + (item.urls.length > 1 ? 'File ' + (i+1) : '')"></span>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </template>
                    <button @click="closeCheckout()" class="w-full py-3 rounded-xl border border-slate-200 text-slate-600 text-sm font-bold hover:bg-slate-50 mt-2">Continue Shopping</button>
                </div>
            </div>
        </div>
    </div>
</x-student-layout>