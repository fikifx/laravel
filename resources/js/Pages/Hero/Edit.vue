<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, Save, RotateCcw, LayoutTemplate, Type, MessageSquare, Link2, Phone, CheckCircle2, AlertCircle } from 'lucide-vue-next';

const props = defineProps({
    hero: {
        type: Object,
        default: null,
    },
});

// Default values shown as placeholder when DB is empty
const defaults = {
    badge_text:         'Rating 4.8/5 · 2000+ Pelanggan Puas',
    headline:           'Sewa Mobil',
    headline_highlight: 'Banyuwangi',
    headline_suffix:    'Murah',
    subheadline:        'Lepas Kunci & Dengan Sopir',
    description:        'Armada terbaru Avanza, Innova, Hiace, Fortuner, Alphard siap mengantar perjalanan Anda. Harga transparan, respon cepat, sopir berpengalaman.',
    cta_primary_text:   'Lihat Semua Armada',
    cta_primary_url:    '#armada',
    cta_secondary_text: 'Konsultasi Gratis',
    whatsapp_number:    '6282339333202',
};

const form = useForm({
    badge_text:         props.hero?.badge_text         ?? '',
    headline:           props.hero?.headline           ?? '',
    headline_highlight: props.hero?.headline_highlight ?? '',
    headline_suffix:    props.hero?.headline_suffix    ?? '',
    subheadline:        props.hero?.subheadline        ?? '',
    description:        props.hero?.description        ?? '',
    cta_primary_text:   props.hero?.cta_primary_text   ?? '',
    cta_primary_url:    props.hero?.cta_primary_url    ?? '',
    cta_secondary_text: props.hero?.cta_secondary_text ?? '',
    whatsapp_number:    props.hero?.whatsapp_number    ?? '',
});

const submit = () => form.put(route('hero.update'));
const doReset = () => {
    if (confirm('Reset semua setting Hero ke default? Data yang ada akan dihapus.')) {
        form.delete(route('hero.reset'));
    }
};

// Live preview values (uses form value or default)
const preview = (field) => form[field] || defaults[field];
</script>

