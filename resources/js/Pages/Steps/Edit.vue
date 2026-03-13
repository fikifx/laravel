<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { 
    ListOrdered, Plus, Trash2, Save, RotateCcw, ArrowUp, ArrowDown, CheckCircle2,
    Type, AlignLeft, Image as ImageIcon,
    // Available Lucide Icons
    Car, CalendarCheck2, Check, ShieldCheck, Clock, MapPin, Phone, UserCheck, Star, Zap
} from 'lucide-vue-next';

const props = defineProps({
    steps: { type: Array, default: () => [] },
});

const defaults = [
    { title: 'Pilih Armada', description: 'Tentukan unit yang sesuai kebutuhan dan budget Anda.', icon: 'Car' },
    { title: 'Konfirmasi via Chat', description: 'Konsultasikan jadwal dan detail perjalanan via WhatsApp.', icon: 'CalendarCheck2' },
    { title: 'Siap Berangkat!', description: 'Unit diantarkan ke lokasi Anda. Selamat menikmati perjalanan.', icon: 'Check' },
];

const form = useForm({
    steps: props.steps.length > 0
        ? props.steps.map(s => ({
            title:       s.title,
            description: s.description,
            icon:        s.icon,
          }))
        : defaults.map(d => ({ ...d })),
});

const addRow = () => {
    if (form.steps.length >= 5) return;
    form.steps.push({ title: '', description: '', icon: 'CheckCircle2' });
};
const removeRow = (i) => {
    if (form.steps.length <= 1) return;
    form.steps.splice(i, 1);
};
const moveUp   = (i) => { if (i > 0) { const t = form.steps[i]; form.steps[i] = form.steps[i-1]; form.steps[i-1] = t; } };
const moveDown = (i) => { if (i < form.steps.length - 1) { const t = form.steps[i]; form.steps[i] = form.steps[i+1]; form.steps[i+1] = t; } };

const submit = () => form.put(route('steps.update'));
const doReset = () => {
    if (confirm('Reset Cara Memesan ke data default? Semua perubahan akan hilang.')) {
        form.delete(route('steps.reset'));
    }
};

const iconOptions = [
    { name: 'Car', component: Car, label: 'Mobil (Pilih Armada)' },
    { name: 'CalendarCheck2', component: CalendarCheck2, label: 'Kalender (Jadwal/Konfirmasi)' },
    { name: 'Check', component: Check, label: 'Ceklis (Siap/Selesai)' },
    { name: 'CheckCircle2', component: CheckCircle2, label: 'Ceklis Lingkaran (Oke)' },
    { name: 'ShieldCheck', component: ShieldCheck, label: 'Perisai (Aman)' },
    { name: 'Clock', component: Clock, label: 'Jam (Waktu/Menunggu)' },
    { name: 'MapPin', component: MapPin, label: 'Pin Lokasi (Alamat/Tujuan)' },
    { name: 'Phone', component: Phone, label: 'Telepon (Hubungi)' },
    { name: 'UserCheck', component: UserCheck, label: 'User Cek (Verifikasi)' },
    { name: 'Star', component: Star, label: 'Bintang (Rating/Premium)' },
    { name: 'Zap', component: Zap, label: 'Petir (Cepat)' },
];

const getIconComponent = (name) => {
    const found = iconOptions.find(o => o.name === name);
    return found ? found.component : CheckCircle2;
};
</script>

