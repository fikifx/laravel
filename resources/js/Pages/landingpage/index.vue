<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { 
    CarFront, Menu, X, MessageCircle, ChevronRight, 
    Star, Users, Settings2, Key, UserCheck, 
    Check, AlertCircle, Quote, ArrowRight, 
    MapPin, MapPinned, Phone, Clock, ShieldCheck, 
    Sparkles, Utensils
} from 'lucide-vue-next';

const isMenuOpen = ref(false);

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};

const orderWhatsApp = (carName) => {
    const message = encodeURIComponent(`Halo, saya ingin memesan sewa mobil ${carName}. Bisa bantu cek ketersediaannya?`);
    window.open(`https://wa.me/6282339333202?text=${message}`, '_blank');
};

const stats = [
    { value: '50+', label: 'Unit Armada' },
    { value: '24/7', label: 'Layanan Pelanggan' },
    { value: '0%', label: 'Biaya Tersembunyi' },
    { value: '100%', label: 'Kondisi Prima' }
];

const cars = [
    {
        name: 'New Avanza (AT/MT)',
        image: '/image/New-Avanza-Silver-Metallic-2019.jpg',
        seats: '7 Kursi',
        trans: 'AT/MT',
        price: '350.000',
        tag: 'Populer'
    },
    {
        name: 'New Innova Reborn',
        image: '/image/inova reboon.webp',
        seats: '7 Kursi',
        trans: 'Auto',
        price: '750.000'
    },
    {
        name: 'Hiace Commuter',
        image: '/image/Hiace Commuter.jpg',
        seats: '15 Kursi',
        trans: 'Manual',
        price: '1.100.000',
        tag: 'Grup Besar'
    },
    {
        name: 'Pajero Sport',
        image: '/image/Pajero.jpg',
        seats: '7 Kursi',
        trans: 'Auto',
        price: '1.700.000'
    },
    {
        name: 'New Innova Zenix',
        image: '/image/New-Zenix.webp',
        seats: '7 Kursi',
        trans: 'Hybrid/AT',
        price: '900.000'
    },
    {
        name: 'New Veloz (AT/MT)',
        image: '/image/New-Veloz.webp',
        seats: '7 Kursi',
        trans: 'AT/MT',
        price: '400.000'
    },
    {
        name: 'Toyota Fortuner VRZ',
        image: '/image/Fortuner.jpg',
        seats: '7 Kursi',
        trans: 'Auto',
        price: '1.500.000'
    },
    {
        name: 'Hiace Premio',
        image: '/image/Hiace Premi.jpeg',
        seats: '12 Kursi',
        trans: 'Manual/AT',
        price: '1.400.000',
        tag: 'Kemewahan Grup'
    },
    {
        name: 'Toyota Alphard',
        image: '/image/Alphard.webp',
        seats: '6 Kursi',
        trans: 'VIP AT',
        price: '3.500.000',
        tag: 'Premium'
    }
];

const testimonials = [
    {
        name: 'Susi Kiki',
        role: 'Verified Customer',
        avatar: 'https://ui-avatars.com/api/?name=Susi+Kiki&background=random',
        content: '"Puas dgn pelayanannya, driver dan fotografernya sll memberikan rekomended tempat makan yg baik, sedikit saran utk dokumentasi kl bisa menggunakan kamera DSLR agar hasilnya lbh bagus lg. Kami sangat puas menggunakan PT. Banyuwangi Trans Wisata"',
        info: 'Sewa Dengan Sopir • 6 Bulan Lalu'
    },
    {
        name: 'CV Unggas Jaya',
        role: 'Bussiness Partner',
        avatar: 'CJ', // Initials
        content: '"Rental innova reborn lepas kunci... Mobil di anter kebandara Blimbingsari.. Mobil baru, bersih, wangi rental mobil lepas kunci yg gak ribet..yg nganterin mobil juga sangat ramah..trans wisata banyuwangi terimakasih."',
        info: 'Lepas Kunci • 2 Bulan Lalu'
    },
    {
        name: 'Rida Setiani',
        role: 'Local Guide',
        avatar: 'https://ui-avatars.com/api/?name=Rida+Setiani&background=random',
        content: '"Happy Banget Pelayanan sangat memuaskan. kondisi Mobil prima. Driver hafal jalan.. nyambung diajak ngobrol dan Sopan. Terimakasih banyuwangi trans wisata 🥰"',
        info: 'Wisata Keluarga • 1 Tahun Lalu'
    }
];
</script>

