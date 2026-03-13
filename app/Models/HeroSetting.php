<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSetting extends Model
{
    protected $fillable = [
        'badge_text',
        'headline',
        'headline_highlight',
        'headline_suffix',
        'subheadline',
        'description',
        'cta_primary_text',
        'cta_primary_url',
        'cta_secondary_text',
        'whatsapp_number',
    ];

    /**
     * Get the singleton hero setting, or return defaults if not set.
     */
    public static function getOrDefault(): array
    {
        $hero = static::first();

        return [
            'badge_text'          => $hero?->badge_text          ?? 'Rating 4.8/5 · 2000+ Pelanggan Puas',
            'headline'            => $hero?->headline             ?? 'Sewa Mobil',
            'headline_highlight'  => $hero?->headline_highlight   ?? 'Banyuwangi',
            'headline_suffix'     => $hero?->headline_suffix      ?? 'Murah',
            'subheadline'         => $hero?->subheadline          ?? 'Lepas Kunci & Dengan Sopir',
            'description'         => $hero?->description          ?? 'Armada terbaru Avanza, Innova, Hiace, Fortuner, Alphard siap mengantar perjalanan Anda. Harga transparan, respon cepat, sopir berpengalaman.',
            'cta_primary_text'    => $hero?->cta_primary_text     ?? 'Lihat Semua Armada',
            'cta_primary_url'     => $hero?->cta_primary_url      ?? '#armada',
            'cta_secondary_text'  => $hero?->cta_secondary_text   ?? 'Konsultasi Gratis',
            'whatsapp_number'     => $hero?->whatsapp_number      ?? '6282339333202',
        ];
    }
}
