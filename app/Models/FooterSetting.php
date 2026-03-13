<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    use HasFactory;

    protected $fillable = ['brand_description', 'phone', 'services', 'maps_link', 'copyright_text', 'footer_nav'];

    protected $casts = [
        'services' => 'array',
        'footer_nav' => 'array',
    ];

    public static function getOrDefault()
    {
        return self::first() ?? new self([
            'brand_description' => 'PT. Banyuwangi Trans Wisata — mitra perjalanan terpercaya Anda sejak 2018. Kami melayani sewa mobil dengan sopir dan lepas kunci di seluruh area Banyuwangi.',
            'phone' => '0823-3933-3202',
            'services' => [
                'Sewa Mobil Lepas Kunci',
                'Sewa Mobil + Sopir & BBM',
                'Antar Jemput Bandara Blimbingsari',
                'Paket Wisata Banyuwangi',
                'Drop Off Luar Kota'
            ],
            'maps_link' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3948.63480694391!2d114.3488593!3d-8.2394277!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd145f99fd54fdd%3A0xd68c459bfa1d891!2sTripBanyuwangi!5e0!3m2!1sid!2sid!4v1773287137760!5m2!1sid!2sid',
            'copyright_text' => '© 2026 PT. Banyuwangi Trans Wisata. All rights reserved.',
            'footer_nav' => [
                ['label' => 'Beranda', 'href' => '#home'],
                ['label' => 'Armada', 'href' => '#armada'],
                ['label' => 'Syarat Sewa', 'href' => '#syarat'],
                ['label' => 'Ulasan', 'href' => '#reviews']
            ],
        ]);
    }
}
