<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import {
    CarFront, Menu, X, ChevronRight, ChevronLeft, ChevronUp, Star, Users, Settings2, Key, UserCheck,
    Check, AlertCircle, Quote, ArrowRight, MapPin, Phone, ShieldCheck, Heart, Map, Clock, CheckCircle,
    CheckCircle2, Sparkles, Trophy, Users2, Zap, Car, CalendarCheck2, HelpCircle, ListOrdered, FileText
} from 'lucide-vue-next';

const props = defineProps({
    cars: {
        type: Array,
        default: () => [],
    },
    hero: {
        type: Object,
        default: () => ({}),
    },
    stats: {
        type: Array,
        default: () => [],
    },
    features: {
        type: Array,
        default: () => [],
    },
    steps: {
        type: Array,
        default: () => [],
    },
    terms: {
        type: Object,
        default: () => ({}),
    },
});

const isMenuOpen = ref(false);
const activeFaq = ref(null);
const toggleMenu = () => { isMenuOpen.value = !isMenuOpen.value; };
const toggleFaq = (i) => { activeFaq.value = activeFaq.value === i ? null : i; };
const orderWhatsApp = (name, type = '') => {
    const msg = encodeURIComponent(`Halo, saya ingin memesan ${name}${type ? ' paket ' + type : ''}. Mohon info ketersediaannya?`);
    window.open(`https://wa.me/6282339333202?text=${msg}`, '_blank');
};

// Stats — use from server prop; defaults are already resolved server-side via StatItem::getOrDefault()
const statValues = ref(props.stats.map(() => 0));
const statsRef = ref(null);
const statsAnimated = ref(false);

const animateStat = (index, target, duration = 1800) => {
    const start = performance.now();
    const update = (now) => {
        const elapsed = now - start;
        const progress = Math.min(elapsed / duration, 1);
        // Ease out cubic
        const eased = 1 - Math.pow(1 - progress, 3);
        statValues.value[index] = Math.round(eased * target);
        if (progress < 1) requestAnimationFrame(update);
    };
    requestAnimationFrame(update);
};

onMounted(() => {
    // Stats count-up observer
    const statsObserver = new IntersectionObserver(
        (entries) => {
            if (entries[0].isIntersecting && !statsAnimated.value) {
                statsAnimated.value = true;
                props.stats.forEach((stat, i) => {
                    if (stat.target !== null && stat.target !== undefined) animateStat(i, Number(stat.target));
                });
            }
        },
        { threshold: 0.3 }
    );
    if (statsRef.value) statsObserver.observe(statsRef.value);
});

const defaultCars = [
    { name: 'New Avanza', image: '/image/New-Avanza-Silver-Metallic-2019.jpg', seats: 7, transmission: 'AT/MT', year: 2022, price_sopir: 'Rp. 600.000', price_lepas: 'Rp. 350.000 /24 jam', tag: 'Populer' },
    { name: 'New Innova Reborn', image: '/image/inova reboon.webp', seats: 7, transmission: 'Matic', year: 2023, price_sopir: 'Rp. 950.000 /12 jam', price_lepas: 'Rp. 750.000 /24 jam' },
    { name: 'Hiace Commuter', image: '/image/Hiace Commuter.jpg', seats: 15, transmission: 'Manual', year: 2021, price_sopir: 'Rp. 1.100.000 /12 jam', price_lepas: null, tag: 'Grup Besar' },
    { name: 'Pajero Sport', image: '/image/Pajero.jpg', seats: 7, transmission: 'Matic', year: 2023, price_sopir: 'Rp. 2.000.000', price_lepas: 'Rp. 1.700.000 /24 jam' },
    { name: 'New Innova Zenix', image: '/image/New-Zenix.webp', seats: 7, transmission: 'Hybrid/AT', year: 2024, price_sopir: 'Rp. 1.200.000', price_lepas: 'Rp. 900.000 /24 jam' },
    { name: 'New Veloz', image: '/image/New-Veloz.webp', seats: 7, transmission: 'AT/MT', year: 2024, price_sopir: 'Rp. 650.000', price_lepas: 'Rp. 400.000 /24 jam' },
    { name: 'Toyota Fortuner VRZ', image: '/image/Fortuner.jpg', seats: 7, transmission: 'Matic', year: 2023, price_sopir: 'Rp. 1.800.000', price_lepas: 'Rp. 1.500.000 /24 jam' },
    { name: 'Hiace Premio', image: '/image/Hiace Premi.jpeg', seats: 12, transmission: 'AT', year: 2022, price_sopir: 'Rp. 1.400.000 /12 jam', price_lepas: null, tag: 'Kemewahan Grup' },
    { name: 'Toyota Alphard', image: '/image/Alphard.webp', seats: 7, transmission: 'Matic', year: 2022, price_sopir: 'Rp. 3.500.000 /12 jam', price_lepas: null, tag: 'Premium' },
];

