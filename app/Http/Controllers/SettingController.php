<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');
        return view('setting.index', compact('settings'));
    }


    public function update(Request $request)
    {
        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_email' => 'required|email|max:255',
            'store_phone' => 'required|string|max:20',
            'store_address' => 'required|string',
            'currency' => 'required|string|max:10',
            'low_stock_treshold' => 'required|integer|min:1',
            'allow_backorder' => 'sometimes|boolean',
            'tax_rate' => 'required|numeric|min:0|max:100'
        ]);

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }


        if ($request->hasFile('storage_logo')) {
            $path = $request->file('storage_logo')->store('settings', 'public');

            Setting::updateOrCreate(
                ['key' => 'store_logo'],
                ['value' => $path]
            );


            return redirect()->route('setting.index')
                ->with('success', 'Pengaturan berhasil disimpan.');
        }
    }
}
