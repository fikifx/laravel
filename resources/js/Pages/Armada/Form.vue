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

        <div class="py-12 bg-slate-50 min-h-[calc(100vh-64px)] font-['Plus Jakarta Sans']">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <form @submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Left: Image Upload -->
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                            <label class="block text-sm font-black text-slate-800 mb-4 uppercase tracking-widest">Foto Armada</label>
                            
                            <div class="relative group">
                                <div v-if="imagePreview" class="relative aspect-[4/3] rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shadow-inner">
                                    <img :src="imagePreview" class="w-full h-full object-cover" />
                                    <button 
                                        type="button" 
                                        @click="removeImage"
                                        class="absolute top-2 right-2 w-8 h-8 bg-black/50 text-white rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"
                                    >
                                        <X class="w-4 h-4" />
                                    </button>
                                </div>
                                <label v-else class="flex flex-col items-center justify-center aspect-[4/3] rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 hover:bg-white hover:border-blue-400 transition-all cursor-pointer group">
                                    <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-slate-400 group-hover:text-blue-500 transition-colors mb-3">
                                        <Upload class="w-6 h-6" />
                                    </div>
                                    <span class="text-xs font-bold text-slate-500 group-hover:text-blue-600 uppercase tracking-widest">Upload Foto</span>
                                    <input type="file" @change="handleImageChange" class="hidden" accept="image/*" />
                                </label>
                                
                                <label v-if="imagePreview" class="absolute bottom-4 right-4 cursor-pointer">
                                    <div class="w-10 h-10 bg-blue-600 text-white rounded-xl shadow-lg flex items-center justify-center hover:bg-blue-700 transition-transform active:scale-90">
                                        <Upload class="w-5 h-5" />
                                    </div>
                                    <input type="file" @change="handleImageChange" class="hidden" accept="image/*" />
                                </label>
                            </div>
                            
                            <p class="text-[10px] text-slate-400 mt-4 leading-relaxed font-bold uppercase tracking-widest">
                                Gunakan Rasio 16:10 atau 4:3<br>Maksimal 2MB (JPG, PNG, WebP)
                            </p>
                            <p v-if="form.errors.image" class="text-xs font-bold text-red-500 mt-2">{{ form.errors.image }}</p>
                        </div>

                        <div class="bg-blue-600 rounded-[2rem] p-8 text-white shadow-xl shadow-blue-500/20 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-16 -mt-16"></div>
                            <h4 class="font-black text-lg mb-2 relative z-10">Tips Premium 💎</h4>
                            <p class="text-blue-100 text-xs leading-relaxed font-medium relative z-10">
                                Gunakan foto dengan latar belakang bersih atau pemandangan alam untuk meningkatkan daya tarik pelanggan hingga 40%.
                            </p>
                        </div>
                    </div>

                    <!-- Right: Form Details -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-[2.5rem] p-8 sm:p-10 shadow-sm border border-slate-100">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div class="sm:col-span-2 space-y-2">
                                    <label class="flex items-center gap-2 text-sm font-black text-slate-700 uppercase tracking-widest">
                                        <Car class="w-4 h-4 text-blue-500" /> Nama Unit
                                    </label>
                                    <input 
                                        v-model="form.name"
                                        type="text" 
                                        placeholder="Contoh: All New Innova Zenix"
                                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700"
                                    >
                                    <p v-if="form.errors.name" class="text-xs font-bold text-red-500 mt-1">{{ form.errors.name }}</p>
                                </div>

                                <!-- Seats -->
                                <div class="space-y-2">
                                    <label class="flex items-center gap-2 text-sm font-black text-slate-700 uppercase tracking-widest">
                                        <Users class="w-4 h-4 text-blue-500" /> Kursi (Seats)
                                    </label>
                                    <input 
                                        v-model="form.seats"
                                        type="number" 
                                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700"
                                    >
                                    <p v-if="form.errors.seats" class="text-xs font-bold text-red-500 mt-1">{{ form.errors.seats }}</p>
                                </div>

                                <!-- Transmission -->
                                <div class="space-y-2">
                                    <label class="flex items-center gap-2 text-sm font-black text-slate-700 uppercase tracking-widest">
                                        <Settings2 class="w-4 h-4 text-blue-500" /> Transmisi
                                    </label>
                                    <select 
                                        v-model="form.transmission"
                                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 appearance-none -webkit-appearance-none"
                                    >
                                        <option value="Matic">Matic</option>
                                        <option value="Manual">Manual</option>
                                        <option value="AT/MT">AT/MT</option>
                                        <option value="Hybrid/AT">Hybrid/AT</option>
                                    </select>
                                    <p v-if="form.errors.transmission" class="text-xs font-bold text-red-500 mt-1">{{ form.errors.transmission }}</p>
                                </div>

                                <!-- Year -->
                                <div class="space-y-2">
                                    <label class="flex items-center gap-2 text-sm font-black text-slate-700 uppercase tracking-widest">
                                        <Key class="w-4 h-4 text-blue-500" /> Tahun
                                    </label>
                                    <input 
                                        v-model="form.year"
                                        type="number" 
                                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700"
                                    >
                                    <p v-if="form.errors.year" class="text-xs font-bold text-red-500 mt-1">{{ form.errors.year }}</p>
                                </div>

                                <!-- Tag -->
                                <div class="space-y-2">
                                    <label class="flex items-center gap-2 text-sm font-black text-slate-700 uppercase tracking-widest">
                                        <TagIcon class="w-4 h-4 text-blue-500" /> Label Tag
                                    </label>
                                    <input 
                                        v-model="form.tag"
                                        type="text" 
                                        placeholder="Kosongkan jika tidak ada"
                                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700"
                                    >
                                    <p v-if="form.errors.tag" class="text-xs font-bold text-red-500 mt-1">{{ form.errors.tag }}</p>
                                </div>

                                <!-- Price Sopir -->
                                <div class="space-y-2">
                                    <label class="flex items-center gap-2 text-sm font-black text-slate-700 uppercase tracking-widest">
                                        Harga (Dengan Sopir)
                                    </label>
                                    <input 
                                        v-model="form.price_sopir"
                                        type="text" 
                                        placeholder="Rp. 600.000"
                                        class="w-full px-5 py-3.5 bg-blue-50 border border-blue-100 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-blue-700"
                                    >
                                    <p v-if="form.errors.price_sopir" class="text-xs font-bold text-red-500 mt-1">{{ form.errors.price_sopir }}</p>
                                </div>

                                <!-- Price Lepas -->
                                <div class="space-y-2">
                                    <label class="flex items-center gap-2 text-sm font-black text-slate-700 uppercase tracking-widest">
                                        Harga (Lepas Kunci)
                                    </label>
                                    <input 
                                        v-model="form.price_lepas"
                                        type="text" 
                                        placeholder="Rp. 350.000 /24 jam"
                                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700"
                                    >
                                    <p v-if="form.errors.price_lepas" class="text-xs font-bold text-red-500 mt-1">{{ form.errors.price_lepas }}</p>
                                </div>
                            </div>

                            <div class="mt-12 flex flex-col sm:flex-row gap-4 items-center">
                                <button 
                                    type="submit"
                                    :disabled="form.processing"
                                    class="w-full sm:w-auto flex items-center justify-center gap-3 px-10 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black text-sm uppercase tracking-widest rounded-2xl shadow-xl shadow-blue-500/20 transition-all active:scale-[0.98] disabled:opacity-50 group"
                                >
                                    <Loader2 v-if="form.processing" class="w-5 h-5 animate-spin" />
                                    <template v-else>
                                        <Save class="w-5 h-5 group-hover:scale-110 transition-transform" />
                                        Simpan Armada
                                    </template>
                                </button>
                                <Link 
                                    :href="route('armada.index')"
                                    class="w-full sm:w-auto px-10 py-4 bg-slate-100 hover:bg-slate-200 text-slate-500 font-bold text-sm uppercase tracking-widest rounded-2xl transition-all text-center"
                                >
                                    Batal
                                </Link>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 text-slate-400 bg-white/50 px-6 py-4 rounded-2xl border border-slate-100">
                            <Info class="w-5 h-5 text-blue-500" />
                            <p class="text-[11px] font-bold uppercase tracking-wider">Perubahan akan langsung terlihat di halaman depan aplikasi setelah disimpan.</p>
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
