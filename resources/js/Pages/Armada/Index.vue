<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { 
    Plus, Edit, Trash2, Car, Users, 
    Settings2, Key, Info, CheckCircle2, X, AlertTriangle 
} from 'lucide-vue-next';

defineProps({
    cars: Array,
});

const showDeleteModal = ref(false);
const carToDelete = ref(null);

const confirmDelete = (car) => {
    carToDelete.value = car;
    showDeleteModal.value = true;
};

const cancelDelete = () => {
    showDeleteModal.value = false;
    carToDelete.value = null;
};

const deleteCar = () => {
    if (carToDelete.value) {
        router.delete(route('armada.destroy', carToDelete.value.id), {
            onSuccess: () => {
                cancelDelete();
                router.reload({ only: ['cars'] });
            }
        });
    }
};
</script>

<template>
    <Head title="Kelola Armada - Admin" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-600 shadow-sm shadow-slate-100">
                        <Car class="w-6 h-6" />
                    </div>
                    <div>
                        <h2 class="font-black text-xl text-slate-800 leading-tight">Kelola Armada</h2>
                        <p class="text-xs text-slate-400 font-medium">Atur koleksi unit kendaraan rental Anda</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <Link
                        :href="route('armada.create')"
                        class="flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-black rounded-xl shadow-lg shadow-blue-100 transition-all active:scale-95"
                    >
                        <Plus class="w-3.5 h-3.5" />
                        Tambah Armada Baru
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-10 bg-slate-50 min-h-[calc(100vh-64px)]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Success Message -->
                <div v-if="$page.props.flash?.message" 
                    class="mb-8 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 text-emerald-600 animate-in fade-in slide-in-from-top-4 duration-500">
                    <CheckCircle2 class="w-5 h-5 shrink-0" />
                    <span class="text-sm font-bold">{{ $page.props.flash.message }}</span>
                </div>

                <!-- Empty State -->
                <div v-if="cars.length === 0" class="bg-white rounded-[2rem] p-20 text-center border border-slate-100 shadow-sm">
                    <div class="w-24 h-24 bg-slate-50 rounded-[2rem] flex items-center justify-center mx-auto mb-8 shadow-inner">
                        <Car class="w-12 h-12 text-slate-300" />
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 mb-3">Belum ada armada</h3>
                    <p class="text-slate-500 mb-10 max-w-sm mx-auto font-medium">Mulai tambahkan unit armada Anda untuk ditampilkan di halaman landing page pelanggan.</p>
                    <Link
                        :href="route('armada.create')"
                        class="inline-flex items-center gap-3 px-10 py-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-blue-100 transition-all active:scale-95"
                    >
                        <Plus class="w-4 h-4" />
                        Buat Armada Pertama
                    </Link>
                </div>

                <!-- Grid -->
                <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    <template v-for="car in cars" :key="car.id">
                        <div v-if="car"
                            class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 flex flex-col group relative">
                        
                        <!-- Actions Floating Overlay -->
                        <div class="absolute top-4 right-4 z-20 flex gap-2 opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                             <Link
                                :href="route('armada.edit', car.id)"
                                class="w-10 h-10 bg-white/90 backdrop-blur-md text-blue-600 rounded-xl flex items-center justify-center shadow-lg hover:bg-blue-600 hover:text-white transition-all active:scale-95"
                            >
                                <Edit class="w-4 h-4" />
                            </Link>
                            <button
                                @click="confirmDelete(car)"
                                class="w-10 h-10 bg-white/90 backdrop-blur-md text-red-600 rounded-xl flex items-center justify-center shadow-lg hover:bg-red-600 hover:text-white transition-all active:scale-95"
                            >
                                <Trash2 class="w-4 h-4" />
                            </button>
                        </div>

                        <!-- Image Section -->
                        <div class="relative aspect-[16/10] overflow-hidden bg-slate-50">
                            <img 
                                :src="car.image_url" 
                                :alt="car.name"
                                class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                            >
                            <div v-if="car.tag" class="absolute top-5 left-5 bg-blue-600 text-white text-[9px] font-black px-4 py-2 rounded-xl border border-blue-400 uppercase tracking-[0.1em] shadow-lg shadow-blue-500/20">
                                {{ car.tag }}
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 lg:p-7 flex flex-col grow">
                            <div class="mb-5">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Unit Kendaraan</span>
                                <h3 class="font-black text-slate-900 text-lg leading-tight">{{ car.name }}</h3>
                            </div>

                            <!-- Pricing -->
                            <div class="space-y-3 mb-6">
                                <div class="bg-blue-50/70 rounded-2xl p-4 border border-blue-50">
                                    <div class="flex justify-between items-center mb-1">
                                        <p class="text-[9px] text-blue-400 font-black uppercase tracking-widest">Sopir + BBM</p>
                                        <Info class="w-3 h-3 text-blue-300" />
                                    </div>
                                    <p class="text-base font-black text-blue-700 tracking-tight">{{ car.price_sopir }}</p>
                                </div>
                                <div class="bg-slate-50/70 rounded-2xl p-4 border border-slate-100">
                                    <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest mb-1">Lepas Kunci</p>
                                    <p class="text-base font-bold tracking-tight" :class="car.price_lepas ? 'text-slate-700' : 'text-slate-300'">
                                        {{ car.price_lepas || 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Specs -->
                            <div class="flex items-center justify-between pt-5 border-t border-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-wider">
                                <span class="flex items-center gap-1.5 group/spec">
                                    <Settings2 class="w-3.5 h-3.5 text-blue-500/50 group-hover/spec:text-blue-500 transition-colors" /> {{ car.year }}
                                </span>
                                <span class="flex items-center gap-1.5 group/spec">
                                    <Users class="w-3.5 h-3.5 text-blue-500/50 group-hover/spec:text-blue-500 transition-colors" /> {{ car.seats }}
                                </span>
                                <span class="flex items-center gap-1.5 group/spec">
                                    <Key class="w-3.5 h-3.5 text-blue-500/50 group-hover/spec:text-blue-500 transition-colors" /> {{ car.transmission }}
                                </span>
                            </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- CUSTOM DELETE MODAL -->
        <div v-if="showDeleteModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
            <!-- Backdrop -->
            <div @click="cancelDelete" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity animate-in fade-in duration-300"></div>
            
            <!-- Modal Box -->
            <div class="relative bg-white rounded-3xl w-full max-w-md overflow-hidden shadow-2xl animate-in zoom-in duration-300">
                <!-- Header Icon & Close -->
                <div class="px-8 pt-8 pb-4 flex justify-between items-start">
                    <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center text-red-500 shadow-sm">
                        <AlertTriangle class="w-8 h-8" />
                    </div>
                    <button @click="cancelDelete" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-slate-100 transition-colors">
                        <X class="w-5 h-5" />
                    </button>
                </div>

                <!-- Content -->
                <div class="px-8 pb-8 text-center sm:text-left">
                    <h3 class="text-2xl font-black text-slate-900 mb-3 tracking-tight">Hapus Armada?</h3>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">
                        Apakah Anda yakin ingin menghapus <span class="font-black text-slate-800 underline decoration-red-200 decoration-4 underline-offset-4">{{ carToDelete?.name }}</span>? Unit ini akan hilang dari katalog landing page.
                    </p>
                </div>

                <!-- Actions -->
                <div class="px-8 py-6 bg-slate-50 flex flex-col sm:flex-row gap-3">
                    <button @click="deleteCar" class="flex-1 px-6 py-4 bg-red-600 hover:bg-red-700 text-white text-[11px] font-black uppercase tracking-[0.15em] rounded-2xl transition-all shadow-xl shadow-red-100 active:scale-95">
                        Ya, Hapus Permanen
                    </button>
                    <button @click="cancelDelete" class="flex-1 px-6 py-4 bg-white border border-slate-200 text-slate-500 text-[11px] font-black uppercase tracking-[0.15em] rounded-2xl hover:bg-slate-50 transition-all active:scale-95">
                        Batalkan
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.animate-in {
    animation-delay: 100ms;
}
</style>
