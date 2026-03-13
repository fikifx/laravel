<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewController extends Controller
{
    public function edit()
    {
        return Inertia::render('Reviews/Edit', [
            'reviews' => Review::orderBy('order_index')->get()
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'reviews' => 'array',
            'reviews.*.name' => 'required|string|max:255',
            'reviews.*.role' => 'nullable|string|max:255',
            'reviews.*.text' => 'required|string',
            'reviews.*.label' => 'nullable|string|max:255',
            'reviews.*.rating' => 'required|integer|min:1|max:5',
            'reviews.*.avatar' => 'nullable|string',
        ]);

        Review::truncate();

        foreach ($validated['reviews'] as $index => $item) {
            Review::create([
                'name' => $item['name'],
                'role' => $item['role'],
                'text' => $item['text'],
                'label' => $item['label'],
                'rating' => $item['rating'],
                'avatar' => $item['avatar'] ?? 'https://ui-avatars.com/api/?name='.urlencode($item['name']).'&background=random&color=fff&bold=true',
                'order_index' => $index,
            ]);
        }

        return redirect()->back()->with('message', 'Ulasan Pelanggan berhasil diperbarui!');
    }

    public function reset()
    {
        Review::truncate();
        
        $defaults = [
            [
                'name' => 'Susi Kiki',
                'role' => 'Wisatawan',
                'avatar' => 'https://ui-avatars.com/api/?name=Susi+Kiki&background=3b82f6&color=fff&bold=true',
                'text' => 'Puas banget! Driver sangat ramah dan hafal tempat wisata. Mobil bersih dan nyaman. Highly recommended!',
                'label' => 'Dengan Sopir · 6 Bulan Lalu',
                'rating' => 5
            ],
            [
                'name' => 'CV Unggas Jaya',
                'role' => 'Mitra Bisnis',
                'avatar' => 'https://ui-avatars.com/api/?name=Unggas+Jaya&background=10b981&color=fff&bold=true',
                'text' => 'Lepas kunci Innova Reborn, antar ke bandara Blimbingsari. Mobil baru, wangi, dan yang antar sangat ramah. Gak ribet sama sekali!',
                'label' => 'Lepas Kunci · 2 Bulan Lalu',
                'rating' => 5
            ],
            [
                'name' => 'Rida Setiani',
                'role' => 'Wisatawan Keluarga',
                'avatar' => 'https://ui-avatars.com/api/?name=Rida+Setiani&background=8b5cf6&color=fff&bold=true',
                'text' => 'Pelayanan sangat memuaskan, mobil prima, driver hafal jalan dan enak diajak ngobrol. Terima kasih Banyuwangi Trans Wisata!',
                'label' => 'Wisata Keluarga · 1 Tahun Lalu',
                'rating' => 5
            ],
        ];

        foreach ($defaults as $i => $item) {
            Review::create([
                'name' => $item['name'],
                'role' => $item['role'],
                'avatar' => $item['avatar'],
                'text' => $item['text'],
                'label' => $item['label'],
                'rating' => $item['rating'],
                'order_index' => $i,
            ]);
        }

        return redirect()->back()->with('message', 'Ulasan Pelanggan berhasil direset ke data awal!');
    }
}
