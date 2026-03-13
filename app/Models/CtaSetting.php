<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtaSetting extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'wa_text', 'wa_number', 'catalog_text', 'catalog_link'];

    public static function getOrDefault()
    {
        return self::first() ?? new self([
            'title' => 'Siap Jelajahi<br><span class="text-blue-400">Banyuwangi?</span>',
            'description' => 'Hubungi kami sekarang dan dapatkan penawaran terbaik untuk perjalanan Anda.',
            'wa_text' => 'Chat WhatsApp',
            'wa_number' => '6282339333202',
            'catalog_text' => 'Katalog Armada',
            'catalog_link' => '#armada',
        ]);
    }
}