const allCars = computed(() => {
    return props.cars && props.cars.length > 0 ? props.cars : defaultCars;
});

const showAllCars = ref(false);
const displayedCars = computed(() => {
    return showAllCars.value ? allCars.value : allCars.value.slice(0, 8);
});

// Helper for dynamic feature icons
const featureIcons = {
    Trophy, Users2, Sparkles, Zap, ShieldCheck, Heart, Car, Map, Clock, CheckCircle: CheckCircle2
};
const getFeatureIcon = (iconName) => {
    return featureIcons[iconName] || CheckCircle2;
};

// Helper for dynamic feature colors
const colorGradients = {
    blue: 'from-blue-500 to-blue-600',
    emerald: 'from-emerald-500 to-emerald-600',
    amber: 'from-amber-500 to-orange-500',
    purple: 'from-purple-500 to-purple-600',
    rose: 'from-rose-500 to-rose-600',
    slate: 'from-slate-500 to-slate-600',
};
const getFeatureColor = (theme) => {
    return colorGradients[theme] || 'from-blue-500 to-blue-600';
};
// Helper for dynamic step icons
const stepIcons = {
    Car, CalendarCheck2, Check, CheckCircle2, ShieldCheck, Clock, MapPin, Phone, UserCheck, Star, Zap
};
const getStepIcon = (iconName) => {
    return stepIcons[iconName] || CheckCircle2;
};

const stepsRef = ref(null);
const stepsVisible = ref(false);

onMounted(() => {
    // Steps slide-in observer
    const stepsObserver = new IntersectionObserver(
        (entries) => {
            if (entries[0].isIntersecting) stepsVisible.value = true;
        },
        { threshold: 0.25 }
    );
    if (stepsRef.value) stepsObserver.observe(stepsRef.value);
});

const faqs = [
    { q: 'Apakah bisa sewa mobil lepas kunci?', a: 'Ya, kami melayani lepas kunci dengan syarat E-KTP, KK, dan SIM A aktif, serta jaminan.' },
    { q: 'Bagaimana jika terjadi kendala selama perjalanan?', a: 'Kami menyediakan bantuan darurat 24 jam. Tim kami akan segera merespons dan mengirim unit pengganti bila diperlukan.' },
    { q: 'Apakah harga sudah include BBM dan sopir?', a: 'Ada dua paket: Dengan Sopir + BBM (all-in) dan Lepas Kunci (unit saja). Detail harga tertera di setiap kartu armada.' },
    { q: 'Bisa antar jemput bandara atau stasiun?', a: 'Tentu! Kami melayani antar-jemput di Bandara Blimbingsari, Stasiun Banyuwangi Kota, maupun hotel Anda.' },
    { q: 'Berapa biaya overtime jika terlambat mengembalikan?', a: 'Toleransi 30 menit, setelah itu dikenakan biaya tambahan 10% dari harga sewa per jam.' },
];

const testimonials = [
    { name: 'Susi Kiki', role: 'Wisatawan', avatar: 'https://ui-avatars.com/api/?name=Susi+Kiki&background=3b82f6&color=fff&bold=true', text: 'Puas banget! Driver sangat ramah dan hafal tempat wisata. Mobil bersih dan nyaman. Highly recommended!', label: 'Dengan Sopir · 6 Bulan Lalu', rating: 5 },
    { name: 'CV Unggas Jaya', role: 'Mitra Bisnis', avatar: 'https://ui-avatars.com/api/?name=Unggas+Jaya&background=10b981&color=fff&bold=true', text: 'Lepas kunci Innova Reborn, antar ke bandara Blimbingsari. Mobil baru, wangi, dan yang antar sangat ramah. Gak ribet sama sekali!', label: 'Lepas Kunci · 2 Bulan Lalu', rating: 5 },
    { name: 'Rida Setiani', role: 'Wisatawan Keluarga', avatar: 'https://ui-avatars.com/api/?name=Rida+Setiani&background=8b5cf6&color=fff&bold=true', text: 'Pelayanan sangat memuaskan, mobil prima, driver hafal jalan dan enak diajak ngobrol. Terima kasih Banyuwangi Trans Wisata!', label: 'Wisata Keluarga · 1 Tahun Lalu', rating: 5 },
];

const duplicatedTestimonials = [...testimonials, ...testimonials, ...testimonials];

// Scroll to Top Logic
const showScrollTop = ref(false);

const checkScroll = () => {
    showScrollTop.value = window.scrollY > 300;
};

const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

onMounted(() => {
    window.addEventListener('scroll', checkScroll);
});
onUnmounted(() => {
    window.removeEventListener('scroll', checkScroll);
});

</script>

