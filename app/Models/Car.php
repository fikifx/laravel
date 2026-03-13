<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'seats',
        'transmission',
        'year',
        'price_sopir',
        'price_lepas',
        'tag',
    ];

    /**
     * Get the URL for the car image.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        // Fallback ke file lokal no image.jpg di folder public/image
        return asset('image/no image.jpg');
    }

    protected $appends = ['image_url'];
}