<template>
    <Head title="Kelola Hero Section" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 bg-purple-100 rounded-lg flex items-center justify-center">
                        <LayoutTemplate class="w-4 h-4 text-purple-600" />
                    </div>
                    <div>
                        <h2 class="font-black text-lg text-slate-800 leading-none">Hero Section</h2>
                        <p class="text-xs text-slate-400 font-medium">Bagian utama landing page</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" @click="doReset"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-xl border border-red-200 text-red-500 hover:bg-red-50 text-xs font-bold transition-all">
                        <RotateCcw class="w-3.5 h-3.5" />
                        Reset Default
                    </button>
                    <button @click="submit" :disabled="form.processing"
                        class="flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-black rounded-xl shadow-lg shadow-blue-200 transition-all active:scale-95 disabled:opacity-60">
                        <Save class="w-3.5 h-3.5" />
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </template>

        <div class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Flash Messages -->
                <div v-if="$page.props.flash?.message"
                    class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 text-emerald-600">
                    <CheckCircle2 class="w-5 h-5 shrink-0" />
                    <span class="text-sm font-bold">{{ $page.props.flash.message }}</span>
                </div>

                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 xl:grid-cols-5 gap-8">

                        <!-- ===== FORM PANEL ===== -->
                        <div class="xl:col-span-3 space-y-6">

                            <!-- Badge / Subtext -->
                            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                                <div class="flex items-center gap-2 mb-5">
                                    <MessageSquare class="w-4 h-4 text-yellow-500" />
                                    <h3 class="font-black text-slate-800">Badge / Rating Text</h3>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Teks Badge (di atas headline)</label>
                                    <input v-model="form.badge_text" type="text"
                                        :placeholder="defaults.badge_text"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none text-sm font-medium text-slate-800 transition-all" />
                                    <p class="text-xs text-slate-400 mt-1.5">Contoh: "Rating 4.8/5 · 2000+ Pelanggan Puas"</p>
                                    <p v-if="form.errors.badge_text" class="text-red-500 text-xs mt-1">{{ form.errors.badge_text }}</p>
                                </div>
                            </div>

                            <!-- Headline -->
                            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                                <div class="flex items-center gap-2 mb-5">
                                    <Type class="w-4 h-4 text-blue-500" />
                                    <h3 class="font-black text-slate-800">Headline Utama</h3>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Teks Awal</label>
                                        <input v-model="form.headline" type="text"
                                            :placeholder="defaults.headline"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none text-sm font-medium text-slate-800 transition-all" />
                                        <p class="text-xs text-slate-400 mt-1">Contoh: "Sewa Mobil"</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Teks Highlight <span class="text-blue-500">(Biru)</span></label>
                                        <input v-model="form.headline_highlight" type="text"
                                            :placeholder="defaults.headline_highlight"
                                            class="w-full px-4 py-3 rounded-xl border border-blue-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none text-sm font-medium text-blue-600 transition-all" />
                                        <p class="text-xs text-slate-400 mt-1">Contoh: "Banyuwangi"</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Teks Akhir</label>
                                        <input v-model="form.headline_suffix" type="text"
                                            :placeholder="defaults.headline_suffix"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none text-sm font-medium text-slate-800 transition-all" />
                                        <p class="text-xs text-slate-400 mt-1">Contoh: "Murah"</p>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Sub-Headline (baris ke-2, lebih kecil)</label>
                                    <input v-model="form.subheadline" type="text"
                                        :placeholder="defaults.subheadline"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none text-sm font-medium text-slate-800 transition-all" />
                                    <p class="text-xs text-slate-400 mt-1">Contoh: "Lepas Kunci &amp; Dengan Sopir"</p>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                                <div class="flex items-center gap-2 mb-5">
                                    <MessageSquare class="w-4 h-4 text-slate-400" />
                                    <h3 class="font-black text-slate-800">Deskripsi / Paragraf</h3>
                                </div>
                                <textarea v-model="form.description" rows="3"
                                    :placeholder="defaults.description"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none text-sm font-medium text-slate-800 transition-all resize-none"></textarea>
                                <p v-if="form.errors.description" class="text-red-500 text-xs mt-1">{{ form.errors.description }}</p>
                            </div>

                            <!-- CTA Buttons -->
                            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                                <div class="flex items-center gap-2 mb-5">
                                    <Link2 class="w-4 h-4 text-emerald-500" />
                                    <h3 class="font-black text-slate-800">Tombol CTA</h3>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div class="space-y-4">
                                        <p class="text-xs font-black text-slate-600 uppercase tracking-wider">Tombol Utama (Biru)</p>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 mb-2">Teks Tombol</label>
                                            <input v-model="form.cta_primary_text" type="text" :placeholder="defaults.cta_primary_text"
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none text-sm font-medium text-slate-800 transition-all" />
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 mb-2">URL / Anchor Link</label>
                                            <input v-model="form.cta_primary_url" type="text" :placeholder="defaults.cta_primary_url"
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none text-sm font-medium text-slate-800 transition-all" />
                                            <p class="text-xs text-slate-400 mt-1">Contoh: "#armada" atau "https://..."</p>
                                        </div>
                                    </div>
                                    <div class="space-y-4">
                                        <p class="text-xs font-black text-slate-600 uppercase tracking-wider">Tombol Sekunder (WhatsApp)</p>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 mb-2">Teks Tombol</label>
                                            <input v-model="form.cta_secondary_text" type="text" :placeholder="defaults.cta_secondary_text"
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none text-sm font-medium text-slate-800 transition-all" />
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 mb-2">
                                                <Phone class="w-3 h-3 inline mr-1" />Nomor WhatsApp
                                            </label>
                                            <div class="flex items-center">
                                                <span class="px-3 py-3 bg-slate-50 border border-r-0 border-slate-200 rounded-l-xl text-xs font-bold text-slate-500">wa.me/</span>
                                                <input v-model="form.whatsapp_number" type="text" :placeholder="defaults.whatsapp_number"
                                                    class="flex-1 px-4 py-3 rounded-r-xl border border-slate-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none text-sm font-medium text-slate-800 transition-all" />
                                            </div>
                                            <p class="text-xs text-slate-400 mt-1">Format: 628xxx (tanpa tanda +)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ===== LIVE PREVIEW PANEL ===== -->
                        <div class="xl:col-span-2">
                            <div class="sticky top-24">
                                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                                    <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-2">
                                        <div class="flex gap-1.5">
                                            <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                            <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                            <div class="w-3 h-3 rounded-full bg-green-400"></div>
                                        </div>
                                        <span class="text-xs font-bold text-slate-400 ml-2">Live Preview</span>
                                    </div>

                                    <!-- Mini Hero Preview -->
                                    <div class="bg-gradient-to-b from-slate-50 to-white p-8 text-center min-h-[380px] flex flex-col items-center justify-center relative overflow-hidden">
                                        <div class="absolute top-0 right-0 w-40 h-40 bg-blue-100 rounded-full blur-3xl opacity-60 -translate-y-1/2 translate-x-1/2"></div>
                                        <div class="absolute bottom-0 left-0 w-32 h-32 bg-emerald-100 rounded-full blur-2xl opacity-50 translate-y-1/3 -translate-x-1/3"></div>

                                        <div class="relative z-10 w-full">
                                            <!-- Badge -->
                                            <div class="inline-flex items-center gap-1.5 bg-white border border-slate-200 shadow-sm rounded-full px-3 py-1 mb-4">
                                                <span class="text-yellow-400 text-xs">★★★★★</span>
                                                <span class="text-[10px] font-bold text-slate-600">{{ preview('badge_text') }}</span>
                                            </div>

                                            <!-- Headline -->
                                            <h1 class="text-lg font-black text-slate-900 leading-tight mb-2">
                                                {{ preview('headline') }}<br>
                                                <span class="text-blue-600">{{ preview('headline_highlight') }}</span> {{ preview('headline_suffix') }}<br>
                                                <span class="text-xs font-bold text-slate-500">{{ preview('subheadline') }}</span>
                                            </h1>

                                            <!-- Description -->
                                            <p class="text-[10px] text-slate-500 mb-4 max-w-[260px] mx-auto leading-relaxed">{{ preview('description') }}</p>

                                            <!-- CTAs -->
                                            <div class="flex flex-col gap-2 items-center">
                                                <div class="px-5 py-2 bg-blue-600 text-white text-[10px] font-black rounded-xl">
                                                    {{ preview('cta_primary_text') }}
                                                </div>
                                                <div class="px-5 py-2 bg-white border-2 border-slate-200 text-slate-700 text-[10px] font-bold rounded-xl">
                                                    📱 {{ preview('cta_secondary_text') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Info Box -->
                                <div class="mt-4 bg-blue-50 border border-blue-100 rounded-2xl p-4 flex gap-3">
                                    <AlertCircle class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" />
                                    <p class="text-xs text-slate-600 leading-relaxed">Jika field dikosongkan, landing page akan menggunakan <strong>data default</strong> secara otomatis.</p>
                                </div>

                                <!-- Save Button (sticky) -->
                                <button @click="submit" :disabled="form.processing"
                                    class="mt-4 w-full flex items-center justify-center gap-2 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-lg shadow-blue-200 transition-all active:scale-95 disabled:opacity-60">
                                    <Save class="w-4 h-4" />
                                    {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
