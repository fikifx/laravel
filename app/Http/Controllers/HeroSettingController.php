<?php

namespace App\Http\Controllers;

use App\Models\HeroSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HeroSettingController extends Controller
{
    public function edit()
    {
        $hero = HeroSetting::first();
        return Inertia::render('Hero/Edit', [
            'hero' => $hero,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'badge_text'          => 'nullable|string|max:150',
            'headline'            => 'nullable|string|max:100',
            'headline_highlight'  => 'nullable|string|max:100',
            'headline_suffix'     => 'nullable|string|max:100',
            'subheadline'         => 'nullable|string|max:150',
            'description'         => 'nullable|string|max:500',
            'cta_primary_text'    => 'nullable|string|max:80',
            'cta_primary_url'     => 'nullable|string|max:200',
            'cta_secondary_text'  => 'nullable|string|max:80',
            'whatsapp_number'     => 'nullable|string|max:20',
        ]);

        HeroSetting::updateOrCreate(['id' => 1], $validated);

        return redirect()->route('hero.edit')
            ->with('message', 'Hero section berhasil diperbarui!');
    }

    public function reset()
    {
        HeroSetting::truncate();
        return redirect()->route('hero.edit')
            ->with('message', 'Hero section telah direset ke data default.');
    }
}
