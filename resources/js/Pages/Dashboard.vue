<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Car, Plus, ExternalLink, ArrowRight, LayoutDashboard } from 'lucide-vue-next';

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({ totalArmada: 0 }),
    },
});

const username = () => {
    try {
        return window.__page?.props?.auth?.user?.name || 'Admin';
    } catch { return 'Admin'; }
};

const quickActions = [
    {
        label: 'Tambah Armada Baru',
        desc: 'Tambahkan unit kendaraan ke katalog',
        route: 'armada.create',
        icon: Plus,
        color: 'from-blue-500 to-indigo-600',
        shadow: 'shadow-blue-200',
    },
    {
        label: 'Kelola Armada',
        desc: 'Edit, hapus, atau kelola unit armada',
        route: 'armada.index',
        icon: Car,
        color: 'from-emerald-500 to-teal-600',
        shadow: 'shadow-emerald-200',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-100 rounded-xl flex items-center justify-center">
                    <LayoutDashboard class="w-4 h-4 text-blue-600" />
                </div>
                <div>
                    <h2 class="font-black text-xl text-slate-800 leading-tight">Dashboard</h2>
                    <p class="text-xs text-slate-400 font-medium">Selamat datang di panel admin</p>
                </div>
            </div>
        </template>

        <div class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

                <!-- Welcome Banner -->
                <div class="relative bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 rounded-3xl p-8 overflow-hidden">
                    <!-- Background decorations -->
                    <div class="absolute top-0 right-0 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-indigo-500/10 rounded-full blur-2xl pointer-events-none"></div>
                    <!-- Dot grid -->
                    <div class="absolute inset-0 opacity-[0.03]"
                        style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 24px 24px;">
                    </div>

                    <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div>
                            <p class="text-blue-300 text-sm font-bold uppercase tracking-widest mb-2">Selamat Datang 👋</p>
                            <h1 class="text-2xl md:text-3xl font-black text-white mb-2">
                                Panel Admin <span class="text-blue-400">Rental Banyuwangi</span>
                            </h1>
                            <p class="text-slate-400 text-sm max-w-lg">
                                Kelola semua konten landing page Anda dari sini. Tambah, edit, dan hapus data armada serta konten lainnya secara real-time.
                            </p>
                        </div>
                        <a href="/" target="_blank"
                            class="shrink-0 inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/10 text-white px-5 py-3 rounded-2xl text-sm font-bold transition-all active:scale-95 backdrop-blur-sm">
                            <ExternalLink class="w-4 h-4" />
                            Lihat Landing Page
                        </a>
                    </div>
                </div>

                <!-- Stats Row -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex items-center gap-5 hover:shadow-md transition-all">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 shrink-0">
                            <Car class="w-7 h-7 text-white" />
                        </div>
                        <div>
                            <p class="text-3xl font-black text-slate-900">{{ props.stats.totalArmada }}</p>
                            <p class="text-sm font-semibold text-slate-400">Total Unit Armada</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex items-center gap-5 hover:shadow-md transition-all">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200 shrink-0">
                            <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/><circle cx="12" cy="10" r="3"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-3xl font-black text-slate-900">1</p>
                            <p class="text-sm font-semibold text-slate-400">Lokasi Pelayanan</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex items-center gap-5 hover:shadow-md transition-all">
                        <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg shadow-amber-200 shrink-0">
                            <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-3xl font-black text-slate-900">4.8</p>
                            <p class="text-sm font-semibold text-slate-400">Rating Pelanggan</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div>
                    <h3 class="text-base font-black text-slate-700 mb-4">Aksi Cepat</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        <Link v-for="action in quickActions" :key="action.route"
                            :href="route(action.route)"
                            class="group bg-white rounded-2xl border border-slate-100 shadow-sm p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex items-center gap-5">
                            <div :class="`w-12 h-12 bg-gradient-to-br ${action.color} rounded-2xl flex items-center justify-center shadow-lg ${action.shadow} shrink-0 group-hover:scale-110 transition-transform`">
                                <component :is="action.icon" class="w-6 h-6 text-white" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-black text-slate-900 text-sm">{{ action.label }}</p>
                                <p class="text-xs text-slate-400 font-medium mt-0.5 truncate">{{ action.desc }}</p>
                            </div>
                            <ArrowRight class="w-4 h-4 text-slate-300 shrink-0 group-hover:text-blue-500 group-hover:translate-x-1 transition-all" />
                        </Link>
                    </div>
                </div>

                <!-- Info Footer -->
                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-black text-slate-800">Tentang Panel Admin</p>
                        <p class="text-xs text-slate-500 mt-0.5">Semua perubahan data yang Anda lakukan di sini akan langsung terlihat di halaman landing page secara real-time. Tidak perlu restart server.</p>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