<template>
    <Head title="Kelola Cara Memesan" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <ListOrdered class="w-4 h-4 text-indigo-600" />
                    </div>
                    <div>
                        <h2 class="font-black text-lg text-slate-800 leading-none">Cara Memesan</h2>
                        <p class="text-xs text-slate-400 font-medium">Langkah-langkah penyewaan armada</p>
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
                                <p class="text-sm font-black text-slate-700">{{ form.steps.length }} langkah sewa</p>
                                <button type="button" @click="addRow" :disabled="form.steps.length >= 5"
                                    class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-bold rounded-xl transition-all disabled:opacity-40">
                                    <Plus class="w-3.5 h-3.5" />
                                    Tambah Langkah
                                </button>
                            </div>

                            <div v-for="(step, i) in form.steps" :key="i"
                                class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 transition-all hover:shadow-md relative overflow-hidden">
                                
                                <!-- Step Number Watermark -->
                                <div class="absolute -right-4 -top-6 text-[120px] font-black text-slate-50 opacity-50 pointer-events-none select-none">
                                    {{ String(i + 1).padStart(2, '0') }}
                                </div>

                                <div class="flex items-center gap-3 mb-4 border-b border-slate-100 pb-4 relative z-10">
                                    <!-- Sort Buttons -->
                                    <div class="flex flex-col gap-1 shrink-0">
                                        <button type="button" @click="moveUp(i)" :disabled="i === 0"
                                            class="w-6 h-6 flex items-center justify-center rounded-lg bg-slate-50 hover:bg-slate-100 disabled:opacity-30 transition-colors">
                                            <ArrowUp class="w-3 h-3 text-slate-400" />
                                        </button>
                                        <button type="button" @click="moveDown(i)" :disabled="i === form.steps.length - 1"
                                            class="w-6 h-6 flex items-center justify-center rounded-lg bg-slate-50 hover:bg-slate-100 disabled:opacity-30 transition-colors">
                                            <ArrowDown class="w-3 h-3 text-slate-400" />
                                        </button>
                                    </div>

                                    <!-- Position badge -->
                                    <div class="w-8 h-8 bg-indigo-100 rounded-xl flex items-center justify-center text-xs font-black text-indigo-600 shrink-0">
                                        {{ i + 1 }}
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-black text-slate-700">Langkah #{{ i + 1 }}</p>
                                    </div>

                                    <!-- Delete -->
                                    <button type="button" @click="removeRow(i)" :disabled="form.steps.length <= 1"
                                        class="w-8 h-8 flex items-center justify-center rounded-xl hover:bg-red-50 text-red-400 hover:text-red-500 transition-colors disabled:opacity-30 shrink-0">
                                        <Trash2 class="w-4 h-4" />
                                    </button>
                                </div>

                                <!-- Fields -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 relative z-10">
                                    <!-- Title -->
                                    <div class="sm:col-span-2">
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                                            <Type class="w-3 h-3 inline mr-1" />Judul Langkah
                                        </label>
                                        <input v-model="step.title" type="text" placeholder="Contoh: Pilih Armada" required
                                            class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none text-sm font-bold text-slate-800 transition-all" />
                                    </div>

                                    <!-- Description -->
                                    <div class="sm:col-span-2">
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                                            <AlignLeft class="w-3 h-3 inline mr-1" />Penjelasan Singkat
                                        </label>
                                        <textarea v-model="step.description" rows="2" placeholder="Jelaskan detail langkah ini..." required
                                            class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none text-xs font-medium text-slate-600 transition-all resize-none"></textarea>
                                    </div>

                                    <!-- Icon -->
                                    <div class="sm:col-span-2 sm:w-1/2 pr-2">
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                                            <ImageIcon class="w-3 h-3 inline mr-1" />Ikon Indikator
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <component :is="getIconComponent(step.icon)" class="w-4 h-4 text-slate-400" />
                                            </div>
                                            <select v-model="step.icon"
                                                class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-slate-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none text-sm font-medium text-slate-800 transition-all appearance-none cursor-pointer">
                                                <option v-for="opt in iconOptions" :key="opt.name" :value="opt.name">
                                                    {{ opt.label }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ===== LIVE PREVIEW ===== -->
                        <div class="lg:col-span-1">
                            <div class="sticky top-20">
                                <div class="bg-slate-900 rounded-2xl shadow-xl overflow-hidden border border-slate-800">
                                    <div class="px-5 py-3.5 border-b border-slate-800 flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <div class="flex gap-1.5">
                                                <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                                                <div class="w-2.5 h-2.5 rounded-full bg-yellow-500"></div>
                                                <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                                            </div>
                                            <span class="text-xs font-bold text-slate-400 ml-1">Live Preview (Dark)</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Mini Preview -->
                                    <div class="p-5 h-[400px] overflow-y-auto custom-scrollbar relative">
                                        <div class="absolute left-[33px] top-8 bottom-8 w-px bg-slate-800/60 z-0"></div>
                                        
                                        <div class="space-y-6 relative z-10">
                                            <div v-for="(step, i) in form.steps" :key="i" class="flex gap-4">
                                                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center shrink-0 shadow-[0_0_15px_rgba(37,99,235,0.3)] border-4 border-slate-900 z-10">
                                                    <component :is="getIconComponent(step.icon)" class="w-3.5 h-3.5 text-white" />
                                                </div>
                                                <div class="pt-1.5 flex-1 bg-slate-800/50 p-3 rounded-xl border border-slate-700/50">
                                                    <div class="text-[10px] font-black text-blue-400 mb-0.5 tracking-wider">LANGKAH {{ String(i + 1).padStart(2, '0') }}</div>
                                                    <h4 class="font-bold text-white text-xs mb-1">{{ step.title || 'Judul Langkah...' }}</h4>
                                                    <p class="text-[10px] text-slate-400 leading-relaxed">{{ step.description || 'Penjelasan singkat...' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div v-if="form.steps.length === 0" class="text-center py-8 text-xs text-slate-500 font-medium border-2 border-dashed border-slate-800 rounded-xl relative z-10">
                                            Belum ada langkah pemesanan
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-5 bg-indigo-50 border border-indigo-100 rounded-2xl p-4 text-xs text-slate-600 leading-relaxed shadow-sm">
                                    <strong class="text-indigo-600">💡 Praktik Terbaik:</strong><br>
                                    Pertahankan <strong>3 langkah yang ringkas</strong> agar pelanggan tidak merasa rumit saat ingin menyewa armada.
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
.custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #475569; }
</style>
