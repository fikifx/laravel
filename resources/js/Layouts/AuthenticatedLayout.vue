<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import {
    LayoutDashboard, Car, ChevronDown, LogOut, User,
    Menu, X, ExternalLink, LayoutTemplate
} from 'lucide-vue-next';

const page = usePage();
const user = computed(() => page.props.auth.user);
const showingNavigationDropdown = ref(false);
const showUserDropdown = ref(false);

const navLinks = [
    { label: 'Dashboard', route: 'dashboard', icon: LayoutDashboard },
    { label: 'Kelola Armada', route: 'armada.index', icon: Car },
    { label: 'Hero Section', route: 'hero.edit', icon: LayoutTemplate },
];
</script>

<template>
    <div style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <div class="min-h-screen bg-slate-50">

            <!-- ===== TOP NAVBAR ===== -->
            <nav class="fixed top-0 w-full z-50 bg-white/90 backdrop-blur-xl border-b border-slate-100 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">

                        <!-- Logo -->
                        <Link :href="route('dashboard')" class="flex items-center gap-2.5 group">
                            <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200 group-hover:scale-105 transition-transform">
                                <Car class="w-5 h-5 text-white" />
                            </div>
                            <div class="leading-none">
                                <span class="text-base font-black text-slate-900">Rental<span class="text-blue-600">Banyuwangi</span></span>
                                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest">Admin Panel</span>
                            </div>
                        </Link>

                        <!-- Desktop Nav Links -->
                        <div class="hidden sm:flex items-center gap-1">
                            <template v-for="link in navLinks" :key="link.route">
                                <Link
                                    :href="route(link.route)"
                                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold transition-all duration-200"
                                    :class="route().current(link.route)
                                        ? 'bg-blue-600 text-white shadow-md shadow-blue-200'
                                        : 'text-slate-500 hover:text-slate-800 hover:bg-slate-100'"
                                >
                                    <component :is="link.icon" class="w-4 h-4" />
                                    {{ link.label }}
                                </Link>
                            </template>
                        </div>

                        <!-- Right Side -->
                        <div class="hidden sm:flex items-center gap-3">
                            <!-- View Landing Page -->
                            <a href="/" target="_blank"
                                class="flex items-center gap-1.5 text-xs font-bold text-slate-400 hover:text-blue-600 transition-colors px-3 py-2 rounded-xl hover:bg-blue-50">
                                <ExternalLink class="w-3.5 h-3.5" />
                                Lihat Landing Page
                            </a>

                            <!-- User Dropdown -->
                            <div class="relative">
                                <button @click="showUserDropdown = !showUserDropdown"
                                    class="flex items-center gap-2.5 pl-3 pr-2 py-2 rounded-xl border border-slate-200 hover:border-blue-300 hover:bg-blue-50/50 transition-all group">
                                    <div class="w-7 h-7 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center text-white text-xs font-black">
                                        {{ user.name?.charAt(0).toUpperCase() }}
                                    </div>
                                    <div class="text-left leading-none">
                                        <p class="text-xs font-black text-slate-800">{{ user.name }}</p>
                                        <p class="text-[10px] text-slate-400 font-medium">Administrator</p>
                                    </div>
                                    <ChevronDown class="w-3.5 h-3.5 text-slate-400 transition-transform" :class="showUserDropdown ? 'rotate-180' : ''" />
                                </button>

                                <!-- Dropdown -->
                                <Transition
                                    enter-active-class="transition duration-150 ease-out"
                                    enter-from-class="opacity-0 scale-95 translate-y-1"
                                    enter-to-class="opacity-100 scale-100 translate-y-0"
                                    leave-active-class="transition duration-100 ease-in"
                                    leave-from-class="opacity-100 scale-100"
                                    leave-to-class="opacity-0 scale-95 translate-y-1"
                                >
                                    <div v-show="showUserDropdown" @click.away="showUserDropdown = false"
                                        class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50 py-1">
                                        <div class="px-4 py-3 border-b border-slate-100">
                                            <p class="text-xs font-black text-slate-900">{{ user.name }}</p>
                                            <p class="text-[11px] text-slate-400">{{ user.email }}</p>
                                        </div>
                                        <Link :href="route('profile.edit')" class="flex items-center gap-2.5 px-4 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                                            <User class="w-4 h-4" />
                                            Profil Saya
                                        </Link>
                                        <Link :href="route('logout')" method="post" as="button"
                                            class="flex items-center gap-2.5 w-full px-4 py-3 text-sm font-semibold text-red-500 hover:bg-red-50 transition-colors">
                                            <LogOut class="w-4 h-4" />
                                            Keluar
                                        </Link>
                                    </div>
                                </Transition>
                            </div>
                        </div>

                        <!-- Mobile Hamburger -->
                        <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="sm:hidden w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 hover:bg-slate-200 transition-colors">
                            <Menu v-if="!showingNavigationDropdown" class="w-5 h-5 text-slate-600" />
                            <X v-else class="w-5 h-5 text-slate-600" />
                        </button>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <Transition
                    enter-active-class="transition duration-200 ease-out"
                    enter-from-class="opacity-0 -translate-y-2"
                    enter-to-class="opacity-100 translate-y-0"
                >
                    <div v-show="showingNavigationDropdown" class="sm:hidden border-t border-slate-100 bg-white px-4 py-4 space-y-1">
                        <template v-for="link in navLinks" :key="link.route">
                            <Link :href="route(link.route)"
                                @click="showingNavigationDropdown = false"
                                class="flex items-center gap-2.5 px-4 py-3 rounded-xl font-bold text-sm transition-all"
                                :class="route().current(link.route)
                                    ? 'bg-blue-600 text-white'
                                    : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'">
                                <component :is="link.icon" class="w-4 h-4" />
                                {{ link.label }}
                            </Link>
                        </template>
                        <div class="border-t border-slate-100 mt-3 pt-3">
                            <div class="flex items-center gap-3 px-4 py-2">
                                <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-black">
                                    {{ user.name?.charAt(0).toUpperCase() }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-800">{{ user.name }}</p>
                                    <p class="text-xs text-slate-400">{{ user.email }}</p>
                                </div>
                            </div>
                            <Link :href="route('profile.edit')" class="flex items-center gap-2 px-4 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50 rounded-xl transition-colors">
                                <User class="w-4 h-4" /> Profil Saya
                            </Link>
                            <Link :href="route('logout')" method="post" as="button"
                                class="flex items-center gap-2 w-full px-4 py-3 text-sm font-semibold text-red-500 hover:bg-red-50 rounded-xl transition-colors">
                                <LogOut class="w-4 h-4" /> Keluar
                            </Link>
                        </div>
                    </div>
                </Transition>
            </nav>

            <!-- Page Header -->
            <header v-if="$slots.header" class="bg-white border-b border-slate-100 pt-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main :class="$slots.header ? '' : 'pt-16'">
                <slot />
            </main>
        </div>
    </div>
</template>
