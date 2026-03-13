<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { 
    MessageCircleQuestion, Plus, Trash2, Save, RotateCcw, ArrowUp, ArrowDown, CheckCircle2,
    Type, AlignLeft, ChevronRight
} from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({
    faqs: { type: Array, default: () => [] },
});

const defaults = [
    { question: 'Apakah bisa sewa mobil tanpa sopir (lepas kunci)?', answer: 'Bisa, syaratnya e-KTP, KK, dan SIM A asli, serta bersedia kami survei ke tempat tinggal/hotel Anda menginap.' },
];

const form = useForm({
    faqs: props.faqs.length > 0
        ? props.faqs.map(f => ({
            question: f.question,
            answer:   f.answer,
          }))
        : defaults.map(d => ({ ...d })),
});

const addRow = () => {
    if (form.faqs.length >= 15) return;
    form.faqs.push({ question: '', answer: '' });
};

const removeRow = (i) => {
    if (form.faqs.length <= 1) return;
    form.faqs.splice(i, 1);
};

const moveUp = (i) => {
    if (i > 0) {
        const item = form.faqs[i];
        form.faqs[i] = form.faqs[i-1];
        form.faqs[i-1] = item;
    }
};

const moveDown = (i) => {
    if (i < form.faqs.length - 1) {
        const item = form.faqs[i];
        form.faqs[i] = form.faqs[i+1];
        form.faqs[i+1] = item;
    }
};

const submit = () => {
    form.put(route('faqs.update'), {
        preserveScroll: true,
        onSuccess: () => {
            // Success logic handled by flash
        }
    });
};

const doReset = () => {
    if (confirm('Reset FAQ ke data default? Semua perubahan akan hilang.')) {
        form.delete(route('faqs.reset'), {
            preserveScroll: true
        });
    }
};

// Preview State
const activeFaqPreview = ref(0);
const togglePreview = (i) => {
    activeFaqPreview.value = activeFaqPreview.value === i ? null : i;
};

</script>

