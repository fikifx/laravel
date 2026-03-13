<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { 
    Star, Plus, Trash2, Save, RotateCcw, ArrowUp, ArrowDown, CheckCircle2,
    User, MessageSquare, Quote, ChevronRight, Check
} from 'lucide-vue-next';
import { ref, computed } from 'vue';

const props = defineProps({
    reviews: { type: Array, default: () => [] },
});

const defaults = [
    { name: 'Susi Kiki', role: 'Wisatawan', avatar: '', text: 'Puas banget! Driver sangat ramah dan hafal tempat wisata. Mobil bersih dan nyaman. Highly recommended!', label: 'Dengan Sopir · 6 Bulan Lalu', rating: 5 },
];

const form = useForm({
    reviews: props.reviews.length > 0
        ? props.reviews.map(r => ({ ...r }))
        : defaults.map(d => ({ ...d })),
});

const addRow = () => {
    if (form.reviews.length >= 10) return;
    form.reviews.push({ 
        name: '', 
        role: '', 
        avatar: '', 
        text: '', 
        label: '', 
        rating: 5 
    });
};

const removeRow = (i) => {
    if (form.reviews.length <= 1) return;
    form.reviews.splice(i, 1);
};

const moveUp = (i) => {
    if (i > 0) {
        const item = form.reviews[i];
        form.reviews[i] = form.reviews[i-1];
        form.reviews[i-1] = item;
    }
};

const moveDown = (i) => {
    if (i < form.reviews.length - 1) {
        const item = form.reviews[i];
        form.reviews[i] = form.reviews[i+1];
        form.reviews[i+1] = item;
    }
};

const submit = () => {
    form.put(route('reviews.update'), {
        preserveScroll: true,
        onSuccess: () => {}
    });
};

const doReset = () => {
    if (confirm('Reset Ulasan ke data default? Semua perubahan akan hilang.')) {
        form.delete(route('reviews.reset'), {
            preserveScroll: true
        });
    }
};

// Live Preview Marquee Logic
const duplicatedReviews = computed(() => {
    const list = form.reviews.filter(r => r.name && r.text);
    if (list.length === 0) return [];
    // For vertical preview, we might just want to show them 1:1 or as a stack
    return list;
});

</script>

