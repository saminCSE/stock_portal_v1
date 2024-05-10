<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function edit()
    {
        $item = DB::table('settings')->first();
        // dd($item);
        return view('admin.settings.edit', compact('item'));
    }


    public function update(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'brand_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'mail_to' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon' => 'nullable|image|mimes:ico|max:2048',
            'fb_link' => 'nullable|string|max:255',
            'twitter_link' => 'nullable|string|max:255',
            'youtube_link' => 'nullable|string|max:255',
            'instagram_link' => 'nullable|string|max:255',
            'service_day' => 'nullable|string|max:255',
            'service_time' => 'nullable|string|max:255',
            'term_and_condition' => 'nullable|string',
            'term_and_condition_bn' => 'nullable|string',
            'user_manual' => 'nullable',
            'demo_banner_heading' => 'nullable',
            'demo_banner_heading_bn' => 'nullable',
            'demo_banner_desc' => 'nullable',
            'demo_banner_desc_bn' => 'nullable',
        ]);

        // Handle file uploads (logo and favicon)
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->storeAs('uploads/settings', 'logo.' . $request->file('logo')->getClientOriginalExtension(), 'public');
            $validatedData['logo'] = $logoPath;
        }

        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->storeAs('uploads/settings', 'favicon.' . $request->file('favicon')->getClientOriginalExtension(), 'public');
            $validatedData['favicon'] = $faviconPath;
        }

        // Update the record in the database
        DB::table('settings')->update($validatedData);

        // Redirect or perform additional logic as needed
        return redirect()->route('settings.edit')->with('success', 'Settings updated successfully.');
    }



}


