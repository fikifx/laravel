<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { 
    FileText, Plus, Trash2, Save, RotateCcw,
    Key, UserCheck, AlertCircle, CheckCircle2, Check
} from 'lucide-vue-next';

const props = defineProps({
    terms: { type: Object, required: true },
});

const form = useForm({
    lepas_kunci_items:   [...props.terms.lepas_kunci_items],
    dengan_sopir_items:  [...props.terms.dengan_sopir_items],
    overtime_percentage: props.terms.overtime_percentage,
    overtime_desc:       props.terms.overtime_desc,
});

// Helpers for array manipulation
const addItem = (type) => {
    if (type === 'lepas') {
        if (form.lepas_kunci_items.length < 10) form.lepas_kunci_items.push('');
    } else {
        if (form.dengan_sopir_items.length < 10) form.dengan_sopir_items.push('');
    }
};

const removeItem = (type, index) => {
    if (type === 'lepas') {
        if (form.lepas_kunci_items.length > 1) form.lepas_kunci_items.splice(index, 1);
    } else {
        if (form.dengan_sopir_items.length > 1) form.dengan_sopir_items.splice(index, 1);
    }
};

const submit = () => form.put(route('terms.update'));
const doReset = () => {
    if (confirm('Reset semua persyaratan ke data bawaan? Perubahan Anda akan hilang.')) {
        form.delete(route('terms.reset'));
    }
};
</script>

