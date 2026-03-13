<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { 
    Zap, Save, RotateCcw, CheckCircle2, 
    Type, AlignLeft, Send, Link as LinkIcon, ExternalLink
} from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({
    cta: { type: Object, default: () => ({}) },
});

const form = useForm({
    title: props.cta.title || 'Siap Jelajahi<br><span class="text-blue-400">Banyuwangi?</span>',
    description: props.cta.description || 'Hubungi kami sekarang dan dapatkan penawaran terbaik untuk perjalanan Anda.',
    wa_text: props.cta.wa_text || 'Chat WhatsApp',
    wa_number: props.cta.wa_number || '6282339333202',
    catalog_text: props.cta.catalog_text || 'Katalog Armada',
    catalog_link: props.cta.catalog_link || '#armada',
});

const submit = () => {
    form.put(route('cta.update'), {
        preserveScroll: true,
    });
};

const doReset = () => {
    if (confirm('Reset seksi CTA ke data default?')) {
        form.delete(route('cta.reset'), {
            preserveScroll: true,
            onSuccess: () => {
                // Values are updated from props automatically
            }
        });
    }
};

</script>

<template>
    <Head title="Kelola CTA" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 shadow-sm shadow-indigo-100">
                        <Zap class="w-6 h-6 fill-current" />
                    </div>
                    <div>
                        <h2 class="font-black text-xl text-slate-800 leading-tight">CTA Section</h2>
                        <p class="text-xs text-slate-400 font-medium">Kelola ajakan bertindak di bagian bawah landing page</p>
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
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-[40px] border border-slate-100 p-10 shadow-sm">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-8 flex items-center gap-2">
                                <AlignLeft class="w-4 h-4" />
                                Konten CTA
                            </h3>

                            <div class="space-y-8">
                                <!-- Title -->
                                <div class="space-y-2">
                                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Judul Utama (Mendukung HTML)</label>
                                    <div class="relative">
                                        <div class="absolute left-4 top-4 text-slate-300">
                                            <Type class="w-5 h-5" />
                                        </div>
                                        <textarea v-model="form.title" rows="2"
                                            class="w-full bg-slate-50 border-0 focus:ring-2 focus:ring-indigo-100 rounded-3xl pl-12 pr-6 py-4 text-base font-black text-slate-800 placeholder:font-normal placeholder:text-slate-300 transition-all resize-none"></textarea>
                                    </div>
                                    <p class="text-[10px] text-slate-400 font-medium pl-1">Gunakan <code>&lt;br&gt;</code> untuk baris baru, dan <code>&lt;span class="text-blue-400"&gt;...&lt;/span&gt;</code> untuk teks biru.</p>
                                </div>

                                <!-- Description -->
                                <div class="space-y-2">
                                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Subjudul / Deskripsi</label>
                                    <textarea v-model="form.description" rows="3"
                                        class="w-full bg-slate-50 border-0 focus:ring-2 focus:ring-indigo-100 rounded-3xl px-6 py-4 text-sm font-medium text-slate-600 leading-relaxed placeholder:text-slate-300 transition-all resize-none"></textarea>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                                    <!-- WhatsApp Button -->
                                    <div class="space-y-5 p-6 bg-slate-50/50 rounded-[32px] border border-slate-50">
                                        <h4 class="text-[10px] font-black text-emerald-500 uppercase tracking-widest flex items-center gap-2">
                                            <Send class="w-3.5 h-3.5" />
                                            Tombol Utama (WhatsApp)
                                        </h4>
                                        <div class="space-y-4">
                                            <div class="space-y-2">
                                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Teks Tombol</label>
                                                <input v-model="form.wa_text" type="text" 
                                                    class="w-full bg-white border border-slate-100 focus:ring-2 focus:ring-emerald-100 rounded-2xl px-4 py-3 text-sm font-bold text-slate-700 transition-all" />
                                            </div>
                                            <div class="space-y-2">
                                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nomor WhatsApp</label>
                                                <div class="relative">
                                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-sm font-bold">+</span>
                                                    <input v-model="form.wa_number" type="text" placeholder="628..."
                                                        class="w-full bg-white border border-slate-100 focus:ring-2 focus:ring-emerald-100 rounded-2xl pl-8 pr-4 py-3 text-sm font-bold text-slate-700 transition-all" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Catalog Button -->
                                    <div class="space-y-5 p-6 bg-slate-50/50 rounded-[32px] border border-slate-50">
                                        <h4 class="text-[10px] font-black text-indigo-500 uppercase tracking-widest flex items-center gap-2">
                                            <LinkIcon class="w-3.5 h-3.5" />
                                            Tombol Kedua (Katalog)
                                        </h4>
                                        <div class="space-y-4">
                                            <div class="space-y-2">
                                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Teks Tombol</label>
                                                <input v-model="form.catalog_text" type="text"
                                                    class="w-full bg-white border border-slate-100 focus:ring-2 focus:ring-indigo-100 rounded-2xl px-4 py-3 text-sm font-bold text-slate-700 transition-all" />
                                            </div>
                                            <div class="space-y-2">
                                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Link Tujuan</label>
                                                <input v-model="form.catalog_link" type="text"
                                                    class="w-full bg-white border border-slate-100 focus:ring-2 focus:ring-indigo-100 rounded-2xl px-4 py-3 text-sm font-bold text-slate-700 transition-all" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PREVIEW PANEL (RIGHT) -->
                    <div class="lg:col-span-1 sticky top-8 space-y-6">
                        <div class="bg-indigo-900 rounded-[40px] p-2 shadow-2xl shadow-indigo-200/50 overflow-hidden border border-indigo-800">
                            <div class="bg-slate-900 rounded-[38px] p-8 relative overflow-hidden text-center">
                                <!-- Background Accents -->
                                <div class="absolute top-0 right-0 w-40 h-40 bg-blue-500/20 rounded-full blur-[40px]"></div>
                                <div class="absolute bottom-0 left-0 w-32 h-32 bg-emerald-500/20 rounded-full blur-[30px]"></div>

                                <div class="relative z-10 flex flex-col items-center">
                                    <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center mb-6">
                                        <div class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></div>
                                    </div>

                                    <h2 class="text-xl md:text-2xl font-black text-white mb-4 leading-tight" v-html="form.title"></h2>
                                    <p class="text-slate-400 text-xs mb-8 font-medium px-4 leading-relaxed">{{ form.description }}</p>

                                    <div class="flex flex-col gap-3 w-full">
                                        <div class="bg-emerald-500 text-white px-6 py-3 rounded-xl font-black text-xs shadow-lg shadow-emerald-900/40">
                                            {{ form.wa_text }}
                                        </div>
                                        <div class="bg-white/10 border border-white/20 text-white px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-wider">
                                            {{ form.catalog_text }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- INFO -->
                        <div class="bg-white rounded-[32px] p-6 border border-slate-100 shadow-sm">
                            <h4 class="text-[10px] font-black text-slate-800 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <ExternalLink class="w-3.5 h-3.5 text-indigo-500" />
                                Informasi Tampilan
                            </h4>
                            <p class="text-[11px] text-slate-500 font-medium leading-relaxed">
                                Bagian ini adalah titik terakhir sebelum pengunjung meninggalkan website. Gunakan kalimat yang penuh semangat dan tombol yang jelas untuk meningkatkan konversi sewa armada Anda.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
