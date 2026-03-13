<?php

namespace App\Http\Controllers;

use App\Models\FaqItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FaqItemController extends Controller
{
    public function edit()
    {
        return Inertia::render('Faqs/Edit', [
            'faqs' => FaqItem::orderBy('order_index')->get()
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'faqs' => 'array',
            'faqs.*.question' => 'required|string|max:255',
            'faqs.*.answer' => 'required|string',
        ]);

        FaqItem::truncate();

        foreach ($validated['faqs'] as $index => $item) {
            FaqItem::create([
                'question' => $item['question'],
                'answer' => $item['answer'],
                'order_index' => $index,
            ]);
        }

        return redirect()->back()->with('message', 'Pertanyaan Umum berhasil diperbarui!');
    }

    public function reset()
    {
        FaqItem::truncate();
        
        $defaults = [
            ['question' => 'Apakah bisa sewa mobil tanpa sopir (lepas kunci)?', 'answer' => 'Bisa, syaratnya e-KTP, KK, dan SIM A asli, serta bersedia kami survei ke tempat tinggal/hotel Anda menginap.'],
            ['question' => 'Bagaimana jika pengembalian mobil terlambat?', 'answer' => 'Keterlambatan akan dikenakan biaya overtime sebesar 10% dari harga sewa per harinya untuk setiap jam keterlambatan. Jika lebih dari 6 jam, dihitung sewa 1 hari.'],
            ['question' => 'Apakah BBM sudah termasuk dalam harga sewa dengan sopir?', 'answer' => 'Paket sewa dengan sopir belum termasuk BBM, tol, parkir, dan makan sopir. Kecuali Anda mengambil paket All-in (Mobil + Sopir + BBM).'],
            ['question' => 'Jangkauan area pemakaian mobil sampai mana saja?', 'answer' => 'Untuk harga standar, pemakaian khusus area Kabupaten Banyuwangi. Jika ke luar kota (seperti Bali atau Surabaya), akan ada penyesuaian tarif.'],
        ];

        foreach ($defaults as $i => $item) {
            FaqItem::create([
                'question' => $item['question'],
                'answer' => $item['answer'],
                'order_index' => $i,
            ]);
        }

        return redirect()->back()->with('message', 'Pertanyaan Umum berhasil direset ke data awal!');
    }
}
