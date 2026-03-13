<?php

namespace App\Http\Controllers;

use App\Models\StepItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StepItemController extends Controller
{
    public function edit()
    {
        return Inertia::render('Steps/Edit', [
            'steps' => StepItem::orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'steps'               => 'required|array|min:1|max:5',
            'steps.*.title'       => 'required|string|max:100',
            'steps.*.description' => 'required|string|max:250',
            'steps.*.icon'        => 'required|string|max:50',
        ]);

        StepItem::truncate();
        foreach ($request->steps as $i => $step) {
            StepItem::create([
                'title'       => $step['title'],
                'description' => $step['description'],
                'icon'        => $step['icon'],
                'sort_order'  => $i,
            ]);
        }

        return redirect()->route('steps.edit')
            ->with('message', 'Langkah pemesanan berhasil diperbarui!');
    }

    public function reset()
    {
        StepItem::truncate();
        return redirect()->route('steps.edit')
            ->with('message', 'Langkah pemesanan telah direset ke data default.');
    }
}
