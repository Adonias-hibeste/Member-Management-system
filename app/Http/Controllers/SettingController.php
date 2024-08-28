<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::find(1);
        return view('Admin.settings', compact('setting'));
    }

    public function savedata(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'website_name' => 'required|max:255',
            'website_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'website_favicon' => 'nullable|image|mimes:ico,png|max:512',
            'description'  => 'nullable',
            'meta_title' => 'required|max:255',
            'meta_keyword' => 'nullable',
            'meta_description' => 'nullable'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $setting = Setting::first(); // Fetching the first setting record

        if ($setting) {
            $setting->website_name = $request->website_name;

            if ($request->hasFile('website_logo')) {
                $destination = 'uploads/settings/' . $setting->logo;
                if (File::exists($destination)) {
                    File::delete($destination);
                }

                $file = $request->file('website_logo');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/settings/', $filename);

                $setting->logo = $filename;
            }

            if ($request->hasFile('website_favicon')) {
                $destination = 'uploads/settings/' . $setting->favicon;
                if (File::exists($destination)) {
                    File::delete($destination);
                }

                $file = $request->file('website_favicon');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/settings/', $filename);

                $setting->favicon = $filename;
            }

            $setting->description = $request->description;
            $setting->meta_title = $request->meta_title;
            $setting->meta_keyword = $request->meta_keyword;
            $setting->meta_description = $request->meta_description;
            $setting->save();

            return redirect()->route('admin.settings')->with('message', 'Setting updated successfully.');
        } else {
            $setting = new Setting;
            $setting->website_name = $request->website_name;

            if ($request->hasFile('website_logo')) {
                $file = $request->file('website_logo');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/settings/', $filename);

                $setting->logo = $filename;
            }

            if ($request->hasFile('website_favicon')) {
                $file = $request->file('website_favicon');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/settings/', $filename);

                $setting->favicon = $filename;
            }

            $setting->description = $request->description;
            $setting->meta_title = $request->meta_title;
            $setting->meta_keyword = $request->meta_keyword;
            $setting->meta_description = $request->meta_description;
            $setting->save();

            return redirect()->route('admin.settings')->with('message', 'Setting added successfully.');
        }
    }
}
