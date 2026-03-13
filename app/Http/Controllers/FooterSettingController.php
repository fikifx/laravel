<?php

namespace App\Http\Controllers;

use App\Models\FooterSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FooterSettingController extends Controller
{
    public function edit()
    {
        return Inertia::render('Footer/Edit', [
            'footer' => FooterSetting::getOrDefault()
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'brand_description' => 'required|string',
            'phone' => 'required|string|max:255',
            'services' => 'required|array',
            'services.*' => 'required|string',
            'maps_link' => 'required|string',
            'copyright_text' => 'required|string|max:255',
            'footer_nav' => 'required|array',
            'footer_nav.*.label' => 'required|string|max:255',
            'footer_nav.*.href' => 'required|string|max:255',
        ]);

        $footer = FooterSetting::first() ?? new FooterSetting();
        $footer->fill($validated);
        $footer->save();

        return redirect()->back()->with('message', 'Footer Section berhasil diperbarui!');
    }

    public function reset()
    {
        FooterSetting::truncate();
        return redirect()->back()->with('message', 'Footer Section berhasil direset ke data default!');
    }
}