<template>
    <Head title="Kelola Ulasan" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center text-yellow-600 shadow-sm shadow-yellow-100">
                        <Star class="w-6 h-6 fill-current" />
                    </div>
                    <div>
                        <h2 class="font-black text-xl text-slate-800 leading-tight">Ulasan Pelanggan</h2>
                        <p class="text-xs text-slate-400 font-medium">Atur testimoni dari pelanggan Anda</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" @click="doReset"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-50 text-xs font-bold transition-all">
                        <RotateCcw class="w-3.5 h-3.5" />
                        Reset
                    </button>
                    <button @click="submit" :disabled="form.processing"
                        class="flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black rounded-xl shadow-lg shadow-indigo-100 transition-all active:scale-95 disabled:opacity-50">
                        <Save class="w-3.5 h-3.5" />
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </template>

        <div class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div v-if="$page.props.flash?.message"
                    class="mb-8 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 text-emerald-600 animate-in fade-in slide-in-from-top-4 duration-500">
                    <CheckCircle2 class="w-5 h-5 shrink-0" />
                    <span class="text-sm font-bold">{{ $page.props.flash.message }}</span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                    
                    <!-- EDITOR PANEL (LEFT) -->
                    <div class="lg:col-span-2 space-y-4">
                        <div class="flex items-center justify-between px-2 mb-2">
                            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Daftar Ulasan (Max 10)</span>
                            <button @click="addRow" :disabled="form.reviews.length >= 10"
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 text-[11px] font-black rounded-lg transition-colors">
                                <Plus class="w-3.5 h-3.5" />
                                Tambah Ulasan
                            </button>
                        </div>

                        <div class="space-y-4">
                            <div v-for="(review, i) in form.reviews" :key="i" 
                                class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-all group relative overflow-hidden">
                                
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity"></div>

                                <div class="flex items-start gap-6">
                                    <!-- Order Controls -->
                                    <div class="flex flex-col gap-1 pt-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button @click="moveUp(i)" :disabled="i === 0" class="p-1.5 hover:bg-slate-50 rounded-lg disabled:opacity-20 text-slate-400">
                                            <ArrowUp class="w-4 h-4" />
                                        </button>
                                        <button @click="moveDown(i)" :disabled="i === form.reviews.length - 1" class="p-1.5 hover:bg-slate-50 rounded-lg disabled:opacity-20 text-slate-400">
                                            <ArrowDown class="w-4 h-4" />
                                        </button>
                                    </div>

                                    <div class="flex-1 space-y-6">
                                        <!-- Header: Name, Role, Rating -->
                                        <div class="flex flex-col md:flex-row gap-6">
                                            <div class="flex-1 flex items-center gap-4">
                                                <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 shrink-0 overflow-hidden border border-slate-100 group-hover:border-indigo-100 transition-colors">
                                                    <img v-if="review.avatar" :src="review.avatar" class="w-full h-full object-cover" />
                                                    <User v-else class="w-7 h-7" />
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <input v-model="review.name" type="text" placeholder="Nama Pelanggan" 
                                                        class="w-full bg-transparent border-0 border-b border-transparent focus:border-indigo-400 focus:ring-0 text-base font-black text-slate-800 p-0 placeholder:font-normal placeholder:text-slate-300 transition-all" />
                                                    <input v-model="review.role" type="text" placeholder="Status / Peran" 
                                                        class="w-full bg-transparent border-0 border-b border-transparent focus:border-indigo-400 focus:ring-0 text-[11px] font-bold text-slate-400 p-0 placeholder:font-normal placeholder:text-slate-200 mt-1 uppercase tracking-wider" />
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <div class="space-y-1">
                                                    <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest pl-1">Rating</label>
                                                    <div class="flex items-center gap-2 bg-slate-50 rounded-xl px-4 py-2 border border-slate-100 group-hover:bg-white transition-colors">
                                                        <select v-model="review.rating" class="bg-transparent border-0 p-0 text-sm font-black text-yellow-600 focus:ring-0 cursor-pointer">
                                                            <option v-for="r in 5" :key="r" :value="r">{{ r }} Bintang</option>
                                                        </select>
                                                        <Star class="w-4 h-4 text-yellow-500 fill-current" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Body: Textarea -->
                                        <div class="relative">
                                            <div class="absolute -left-3 -top-3 text-indigo-50/50 -z-10">
                                                <Quote class="w-12 h-12 fill-current" />
                                            </div>
                                            <textarea v-model="review.text" rows="3" placeholder="Tulis testimoni lengkap pelanggan di sini..."
                                                class="w-full bg-slate-50/50 border-0 focus:bg-white focus:ring-2 focus:ring-indigo-100 rounded-2xl p-5 text-sm font-medium text-slate-600 leading-relaxed placeholder:text-slate-300 transition-all resize-none italic"></textarea>
                                        </div>

                                        <!-- Footer: Label & Avatar URL -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="space-y-1.5">
                                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Info Tambahan (Label)</label>
                                                <input v-model="review.label" type="text" placeholder="Contoh: Lepas Kunci · 2 Bulan Lalu" 
                                                    class="w-full bg-slate-50 border-0 focus:ring-2 focus:ring-indigo-100 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-500 placeholder:font-normal placeholder:text-slate-300 transition-all" />
                                            </div>
                                            <div class="space-y-1.5">
                                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">URL Avatar (Opsional)</label>
                                                <input v-model="review.avatar" type="text" placeholder="https://..." 
                                                    class="w-full bg-slate-50 border-0 focus:ring-2 focus:ring-indigo-100 rounded-xl px-4 py-2.5 text-[11px] font-medium text-slate-400 truncate placeholder:text-slate-300 transition-all" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-1">
                                        <button @click="removeRow(i)" :disabled="form.reviews.length <= 1"
                                            class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-red-50 text-slate-200 hover:text-red-500 transition-all opacity-0 group-hover:opacity-100 disabled:hidden">
                                            <Trash2 class="w-5 h-5" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-if="form.reviews.length === 0" class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-[40px] py-16 px-4 text-center">
                            <Star class="w-16 h-16 text-slate-200 mx-auto mb-4" />
                            <p class="text-slate-400 font-bold">Belum ada ulasan yang ditambahkan.</p>
                        </div>
                    </div>

                    <!-- PREVIEW PANEL (RIGHT) -->
                    <div class="lg:col-span-1 sticky top-8 space-y-6">
                        <div class="bg-indigo-900 rounded-[32px] p-1 shadow-2xl shadow-indigo-200/50 overflow-hidden border border-indigo-800">
                            <div class="bg-slate-900/50 rounded-[31px] overflow-hidden">
                                <div class="px-6 py-5 flex items-center justify-between border-b border-white/5 bg-white/5">
                                    <div class="flex items-center gap-2">
                                        <div class="flex gap-1.5">
                                            <div class="w-2.5 h-2.5 rounded-full bg-rose-500"></div>
                                            <div class="w-2.5 h-2.5 rounded-full bg-amber-500"></div>
                                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                                        </div>
                                        <span class="ml-2 text-[10px] font-black text-indigo-300 uppercase tracking-widest">LIVE PREVIEW</span>
                                    </div>
                                </div>
                                
                                <div class="p-6 h-[600px] overflow-y-auto custom-scrollbar bg-slate-50/5">
                                    <div class="mb-10 text-center">
                                        <span class="inline-block bg-white/10 text-yellow-400 text-[9px] font-bold uppercase tracking-[0.2em] px-3 py-1 rounded-full mb-3">TESTIMONIALS</span>
                                        <h3 class="text-lg font-black text-white leading-tight">Apa Kata Mereka?</h3>
                                    </div>

                                    <div class="space-y-6">
                                        <div v-for="(t, idx) in duplicatedReviews" :key="'pv-'+idx"
                                            class="bg-white/10 backdrop-blur-md border border-white/10 rounded-2xl p-6 relative overflow-hidden group/item">
                                            
                                            <div class="absolute -right-2 -top-2 opacity-5 scale-150 rotate-12 transition-transform group-hover/item:scale-[1.7] duration-500">
                                                <Quote class="w-16 h-16 text-white" />
                                            </div>

                                            <div class="flex text-yellow-400 mb-4 scale-75 origin-left">
                                                <Star v-for="i in t.rating" :key="i" class="w-4 h-4 fill-current" />
                                            </div>
                                            
                                            <p class="text-indigo-100/90 text-[11px] leading-relaxed mb-5 italic font-medium relative z-10">"{{ t.text || '...' }}"</p>
                                            
                                            <div class="flex items-center gap-3 border-t border-white/5 pt-4">
                                                <div class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center text-xs font-black text-white shrink-0 overflow-hidden border border-white/10">
                                                    <img v-if="t.avatar" :src="t.avatar" class="w-full h-full object-cover" />
                                                    <span v-else>{{ t.name?.charAt(0) || '?' }}</span>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-[10px] font-black text-white truncate">{{ t.name || 'Pelanggan' }}</p>
                                                    <p class="text-[9px] text-indigo-400 font-bold truncate">{{ t.role || 'Wisatawan' }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div v-if="duplicatedReviews.length === 0" class="text-center py-20">
                                            <Star class="w-10 h-10 text-white/10 mx-auto mb-3" />
                                            <p class="text-white/20 text-xs italic font-medium">Belum ada data...</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-6 py-4 bg-indigo-950/50 border-t border-white/5 text-center">
                                    <p class="text-[9px] font-bold text-indigo-400 uppercase tracking-widest">Tampilan Landing Page</p>
                                </div>
                            </div>
                        </div>

                        <!-- TIPS -->
                        <div class="bg-white rounded-[32px] p-6 border border-slate-100 shadow-sm overflow-hidden relative">
                            <div class="absolute -right-4 -bottom-4 opacity-5">
                                <Star class="w-24 h-24 text-indigo-600 rotate-12" />
                            </div>
                            <h4 class="text-[11px] font-black text-slate-800 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <Check class="w-3.5 h-3.5 text-emerald-500" />
                                Tips Berhasil
                            </h4>
                            <div class="space-y-4">
                                <div class="flex gap-3">
                                    <div class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-500 flex items-center justify-center shrink-0">
                                        <Star class="w-3 h-3 fill-current" />
                                    </div>
                                    <p class="text-[10px] text-slate-500 font-semibold leading-relaxed">Prioritaskan ulasan dengan rating 5 bintang untuk dipasang.</p>
                                </div>
                                <div class="flex gap-3">
                                    <div class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-500 flex items-center justify-center shrink-0">
                                        <User class="w-3 h-3" />
                                    </div>
                                    <p class="text-[10px] text-slate-500 font-semibold leading-relaxed">Gunakan foto asli pelanggan (jika ada izin) untuk meningkatkan kepercayaan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.02);
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(245, 158, 11, 0.2);
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(245, 158, 11, 0.4);
}
</style>