<template>
    <Head title="Kelola FAQ" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 shadow-sm shadow-indigo-100">
                        <MessageCircleQuestion class="w-6 h-6" />
                    </div>
                    <div>
                        <h2 class="font-black text-xl text-slate-800 leading-tight">Pertanyaan Umum (FAQ)</h2>
                        <p class="text-xs text-slate-400 font-medium">Atur daftar tanya jawab untuk pelanggan</p>
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
                    
                    <!-- Editor Panel -->
                    <div class="lg:col-span-2 space-y-4">
                        <div class="flex items-center justify-between px-2 mb-2">
                            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Daftar FAQ (Max 15)</span>
                            <button @click="addRow" :disabled="form.faqs.length >= 15"
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 text-[11px] font-black rounded-lg transition-colors">
                                <Plus class="w-3.5 h-3.5" />
                                Tambah Item
                            </button>
                        </div>

                        <div class="space-y-4">
                            <div v-for="(faq, i) in form.faqs" :key="i" 
                                class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-all group relative overflow-hidden">
                                
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-indigo-400 opacity-0 group-hover:opacity-100 transition-opacity"></div>

                                <div class="flex items-start gap-4">
                                    <div class="flex flex-col gap-1 pt-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button @click="moveUp(i)" :disabled="i === 0" class="p-1 hover:bg-slate-50 rounded disabled:opacity-20">
                                            <ArrowUp class="w-4 h-4 text-slate-400" />
                                        </button>
                                        <button @click="moveDown(i)" :disabled="i === form.faqs.length - 1" class="p-1 hover:bg-slate-50 rounded disabled:opacity-20">
                                            <ArrowDown class="w-4 h-4 text-slate-400" />
                                        </button>
                                    </div>

                                    <div class="flex-1 space-y-4">
                                        <div class="flex items-center gap-3 group/title">
                                            <div class="w-8 h-8 rounded-xl bg-slate-50 flex items-center justify-center text-xs font-black text-slate-400 group-hover/title:bg-indigo-50 group-hover/title:text-indigo-500 transition-colors">
                                                Q
                                            </div>
                                            <div class="flex-1">
                                                <input v-model="faq.question" type="text" placeholder="Masukkan pertanyaan..." 
                                                    class="w-full bg-transparent border-0 border-b border-transparent focus:border-indigo-400 focus:ring-0 text-sm font-bold text-slate-700 placeholder:text-slate-300 placeholder:font-normal py-1 pr-10" />
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-3 group/desc">
                                            <div class="w-8 h-8 rounded-xl bg-slate-50 flex items-center justify-center text-xs font-black text-slate-400 group-hover/desc:bg-blue-50 group-hover/desc:text-blue-500 transition-colors shrink-0">
                                                A
                                            </div>
                                            <div class="flex-1">
                                                <textarea v-model="faq.answer" rows="3" placeholder="Tuliskan jawabannya..."
                                                    class="w-full bg-slate-50/50 border-0 focus:bg-white focus:ring-2 focus:ring-indigo-100 rounded-2xl p-4 text-xs font-medium text-slate-600 leading-relaxed placeholder:text-slate-300 transition-all resize-none"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-1">
                                        <button @click="removeRow(i)" :disabled="form.faqs.length <= 1"
                                            class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-red-50 text-slate-200 hover:text-red-500 transition-all opacity-0 group-hover:opacity-100 disabled:hidden">
                                            <Trash2 class="w-4.5 h-4.5" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-if="form.faqs.length === 0" class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl py-12 px-4 text-center">
                            <MessageCircleQuestion class="w-12 h-12 text-slate-300 mx-auto mb-4" />
                            <p class="text-slate-400 font-medium text-sm">Belum ada FAQ. Klik tambah untuk memulai.</p>
                        </div>
                    </div>

                    <!-- Live Preview Panel -->
                    <div class="lg:col-span-1 sticky top-8">
                        <div class="bg-indigo-900 rounded-[32px] p-1 shadow-2xl shadow-indigo-200/50 overflow-hidden">
                            <div class="bg-indigo-800/50 rounded-[31px] overflow-hidden border border-indigo-700/50">
                                <div class="px-6 py-5 flex items-center justify-between border-b border-indigo-700/30">
                                    <div class="flex items-center gap-2">
                                        <div class="flex gap-1.5">
                                            <div class="w-2.5 h-2.5 rounded-full bg-rose-500"></div>
                                            <div class="w-2.5 h-2.5 rounded-full bg-amber-500"></div>
                                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                                        </div>
                                        <span class="ml-2 text-[10px] font-black text-indigo-300 uppercase tracking-widest">FAQ PREVIEW</span>
                                    </div>
                                </div>
                                
                                <div class="p-6 h-[500px] overflow-y-auto custom-scrollbar bg-slate-50/5">
                                    <div class="mb-8 text-center px-4">
                                        <h3 class="text-lg font-black text-white mb-2">Pertanyaan Umum</h3>
                                        <p class="text-[10px] text-indigo-300/80 leading-relaxed">Hal-hal yang sering ditanyakan pelanggan kami.</p>
                                    </div>

                                    <div class="space-y-3 px-2">
                                        <div v-for="(faq, i) in form.faqs" :key="'pv-'+i"
                                            class="bg-white/5 border border-white/5 rounded-2xl overflow-hidden transition-all duration-300"
                                            :class="{'bg-white/10 border-white/10 ring-1 ring-indigo-400/30': activeFaqPreview === i}">
                                            <button @click="togglePreview(i)" class="w-full flex items-center justify-between px-5 py-4 text-left">
                                                <span class="font-bold text-white text-[11px] leading-tight pr-4">{{ faq.question || 'Petanyaan anda...' }}</span>
                                                <ChevronRight class="w-3.5 h-3.5 text-indigo-300 transition-transform duration-300" 
                                                    :class="{'rotate-90 text-indigo-400': activeFaqPreview === i}" />
                                            </button>
                                            <div v-show="activeFaqPreview === i" class="px-5 pb-5">
                                                <div class="h-px bg-white/5 mb-3"></div>
                                                <p class="text-indigo-100/70 text-[11px] leading-relaxed">{{ faq.answer || 'Tuliskan jawaban lengkap di sini agar pelanggan mudah mengerti.' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 text-center">Tips</p>
                            <div class="space-y-3">
                                <div class="flex gap-3">
                                    <div class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-500 flex items-center justify-center shrink-0">
                                        <Check class="w-3 h-3" />
                                    </div>
                                    <p class="text-[11px] text-slate-500 font-medium leading-relaxed">Gunakan pertanyaan yang paling sering ditanyakan oleh pelanggan melalui WhatsApp.</p>
                                </div>
                                <div class="flex gap-3">
                                    <div class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-500 flex items-center justify-center shrink-0">
                                        <Check class="w-3 h-3" />
                                    </div>
                                    <p class="text-[11px] text-slate-500 font-medium leading-relaxed">Jawaban yang ringkas dan padat lebih disukai oleh pengunjung website.</p>
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
    background: rgba(99, 102, 241, 0.2);
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(99, 102, 241, 0.4);
}
</style>
