<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { 
    CarFront, Mail, Lock, LogIn, ChevronRight, 
    ShieldCheck, Sparkles, Key, ArrowLeft, Loader2 
} from 'lucide-vue-next';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const isSubmitting = ref(false);

const submit = () => {
    isSubmitting.value = true;
    form.post(route('login'), {
        onFinish: () => {
            isSubmitting.value = false;
            form.reset('password');
        },
        onError: () => {
            isSubmitting.value = false;
        }
    });
};
</script>

<template>
    <Head title="Login - Rental Mobil Banyuwangi" />

    <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8 bg-slate-50 font-['Plus Jakarta Sans'] selection:bg-blue-100 selection:text-blue-600">
        <!-- Background Decorations -->
        <div class="fixed inset-0 pointer-events-none overflow-hidden">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-100 rounded-full blur-[120px] opacity-60 -translate-y-1/2 translate-x-1/4"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-emerald-100 rounded-full blur-[100px] opacity-50 translate-y-1/3 -translate-x-1/4"></div>
        </div>

        <div class="w-full max-w-[1100px] grid lg:grid-cols-2 bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 overflow-hidden relative z-10 border border-slate-100/50">
            
            <!-- Left Side: Visual/Branding -->
            <div class="hidden lg:flex flex-col justify-between p-12 bg-slate-900 relative overflow-hidden">
                <div class="absolute inset-0">
                    <img 
                        src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&q=80&w=1200" 
                        class="w-full h-full object-cover opacity-30 grayscale"
                        alt="Background"
                    />
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/40 to-slate-900/90"></div>
                </div>

                <div class="relative z-10">
                    <Link href="/" class="flex items-center gap-3 group w-fit">
                        <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20 group-hover:scale-105 transition-transform">
                            <CarFront class="w-5 h-5 text-white" />
                        </div>
                        <span class="text-xl font-black text-white tracking-tight">Rental<span class="text-blue-400">Banyuwangi</span></span>
                    </Link>
                </div>

                <div class="relative z-10 space-y-6">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md rounded-full border border-white/10">
                        <Sparkles class="w-4 h-4 text-blue-300" />
                        <span class="text-xs font-bold text-blue-100 uppercase tracking-widest">Admin Dashboard Access</span>
                    </div>
                    <h2 class="text-4xl xl:text-5xl font-black text-white leading-tight">
                        Kelola Armada & <br> Layanan dengan <br> <span class="text-blue-400">Lebih Mudah.</span>
                    </h2>
                    <p class="text-slate-400 text-lg leading-relaxed max-w-md">
                        Masuk ke dashboard untuk mengatur konten landing page, armada, dan ulasan pelanggan secara real-time.
                    </p>
                </div>

                <div class="relative z-10 flex items-center gap-4 py-4 px-6 bg-white/5 backdrop-blur-sm rounded-2xl border border-white/5 w-fit">
                    <div class="w-10 h-10 bg-emerald-500/20 rounded-xl flex items-center justify-center border border-emerald-500/30">
                        <ShieldCheck class="w-5 h-5 text-emerald-400" />
                    </div>
                    <div>
                        <p class="text-xs font-bold text-white uppercase tracking-wider">Secure Access</p>
                        <p class="text-[10px] text-slate-400 font-medium">End-to-end encrypted connection</p>
                    </div>
                </div>
            </div>

            <!-- Right Side: Login Form -->
            <div class="p-8 sm:p-12 lg:p-16 flex flex-col justify-center">
                <div class="lg:hidden mb-10 flex justify-center">
                    <Link href="/" class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                            <CarFront class="w-5 h-5 text-white" />
                        </div>
                        <span class="text-xl font-black text-slate-900 tracking-tight">Rental<span class="text-blue-600">Banyuwangi</span></span>
                    </Link>
                </div>

                <div class="max-w-md mx-auto w-full space-y-8">
                    <div>
                        <h1 class="text-3xl font-black text-slate-900 mb-2">Selamat Datang 👋</h1>
                        <p class="text-slate-500 font-medium">Silakan masuk untuk mengelola sistem rental Anda.</p>
                    </div>

                    <div v-if="status" class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-sm font-semibold text-emerald-600">
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit" class="space-y-5">
                        <!-- Email Field -->
                        <div class="space-y-2">
                            <label for="email" class="text-sm font-bold text-slate-700 ml-1">Email Address</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <Mail class="w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" />
                                </div>
                                <input
                                    id="email"
                                    type="email"
                                    v-model="form.email"
                                    required
                                    autofocus
                                    placeholder="admin@rentalbanyuwangi.com"
                                    class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all outline-none font-medium placeholder:text-slate-400"
                                />
                            </div>
                            <p v-if="form.errors.email" class="text-xs font-bold text-red-500 mt-1.5 ml-1">{{ form.errors.email }}</p>
                        </div>

                        <!-- Password Field -->
                        <div class="space-y-2">
                            <div class="flex items-center justify-between px-1">
                                <label for="password" class="text-sm font-bold text-slate-700">Password</label>
                                <Link
                                    v-if="canResetPassword"
                                    :href="route('password.request')"
                                    class="text-xs font-bold text-blue-600 hover:text-blue-700 transition-colors"
                                >
                                    Lupa Password?
                                </Link>
                            </div>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <Lock class="w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" />
                                </div>
                                <input
                                    id="password"
                                    type="password"
                                    v-model="form.password"
                                    required
                                    placeholder="••••••••"
                                    class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all outline-none font-medium placeholder:text-slate-400"
                                />
                            </div>
                            <p v-if="form.errors.password" class="text-xs font-bold text-red-500 mt-1.5 ml-1">{{ form.errors.password }}</p>
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center gap-3 px-1">
                            <label class="relative flex items-center cursor-pointer group">
                                <input 
                                    type="checkbox" 
                                    v-model="form.remember"
                                    class="peer sr-only"
                                />
                                <div class="w-5 h-5 bg-slate-100 border-2 border-slate-200 rounded-md peer-checked:bg-blue-600 peer-checked:border-blue-600 transition-all flex items-center justify-center group-hover:border-blue-400 shadow-sm">
                                    <svg v-if="form.remember" class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm font-bold text-slate-600 select-none">Ingat saya untuk sesi berikutnya</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            :disabled="isSubmitting"
                            class="w-full flex items-center justify-center gap-3 px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black text-sm uppercase tracking-widest rounded-2xl shadow-xl shadow-blue-600/20 transition-all active:scale-[0.98] disabled:opacity-70 disabled:grayscale disabled:cursor-not-allowed group"
                        >
                            <Loader2 v-if="isSubmitting" class="w-5 h-5 animate-spin" />
                            <template v-else>
                                Masuk Sekarang
                                <LogIn class="w-5 h-5 group-hover:translate-x-1 transition-transform" />
                            </template>
                        </button>
                    </form>

                    <!-- Back to Home -->
                    <div class="pt-8 text-center border-t border-slate-100 mt-8">
                        <Link href="/" class="inline-flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-blue-600 transition-all group">
                            <ArrowLeft class="w-4 h-4 group-hover:-translate-x-1 transition-transform" />
                            Kembali ke Beranda
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Info -->
        <p class="fixed bottom-6 text-slate-400 text-xs font-bold uppercase tracking-[0.2em] pointer-events-none">
            © 2026 PT. BANYUWANGI TRANS WISATA • SECURE AUTH
        </p>
    </div>
</template>

<style>
/* Gradient Text for certain elements if needed */
.text-gradient {
    background: linear-gradient(to right, #2563eb, #3b82f6);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>
