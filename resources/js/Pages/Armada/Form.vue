<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { 
    ArrowLeft, Save, Car, Users, Settings2, 
    Key, Tag as TagIcon, Upload, X, Loader2, Info
} from 'lucide-vue-next';

const props = defineProps({
    car: {
        type: Object,
        default: null,
    },
});

const isEdit = !!props.car;

const form = useForm({
    _method: isEdit ? 'put' : 'post',
    name: props.car?.name || '',
    image: null,
    seats: props.car?.seats || 7,
    transmission: props.car?.transmission || 'AT/MT',
    year: props.car?.year || 2024,
    price_sopir: props.car?.price_sopir || 'Rp. ',
    price_lepas: props.car?.price_lepas || 'Rp. ',
    tag: props.car?.tag || '',
});

const imagePreview = ref(props.car?.image_url || null);

const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const removeImage = () => {
    form.image = null;
    imagePreview.value = props.car?.image_url || null;
};

const submit = () => {
    if (isEdit) {
        // Inertia.js file upload with PUT requires _method trick or using post with spoofing
        form.post(route('armada.update', props.car.id), {
            forceFormData: true,
        });
    } else {
        form.post(route('armada.store'));
    }
};
</script>

<template>
    <Head :title="isEdit ? 'Edit Armada' : 'Tambah Armada'" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link
                    :href="route('armada.index')"
                    class="p-2 hover:bg-slate-100 rounded-xl transition-colors text-slate-400 hover:text-slate-600"
                >
                    <ArrowLeft class="w-6 h-6" />
                </Link>
                <h2 class="font-black text-xl text-slate-800 leading-tight">
                    {{ isEdit ? 'Edit' : 'Tambah' }} <span class="text-blue-600">Armada</span>
                </h2>
            </div>
        </template>

        <div class="py-12 bg-slate-50 min-h-[calc(100vh-64px)] font-['Plus Jakarta Jakarta', sans-serif]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <form @submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                    
                    <!-- EDITOR PANEL (LEFT & CENTER) -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Main Info Card -->
                        <div class="bg-white rounded-3xl border border-slate-100 p-8 sm:p-10 shadow-sm">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-8 flex items-center gap-2">
                                <Car class="w-4 h-4" />
                                Detail Unit Armada
                            </h3>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="sm:col-span-2 space-y-2">
                                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Nama Unit Kendaraan</label>
                                    <input v-model="form.name" type="text" placeholder="Contoh: All New Innova Zenix"
                                        class="w-full bg-slate-50 border-0 focus:ring-2 focus:ring-blue-100 rounded-2xl px-6 py-4 text-base font-black text-slate-700 transition-all" />
                                    <p v-if="form.errors.name" class="text-xs font-bold text-red-500 mt-1">{{ form.errors.name }}</p>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Kapasitas Kursi (Seats)</label>
                                    <div class="relative">
                                        <Users class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300" />
                                        <input v-model="form.seats" type="number"
                                            class="w-full bg-slate-50 border-0 focus:ring-2 focus:ring-blue-100 rounded-xl pl-12 pr-6 py-3.5 text-sm font-bold text-slate-600 transition-all" />
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Transmisi</label>
                                    <div class="relative">
                                        <Settings2 class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300" />
                                        <select v-model="form.transmission"
                                            class="w-full bg-slate-50 border-0 focus:ring-2 focus:ring-blue-100 rounded-xl pl-12 pr-6 py-3.5 text-sm font-bold text-slate-600 transition-all appearance-none">
                                            <option value="Matic">Matic</option>
                                            <option value="Manual">Manual</option>
                                            <option value="AT/MT">AT/MT</option>
                                            <option value="Hybrid/AT">Hybrid/AT</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Tahun Unit</label>
                                    <div class="relative">
                                        <Key class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300" />
                                        <input v-model="form.year" type="number"
                                            class="w-full bg-slate-50 border-0 focus:ring-2 focus:ring-blue-100 rounded-xl pl-12 pr-6 py-3.5 text-sm font-bold text-slate-600 transition-all" />
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Label Tag (Opsional)</label>
                                    <div class="relative">
                                        <TagIcon class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300" />
                                        <input v-model="form.tag" type="text" placeholder="e.g. Terlaris"
                                            class="w-full bg-slate-50 border-0 focus:ring-2 focus:ring-blue-100 rounded-xl pl-12 pr-6 py-3.5 text-sm font-bold text-slate-600 transition-all" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Card -->
                        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-8 flex items-center gap-2">
                                <TagIcon class="w-4 h-4 text-blue-500" />
                                Informasi Harga
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[11px] font-black text-blue-500 uppercase tracking-widest pl-1">Harga (Dengan Sopir + BBM)</label>
                                    <input v-model="form.price_sopir" type="text" placeholder="Rp. 600.000"
                                        class="w-full bg-blue-50/50 border-0 focus:ring-2 focus:ring-blue-100 rounded-2xl px-6 py-4 text-sm font-black text-blue-700 transition-all" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Harga (Lepas Kunci)</label>
                                    <input v-model="form.price_lepas" type="text" placeholder="Rp. 350.000"
                                        class="w-full bg-slate-50 border-0 focus:ring-2 focus:ring-blue-100 rounded-2xl px-6 py-4 text-sm font-black text-slate-600 transition-all" />
                                </div>
                            </div>
                        </div>

                        <!-- Image Upload Card -->
                        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                                <Upload class="w-4 h-4" />
                                Foto Unit
                            </h3>
                            <div class="relative group max-w-md">
                                <div v-if="imagePreview" class="relative aspect-[16/10] rounded-2xl overflow-hidden bg-slate-100 border border-slate-100 shadow-inner">
                                    <img :src="imagePreview" class="w-full h-full object-cover" />
                                    <button type="button" @click="removeImage"
                                        class="absolute top-4 right-4 w-10 h-10 bg-black/50 backdrop-blur-md text-white rounded-xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <X class="w-5 h-5" />
                                    </button>
                                </div>
                                <label v-else class="flex flex-col items-center justify-center aspect-[16/10] rounded-2xl border-2 border-dashed border-slate-100 bg-slate-50 hover:bg-slate-100 hover:border-blue-300 transition-all cursor-pointer group">
                                    <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center text-slate-300 group-hover:text-blue-500 transition-colors mb-4">
                                        <Upload class="w-7 h-7" />
                                    </div>
                                    <span class="text-xs font-black text-slate-400 group-hover:text-blue-600 uppercase tracking-widest">Pilih Foto Unit</span>
                                    <input type="file" @change="handleImageChange" class="hidden" accept="image/*" />
                                </label>
                                
                                <label v-if="imagePreview" class="absolute bottom-4 right-4 cursor-pointer">
                                    <div class="w-12 h-12 bg-blue-600 text-white rounded-2xl shadow-lg flex items-center justify-center hover:bg-blue-700 transition-all active:scale-90">
                                        <Upload class="w-6 h-6" />
                                    </div>
                                    <input type="file" @change="handleImageChange" class="hidden" accept="image/*" />
                                </label>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-4 pt-4">
                            <button @click="submit" :disabled="form.processing"
                                class="flex-1 sm:flex-none flex items-center justify-center gap-3 px-12 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black text-sm uppercase tracking-widest rounded-3xl shadow-xl shadow-blue-200 transition-all active:scale-[0.98] disabled:opacity-50">
                                <Loader2 v-if="form.processing" class="w-5 h-5 animate-spin" />
                                <Save v-else class="w-5 h-5" />
                                Simpan Armada
                            </button>
                            <Link :href="route('armada.index')"
                                class="flex-1 sm:flex-none px-12 py-4 bg-slate-100 hover:bg-slate-200 text-slate-500 font-bold text-sm uppercase tracking-widest rounded-3xl transition-all text-center">
                                Batal
                            </Link>
                        </div>
                    </div>

                    <!-- PREVIEW PANEL (RIGHT) -->
                    <div class="lg:col-span-1 sticky top-8 space-y-6">
                        <div class="bg-indigo-100 rounded-3xl p-2 shadow-2xl shadow-slate-200 overflow-hidden border border-slate-200">
                             <!-- Mac-style Header -->
                             <div class="px-5 py-3.5 border-b border-slate-200 flex items-center gap-2 bg-white/50">
                                <div class="flex gap-1.5">
                                    <div class="w-2.5 h-2.5 rounded-full bg-red-400/80"></div>
                                    <div class="w-2.5 h-2.5 rounded-full bg-yellow-400/80"></div>
                                    <div class="w-2.5 h-2.5 rounded-full bg-green-400/80"></div>
                                </div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Live Preview</span>
                            </div>

                            <div class="bg-slate-50 rounded-b-2xl p-8 flex justify-center items-center min-h-[400px]">
                                
                                <!-- Armada Card Preview (Landing Page Style) -->
                                <div class="w-full max-w-[280px] bg-white rounded-2xl overflow-hidden shadow-xl border border-slate-100 flex flex-col scale-110">
                                    <!-- Image -->
                                    <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                                        <img v-if="imagePreview" :src="imagePreview" class="w-full h-full object-cover">
                                        <div v-else class="w-full h-full flex flex-col items-center justify-center text-slate-200 gap-2">
                                            <Car class="w-12 h-12" />
                                            <span class="text-[10px] uppercase font-black tracking-widest">No Image</span>
                                        </div>
                                        <div v-if="form.tag"
                                            class="absolute top-3 left-3 bg-blue-600 text-white text-[9px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                            {{ form.tag }}
                                        </div>
                                    </div>

                                    <!-- Body -->
                                    <div class="p-4 flex flex-col grow">
                                        <h3 class="font-black text-slate-900 text-sm mb-3">{{ form.name || 'Nama Armada' }}</h3>

                                        <!-- Prices -->
                                        <div class="space-y-2 mb-4 grow">
                                            <div class="bg-blue-50 rounded-xl p-3">
                                                <p class="text-[10px] text-blue-400 font-bold uppercase tracking-wider mb-0.5">Dengan Sopir + BBM</p>
                                                <p class="text-sm font-black text-blue-700">{{ form.price_sopir || 'Rp. 0' }}</p>
                                            </div>
                                            <div class="bg-slate-50 rounded-xl p-3" v-if="form.price_lepas">
                                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">Lepas Kunci</p>
                                                <p class="text-sm font-bold text-slate-700">{{ form.price_lepas }}</p>
                                            </div>
                                        </div>

                                        <!-- Specs -->
                                        <div class="flex items-center gap-2 pt-3 border-t border-slate-100 text-[9px] font-semibold text-slate-400 mb-3">
                                            <span class="flex items-center gap-1"><Settings2 class="w-3 h-3 text-blue-500" /> {{ form.year }}</span>
                                            <span>|</span>
                                            <span class="flex items-center gap-1"><Users class="w-3 h-3 text-blue-500" /> {{ form.seats }} seat</span>
                                            <span>|</span>
                                            <span class="flex items-center gap-1"><Key class="w-3 h-3 text-blue-500" /> {{ form.transmission }}</span>
                                        </div>

                                        <!-- CTA Button -->
                                        <div class="w-full py-3 rounded-xl bg-emerald-500 text-white text-[10px] font-black uppercase tracking-widest text-center shadow-lg shadow-emerald-100">
                                            Pesan Sekarang
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Info Card -->
                        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm relative overflow-hidden">
                            <div class="absolute -right-4 -bottom-4 opacity-5">
                                <Info class="w-24 h-24 text-blue-600" />
                            </div>
                            <h4 class="text-[11px] font-black text-slate-800 uppercase tracking-widest mb-3">Catatan Admin</h4>
                            <p class="text-[10px] text-slate-500 font-semibold leading-relaxed relative z-10">
                                Foto unit yang menarik sangat berpengaruh pada keputusan pelanggan. Pastikan pencahayaan cukup dan mobil dalam kondisi bersih saat difoto.
                            </p>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  appearance: textfield;
  -moz-appearance: textfield;
}
</style>
