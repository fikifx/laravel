<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import {
    LayoutDashboard, Car, LayoutTemplate, BarChart3, Star, ListOrdered, FileText,
    LogOut, User, ChevronRight, ExternalLink,
    Menu, X, MessageCircleQuestion, Zap
} from 'lucide-vue-next';

const page = usePage();
const user = computed(() => page.props.auth.user);
const sidebarOpen = ref(false);

const navGroups = [
    {
        label: 'Umum',
        links: [
            { label: 'Dashboard', route: 'dashboard', icon: LayoutDashboard },
        ],
    },
    {
        label: 'Kelola Konten',
        links: [
            { label: 'Hero Section',  route: 'hero.edit',     icon: LayoutTemplate },
            { label: 'Stats Section', route: 'stats.edit',    icon: BarChart3 },
            { label: 'Kelola Armada', route: 'armada.index',  icon: Car },
            { label: 'Keunggulan',    route: 'features.edit', icon: Star },
            { label: 'Cara Memesan',  route: 'steps.edit',    icon: ListOrdered },
            { label: 'Syarat Sewa',   route: 'terms.edit',    icon: FileText },
            { label: 'Pertanyaan Umum', route: 'faqs.edit', icon: MessageCircleQuestion },
            { label: 'Ulasan Pelanggan', route: 'reviews.edit', icon: Star },
            { label: 'CTA Section', route: 'cta.edit', icon: Zap },
            { label: 'Footer Section', route: 'footer.edit', icon: LayoutTemplate },
        ],
    },
];

const isActive = (routeName) => {
    try { return route().current(routeName); } catch { return false; }
};
</script>

<template>
    <div style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <div class="min-h-screen bg-slate-50 flex">

            <!-- ===== SIDEBAR ===== -->
            <!-- Overlay (mobile) -->
            <div v-if="sidebarOpen" @click="sidebarOpen = false"
                class="fixed inset-0 bg-slate-900/50 z-30 lg:hidden backdrop-blur-sm"></div>

            <!-- Sidebar panel -->
            <aside
                class="fixed top-0 left-0 h-full w-64 bg-slate-900 z-40 flex flex-col transition-transform duration-300 ease-in-out"
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

                <!-- Logo -->
                <div class="px-5 py-5 border-b border-white/5">
                    <Link :href="route('dashboard')" class="flex items-center gap-3 group">
                        <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/50 group-hover:scale-105 transition-transform shrink-0">
                            <Car class="w-5 h-5 text-white" />
                        </div>
                        <div class="leading-none">
                            <span class="text-sm font-black text-white">Rental<span class="text-blue-400">Banyuwangi</span></span>
                            <span class="block text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Admin Panel</span>
                        </div>
                    </Link>
                </div>

                <!-- Nav Links -->
                <nav class="flex-1 overflow-y-auto py-5 px-3 space-y-6">
                    <div v-for="group in navGroups" :key="group.label">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3 mb-2">{{ group.label }}</p>
                        <div class="space-y-1">
                            <Link v-for="link in group.links" :key="link.route"
                                :href="route(link.route)"
                                @click="sidebarOpen = false"
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold transition-all duration-150 group"
                                :class="isActive(link.route)
                                    ? 'bg-blue-600 text-white shadow-md shadow-blue-900/50'
                                    : 'text-slate-400 hover:text-white hover:bg-white/5'">
                                <component :is="link.icon"
                                    class="w-4 h-4 shrink-0 transition-colors"
                                    :class="isActive(link.route) ? 'text-white' : 'text-slate-500 group-hover:text-white'" />
                                {{ link.label }}
                                <ChevronRight v-if="isActive(link.route)" class="w-3.5 h-3.5 ml-auto opacity-60" />
                            </Link>
                        </div>
                    </div>
                </nav>

                <!-- Bottom: View Site + User -->
                <div class="border-t border-white/5 p-3 space-y-2">
                    <a href="/" target="_blank"
                        class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-bold text-slate-400 hover:text-white hover:bg-white/5 transition-all">
                        <ExternalLink class="w-4 h-4 text-slate-500" />
                        Lihat Landing Page
                    </a>
                    <Link :href="route('profile.edit')"
                        class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-bold text-slate-400 hover:text-white hover:bg-white/5 transition-all">
                        <User class="w-4 h-4 text-slate-500" />
                        Profil Saya
                    </Link>
                    <Link :href="route('logout')" method="post" as="button"
                        class="flex items-center gap-2.5 w-full px-3 py-2.5 rounded-xl text-sm font-bold text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all">
                        <LogOut class="w-4 h-4" />
                        Keluar
                    </Link>

                    <!-- User Info -->
                    <div class="flex items-center gap-3 px-3 py-3 rounded-xl bg-white/5 mt-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center text-white text-xs font-black shrink-0">
                            {{ user.name?.charAt(0).toUpperCase() }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-black text-white truncate">{{ user.name }}</p>
                            <p class="text-[10px] text-slate-500 truncate">{{ user.email }}</p>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- ===== MAIN CONTENT ===== -->
            <div class="flex-1 lg:ml-64 flex flex-col min-h-screen">

                <!-- Top bar (mobile + header slot) -->
                <header class="sticky top-0 z-20 bg-white/90 backdrop-blur-xl border-b border-slate-100 shadow-sm">
                    <div class="flex items-center gap-4 px-4 sm:px-6 h-14">
                        <!-- Mobile hamburger -->
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="lg:hidden w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 hover:bg-slate-200 transition-colors shrink-0">
                            <Menu v-if="!sidebarOpen" class="w-5 h-5 text-slate-600" />
                            <X v-else class="w-5 h-5 text-slate-600" />
                        </button>

                        <!-- Page Header slot -->
                        <div class="flex-1 min-w-0">
                            <slot name="header" />
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1">
                    <slot />
                </main>

            </div>
        </div>
    </div>
</template>
