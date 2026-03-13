<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StepItem extends Model
{
    protected $fillable = ['title', 'description', 'icon', 'sort_order'];
    protected $casts = ['sort_order' => 'integer'];

    public static function getDefaults(): array
    {
        return [
            ['title' => 'Pilih Armada', 'description' => 'Tentukan unit yang sesuai kebutuhan dan budget Anda.', 'icon' => 'Car'],
            ['title' => 'Konfirmasi via Chat', 'description' => 'Konsultasikan jadwal dan detail perjalanan via WhatsApp.', 'icon' => 'CalendarCheck2'],
            ['title' => 'Siap Berangkat!', 'description' => 'Unit diantarkan ke lokasi Anda. Selamat menikmati perjalanan.', 'icon' => 'Check'],
        ];
    }

    public static function getOrDefault(): array
    {
        $items = static::orderBy('sort_order')->get()->toArray();
        return count($items) > 0 ? $items : static::getDefaults();
    }
}
