<?php

namespace App\Http\Controllers;

use App\Models\CtaSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CtaSettingController extends Controller
{
    public function edit()
    {
        return Inertia::render('Cta/Edit', [
            'cta' => CtaSetting::getOrDefault()
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'wa_text' => 'required|string|max:255',
            'wa_number' => 'required|string|max:255',
            'catalog_text' => 'required|string|max:255',
            'catalog_link' => 'required|string|max:255',
        ]);

        $cta = CtaSetting::first() ?? new CtaSetting();
        $cta->fill($validated);
        $cta->save();

        return redirect()->back()->with('message', 'CTA Section berhasil diperbarui!');
    }

    public function reset()
    {
        CtaSetting::truncate();
        return redirect()->back()->with('message', 'CTA Section berhasil direset ke data default!');
    }
}