<template>
    <Head title="Kelola Syarat & Ketentuan" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 bg-slate-800 rounded-lg flex items-center justify-center shadow-md">
                        <FileText class="w-4 h-4 text-white" />
                    </div>
                    <div>
                        <h2 class="font-black text-lg text-slate-800 leading-none">Syarat & Ketentuan</h2>
                        <p class="text-xs text-slate-400 font-medium">Atur persyaratan sewa dan kebijakan overtime</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" @click="doReset"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-xl border border-red-200 text-red-500 hover:bg-red-50 text-xs font-bold transition-all">
                        <RotateCcw class="w-3.5 h-3.5" />
                        Reset
                    </button>
                    <button @click="submit" :disabled="form.processing"
                        class="flex items-center gap-1.5 px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-black rounded-xl shadow-lg shadow-slate-200 transition-all active:scale-95 disabled:opacity-60">
                        <Save class="w-3.5 h-3.5" />
                        Simpan
                    </button>
                </div>
            </div>
        </template>

        <div class="py-10">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Flash message -->
                <div v-if="$page.props.flash?.message"
                    class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 text-emerald-600 shadow-sm">
                    <CheckCircle2 class="w-5 h-5 shrink-0" />
                    <span class="text-sm font-bold">{{ $page.props.flash.message }}</span>
                </div>

                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        
                        <!-- Col 1 & 2: Form Fields -->
                        <div class="lg:col-span-2 space-y-6">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                <!-- Lepas Kunci -->
                                <div class="bg-white rounded-3xl border-2 border-blue-50 shadow-sm p-6 overflow-hidden relative">
                                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-50 rounded-full blur-2xl pointer-events-none"></div>
                                    <div class="flex items-center justify-between mb-6 relative z-10">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200 text-white">
                                                <Key class="w-5 h-5" />
                                            </div>
                                            <div>
                                                <h3 class="text-base font-black text-slate-900 leading-tight">Lepas Kunci</h3>
                                                <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest">Self Drive</p>
                                            </div>
                                        </div>
                                        <button type="button" @click="addItem('lepas')" :disabled="form.lepas_kunci_items.length >= 10" class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition-colors disabled:opacity-50">
                                            <Plus class="w-4 h-4" />
                                        </button>
                                    </div>

                                    <div class="space-y-3 relative z-10">
                                        <div v-for="(item, i) in form.lepas_kunci_items" :key="'lk-'+i" class="flex items-start gap-2 group">
                                            <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center shrink-0 mt-1.5">
                                                <CheckCircle2 class="w-3.5 h-3.5 text-blue-600" />
                                            </div>
                                            <div class="flex-1">
                                                <input v-model="form.lepas_kunci_items[i]" type="text" placeholder="Masukkan syarat..." required class="w-full px-3 py-2 rounded-xl border-slate-200 focus:border-blue-400 focus:ring-opacity-50 focus:ring-blue-200 shadow-sm text-sm font-medium text-slate-700 transition-all placeholder:font-normal" />
                                            </div>
                                            <button type="button" @click="removeItem('lepas', i)" :disabled="form.lepas_kunci_items.length <= 1" class="w-8 h-8 rounded-xl text-red-300 hover:text-red-500 hover:bg-red-50 flex items-center justify-center shrink-0 mt-0.5 opacity-0 group-hover:opacity-100 focus:opacity-100 disabled:opacity-0 transition-all">
                                                <Trash2 class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dengan Sopir -->
                                <div class="bg-white rounded-3xl border-2 border-emerald-50 shadow-sm p-6 overflow-hidden relative">
                                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-50 rounded-full blur-2xl pointer-events-none"></div>
                                    <div class="flex items-center justify-between mb-6 relative z-10">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-200 text-white">
                                                <UserCheck class="w-5 h-5" />
                                            </div>
                                            <div>
                                                <h3 class="text-base font-black text-slate-900 leading-tight">Dengan Sopir</h3>
                                                <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest">Driver + BBM</p>
                                            </div>
                                        </div>
                                        <button type="button" @click="addItem('sopir')" :disabled="form.dengan_sopir_items.length >= 10" class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center hover:bg-emerald-100 transition-colors disabled:opacity-50">
                                            <Plus class="w-4 h-4" />
                                        </button>
                                    </div>

                                    <div class="space-y-3 relative z-10">
                                        <div v-for="(item, i) in form.dengan_sopir_items" :key="'ds-'+i" class="flex items-start gap-2 group">
                                            <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 mt-1.5">
                                                <CheckCircle2 class="w-3.5 h-3.5 text-emerald-600" />
                                            </div>
                                            <div class="flex-1">
                                                <input v-model="form.dengan_sopir_items[i]" type="text" placeholder="Masukkan fasilitas/syarat..." required class="w-full px-3 py-2 rounded-xl border-slate-200 focus:border-emerald-400 focus:ring-opacity-50 focus:ring-emerald-200 shadow-sm text-sm font-medium text-slate-700 transition-all placeholder:font-normal" />
                                            </div>
                                            <button type="button" @click="removeItem('sopir', i)" :disabled="form.dengan_sopir_items.length <= 1" class="w-8 h-8 rounded-xl text-red-300 hover:text-red-500 hover:bg-red-50 flex items-center justify-center shrink-0 mt-0.5 opacity-0 group-hover:opacity-100 focus:opacity-100 disabled:opacity-0 transition-all">
                                                <Trash2 class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Overtime Policy -->
                            <div class="bg-amber-50/50 border-2 border-amber-100 rounded-3xl p-6 sm:p-8">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-500 flex items-center justify-center shrink-0">
                                        <AlertCircle class="w-6 h-6" />
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-base font-black text-slate-800 mb-1">Kebijakan Overtime / Keterlambatan</h3>
                                        <p class="text-xs text-slate-500 font-medium mb-6">Atur denda keterlambatan pengembalian unit agar terlihat transparan bagi pelanggan.</p>
                                        
                                        <div class="grid sm:grid-cols-3 gap-6">
                                            <div class="sm:col-span-1">
                                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Persentase Denda (%)</label>
                                                <div class="relative">
                                                    <input v-model="form.overtime_percentage" type="number" min="0" max="100" required class="w-full pl-4 pr-10 py-3 rounded-xl border-amber-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-200 outline-none font-black text-amber-600 text-lg transition-all" />
                                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-amber-400 font-black">%</div>
                                                </div>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Deskripsi Lengkap</label>
                                                <input v-model="form.overtime_desc" type="text" placeholder="Contoh: Toleransi 30 menit. Lebih dari itu dikenakan..." required class="w-full px-4 py-3 rounded-xl border-amber-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-200 outline-none text-sm font-medium text-slate-700 transition-all" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Col 3: Live Preview -->
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
                                    
                                    <div class="p-5 h-[400px] overflow-y-auto custom-scrollbar">
                                        <div class="space-y-6">
                                            
                                            <!-- Lepas Kunci -->
                                            <div class="bg-blue-900/20 border border-blue-500/20 rounded-xl p-4">
                                                <div class="flex items-center gap-3 mb-3">
                                                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white">
                                                        <Key class="w-4 h-4" />
                                                    </div>
                                                    <h4 class="text-sm font-black text-white">Lepas Kunci</h4>
                                                </div>
                                                <ul class="space-y-2">
                                                    <li v-for="item in form.lepas_kunci_items" :key="'p-lk-'+item" class="flex gap-2 text-xs text-slate-300">
                                                        <Check class="w-3.5 h-3.5 text-blue-400 shrink-0 mt-0.5" />
                                                        <span class="leading-tight">{{ item || '...' }}</span>
                                                    </li>
                                                </ul>
                                            </div>

                                            <!-- Dengan Sopir -->
                                            <div class="bg-emerald-900/20 border border-emerald-500/20 rounded-xl p-4">
                                                <div class="flex items-center gap-3 mb-3">
                                                    <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center text-white">
                                                        <UserCheck class="w-4 h-4" />
                                                    </div>
                                                    <h4 class="text-sm font-black text-white">Dengan Sopir</h4>
                                                </div>
                                                <ul class="space-y-2">
                                                    <li v-for="item in form.dengan_sopir_items" :key="'p-ds-'+item" class="flex gap-2 text-xs text-slate-300">
                                                        <Check class="w-3.5 h-3.5 text-emerald-400 shrink-0 mt-0.5" />
                                                        <span class="leading-tight">{{ item || '...' }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                            <!-- Overtime -->
                                            <div class="bg-amber-900/20 border border-amber-500/20 rounded-xl p-4 flex gap-3">
                                                <AlertCircle class="w-5 h-5 text-amber-500 shrink-0" />
                                                <div>
                                                    <p class="text-[10px] font-bold text-amber-500 uppercase">Denda Overtime</p>
                                                    <p class="text-xl font-black text-white mb-1">+{{ form.overtime_percentage }}%</p>
                                                    <p class="text-[10px] text-slate-400 leading-tight">{{ form.overtime_desc || '...' }}</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <button @click="submit()" :disabled="form.processing" class="mt-4 w-full flex items-center justify-center gap-2 py-3.5 bg-slate-800 hover:bg-slate-900 text-white font-black rounded-2xl shadow-lg shadow-slate-200 text-sm transition-all active:scale-95 disabled:opacity-60">
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
