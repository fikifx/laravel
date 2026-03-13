<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatItem extends Model
{
    protected $fillable = ['label', 'target', 'suffix', 'fixed_value', 'sort_order'];

    protected $casts = ['target' => 'integer', 'sort_order' => 'integer'];

    /**
     * Default stat items — used when DB is empty.
     */
    public static function getDefaults(): array
    {
        return [
            ['label' => 'Unit Armada',         'target' => 50,   'suffix' => '+',   'fixed_value' => null],
            ['label' => 'Tahun Berpengalaman', 'target' => 8,    'suffix' => '+',   'fixed_value' => null],
            ['label' => 'Pelanggan Puas',      'target' => 2000, 'suffix' => '+',   'fixed_value' => null],
            ['label' => 'Siap Melayani',       'target' => null, 'suffix' => null,  'fixed_value' => '24/7'],
        ];
    }

    public static function getOrDefault(): array
    {
        $items = static::orderBy('sort_order')->get()->toArray();
        return count($items) > 0 ? $items : static::getDefaults();
    }
}
