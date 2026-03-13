<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { BarChart3, Plus, Trash2, Save, RotateCcw, ArrowUp, ArrowDown, CheckCircle2, Hash, Type } from 'lucide-vue-next';

const props = defineProps({
    stats: { type: Array, default: () => [] },
});

const defaults = [
    { label: 'Unit Armada',         target: 50,   suffix: '+',  fixed_value: '' },
    { label: 'Tahun Berpengalaman', target: 8,    suffix: '+',  fixed_value: '' },
    { label: 'Pelanggan Puas',      target: 2000, suffix: '+',  fixed_value: '' },
    { label: 'Siap Melayani',       target: null, suffix: '',   fixed_value: '24/7' },
];

const form = useForm({
    stats: props.stats.length > 0
        ? props.stats.map(s => ({
            label:       s.label       ?? '',
            target:      s.target      ?? '',
            suffix:      s.suffix      ?? '',
            fixed_value: s.fixed_value ?? '',
          }))
        : defaults.map(d => ({ ...d })),
});

const addRow = () => {
    if (form.stats.length >= 8) return;
    form.stats.push({ label: '', target: '', suffix: '+', fixed_value: '' });
};
const removeRow = (i) => {
    if (form.stats.length <= 1) return;
    form.stats.splice(i, 1);
};
const moveUp   = (i) => { if (i > 0) { const t = form.stats[i]; form.stats[i] = form.stats[i-1]; form.stats[i-1] = t; } };
const moveDown = (i) => { if (i < form.stats.length - 1) { const t = form.stats[i]; form.stats[i] = form.stats[i+1]; form.stats[i+1] = t; } };

const isFixed = (stat) => !!(stat.fixed_value);
const toggleFixed = (stat) => {
    if (isFixed(stat)) { stat.fixed_value = ''; }
    else               { stat.fixed_value = stat.target + (stat.suffix || ''); stat.target = ''; stat.suffix = ''; }
};

const submit = () => form.put(route('stats.update'));
const doReset = () => {
    if (confirm('Reset Stats ke data default? Semua perubahan akan hilang.')) {
        form.delete(route('stats.reset'));
    }
};

const displayValue = (stat) => {
    if (stat.fixed_value) return stat.fixed_value;
    if (stat.target !== '' && stat.target !== null) return stat.target + (stat.suffix || '');
    return '—';
};
</script>

