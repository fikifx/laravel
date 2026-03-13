<?php

namespace App\Http\Controllers;

use App\Models\StatItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StatItemController extends Controller
{
    public function edit()
    {
        return Inertia::render('Stats/Edit', [
            'stats' => StatItem::orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'stats'                  => 'required|array|min:1|max:8',
            'stats.*.label'          => 'required|string|max:80',
            'stats.*.target'         => 'nullable|integer|min:0',
            'stats.*.suffix'         => 'nullable|string|max:10',
            'stats.*.fixed_value'    => 'nullable|string|max:20',
        ]);

        // Delete all and re-insert with new sort order
        StatItem::truncate();
        foreach ($request->stats as $i => $stat) {
            StatItem::create([
                'label'       => $stat['label'],
                'target'      => $stat['target'] ?? null,
                'suffix'      => $stat['suffix'] ?? null,
                'fixed_value' => $stat['fixed_value'] ?? null,
                'sort_order'  => $i,
            ]);
        }

        return redirect()->route('stats.edit')
            ->with('message', 'Stats berhasil diperbarui!');
    }

    public function reset()
    {
        StatItem::truncate();
        return redirect()->route('stats.edit')
            ->with('message', 'Stats telah direset ke data default.');
    }
}
