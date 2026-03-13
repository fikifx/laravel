<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { 
    Star, Plus, Trash2, Save, RotateCcw, ArrowUp, ArrowDown, CheckCircle2,
    Type, AlignLeft, Palette, Image as ImageIcon,
    // Available Lucide Icons
    Trophy, Users2, Sparkles, Zap, ShieldCheck, Heart, Car, Map, Clock, CheckCircle
} from 'lucide-vue-next';

const props = defineProps({
    features: { type: Array, default: () => [] },
});

const defaults = [
    { title: 'Armada Terawat', description: 'Semua unit kami keluaran terbaru dengan perawatan rutin di bengkel resmi.', icon: 'Trophy', color_theme: 'blue' },
    { title: 'Sopir Berpengalaman', description: 'Driver ramah, profesional, dan hafal rute wisata Banyuwangi.', icon: 'Users2', color_theme: 'emerald' },
    { title: 'Harga Transparan', description: 'Harga yang kami kutip adalah harga final. Tanpa biaya tersembunyi.', icon: 'Sparkles', color_theme: 'amber' },
    { title: 'Respon 24/7', description: 'Admin siap membantu Anda kapan saja melalui WhatsApp.', icon: 'Zap', color_theme: 'purple' },
];

const form = useForm({
    features: props.features.length > 0
        ? props.features.map(f => ({
            title:       f.title,
            description: f.description,
            icon:        f.icon,
            color_theme: f.color_theme,
          }))
        : defaults.map(d => ({ ...d })),
});

const addRow = () => {
    if (form.features.length >= 6) return;
    form.features.push({ title: '', description: '', icon: 'CheckCircle', color_theme: 'blue' });
};
const removeRow = (i) => {
    if (form.features.length <= 1) return;
    form.features.splice(i, 1);
};
const moveUp   = (i) => { if (i > 0) { const t = form.features[i]; form.features[i] = form.features[i-1]; form.features[i-1] = t; } };
const moveDown = (i) => { if (i < form.features.length - 1) { const t = form.features[i]; form.features[i] = form.features[i+1]; form.features[i+1] = t; } };

const submit = () => form.put(route('features.update'));
const doReset = () => {
    if (confirm('Reset Keunggulan ke data default? Semua perubahan akan hilang.')) {
        form.delete(route('features.reset'));
    }
};

const iconOptions = [
    { name: 'Trophy', component: Trophy, label: 'Piala (Kualitas)' },
    { name: 'Users2', component: Users2, label: 'Orang (Sopir/Pelanggan)' },
    { name: 'Sparkles', component: Sparkles, label: 'Bintang (Bersih/Premium)' },
    { name: 'Zap', component: Zap, label: 'Petir (Cepat/Responsif)' },
    { name: 'ShieldCheck', component: ShieldCheck, label: 'Perisai (Aman)' },
    { name: 'Heart', component: Heart, label: 'Hati (Pelayanan)' },
    { name: 'Car', component: Car, label: 'Mobil (Armada)' },
    { name: 'Map', component: Map, label: 'Peta (Rute/Wisata)' },
    { name: 'Clock', component: Clock, label: 'Jam (Tepat Waktu)' },
    { name: 'CheckCircle', component: CheckCircle, label: 'Ceklis (Pasti)' },
];

const getIconComponent = (name) => {
    const found = iconOptions.find(o => o.name === name);
    return found ? found.component : CheckCircle;
};

const colorOptions = [
    { value: 'blue', label: 'Biru (Trust)', class: 'bg-blue-500', grad: 'from-blue-500 to-blue-600' },
    { value: 'emerald', label: 'Hijau (Safe)', class: 'bg-emerald-500', grad: 'from-emerald-500 to-emerald-600' },
    { value: 'amber', label: 'Kuning (Value)', class: 'bg-amber-500', grad: 'from-amber-500 to-orange-500' },
    { value: 'purple', label: 'Ungu (Premium)', class: 'bg-purple-500', grad: 'from-purple-500 to-purple-600' },
    { value: 'rose', label: 'Merah (Passion)', class: 'bg-rose-500', grad: 'from-rose-500 to-rose-600' },
    { value: 'slate', label: 'Abu-abu (Solid)', class: 'bg-slate-500', grad: 'from-slate-500 to-slate-600' },
];

