<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureItem extends Model
{
    protected $fillable = ['title', 'description', 'icon', 'color_theme', 'sort_order'];
    protected $casts = ['sort_order' => 'integer'];

    public static function getDefaults(): array
    {
        return [
            ['title' => 'Armada Terawat', 'description' => 'Semua unit kami keluaran terbaru dengan perawatan rutin di bengkel resmi.', 'icon' => 'Trophy', 'color_theme' => 'blue'],
            ['title' => 'Sopir Berpengalaman', 'description' => 'Driver ramah, profesional, dan hafal rute wisata Banyuwangi.', 'icon' => 'Users2', 'color_theme' => 'emerald'],
            ['title' => 'Harga Transparan', 'description' => 'Harga yang kami kutip adalah harga final. Tanpa biaya tersembunyi.', 'icon' => 'Sparkles', 'color_theme' => 'amber'],
            ['title' => 'Respon 24/7', 'description' => 'Admin siap membantu Anda kapan saja melalui WhatsApp.', 'icon' => 'Zap', 'color_theme' => 'purple'],
        ];
    }

    public static function getOrDefault(): array
    {
        $items = static::orderBy('sort_order')->get()->toArray();
        return count($items) > 0 ? $items : static::getDefaults();
    }
}
