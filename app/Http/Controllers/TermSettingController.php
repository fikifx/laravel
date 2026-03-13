<?php

namespace App\Http\Controllers;

use App\Models\TermSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TermSettingController extends Controller
{
    public function edit()
    {
        return Inertia::render('Terms/Edit', [
            'terms' => TermSetting::getOrDefault(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'lepas_kunci_items'   => 'required|array|max:10',
            'lepas_kunci_items.*' => 'required|string|max:150',
            
            'dengan_sopir_items'  => 'required|array|max:10',
            'dengan_sopir_items.*'=> 'required|string|max:150',
            
            'overtime_percentage' => 'required|integer|min:0|max:100',
            'overtime_desc'       => 'required|string|max:200',
        ]);

        $setting = TermSetting::first() ?? new TermSetting();
        
        $setting->lepas_kunci_items   = array_values($request->lepas_kunci_items);
        $setting->dengan_sopir_items  = array_values($request->dengan_sopir_items);
        $setting->overtime_percentage = $request->overtime_percentage;
        $setting->overtime_desc       = $request->overtime_desc;
        
        $setting->save();

        return redirect()->route('terms.edit')
            ->with('message', 'Syarat & Ketentuan sewa berhasil diperbarui!');
    }

    public function reset()
    {
        TermSetting::truncate();
        return redirect()->route('terms.edit')
            ->with('message', 'Syarat & Ketentuan sewa telah direset ke data awal.');
    }
}
