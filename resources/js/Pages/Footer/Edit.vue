<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { 
    LayoutTemplate, Save, RotateCcw, CheckCircle2, 
    Type, Phone, MapPin, List, Plus, Trash2, Link as LinkIcon,
    Check, ChevronRight, CarFront
} from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({
    footer: { type: Object, default: () => ({}) },
});

const form = useForm({
    brand_description: props.footer.brand_description || '',
    phone: props.footer.phone || '',
    services: props.footer.services || [],
    maps_link: props.footer.maps_link || '',
    copyright_text: props.footer.copyright_text || '',
    footer_nav: props.footer.footer_nav || [],
});

const addService = () => {
    form.services.push('');
};

const removeService = (index) => {
    form.services.splice(index, 1);
};

const addNavLink = () => {
    form.footer_nav.push({ label: '', href: '' });
};

const removeNavLink = (index) => {
    form.footer_nav.splice(index, 1);
};

const submit = () => {
    form.put(route('footer.update'), {
        preserveScroll: true,
    });
};

const doReset = () => {
    if (confirm('Reset seksi Footer ke data default?')) {
        form.delete(route('footer.reset'), {
            preserveScroll: true,
        });
    }
};

</script>

<template>
    <Head title="Kelola Footer" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-600 shadow-sm shadow-slate-100">
                        <LayoutTemplate class="w-6 h-6" />
                    </div>
                    <div>
                        <h2 class="font-black text-xl text-slate-800 leading-tight">Footer Section</h2>
                        <p class="text-xs text-slate-400 font-medium">Kelola informasi brand, layanan, dan navigasi bawah</p>
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
                    <div class="lg:col-span-2 space-y-8">
                        
                        <!-- Brand & Phone -->
                        <div class="bg-white rounded-[40px] border border-slate-100 p-8 shadow-sm">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                                <CarFront class="w-4 h-4" />
                                Informasi Brand
                            </h3>
                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Deskripsi Singkat</label>
                                    <textarea v-model="form.brand_description" rows="3"
                                        class="w-full bg-slate-50 border-0 focus:ring-2 focus:ring-indigo-100 rounded-3xl px-6 py-4 text-sm font-medium text-slate-600 leading-relaxed transition-all resize-none"></textarea>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Nomor Telepon / WA Utama</label>
                                    <div class="relative">
                                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300">
                                            <Phone class="w-4 h-4" />
                                        </div>
                                        <input v-model="form.phone" type="text"
                                            class="w-full bg-slate-50 border-0 focus:ring-2 focus:ring-indigo-100 rounded-2xl pl-12 pr-6 py-3.5 text-sm font-bold text-slate-700 transition-all" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Services List -->
                        <div class="bg-white rounded-[40px] border border-slate-100 p-8 shadow-sm">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <List class="w-4 h-4" />
                                    Layanan Utama
                                </h3>
                                <button @click="addService" class="text-indigo-600 text-[11px] font-black flex items-center gap-1 hover:underline">
                                    <Plus class="w-3 h-3" /> Tambah Layanan
                                </button>
                            </div>
                            <div class="space-y-3">
                                <div v-for="(svc, i) in form.services" :key="i" class="flex items-center gap-3 group">
                                    <div class="flex-1 relative">
                                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-hover:text-blue-500 transition-colors">
                                            <Check class="w-4 h-4" />
                                        </div>
                                        <input v-model="form.services[i]" type="text"
                                            class="w-full bg-slate-50 border-0 focus:ring-2 focus:ring-indigo-100 rounded-xl pl-12 pr-4 py-3 text-sm font-bold text-slate-600 transition-all" />
                                    </div>
                                    <button @click="removeService(i)" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-red-50 text-slate-200 hover:text-red-500 transition-all">
                                        <Trash2 class="w-4 h-4" />
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Map Link -->
                        <div class="bg-white rounded-[40px] border border-slate-100 p-8 shadow-sm">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                                <MapPin class="w-4 h-4" />
                                Lokasi Google Maps (Embed URL)
                            </h3>
                            <div class="space-y-4">
                                <textarea v-model="form.maps_link" rows="2"
                                    class="w-full bg-slate-50 border-0 focus:ring-2 focus:ring-indigo-100 rounded-2xl px-6 py-4 text-xs font-mono text-slate-500 transition-all resize-none"></textarea>
                                <p class="text-[10px] text-slate-400 italic">Pastikan mengambil URL dari <code>src="..."</code> pada menu 'Share' -> 'Embed a map' di Google Maps.</p>
                            </div>
                        </div>

                        <!-- Footer Nav & Copyright -->
                        <div class="bg-white rounded-[40px] border border-slate-100 p-8 shadow-sm">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                <div class="space-y-6">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                            <LinkIcon class="w-4 h-4" />
                                            Navigasi
                                        </h3>
                                        <button @click="addNavLink" class="text-indigo-600 text-[11px] font-black flex items-center gap-1 hover:underline">
                                            <Plus class="w-3 h-3" /> Tambah
                                        </button>
                                    </div>
                                    <div class="space-y-4">
                                        <div v-for="(nav, i) in form.footer_nav" :key="i" class="space-y-2 p-4 bg-slate-50 rounded-2xl relative group">
                                            <button @click="removeNavLink(i)" class="absolute right-2 top-2 w-7 h-7 flex items-center justify-center rounded-lg hover:bg-red-50 text-slate-300 hover:text-red-500 transition-all">
                                                <Trash2 class="w-3.5 h-3.5" />
                                            </button>
                                            <input v-model="nav.label" type="text" placeholder="Label" class="w-full bg-white border border-slate-100 rounded-lg px-3 py-2 text-xs font-bold" />
                                            <input v-model="nav.href" type="text" placeholder="Link (e.g. #armada)" class="w-full bg-white border border-slate-100 rounded-lg px-3 py-2 text-[11px] font-medium text-slate-400" />
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-6">
                                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                        <Type class="w-4 h-4" />
                                        Copyright
                                    </h3>
                                    <div class="space-y-4">
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Teks Copyright</label>
                                            <input v-model="form.copyright_text" type="text"
                                                class="w-full bg-slate-50 border-0 focus:ring-2 focus:ring-indigo-100 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 transition-all" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1 sticky top-8 space-y-6">
                        <div class="bg-indigo-950 rounded-[40px] p-1 shadow-2xl shadow-indigo-200/50 overflow-hidden border border-indigo-900/50">
                            <!-- Mac-style Header -->
                            <div class="px-5 py-3.5 border-b border-indigo-900 flex items-center gap-2 bg-indigo-950">
                                <div class="flex gap-1.5">
                                    <div class="w-2.5 h-2.5 rounded-full bg-red-400/80"></div>
                                    <div class="w-2.5 h-2.5 rounded-full bg-yellow-400/80"></div>
                                    <div class="w-2.5 h-2.5 rounded-full bg-green-400/80"></div>
                                </div>
                                <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest ml-1">Live Preview</span>
                            </div>

                            <div class="bg-slate-950 rounded-b-[39px] rounded-t-none p-8 max-h-[700px] overflow-y-auto custom-scrollbar">

                                <!-- Brand -->
                                <div class="mb-10">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-900/50">
                                            <CarFront class="w-4 h-4 text-white" />
                                        </div>
                                        <span class="text-base font-black text-white tracking-tight">Rental<span class="text-blue-500">Banyuwangi</span></span>
                                    </div>
                                    <p class="text-slate-400 text-[11px] leading-relaxed mb-6">{{ form.brand_description }}</p>
                                    <div class="flex items-center gap-2 text-slate-300 text-[10px] font-medium bg-white/5 w-fit px-3 py-2 rounded-lg border border-white/5">
                                        <Phone class="w-3 h-3 text-emerald-400" />
                                        <span>{{ form.phone }}</span>
                                    </div>
                                </div>

                                <!-- Services -->
                                <div class="mb-10">
                                    <h5 class="text-white font-bold text-xs tracking-widest mb-4 border-b border-white/10 pb-2 inline-block">LAYANAN</h5>
                                    <ul class="space-y-2.5">
                                        <li v-for="svc in form.services" :key="svc" class="text-slate-400 text-[10px] font-medium flex items-center gap-2">
                                            <Check class="w-3 h-3 text-blue-500" />
                                            {{ svc }}
                                        </li>
                                    </ul>
                                </div>

                                <!-- Nav links as small tags -->
                                <div class="mb-10">
                                    <h5 class="text-white font-bold text-xs tracking-widest mb-4 border-b border-white/10 pb-2 inline-block">NAVIGASI</h5>
                                    <div class="flex flex-wrap gap-2">
                                        <span v-for="nav in form.footer_nav" :key="nav.label" class="text-slate-500 text-[9px] font-bold uppercase tracking-wider px-2 py-1 bg-white/5 rounded">
                                            {{ nav.label }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Map Preview -->
                                <div class="rounded-xl overflow-hidden h-28 border border-white/10 mb-6 flex items-center justify-center bg-slate-900">
                                    <MapPin v-if="!form.maps_link" class="w-8 h-8 text-white/5" />
                                    <iframe v-else :src="form.maps_link" width="100%" height="100%" class="grayscale opacity-50 pointer-events-none"></iframe>
                                </div>

                                <!-- Copyright -->
                                <div class="pt-6 border-t border-white/5 text-center">
                                    <p class="text-slate-600 text-[9px] font-medium">{{ form.copyright_text }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- TIPS -->
                        <div class="bg-white rounded-[32px] p-6 border border-slate-100 shadow-sm overflow-hidden relative">
                            <div class="absolute -right-4 -bottom-4 opacity-5">
                                <LayoutTemplate class="w-24 h-24 text-indigo-600" />
                            </div>
                            <h4 class="text-[11px] font-black text-slate-800 uppercase tracking-widest mb-4">Tips Optimasi</h4>
                            <p class="text-[10px] text-slate-500 font-semibold leading-relaxed">
                                Pastikan nomor telepon yang dicantumkan sama dengan nomor WhatsApp agar memudahkan pelanggan menghubungi Anda dari berbagai sisi website.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    width: 3px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}
</style>