<template>

    <Head>
        <title>Rental Mobil Banyuwangi - Sewa Murah Terpercaya | Lepas Kunci & Sopir</title>
        <meta name="description"
            content="Sewa mobil Banyuwangi murah & terpercaya. Armada Avanza, Innova, Hiace, Fortuner, Alphard. Layanan Lepas Kunci & Dengan Sopir. Respon cepat, harga transparan.">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap"
            rel="stylesheet">
    </Head>

    <div class="bg-white text-slate-800 scroll-smooth" style="font-family: 'Plus Jakarta Sans', sans-serif;">

        <!-- ========= NAVBAR ========= -->
        <nav
            class="fixed top-0 w-full z-50 transition-all duration-300 bg-white/90 backdrop-blur-xl shadow-sm border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <!-- Logo -->
                    <a href="/" class="flex items-center gap-2.5 group">
                        <div
                            class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200 group-hover:scale-105 transition-transform">
                            <CarFront class="w-5 h-5 text-white" />
                        </div>
                        <span class="text-lg font-black text-slate-900">Rental<span
                                class="text-blue-600">Banyuwangi</span></span>
                    </a>

                    <!-- Desktop Nav -->
                    <div class="hidden md:flex items-center gap-8">
                        <a href="#home"
                            class="text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors">Beranda</a>
                        <a href="#armada"
                            class="text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors">Armada</a>
                        <a href="#syarat"
                            class="text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors">Syarat
                            Sewa</a>
                        <a href="#reviews"
                            class="text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors">Ulasan</a>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="https://wa.me/6282339333202" target="_blank"
                            class="hidden sm:flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all active:scale-95 shadow-lg shadow-emerald-200">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#25D366"
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.164-.173.199-.347.223-.644.075-.297-.148-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </svg>
                            WhatsApp
                        </a>
                        <button @click="toggleMenu"
                            class="md:hidden w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 hover:bg-slate-200 transition-colors">
                            <Menu v-if="!isMenuOpen" class="w-5 h-5" />
                            <X v-else class="w-5 h-5" />
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div v-show="isMenuOpen" class="md:hidden border-t border-slate-100 bg-white px-4 py-5 space-y-1">
                <a href="#home" @click="isMenuOpen = false"
                    class="block px-4 py-3 rounded-xl font-semibold text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">Beranda</a>
                <a href="#armada" @click="isMenuOpen = false"
                    class="block px-4 py-3 rounded-xl font-semibold text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">Armada</a>
                <a href="#syarat" @click="isMenuOpen = false"
                    class="block px-4 py-3 rounded-xl font-semibold text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">Syarat
                    Sewa</a>
                <a href="#reviews" @click="isMenuOpen = false"
                    class="block px-4 py-3 rounded-xl font-semibold text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">Ulasan</a>
                <div class="pt-3">
                    <a href="https://wa.me/6282339333202"
                        class="flex items-center justify-center gap-2.5 bg-emerald-500 text-white py-3.5 rounded-2xl font-bold text-sm">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#ffffff"
                                d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.164-.173.199-.347.223-.644.075-.297-.148-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                        </svg>
                        Chat WhatsApp
                    </a>
                </div>
            </div>
        </nav>

        <!-- ========= HERO ========= -->
        <section id="home"
            class="relative pt-28 pb-20 md:pt-36 md:pb-28 overflow-hidden bg-gradient-to-b from-slate-50 to-white">
            <div class="absolute inset-0 pointer-events-none">
                <div
                    class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-100 rounded-full blur-[120px] opacity-60 -translate-y-1/2 translate-x-1/4">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-emerald-100 rounded-full blur-[100px] opacity-50 translate-y-1/3 -translate-x-1/4">
                </div>
            </div>

            <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
                <!-- Badge -->
                <div
                    class="inline-flex items-center gap-2 bg-white border border-slate-200 shadow-sm rounded-full px-4 py-1.5 mb-8">
                    <div class="flex text-yellow-400">
                        <Star v-for="i in 5" :key="i" class="w-3.5 h-3.5 fill-current" />
                    </div>
                    <span class="text-xs font-bold text-slate-600">{{ hero.badge_text }}</span>
                </div>

                <!-- Headline -->
                <h1
                    class="text-4xl md:text-6xl lg:text-7xl font-black text-slate-900 leading-[1.1] mb-6 tracking-tight">
                    {{ hero.headline }} <br class="hidden sm:block">
                    <span class="text-blue-600">{{ hero.headline_highlight }}</span> {{ hero.headline_suffix }}<br>
                    <span class="text-2xl md:text-3xl lg:text-4xl font-bold text-slate-500">{{ hero.subheadline }}</span>
                </h1>

                <p class="text-base md:text-lg text-slate-500 mb-10 max-w-2xl mx-auto leading-relaxed">
                    {{ hero.description }}
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a :href="hero.cta_primary_url"
                        class="group inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-bold text-base transition-all active:scale-95 shadow-xl shadow-blue-200">
                        {{ hero.cta_primary_text }}
                        <ChevronRight class="w-5 h-5 group-hover:translate-x-1 transition-transform" />
                    </a>
                    <a :href="`https://wa.me/${hero.whatsapp_number}`" target="_blank"
                        class="inline-flex items-center justify-center gap-2.5 bg-white hover:bg-slate-50 border-2 border-slate-200 text-slate-700 px-8 py-4 rounded-2xl font-bold text-base transition-all active:scale-95">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#25D366"
                                d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.164-.173.199-.347.223-.644.075-.297-.148-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                        </svg>
                        {{ hero.cta_secondary_text }}
                    </a>
                </div>
            </div>
        </section>

        <!-- ========= STATS ========= -->
        <section ref="statsRef" class="py-14 bg-blue-600">
            <div class="max-w-5xl mx-auto px-4">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div v-for="(stat, i) in stats" :key="stat.label ?? i" class="text-center">
                        <p class="text-3xl md:text-4xl font-black text-white mb-1 tabular-nums">
                            <template v-if="stat.fixed_value || stat.fixed">{{ stat.fixed_value || stat.fixed }}</template>
                            <template v-else>{{ statValues[i].toLocaleString('id-ID') }}{{ stat.suffix }}</template>
                        </p>
                        <p class="text-sm text-blue-100 font-semibold">{{ stat.label }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========= ARMADA CATALOG ========= -->
        <section id="armada" class="py-20 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-14">
                    <span
                        class="inline-block bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4">Koleksi
                        Armada</span>
                    <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-4">Pilihan Sewa Mobil Banyuwangi</h2>
                    <p class="text-slate-500 max-w-xl mx-auto">Semua unit kondisi prima, pajak hidup, dan terawat
                        berkala di
                        bengkel resmi.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    <template v-for="car in displayedCars" :key="car.name">
                        <div v-if="car"
                            class="bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                        <!-- Image -->
                        <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                            <img :src="car.image_url || car.image" :alt="car.name"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div v-if="car.tag"
                                class="absolute top-3 left-3 bg-blue-600 text-white text-[9px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                {{ car.tag }}
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="p-4 flex flex-col grow">
                            <h3 class="font-black text-slate-900 text-sm mb-3">{{ car.name }}</h3>

                            <!-- Prices -->
                            <div class="space-y-2 mb-4 grow">
                                <div class="bg-blue-50 rounded-xl p-3">
                                    <p class="text-[10px] text-blue-400 font-bold uppercase tracking-wider mb-0.5">
                                        Dengan Sopir
                                        + BBM</p>
                                    <p class="text-sm font-black text-blue-700">{{ car.price_sopir }}</p>
                                </div>
                                <div class="bg-slate-50 rounded-xl p-3">
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">
                                        Lepas Kunci
                                    </p>
                                    <p class="text-sm font-bold"
                                        :class="car.price_lepas ? 'text-slate-700' : 'text-slate-300'">
                                        {{ car.price_lepas || 'Tidak Tersedia' }}</p>
                                </div>
                            </div>

                            <!-- Specs -->
                            <div
                                class="flex items-center gap-3 pt-3 border-t border-slate-100 text-[10px] font-semibold text-slate-400 mb-3">
                                <span class="flex items-center gap-1">
                                    <Settings2 class="w-3 h-3" /> {{ car.year }}
                                </span>
                                <span class="text-slate-200">|</span>
                                <span class="flex items-center gap-1">
                                    <Users class="w-3 h-3" /> {{ car.seats }} seat
                                </span>
                                <span class="text-slate-200">|</span>
                                <span class="flex items-center gap-1">
                                    <Key class="w-3 h-3" /> {{ car.transmission }}
                                </span>
                            </div>

                            <!-- CTA -->
                            <button @click="orderWhatsApp(car.name)"
                                class="w-full py-3 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-black uppercase tracking-widest transition-all active:scale-95">
                                Pesan Sekarang
                            </button>
                        </div>
                    </div>
                </template>
            </div>

                <div v-if="cars.length > 8" class="mt-12 text-center">
                    <button @click="showAllCars = !showAllCars"
                        class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold text-sm px-8 py-3.5 rounded-xl shadow-sm hover:shadow-md transition-all active:scale-95 group">
                        {{ showAllCars ? 'Tampilkan Lebih Sedikit' : 'Lihat Semua Armada' }}
                        <ChevronUp v-if="showAllCars" class="w-4 h-4" />
                        <ChevronRight v-else class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                    </button>
                </div>
            </div>
        </section>

        <!-- ========= WHY CHOOSE US ========= -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <span
                            class="inline-block bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-5">Mengapa
                            Kami?</span>
                        <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-5 leading-tight">Standar
                            Layanan<br>yang
                            Kami Jaga</h2>
                        <p class="text-slate-500 mb-10 leading-relaxed">Kami bukan sekadar rental mobil. Kami hadir
                            sebagai
                            mitra perjalanan Anda — memberikan keamanan, kenyamanan, dan kemudahan di setiap kilometer.
                        </p>

                        <div class="grid sm:grid-cols-2 gap-5">
                            <div v-for="feature in features" :key="feature.title"
                                class="group p-5 rounded-2xl bg-slate-50 hover:bg-white hover:shadow-md border border-transparent hover:border-slate-100 transition-all cursor-default">
                                <div
                                    :class="['w-11 h-11 rounded-xl bg-gradient-to-br flex items-center justify-center mb-4 shadow-lg group-hover:scale-110 transition-transform', getFeatureColor(feature.color_theme)]">
                                    <component :is="getFeatureIcon(feature.icon)" class="w-5 h-5 text-white" />
                                </div>
                                <h4 class="font-black text-slate-900 text-sm mb-1">{{ feature.title }}</h4>
                                <p class="text-slate-500 text-xs leading-relaxed">{{ feature.description || feature.desc }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative hidden lg:block">
                        <div class="absolute -inset-6 bg-blue-500/5 rounded-[3rem]"></div>
                        <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&q=80&w=800"
                            alt="Premium Service" class="rounded-3xl w-full object-cover shadow-2xl relative z-10">
                        <!-- Floating badge -->
                        <div
                            class="absolute bottom-6 left-6 z-20 bg-white rounded-2xl p-4 shadow-xl border border-slate-100 flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center">
                                <ShieldCheck class="w-5 h-5 text-white" />
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-900">Terpercaya Sejak 2018</p>
                                <p class="text-[10px] text-slate-400 font-medium">Ribuan perjalanan sukses</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========= HOW IT WORKS ========= -->
        <section class="py-24 bg-slate-900 overflow-hidden">
            <div class="max-w-5xl mx-auto px-4 text-center">
                <span
                    class="inline-block bg-white/10 text-blue-300 text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-5">Cara
                    Memesan</span>
                <h2 class="text-3xl md:text-4xl font-black text-white mb-16">3 Langkah Mudah Sewa Mobil</h2>

                <!-- Cards with slide-in animation -->
                <div ref="stepsRef" class="grid md:grid-cols-3 gap-6 relative">
                    <!-- Connector line -->
                    <div
                        class="hidden md:block absolute top-12 left-[18%] right-[18%] h-px bg-gradient-to-r from-transparent via-blue-500/50 to-transparent">
                    </div>

                    <!-- Step Cards (Dynamic) -->
                    <div v-for="(step, i) in steps" :key="step.title"
                        class="flex flex-col items-center p-8 rounded-3xl backdrop-blur-sm transition-all duration-700"
                        :class="[
                            i === 1 ? 'border border-blue-500/50 bg-blue-600/20' : 'border border-white/10 bg-white/5',
                            stepsVisible 
                                ? 'opacity-100 translate-x-0 translate-y-0 scale-100' 
                                : `opacity-0 ${i === 1 ? 'translate-y-16 scale-95' : (i === 0 ? '-translate-x-20' : 'translate-x-20')}`
                        ]"
                        :style="{ transitionDelay: `${i * 200}ms` }">
                        <div class="relative w-24 h-24 flex items-center justify-center mb-6">
                            <div class="absolute inset-0 rounded-3xl" 
                                :class="i === 1 ? 'bg-blue-400/20 animate-pulse' : (i === 0 ? 'bg-blue-500/20' : 'bg-emerald-500/20')"></div>
                            <div class="w-20 h-20 rounded-2xl flex items-center justify-center shadow-xl relative group-hover:scale-110 transition-transform"
                                :class="i === 1 ? 'bg-gradient-to-br from-indigo-400 to-blue-600 shadow-blue-900/50' : (i === 0 ? 'bg-gradient-to-br from-blue-500 to-blue-700 shadow-blue-900/50' : 'bg-gradient-to-br from-emerald-500 to-teal-600 shadow-emerald-900/50')">
                                <component :is="getStepIcon(step.icon)" class="w-10 h-10 text-white" />
                                <span class="absolute -top-2 -right-2 w-7 h-7 bg-white rounded-full flex items-center justify-center text-xs font-black shadow-lg"
                                    :class="i === 1 ? 'text-blue-600' : (i === 0 ? 'text-blue-600' : 'text-emerald-600')">
                                    {{ i + 1 }}
                                </span>
                            </div>
                        </div>
                        <h4 class="text-white font-black text-xl mb-3 text-center">{{ step.title }}</h4>
                        <p class="text-slate-400 text-sm leading-relaxed text-center">{{ step.description || step.desc }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========= TERMS ========= -->
        <section id="syarat" class="py-20 bg-white">
            <div class="max-w-5xl mx-auto px-4">
                <div class="text-center mb-14">
                    <span
                        class="inline-block bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4">Persyaratan</span>
                    <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-4">Syarat & Ketentuan Sewa</h2>
                    <p class="text-slate-500">Proses mudah dan tidak berbelit. Berikut syarat yang diperlukan.</p>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Lepas Kunci -->
                    <div class="rounded-2xl border-2 border-blue-100 bg-blue-50/30 p-8">
                        <div class="flex items-center gap-4 mb-7">
                            <div
                                class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200">
                                <Key class="w-6 h-6 text-white" />
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-900">Lepas Kunci</h3>
                                <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Self Drive</p>
                            </div>
                        </div>
                        <ul class="space-y-3.5">
                            <li v-for="item in terms.lepas_kunci_items"
                                :key="item" class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                                    <Check class="w-3 h-3 text-blue-600" />
                                </div>
                                <span class="text-sm font-semibold text-slate-700">{{ item }}</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Dengan Sopir -->
                    <div class="rounded-2xl border-2 border-emerald-100 bg-emerald-50/30 p-8">
                        <div class="flex items-center gap-4 mb-7">
                            <div
                                class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200">
                                <UserCheck class="w-6 h-6 text-white" />
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-900">Dengan Sopir</h3>
                                <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Driver + BBM
                                </p>
                            </div>
                        </div>
                        <ul class="space-y-3.5">
                            <li v-for="item in terms.dengan_sopir_items"
                                :key="item" class="flex items-center gap-3">
                                <div
                                    class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                                    <Check class="w-3 h-3 text-emerald-600" />
                                </div>
                                <span class="text-sm font-semibold text-slate-700">{{ item }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Overtime Notice -->
                <div class="mt-6 bg-amber-50 border border-amber-200 rounded-2xl p-6 flex flex-col md:flex-row items-center gap-6">
                    <div class="flex items-center gap-3 text-amber-600">
                        <AlertCircle class="w-6 h-6 shrink-0" />
                        <div>
                            <p class="font-black text-slate-900 text-sm">Kebijakan Keterlambatan</p>
                            <p class="text-slate-500 text-xs mt-0.5">{{ terms.overtime_desc }}</p>
                        </div>
                    </div>
                    <div class="md:ml-auto text-center md:text-right flex items-center gap-3">
                        <div class="text-left w-full md:w-auto">
                            <p class="text-[10px] uppercase font-bold text-amber-500 tracking-wider mb-0.5">Denda Overtime</p>
                            <div class="flex items-baseline gap-1 justify-center md:justify-end">
                                <span class="text-3xl font-black text-amber-600 leading-none">+{{ terms.overtime_percentage }}</span>
                                <span class="text-xl font-black text-amber-600 leading-none">%</span>
                            </div>
                            <p class="text-[10px] font-bold text-slate-400 mt-1">DARI HARGA SEWA</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========= FAQ ========= -->
        <section class="py-20 bg-slate-50">
            <div class="max-w-3xl mx-auto px-4">
                <div class="text-center mb-12">
                    <span
                        class="inline-block bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4">FAQ</span>
                    <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-4">Pertanyaan Umum</h2>
                    <p class="text-slate-500">Hal-hal yang sering ditanyakan pelanggan kami.</p>
                </div>

                <div class="space-y-3">
                    <div v-for="(faq, i) in faqs" :key="i"
                        class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
                        <button @click="toggleFaq(i)"
                            class="w-full flex items-center justify-between px-6 py-5 text-left focus:outline-none">
                            <span class="font-bold text-slate-800 text-sm pr-4">{{ faq.q }}</span>
                            <ChevronRight
                                :class="['w-5 h-5 text-slate-400 shrink-0 transition-transform duration-300', activeFaq === i ? 'rotate-90 text-blue-500' : '']" />
                        </button>
                        <div v-show="activeFaq === i" class="px-6 pb-5">
                            <div class="h-px bg-slate-100 mb-4"></div>
                            <p class="text-slate-500 text-sm leading-relaxed">{{ faq.a }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="mt-8 bg-blue-600 rounded-2xl p-6 flex flex-col md:flex-row items-center justify-between gap-5">
                    <div>
                        <p class="font-black text-white text-lg">Masih ada pertanyaan?</p>
                        <p class="text-blue-100 text-sm">Admin kami online 24 jam untuk membantu Anda.</p>
                    </div>
                    <a href="https://wa.me/6282339333202" target="_blank"
                        class="whitespace-nowrap px-7 py-3 bg-white text-blue-600 rounded-xl font-black text-sm hover:bg-blue-50 transition-all active:scale-95">
                        Tanya Sekarang
                    </a>
                </div>
            </div>
        </section>

        <!-- ========= TESTIMONIALS ========= -->
        <section id="reviews" class="py-20 bg-white">
            <div class="max-w-6xl mx-auto px-4">
                <div class="text-center mb-12">
                    <span
                        class="inline-block bg-yellow-50 text-yellow-600 text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4">Ulasan
                        Pelanggan</span>
                    <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-2">Kata Mereka Tentang Kami</h2>
                    <div class="flex items-center justify-center gap-1.5 mt-4">
                        <div class="flex text-yellow-400">
                            <Star v-for="i in 5" :key="i" class="w-5 h-5 fill-current" />
                        </div>
                        <span class="text-slate-500 font-semibold text-sm ml-2">4.8/5 dari 50+ ulasan Google</span>
                    </div>
                </div>

                <!-- Marquee Container -->
                <div class="relative max-w-[100vw] overflow-hidden -mx-4 md:mx-auto mt-12 py-4 mask-edges">
                    <div class="flex gap-6 animate-marquee w-max hover:[animation-play-state:paused]">
                        <!-- Loop the duplicated list twice inside the flex track to ensure seamless scroll -->
                        <div v-for="(t, idx) in [...duplicatedTestimonials, ...duplicatedTestimonials]" :key="idx"
                            class="w-80 md:w-96 shrink-0">
                            <div
                                class="bg-slate-50 rounded-2xl p-7 border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col h-full cursor-grab active:cursor-grabbing">
                                <!-- Stars -->
                                <div class="flex text-yellow-400 mb-5">
                                    <Star v-for="i in t.rating" :key="i" class="w-4 h-4 fill-current" />
                                </div>
                                <!-- Content -->
                                <p class="text-slate-600 text-sm leading-relaxed mb-6 grow italic">"{{ t.text }}"</p>
                                <!-- Author -->
                                <div class="flex items-center gap-3 pt-5 border-t border-slate-200">
                                    <img :src="t.avatar" :alt="t.name" class="w-10 h-10 rounded-full">
                                    <div>
                                        <p class="font-black text-slate-900 text-sm">{{ t.name }}</p>
                                        <p class="text-[10px] text-slate-400 font-semibold">{{ t.label }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 text-center">
                    <a href="https://maps.google.com" target="_blank"
                        class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors group">
                        Lihat Semua Ulasan di Google Maps
                        <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                    </a>
                </div>
            </div>
        </section>

        <!-- ========= FINAL CTA ========= -->
        <section class="py-20 bg-slate-50">
            <div class="max-w-3xl mx-auto px-4 text-center">
                <div class="bg-slate-900 rounded-3xl p-12 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-80 h-80 bg-blue-500/10 rounded-full blur-[100px]"></div>
                    <div class="absolute bottom-0 left-0 w-60 h-60 bg-emerald-500/10 rounded-full blur-[80px]"></div>

                    <div class="relative z-10">
                        <h2 class="text-3xl md:text-4xl font-black text-white mb-4 leading-tight">
                            Siap Jelajahi<br><span class="text-blue-400">Banyuwangi?</span>
                        </h2>
                        <p class="text-slate-400 mb-10 font-medium">Hubungi kami sekarang dan dapatkan penawaran terbaik
                            untuk
                            perjalanan Anda.</p>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="https://wa.me/6282339333202" target="_blank"
                                class="inline-flex items-center justify-center gap-2.5 bg-emerald-500 hover:bg-emerald-400 text-white px-8 py-4 rounded-2xl font-black text-base transition-all active:scale-95 shadow-xl shadow-emerald-900/20">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="#ffffff"
                                        d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.164-.173.199-.347.223-.644.075-.297-.148-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                </svg>
                                Chat WhatsApp
                            </a>
                            <a href="#armada"
                                class="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white px-8 py-4 rounded-2xl font-bold text-base transition-all">
                                Katalog Armada
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========= FOOTER ========= -->
        <footer class="bg-slate-950 pt-20 pb-10">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-6 mb-16">
                    <!-- Brand -->
                    <div class="lg:col-span-4 md:col-span-2 max-w-sm">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/50">
                                <CarFront class="w-5 h-5 text-white" />
                            </div>
                            <span class="text-xl font-black text-white tracking-tight">Rental<span
                                    class="text-blue-500">Banyuwangi</span></span>
                        </div>
                        <p class="text-slate-400 text-sm leading-relaxed mb-8">
                            PT. Banyuwangi Trans Wisata — mitra perjalanan terpercaya Anda sejak 2018. Kami melayani
                            sewa mobil
                            dengan sopir dan lepas kunci di seluruh area Banyuwangi.
                        </p>
                        <div
                            class="flex items-center gap-3 text-slate-300 text-sm font-medium bg-white/5 w-fit px-4 py-2.5 rounded-xl border border-white/5">
                            <Phone class="w-4 h-4 text-emerald-400" />
                            <span>0823-3933-3202</span>
                            <span
                                class="w-1.5 h-1.5 rounded-full bg-emerald-400 ml-2 animate-pulse shadow-[0_0_8px_rgba(52,211,153,0.8)]"></span>
                            <span class="text-emerald-400 text-xs font-bold uppercase tracking-wider">Online 24/7</span>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="lg:col-span-2">
                        <h5
                            class="text-white font-bold text-sm tracking-widest mb-6 border-b border-white/10 pb-3 inline-block">
                            NAVIGASI</h5>
                        <ul class="space-y-4">
                            <li v-for="link in [{ label: 'Beranda', href: '#home' }, { label: 'Armada', href: '#armada' }, { label: 'Syarat Sewa', href: '#syarat' }, { label: 'Ulasan', href: '#reviews' }]"
                                :key="link.label">
                                <a :href="link.href"
                                    class="text-slate-400 hover:text-white text-sm font-medium transition-colors flex items-center gap-2 group">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full bg-blue-600 opacity-0 -ml-3 group-hover:opacity-100 group-hover:ml-0 transition-all"></span>
                                    {{ link.label }}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Services -->
                    <div class="lg:col-span-3">
                        <h5
                            class="text-white font-bold text-sm tracking-widest mb-6 border-b border-white/10 pb-3 inline-block">
                            LAYANAN UTAMA</h5>
                        <ul class="space-y-4">
                            <li v-for="svc in ['Sewa Mobil Lepas Kunci', 'Sewa Mobil + Sopir & BBM', 'Antar Jemput Bandara Blimbingsari', 'Paket Wisata Banyuwangi', 'Drop Off Luar Kota']"
                                :key="svc">
                                <span
                                    class="text-slate-400 hover:text-white transition-colors cursor-default text-sm font-medium flex items-center gap-2">
                                    <Check class="w-3.5 h-3.5 text-blue-500" />
                                    {{ svc }}
                                </span>
                            </li>
                        </ul>
                    </div>

                    <!-- Map -->
                    <div class="lg:col-span-3 w-full">
                        <h5
                            class="text-white font-bold text-sm tracking-widest mb-6 border-b border-white/10 pb-3 inline-block">
                            LOKASI KAMI</h5>
                        <div
                            class="rounded-xl overflow-hidden h-32 lg:h-40 border border-white/10 shadow-lg shadow-black/50">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3948.63480694391!2d114.3488593!3d-8.2394277!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd145f99fd54fdd%3A0xd68c459bfa1d891!2sTripBanyuwangi!5e0!3m2!1sid!2sid!4v1773287137760!5m2!1sid!2sid"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                class="grayscale hover:grayscale-0 transition-all duration-500">
                            </iframe>
                        </div>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-slate-600 text-xs font-medium">© 2026 PT. Banyuwangi Trans Wisata. All rights
                        reserved.</p>
                    <div class="flex gap-6">
                        <a href="#" class="text-slate-600 hover:text-slate-400 text-xs transition-colors">Kebijakan
                            Privasi</a>
                        <a href="#" class="text-slate-600 hover:text-slate-400 text-xs transition-colors">Syarat
                            Penggunaan</a>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Floating Action Buttons (Sticky Right Bottom) -->
        <div class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-50 flex flex-col gap-2.5 sm:gap-3">
            <!-- Scroll to Top Button -->
            <button @click="scrollToTop"
                class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-400 hover:bg-yellow-500 text-blue-900 rounded-full flex items-center justify-center shadow-lg hover:scale-110 active:scale-95 transition-all focus:outline-none group relative"
                :class="showScrollTop ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0 pointer-events-none'">
                <ChevronUp class="w-5 h-5 sm:w-6 sm:h-6" />
                <span
                    class="absolute right-full mr-3 top-1/2 -translate-y-1/2 bg-slate-900 text-white text-xs font-bold px-3 py-1.5 rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none shadow-xl hidden sm:block">
                    Ke Atas
                </span>
            </button>

            <!-- Call Button -->
            <a href="tel:082339333202"
                class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-600 hover:bg-blue-700 text-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 active:scale-95 transition-all focus:outline-none group relative">
                <Phone class="w-4 h-4 sm:w-5 sm:h-5 fill-current" />
                <span
                    class="absolute right-full mr-3 top-1/2 -translate-y-1/2 bg-slate-900 text-white text-xs font-bold px-3 py-1.5 rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none shadow-xl hidden sm:block">
                    Telepon Kami
                </span>
            </a>

            <!-- WhatsApp Button -->
            <a href="https://wa.me/6282339333202" target="_blank"
                class="w-10 h-10 sm:w-12 sm:h-12 bg-[#25D366] hover:bg-[#20bd5a] text-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 active:scale-95 transition-all focus:outline-none group relative">
                <svg class="w-5 h-5 sm:w-7 sm:h-7" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#ffffff"
                        d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.164-.173.199-.347.223-.644.075-.297-.148-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                </svg>
                <span
                    class="absolute right-full mr-3 top-1/2 -translate-y-1/2 bg-slate-900 text-white text-xs font-bold px-3 py-1.5 rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none shadow-xl hidden sm:block">
                    Chat WhatsApp
                </span>
            </a>
        </div>

    </div>
</template>

<style scoped>
html {
    scroll-behavior: smooth;
}

.mask-edges {
    -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
    mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
}

@keyframes marquee {
    0% {
        transform: translateX(0);
    }

    100% {
        transform: translateX(-50%);
    }
}

.animate-marquee {
    animation: marquee 60s linear infinite;
}
</style>