const getColorGradient = (val) => {
    const found = colorOptions.find(c => c.value === val);
    return found ? found.grad : 'from-blue-500 to-blue-600';
};
</script>

<template>
    <Head title="Kelola Keunggulan Section" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 bg-amber-100 rounded-lg flex items-center justify-center">
                        <Star class="w-4 h-4 text-amber-600" />
                    </div>
                    <div>
                        <h2 class="font-black text-lg text-slate-800 leading-none">Keunggulan Section</h2>
                        <p class="text-xs text-slate-400 font-medium">Alasan mengapa memilih layanan ini</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" @click="doReset"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-xl border border-red-200 text-red-500 hover:bg-red-50 text-xs font-bold transition-all">
                        <RotateCcw class="w-3.5 h-3.5" />
                        Reset
                    </button>
                    <button @click="submit" :disabled="form.processing"
                        class="flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-black rounded-xl shadow-lg shadow-blue-200 transition-all active:scale-95 disabled:opacity-60">
                        <Save class="w-3.5 h-3.5" />
                        Simpan
                    </button>
                </div>
            </div>
        </template>

        <div class="py-10">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Flash message -->
                <div v-if="$page.props.flash?.message"
                    class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 text-emerald-600">
                    <CheckCircle2 class="w-5 h-5 shrink-0" />
                    <span class="text-sm font-bold">{{ $page.props.flash.message }}</span>
                </div>

                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        <!-- ===== ROWS ===== -->
                        <div class="lg:col-span-2 space-y-4">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-black text-slate-700">{{ form.features.length }} item keunggulan</p>
                                <button type="button" @click="addRow" :disabled="form.features.length >= 6"
                                    class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-bold rounded-xl transition-all disabled:opacity-40">
                                    <Plus class="w-3.5 h-3.5" />
                                    Tambah Item
                                </button>
                            </div>

                            <div v-for="(feature, i) in form.features" :key="i"
                                class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 transition-all hover:shadow-md">
                                <div class="flex items-center gap-3 mb-4 border-b border-slate-100 pb-4">
                                    <!-- Sort Buttons -->
                                    <div class="flex flex-col gap-1 shrink-0">
                                        <button type="button" @click="moveUp(i)" :disabled="i === 0"
                                            class="w-6 h-6 flex items-center justify-center rounded-lg bg-slate-50 hover:bg-slate-100 disabled:opacity-30 transition-colors">
                                            <ArrowUp class="w-3 h-3 text-slate-400" />
                                        </button>
                                        <button type="button" @click="moveDown(i)" :disabled="i === form.features.length - 1"
                                            class="w-6 h-6 flex items-center justify-center rounded-lg bg-slate-50 hover:bg-slate-100 disabled:opacity-30 transition-colors">
                                            <ArrowDown class="w-3 h-3 text-slate-400" />
                                        </button>
                                    </div>

                                    <!-- Position badge -->
                                    <div class="w-8 h-8 bg-amber-100 rounded-xl flex items-center justify-center text-xs font-black text-amber-600 shrink-0">
                                        {{ i + 1 }}
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-black text-slate-700">Keunggulan #{{ i + 1 }}</p>
                                    </div>

                                    <!-- Delete -->
                                    <button type="button" @click="removeRow(i)" :disabled="form.features.length <= 1"
                                        class="w-8 h-8 flex items-center justify-center rounded-xl hover:bg-red-50 text-red-400 hover:text-red-500 transition-colors disabled:opacity-30 shrink-0">
                                        <Trash2 class="w-4 h-4" />
                                    </button>
                                </div>

                                <!-- Fields -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- Title -->
                                    <div class="sm:col-span-2">
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                                            <Type class="w-3 h-3 inline mr-1" />Judul
                                        </label>
                                        <input v-model="feature.title" type="text" placeholder="Contoh: Armada Terawat" required
                                            class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none text-sm font-bold text-slate-800 transition-all" />
                                    </div>

                                    <!-- Description -->
                                    <div class="sm:col-span-2">
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                                            <AlignLeft class="w-3 h-3 inline mr-1" />Deskripsi Singkat
                                        </label>
                                        <textarea v-model="feature.description" rows="2" placeholder="Penjelasan singkat..." required
                                            class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none text-xs font-medium text-slate-600 transition-all resize-none"></textarea>
                                    </div>

                                    <!-- Icon -->
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                                            <ImageIcon class="w-3 h-3 inline mr-1" />Ikon
                                        </label>
                                        <select v-model="feature.icon"
                                            class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none text-sm font-medium text-slate-800 transition-all">
                                            <option v-for="opt in iconOptions" :key="opt.name" :value="opt.name">
                                                {{ opt.label }}
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Color -->
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                                            <Palette class="w-3 h-3 inline mr-1" />Warna Tema
                                        </label>
                                        <select v-model="feature.color_theme"
                                            class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none text-sm font-medium text-slate-800 transition-all">
                                            <option v-for="color in colorOptions" :key="color.value" :value="color.value">
                                                {{ color.label }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ===== LIVE PREVIEW ===== -->
                        <div class="lg:col-span-1">
                            <div class="sticky top-20">
                                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                                    <div class="px-5 py-3.5 border-b border-slate-100 flex items-center gap-2">
                                        <div class="flex gap-1.5">
                                            <div class="w-2.5 h-2.5 rounded-full bg-red-400"></div>
                                            <div class="w-2.5 h-2.5 rounded-full bg-yellow-400"></div>
                                            <div class="w-2.5 h-2.5 rounded-full bg-green-400"></div>
                                        </div>
                                        <span class="text-xs font-bold text-slate-400 ml-1">Live Preview</span>
                                    </div>
                                    
                                    <!-- Mini Preview -->
                                    <div class="bg-white p-5 space-y-3 h-[400px] overflow-y-auto custom-scrollbar">
                                        <div v-for="(feature, i) in form.features" :key="i"
                                            class="flex gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                            <div :class="`w-8 h-8 rounded-lg bg-gradient-to-br ${getColorGradient(feature.color_theme)} flex items-center justify-center shrink-0`">
                                                <component :is="getIconComponent(feature.icon)" class="w-4 h-4 text-white" />
                                            </div>
                                            <div>
                                                <h4 class="font-black text-slate-900 text-[11px] leading-tight mb-0.5">{{ feature.title || 'Judul...' }}</h4>
                                                <p class="text-[9px] text-slate-500 leading-relaxed line-clamp-2">{{ feature.description || 'Deskripsi...' }}</p>
                                            </div>
                                        </div>
                                        
                                        <div v-if="form.features.length === 0" class="text-center py-8 text-xs text-slate-400 font-medium border-2 border-dashed border-slate-100 rounded-xl">
                                            Belum ada data keunggulan
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 bg-indigo-50 border border-indigo-100 rounded-2xl p-4 text-xs text-slate-600 leading-relaxed">
                                    <strong class="text-indigo-600">💡 Tips Layanan:</strong><br>
                                    Tuliskan <strong>4-6 keunggulan</strong> terbaik untuk meningkatkan kepercayaan pengunjung.
                                </div>

                                <button @click="submit" :disabled="form.processing"
                                    class="mt-4 w-full flex items-center justify-center gap-2 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-lg shadow-blue-200 text-sm transition-all active:scale-95 disabled:opacity-60">
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

<style scoped>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
