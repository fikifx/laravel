<?php

namespace App\Http\Controllers;

use App\Models\FeatureItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FeatureItemController extends Controller
{
    public function edit()
    {
        return Inertia::render('Feature/Edit', [
            'features' => FeatureItem::orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'features'               => 'required|array|min:1|max:6',
            'features.*.title'       => 'required|string|max:100',
            'features.*.description' => 'required|string|max:250',
            'features.*.icon'        => 'required|string|max:50',
            'features.*.color_theme' => 'required|string|max:50',
        ]);

        FeatureItem::truncate();
        foreach ($request->features as $i => $feature) {
            FeatureItem::create([
                'title'       => $feature['title'],
                'description' => $feature['description'],
                'icon'        => $feature['icon'],
                'color_theme' => $feature['color_theme'],
                'sort_order'  => $i,
            ]);
        }

        return redirect()->route('features.edit')
            ->with('message', 'Keunggulan berhasil diperbarui!');
    }

    public function reset()
    {
        FeatureItem::truncate();
        return redirect()->route('features.edit')
            ->with('message', 'Keunggulan telah direset ke data default.');
    }
}
