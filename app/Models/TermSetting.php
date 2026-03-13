<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermSetting extends Model
{
    protected $fillable = [
        'lepas_kunci_items',
        'dengan_sopir_items',
        'overtime_percentage',
        'overtime_desc'
    ];

    protected $casts = [
        'lepas_kunci_items'   => 'array',
        'dengan_sopir_items'  => 'array',
        'overtime_percentage' => 'integer',
    ];

    public static function getDefaults(): array
    {
        return [
            'lepas_kunci_items' => [
                'E-KTP & Kartu Keluarga (KK) Asli',
                'SIM A Aktif & Wajib Ditunjukkan',
                'Jaminan Motor + STNK / Deposit',
                'Survei khusus untuk pelanggan baru'
            ],
            'dengan_sopir_items' => [
                'Durasi standar 12 jam/hari',
                'BBM ditanggung dalam paket harga',
                'Sopir ramah, profesional & hafal rute',
                'Bisa request driver untuk wisata'
            ],
            'overtime_percentage' => 10,
            'overtime_desc'       => 'Toleransi 30 menit. Lebih dari itu dikenakan biaya overtime.'
        ];
    }

    public static function getOrDefault(): array
    {
        $setting = static::first();
        if ($setting) {
            return $setting->toArray();
        }
        return static::getDefaults();
    }
}