<template>
    <Head>
        <title>Rental Mobil Banyuwangi - Sewa Mobil Murah & Terpercaya</title>
        <meta name="description" content="Sewa Mobil Murah & Terpercaya di Banyuwangi. Armada terbaru (Avanza, Innova, Hiace) dengan layanan Lepas Kunci atau Dengan Sopir. Hubungi kami sekarang!">
    </Head>

    <div class="bg-slate-50 text-slate-900 font-sans selection:bg-blue-100 selection:text-blue-900 scroll-smooth">
        <!-- Navigation -->
        <nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-xl border-b border-slate-200/50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex-shrink-0 flex items-center gap-2 group cursor-pointer">
                        <div class="bg-blue-600 p-2 rounded-xl group-hover:scale-110 transition-transform duration-300">
                            <CarFront class="text-white w-6 h-6" />
                        </div>
                        <span class="text-xl font-extrabold tracking-tight text-slate-900">Rental<span class="text-blue-600">Banyuwangi</span></span>
                    </div>
                    
                    <div class="hidden md:flex space-x-10">
                        <a href="#home" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition-colors">Home</a>
                        <a href="#armada" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition-colors">Armada</a>
                        <a href="#syarat" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition-colors">Syarat & Ketentuan</a>
                        <a href="#reviews" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition-colors">Ulasan</a>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <a href="#armada" class="hidden sm:inline-block bg-blue-600 text-white px-6 py-3 rounded-full text-sm font-bold hover:bg-black transition-all shadow-xl shadow-blue-200 active:scale-95">
                            Sewa Sekarang
                        </a>
                        <button @click="toggleMenu" class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
                            <Menu v-if="!isMenuOpen" class="w-6 h-6 animate-in fade-in zoom-in" />
                            <X v-else class="w-6 h-6 animate-in fade-in zoom-in" />
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div v-show="isMenuOpen" class="md:hidden bg-white border-t border-slate-100 overflow-hidden transition-all duration-300 transform" 
                 :class="{'translate-y-0 opacity-100': isMenuOpen, '-translate-y-4 opacity-0': !isMenuOpen}">
                <div class="px-6 py-8 space-y-6">
                    <a href="#home" @click="isMenuOpen = false" class="block text-lg font-bold text-slate-900 border-b border-slate-50 pb-2">Home</a>
                    <a href="#armada" @click="isMenuOpen = false" class="block text-lg font-bold text-slate-900 border-b border-slate-50 pb-2">Armada</a>
                    <a href="#syarat" @click="isMenuOpen = false" class="block text-lg font-bold text-slate-900 border-b border-slate-50 pb-2">Syarat & Ketentuan</a>
                    <a href="#reviews" @click="isMenuOpen = false" class="block text-lg font-bold text-slate-900 border-b border-slate-50 pb-2">Ulasan</a>
                    <div class="pt-4">
                        <a href="https://wa.me/6282339333202" class="flex items-center justify-center gap-3 bg-emerald-500 text-white py-4 rounded-2xl font-black shadow-xl shadow-emerald-100 active:scale-95 transition-transform">
                            <MessageCircle class="w-6 h-6" />
                            Chat WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section id="home" class="relative pt-28 pb-12 md:pt-40 md:pb-20 overflow-hidden">
            <div class="absolute top-0 right-0 -z-10 opacity-30 transform translate-x-1/2 -translate-y-1/4">
                <div class="w-[600px] h-[600px] bg-blue-400 rounded-full blur-[150px]"></div>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
                <div class="text-center max-w-4xl mx-auto">
                    <div class="inline-flex items-center gap-2 bg-white border border-slate-200 shadow-sm rounded-full px-5 py-2 mb-8 animate-bounce hover:scale-105 transition-transform cursor-default">
                        <div class="flex text-yellow-500">
                            <Star v-for="i in 5" :key="i" class="w-4 h-4 fill-current" />
                        </div>
                        <span class="text-xs font-black text-slate-700">4.7/5 (48 Ulasan Google)</span>
                    </div>
                    
                    <h1 class="text-5xl md:text-7xl font-black text-slate-900 leading-[1.1] mb-8 tracking-tighter">
                        Sewa Mobil <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600">Banyuwangi Murah</span> - Lepas Kunci & Sopir
                    </h1>
                    
                    <p class="text-lg md:text-xl text-slate-500 mb-10 leading-relaxed max-w-3xl mx-auto font-medium">
                        Sewa mobil Banyuwangi terbaik dengan armada terbaru: <span class="text-blue-600 font-bold">Avanza, Innova Reborn, Zenix, Hiace & Fortuner.</span> Melayani sewa mobil lepas kunci atau dengan sopir berpengalaman. <span class="text-slate-900 font-bold underline decoration-blue-500 decoration-4">Respon Cepat & Harga Transparan.</span>
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="#armada" class="group w-full sm:w-auto px-8 py-4 bg-blue-600 text-white rounded-2xl font-black text-lg hover:bg-black transition-all shadow-xl shadow-blue-200 flex items-center justify-center gap-2 active:scale-95">
                            Pilih Armada
                            <ChevronRight class="w-5 h-5 group-hover:translate-x-2 transition-transform" />
                        </a>
                        <a href="https://wa.me/6282339333202" target="_blank" class="w-full sm:w-auto px-8 py-4 bg-emerald-500 text-white rounded-2xl font-black text-lg hover:bg-emerald-600 transition-all shadow-xl shadow-emerald-200 flex items-center justify-center gap-2 active:scale-95">
                            <MessageCircle class="w-6 h-6" />
                            Chat WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-12 bg-white border-y border-slate-100">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div v-for="stat in stats" :key="stat.label" class="text-center group cursor-default">
                        <p class="text-3xl md:text-4xl font-black text-blue-600 mb-1 group-hover:scale-110 transition-transform duration-300">{{ stat.value }}</p>
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-widest">{{ stat.label }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Catalog Section -->
        <section id="armada" class="py-24 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-20">
                    <span class="text-blue-600 font-black text-xs uppercase tracking-[0.3em] mb-4 inline-block">Koleksi Armada Terbaru</span>
                    <h2 class="text-4xl md:text-5xl font-black text-slate-900 mb-6 tracking-tight tracking-tighter">Pilihan Sewa Mobil Terbaik di Banyuwangi</h2>
                    <p class="text-slate-500 max-w-2xl mx-auto text-lg font-medium">Temukan mobil yang sesuai dengan gaya dan budget perjalanan Anda. Semua unit dalam kondisi prima dan terawat.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="car in cars" :key="car.name" class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-slate-100 group">
                        <div class="relative aspect-[16/10] overflow-hidden">
                            <img :src="car.image" :alt="car.name" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div v-if="car.tag" class="absolute top-4 left-4 bg-blue-600/90 backdrop-blur-md text-white text-[10px] font-black px-4 py-2 rounded-full uppercase tracking-widest">
                                {{ car.tag }}
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-slate-900 mb-2">{{ car.name }}</h3>
                            <div class="flex items-center gap-4 mb-6 text-slate-500 font-bold text-sm">
                                <div class="flex items-center gap-1">
                                    <Users class="w-4 h-4 text-blue-500" />
                                    <span>{{ car.seats }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <Settings2 class="w-4 h-4 text-blue-500" />
                                    <span>{{ car.trans }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                                <div>
                                    <p class="text-[10px] text-slate-400 uppercase font-black tracking-widest mb-1">Mulai Dari</p>
                                    <p class="text-2xl font-black text-slate-900">Rp {{ car.price }}<span class="text-sm font-bold text-slate-400 lowercase">/hari</span></p>
                                </div>
                                <button @click="orderWhatsApp(car.name)" class="bg-emerald-500 hover:bg-black text-white p-3 rounded-2xl transition-all shadow-lg active:scale-90">
                                    <MessageCircle class="w-6 h-6" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Terms Section -->
        <section id="syarat" class="py-24 bg-white">
            <div class="max-w-6xl mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-black text-slate-900 mb-6 tracking-tight">Syarat Sewa Mobil Mudah</h2>
                    <div class="w-20 h-1.5 bg-blue-600 mx-auto rounded-full mb-6"></div>
                    <p class="text-slate-500 text-lg font-medium">Proses sewa mobil di Banyuwangi kini lebih praktis tanpa ribet.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                    <!-- Lepas Kunci -->
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl blur opacity-10 group-hover:opacity-20 transition duration-500"></div>
                        <div class="relative bg-white border border-slate-100 rounded-3xl p-8 h-full shadow-sm hover:shadow-xl transition-all">
                            <div class="flex items-center gap-4 mb-8">
                                <div class="bg-blue-600 text-white p-3 rounded-2xl shadow-xl shadow-blue-100">
                                    <Key class="w-6 h-6" />
                                </div>
                                <div>
                                    <h3 class="text-2xl font-black text-slate-900">Lepas Kunci</h3>
                                    <p class="text-xs font-black text-blue-600 uppercase tracking-widest">Sewa Mobil Lepas Kunci Banyuwangi</p>
                                </div>
                            </div>
                            <ul class="space-y-4">
                                <li v-for="item in ['E-KTP & Kartu Keluarga (KK) Asli', 'SIM A Aktif & Wajib ditunjukkan', 'Jaminan Motor + STNK / Deposit', 'Survei khusus pelanggan baru']" :key="item" class="flex items-start gap-4">
                                    <div class="w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center shrink-0 mt-0.5">
                                        <Check class="w-3 h-3 text-blue-600 font-bold" />
                                    </div>
                                    <span class="text-slate-600 font-bold text-base leading-tight">{{ item }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Dengan Sopir -->
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-3xl blur opacity-10 group-hover:opacity-20 transition duration-500"></div>
                        <div class="relative bg-white border border-slate-100 rounded-3xl p-8 h-full shadow-sm hover:shadow-xl transition-all">
                            <div class="flex items-center gap-4 mb-8">
                                <div class="bg-emerald-600 text-white p-3 rounded-2xl shadow-xl shadow-emerald-100">
                                    <UserCheck class="w-6 h-6" />
                                </div>
                                <div>
                                    <h3 class="text-2xl font-black text-slate-900">Dengan Sopir</h3>
                                    <p class="text-xs font-black text-emerald-600 uppercase tracking-widest">Sewa Mobil Dengan Sopir Banyuwangi</p>
                                </div>
                            </div>
                            <ul class="space-y-4">
                                <li v-for="item in ['Durasi sewa standar 12 jam/hari', 'Eksclude BBM, Parkir, Tol & Makan', 'Sopir Ramah, Pro & Hafal Rute']" :key="item" class="flex items-start gap-4">
                                    <div class="w-6 h-6 rounded-full bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                                        <Check class="w-3 h-3 text-emerald-600 font-bold" />
                                    </div>
                                    <span class="text-slate-600 font-bold text-base leading-tight">{{ item }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Overtime Banner -->
                <div class="bg-slate-900 rounded-3xl p-10 md:p-16 overflow-hidden relative group">
                    <div class="absolute top-0 right-0 w-80 h-80 bg-blue-600/20 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
                    <div class="flex flex-col md:flex-row items-center justify-between gap-12 relative z-10">
                        <div class="text-center md:text-left flex-1">
                            <div class="inline-flex items-center gap-2 bg-orange-500/20 text-orange-500 px-5 py-2 rounded-full text-xs font-black uppercase tracking-widest mb-6">
                                <AlertCircle class="w-5 h-5" />
                                Kebijakan Overtime
                            </div>
                            <h3 class="text-3xl md:text-4xl font-black text-white mb-4 leading-tight">Terlambat mengembalikan unit?</h3>
                            <p class="text-slate-400 text-lg font-medium">Berapa biaya telat sewa mobil? Kami memberikan toleransi transparan bagi pelanggan kami.</p>
                        </div>
                        <div class="bg-white/5 border border-white/10 backdrop-blur-2xl px-12 py-10 rounded-2xl text-center min-w-[280px] group-hover:scale-105 transition-transform">
                            <p class="text-slate-400 text-sm font-black uppercase tracking-widest mb-2">Biaya Tambahan</p>
                            <p class="text-6xl font-black text-white">10%</p>
                            <p class="text-blue-400 font-black text-xl mt-2 tracking-widest">PER JAM</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section id="reviews" class="py-24 bg-white relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-16">
                    <span class="inline-block px-5 py-2 mb-6 text-xs font-black tracking-widest text-blue-600 uppercase bg-blue-50 rounded-full">
                        Testimoni Sewa Mobil Banyuwangi
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-slate-900 mb-8 tracking-tight">Kisah Puas Dari Pelanggan Kami</h2>
                    <div class="flex items-center justify-center gap-2 mb-4">
                        <div class="flex text-yellow-400">
                            <Star v-for="i in 5" :key="i" class="w-6 h-6 fill-current" />
                        </div>
                    </div>
                    <p class="text-slate-500 font-black text-xl">Rating 4.7/5 • 48 Ulasan Google Terverifikasi</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div v-for="testi in testimonials" :key="testi.name" class="relative group h-full">
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl blur opacity-0 group-hover:opacity-10 transition duration-500"></div>
                        <div class="relative bg-slate-50 rounded-3xl p-8 border border-slate-100 flex flex-col h-full shadow-sm hover:shadow-xl transition-all duration-500">
                            <div class="mb-6 flex items-start justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-xl overflow-hidden shadow-lg border-2 border-white ring-4 ring-blue-50/50">
                                        <img v-if="testi.avatar.startsWith('http')" :src="testi.avatar" :alt="testi.name" class="w-full h-full object-cover">
                                        <div v-else class="w-full h-full bg-blue-600 flex items-center justify-center text-white font-black text-xl">{{ testi.avatar }}</div>
                                    </div>
                                    <div>
                                        <h4 class="font-black text-slate-900 text-base mb-0.5">{{ testi.name }}</h4>
                                        <p class="text-[10px] text-blue-600 font-black uppercase tracking-[0.2em]">{{ testi.role }}</p>
                                    </div>
                                </div>
                                <Quote class="w-10 h-10 text-blue-100/50" />
                            </div>
                            <p class="text-slate-600 leading-relaxed font-bold text-base mb-8 grow italic">
                                {{ testi.content }}
                            </p>
                            <div class="pt-6 border-t border-slate-200/50">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ testi.info }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-20 text-center">
                    <a href="https://maps.google.com" target="_blank" class="inline-flex items-center gap-3 text-slate-900 font-black uppercase tracking-widest text-sm group hover:text-blue-600 transition-colors">
                        Lihat Ulasan Lainnya Di Google Maps
                        <ArrowRight class="w-6 h-6 group-hover:translate-x-3 transition-transform" />
                    </a>
                </div>
            </div>
        </section>

        <!-- Final CTA -->
        <section class="py-24 bg-white overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 relative">
                <div class="bg-gradient-to-br from-blue-700 via-indigo-900 to-slate-900 rounded-[3rem] p-10 md:p-20 text-center relative overflow-hidden shadow-2xl">
                    <div class="absolute top-0 right-0 w-full h-full opacity-20 pointer-events-none">
                        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-white rounded-full blur-[150px] -translate-y-1/2 translate-x-1/2"></div>
                        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-blue-500 rounded-full blur-[150px] translate-y-1/2 -translate-x-1/2"></div>
                    </div>

                    <div class="relative z-10 max-w-4xl mx-auto">
                        <h2 class="text-4xl md:text-7xl font-black text-white mb-8 leading-[1] tracking-tighter">
                            Siap Menjelajahi <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-300 to-indigo-200">Banyuwangi Sekarang?</span>
                        </h2>
                        
                        <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-12">
                            <a href="https://wa.me/6282333202" class="group w-full sm:w-auto px-10 py-5 bg-emerald-500 text-white rounded-2xl font-black text-xl hover:bg-white hover:text-emerald-600 transition-all shadow-2xl shadow-emerald-500/30 flex items-center justify-center gap-3 active:scale-95">
                                <MessageCircle class="w-7 h-7" />
                                Pesan Via WhatsApp
                            </a>
                            <a href="#armada" class="w-full sm:w-auto px-10 py-5 bg-white/10 text-white border-2 border-white/20 rounded-2xl font-black text-xl hover:bg-white hover:text-slate-900 transition-all backdrop-blur-xl">
                                Katalog Armada
                            </a>
                        </div>

                        <div class="flex flex-wrap justify-center gap-10 md:gap-16">
                            <div v-for="feature in [
                                { icon: ShieldCheck, text: '100% Aman', color: 'text-emerald-400' },
                                { icon: Sparkles, text: 'Mobil Bersih', color: 'text-blue-300' },
                                { icon: Utensils, text: 'Driver Friendly', color: 'text-orange-400' }
                            ]" :key="feature.text" class="flex items-center gap-4">
                                <component :is="feature.icon" :class="['w-8 h-8', feature.color]" />
                                <span class="text-white font-black text-lg tracking-wide">{{ feature.text }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer / Contact Section -->
        <footer class="pt-24 pb-12 bg-slate-950 relative overflow-hidden">
            <!-- Background Decorative Elements -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full pointer-events-none opacity-20">
                <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-blue-600 rounded-full blur-[120px]"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-indigo-600 rounded-full blur-[120px]"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <!-- Top Grid: Branding & Quick Info -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 mb-20">
                    <!-- Brand Column -->
                    <div class="lg:col-span-4 space-y-8">
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-600 p-2.5 rounded-2xl shadow-xl shadow-blue-500/20">
                                <CarFront class="text-white w-7 h-7" />
                            </div>
                            <span class="text-2xl font-black tracking-tight text-white focus:outline-none">Rental<span class="text-blue-500">Banyuwangi</span></span>
                        </div>
                        <p class="text-slate-400 text-lg leading-relaxed font-medium">
                            Solusi transportasi terbaik di Banyuwangi. Kami berkomitmen memberikan layanan sewa mobil yang aman, nyaman, dan terjangkau untuk setiap perjalanan Anda.
                        </p>
                        <div class="flex gap-4">
                            <a v-for="i in 4" :key="i" href="#" class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-300">
                                <component :is="[Sparkles, Utensils, ShieldCheck, Star][i-1]" class="w-5 h-5" />
                            </a>
                        </div>
                    </div>

                    <!-- Contact & Map Column -->
                    <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-2 gap-10">
                        <!-- Address Card -->
                        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-[2rem] p-8 hover:bg-white/10 transition-colors group">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 rounded-2xl bg-blue-500/10 flex items-center justify-center group-hover:bg-blue-500 transition-colors">
                                    <MapPin class="w-6 h-6 text-blue-500 group-hover:text-white" />
                                </div>
                                <h4 class="text-white font-black text-xl uppercase tracking-tighter">Lokasi Kantor</h4>
                            </div>
                            <p class="text-slate-300 font-medium leading-relaxed mb-6">
                                Depan Masjid Cheng Ho ke barat dikit, <br>
                                Jl. Sutawijaya, Sumberrejo, <br>
                                Kec. Banyuwangi, Jawa Timur 68419
                            </p>
                            <a href="https://maps.app.goo.gl/..." target="_blank" class="inline-flex items-center gap-2 text-blue-400 font-black text-sm uppercase tracking-widest hover:text-white transition-colors">
                                <MapPinned class="w-4 h-4" />
                                Navigasi Google Maps
                            </a>
                        </div>

                        <!-- Info Card -->
                        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-[2rem] p-8 hover:bg-white/10 transition-colors group">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center group-hover:bg-emerald-500 transition-colors">
                                    <Phone class="w-6 h-6 text-emerald-500 group-hover:text-white" />
                                </div>
                                <h4 class="text-white font-black text-xl uppercase tracking-tighter">Hubungi Kami</h4>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">WhatsApp</span>
                                    <span class="text-white font-black text-lg">0823-3933-3202</span>
                                </div>
                                <div class="flex items-center justify-between border-t border-white/5 pt-4">
                                    <span class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">Operasional</span>
                                    <span class="text-emerald-400 font-black text-lg flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                                        24 JAM
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Layout: Map & Links -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 border-t border-white/5 pt-20">
                    <!-- Map Container -->
                    <div class="lg:col-span-7 rounded-[2.5rem] overflow-hidden border border-white/10 shadow-3xl h-[400px] group relative">
                        <div class="absolute inset-0 bg-blue-600/10 group-hover:bg-transparent transition-colors z-10 pointer-events-none"></div>
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3948.63480694391!2d114.3488593!3d-8.2394277!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd145f99fd54fdd%3A0xd68c459bfa1d891!2sTripBanyuwangi!5e0!3m2!1sid!2sid!4v1773287137760!5m2!1sid!2sid" 
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                            class="grayscale hover:grayscale-0 transition-all duration-700">
                        </iframe>
                    </div>

                    <!-- Quick Links -->
                    <div class="lg:col-span-5 flex flex-col justify-between py-4">
                        <div class="grid grid-cols-2 gap-16">
                            <div class="space-y-6">
                                <h5 class="text-white font-black uppercase text-xs tracking-[0.3em]">Halaman</h5>
                                <ul class="space-y-4">
                                    <li v-for="link in ['Home', 'Armada', 'Syarat', 'Ulasan']" :key="link">
                                        <a href="#" class="text-slate-400 hover:text-blue-500 transition-colors font-bold">{{ link }}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="space-y-6">
                                <h5 class="text-white font-black uppercase text-xs tracking-[0.3em]">Layanan</h5>
                                <ul class="space-y-4">
                                    <li v-for="link in ['Lepas Kunci', 'Dengan Sopir', 'Drop Off', 'Paket Wisata']" :key="link">
                                        <a href="#" class="text-slate-400 hover:text-blue-500 transition-colors font-bold">{{ link }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Brand Statement -->
                        <div class="mt-20 p-8 rounded-3xl bg-blue-600/10 border border-blue-500/20 active:scale-95 transition-transform cursor-default">
                            <p class="text-blue-300 font-bold text-sm italic">
                                "Perjalanan Anda adalah prioritas kami. Nikmati setiap momen di Banyuwangi dengan kenyamanan armada terbaik kami."
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Copyright Bar -->
                <div class="mt-20 pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6">
                    <p class="text-slate-500 font-bold uppercase text-[10px] tracking-[0.3em]">
                        © 2026 PT. Banyuwangi Trans Wisata • <span class="text-slate-700">All Rights Reserved</span>
                    </p>
                    <div class="flex gap-8">
                        <a href="#" class="text-slate-600 hover:text-slate-400 transition-colors text-[10px] font-black uppercase tracking-widest">Privacy Policy</a>
                        <a href="#" class="text-slate-600 hover:text-slate-400 transition-colors text-[10px] font-black uppercase tracking-widest">Terms of Service</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<style>
/* Custom animations or refined styles if needed beyond Tailwind */
@keyframes fade-up {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-up {
    animation: fade-up 0.8s ease-out forwards;
}

html {
    scroll-behavior: smooth;
}

/* Glass effect for active states */
.glass-active {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px font-bold rgba(255, 255, 255, 0.1);
}
</style>