<template>
    <Head title="Kelola Stats Section" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <BarChart3 class="w-4 h-4 text-indigo-600" />
                    </div>
                    <div>
                        <h2 class="font-black text-lg text-slate-800 leading-none">Stats Section</h2>
                        <p class="text-xs text-slate-400 font-medium">Angka statistik pada landing page</p>
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

                        <!-- ===== STATS ROWS ===== -->
                        <div class="lg:col-span-2 space-y-4">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-black text-slate-700">{{ form.stats.length }} item stat</p>
                                <button type="button" @click="addRow" :disabled="form.stats.length >= 8"
                                    class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-bold rounded-xl transition-all disabled:opacity-40">
                                    <Plus class="w-3.5 h-3.5" />
                                    Tambah Stat
                                </button>
                            </div>

                            <div v-for="(stat, i) in form.stats" :key="i"
                                class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 transition-all hover:shadow-md">
                                <div class="flex items-center gap-3 mb-4">
                                    <!-- Sort Buttons -->
                                    <div class="flex flex-col gap-1 shrink-0">
                                        <button type="button" @click="moveUp(i)" :disabled="i === 0"
                                            class="w-6 h-6 flex items-center justify-center rounded-lg bg-slate-50 hover:bg-slate-100 disabled:opacity-30 transition-colors">
                                            <ArrowUp class="w-3 h-3 text-slate-400" />
                                        </button>
                                        <button type="button" @click="moveDown(i)" :disabled="i === form.stats.length - 1"
                                            class="w-6 h-6 flex items-center justify-center rounded-lg bg-slate-50 hover:bg-slate-100 disabled:opacity-30 transition-colors">
                                            <ArrowDown class="w-3 h-3 text-slate-400" />
                                        </button>
                                    </div>

                                    <!-- Position badge -->
                                    <div class="w-8 h-8 bg-indigo-100 rounded-xl flex items-center justify-center text-xs font-black text-indigo-600 shrink-0">
                                        {{ i + 1 }}
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-black text-slate-700">Stat #{{ i + 1 }}</p>
                                        <p class="text-[10px] text-slate-400">Nilai yang tampil: <span class="font-bold text-slate-600">{{ displayValue(stat) }}</span></p>
                                    </div>

                                    <!-- Fixed toggle -->
                                    <button type="button" @click="toggleFixed(stat)"
                                        :class="isFixed(stat) ? 'bg-purple-100 text-purple-600' : 'bg-slate-100 text-slate-400 hover:text-slate-600'"
                                        class="px-2.5 py-1 rounded-lg text-[10px] font-black transition-colors shrink-0">
                                        {{ isFixed(stat) ? 'TEKS TETAP' : 'ANGKA' }}
                                    </button>

                                    <!-- Delete -->
                                    <button type="button" @click="removeRow(i)" :disabled="form.stats.length <= 1"
                                        class="w-8 h-8 flex items-center justify-center rounded-xl hover:bg-red-50 text-red-400 hover:text-red-500 transition-colors disabled:opacity-30 shrink-0">
                                        <Trash2 class="w-4 h-4" />
                                    </button>
                                </div>

                                <!-- Fields -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <!-- Label -->
                                    <div class="sm:col-span-3">
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                                            <Type class="w-3 h-3 inline mr-1" />Label
                                        </label>
                                        <input v-model="stat.label" type="text" placeholder="Contoh: Unit Armada"
                                            class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none text-sm font-medium text-slate-800 transition-all" />
                                    </div>

                                    <!-- Number mode -->
                                    <template v-if="!isFixed(stat)">
                                        <div class="sm:col-span-2">
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                                                <Hash class="w-3 h-3 inline mr-1" />Target Angka
                                            </label>
                                            <input v-model="stat.target" type="number" min="0" placeholder="50"
                                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none text-sm font-medium text-slate-800 transition-all" />
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Suffix</label>
                                            <input v-model="stat.suffix" type="text" placeholder="+"
                                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none text-sm font-medium text-slate-800 transition-all" />
                                        </div>
                                    </template>

                                    <!-- Fixed text mode -->
                                    <template v-else>
                                        <div class="sm:col-span-3">
                                            <label class="block text-[10px] font-bold text-purple-400 uppercase tracking-wider mb-1.5">Nilai Teks Tetap</label>
                                            <input v-model="stat.fixed_value" type="text" placeholder="Contoh: 24/7"
                                                class="w-full px-3 py-2.5 rounded-xl border border-purple-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-100 outline-none text-sm font-bold text-purple-700 transition-all" />
                                        </div>
                                    </template>
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
                                    <!-- Mini Stats Preview -->
                                    <div class="bg-blue-600 p-6">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div v-for="(stat, i) in form.stats" :key="i" class="text-center">
                                                <p class="text-xl font-black text-white">{{ displayValue(stat) }}</p>
                                                <p class="text-[10px] text-blue-200 font-semibold mt-0.5">{{ stat.label || '...' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 bg-indigo-50 border border-indigo-100 rounded-2xl p-4 text-xs text-slate-600 leading-relaxed">
                                    <strong class="text-indigo-600">💡 Tips:</strong><br>
                                    • <strong>Angka</strong>: animasi count-up saat scroll<br>
                                    • <strong>Teks Tetap</strong>: tampil langsung (mis. "24/7")<br>
                                    • Maks. <strong>8 stat</strong> item
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
