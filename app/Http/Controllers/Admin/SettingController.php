<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function updateBulk(Request $request)
    {
        $settings = $request->input('settings', []);
        
        foreach ($settings as $id => $value) {
            $setting = Setting::find($id);
            if ($setting) {
                $setting->update(['value' => $value]);
            }
        }

        return redirect()->back()->with('success', 'System configurations synchronized successfully.');
    }

    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);
        $setting->update([
            'value' => $request->value
        ]);

        return redirect()->back()->with('success', 'Intelligence parameter updated.');
    }
}
