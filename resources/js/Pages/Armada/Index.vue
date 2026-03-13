<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { 
    Plus, Edit, Trash2, Car, Users, 
    Settings2, Key, Info, CheckCircle2 
} from 'lucide-vue-next';

defineProps({
    cars: Array,
});

const deleteCar = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus armada ini?')) {
        router.delete(route('armada.destroy', id));
    }
};
</script>

<template>
    <Head title="Kelola Armada - Admin" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center">
                        <Car class="w-4 h-4 text-blue-600" />
                    </div>
                    <div>
                        <h2 class="font-black text-lg text-slate-800 leading-none">Kelola Armada</h2>
                        <p class="text-xs text-slate-400 font-medium">Atur unit kendaraan rental Anda</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <Link
                        :href="route('armada.create')"
                        class="flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-black rounded-xl shadow-lg shadow-blue-200 transition-all active:scale-95"
                    >
                        <Plus class="w-3.5 h-3.5" />
                        Tambah Armada
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12 bg-slate-50 min-h-[calc(100vh-64px)]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Success Message -->
                <div v-if="$page.props.flash?.message" class="mb-8 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 text-emerald-600 shadow-sm animate-in fade-in slide-in-from-top-4 duration-500">
                    <CheckCircle2 class="w-5 h-5" />
                    <span class="text-sm font-bold">{{ $page.props.flash.message }}</span>
                </div>

                <div v-if="cars.length === 0" class="bg-white rounded-[2rem] p-16 text-center border border-dashed border-slate-200 shadow-sm">
                    <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-6">
                        <Car class="w-10 h-10 text-slate-300" />
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-2">Belum ada armada</h3>
                    <p class="text-slate-500 mb-8 max-w-sm mx-auto">Mulai tambahkan unit armada Anda untuk ditampilkan di halaman landing page.</p>
                    <Link
                        :href="route('armada.create')"
                        class="inline-flex items-center gap-2 px-8 py-3.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-blue-600/20 transition-all active:scale-95"
                    >
                        Buat Armada Pertama
                    </Link>
                </div>

                <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <template v-for="car in cars" :key="car.id">
                        <div v-if="car"
                            class="bg-white rounded-[2rem] overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group relative">
                        
                        <!-- Actions Floating Overlay (Visible on Hover) -->
                        <div class="absolute top-4 right-4 z-20 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                             <Link
                                :href="route('armada.edit', car.id)"
                                class="w-10 h-10 bg-white/90 backdrop-blur-md text-blue-600 rounded-xl flex items-center justify-center shadow-lg hover:bg-blue-600 hover:text-white transition-all active:scale-95"
                            >
                                <Edit class="w-5 h-5" />
                            </Link>
                            <button
                                @click="deleteCar(car.id)"
                                class="w-10 h-10 bg-white/90 backdrop-blur-md text-red-600 rounded-xl flex items-center justify-center shadow-lg hover:bg-red-600 hover:text-white transition-all active:scale-95"
                            >
                                <Trash2 class="w-5 h-5" />
                            </button>
                        </div>

                        <!-- Image Section -->
                        <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                            <img 
                                :src="car.image_url" 
                                :alt="car.name"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                            >
                            <div v-if="car.tag" class="absolute top-4 left-4 bg-blue-600 text-white text-[10px] font-black px-3 py-1.5 rounded-lg uppercase tracking-wider shadow-lg shadow-blue-500/40">
                                {{ car.tag }}
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 flex flex-col grow">
                            <h3 class="font-black text-slate-900 text-lg mb-4">{{ car.name }}</h3>

                            <!-- Pricing -->
                            <div class="grid grid-cols-1 gap-3 mb-6">
                                <div class="bg-blue-50/50 rounded-2xl p-4 border border-blue-50">
                                    <p class="text-[10px] text-blue-400 font-bold uppercase tracking-widest mb-1">Dengan Sopir + BBM</p>
                                    <p class="text-base font-black text-blue-700">{{ car.price_sopir }}</p>
                                </div>
                                <div class="bg-slate-50/50 rounded-2xl p-4 border border-slate-100">
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Lepas Kunci</p>
                                    <p class="text-base font-bold" :class="car.price_lepas ? 'text-slate-700' : 'text-slate-300'">
                                        {{ car.price_lepas || 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Specs -->
                            <div class="flex items-center justify-between pt-5 border-t border-slate-100 text-[11px] font-bold text-slate-400">
                                <span class="flex items-center gap-1.5">
                                    <Settings2 class="w-3.5 h-3.5 text-blue-500/50" /> {{ car.year }}
                                </span>
                                <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                                <span class="flex items-center gap-1.5">
                                    <Users class="w-3.5 h-3.5 text-blue-500/50" /> {{ car.seats }} Seats
                                </span>
                                <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                                <span class="flex items-center gap-1.5">
                                    <Key class="w-3.5 h-3.5 text-blue-500/50" /> {{ car.transmission }}
                                </span>
                            </div>
                            </div>
                        </div>
                    </template>
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
