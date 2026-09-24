<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::first();
        return view('admin.setting.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first();

        $data = $request->all();

        /*
        |------------------------------------------
        | UPLOAD LOGO (HOSTING SAFE)
        |------------------------------------------
        */
        if ($request->hasFile('logo')) {

            $file = $request->file('logo');
            $namaFile = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $namaFile);

            $data['logo'] = $namaFile;
        }

        /*
        |------------------------------------------
        | HERO SLIDE 1
        |------------------------------------------
        */
        if ($request->hasFile('hero_slide_1')) {

            $file = $request->file('hero_slide_1');
            $namaFile = time().'_slide1_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $namaFile);

            $data['hero_slide_1'] = $namaFile;
        }

        /*
        |------------------------------------------
        | HERO SLIDE 2
        |------------------------------------------
        */
        if ($request->hasFile('hero_slide_2')) {

            $file = $request->file('hero_slide_2');
            $namaFile = time().'_slide2_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $namaFile);

            $data['hero_slide_2'] = $namaFile;
        }

        /*
        |------------------------------------------
        | HERO SLIDE 3
        |------------------------------------------
        */
        if ($request->hasFile('hero_slide_3')) {

            $file = $request->file('hero_slide_3');
            $namaFile = time().'_slide3_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $namaFile);

            $data['hero_slide_3'] = $namaFile;
        }

        $setting->update($data);

        ActivityLogger::log('UPDATE', 'Setting Website', 'Memperbarui konfigurasi identitas dan tampilan website');

        return back()->with('success', 'Setting berhasil diupdate');
    }
}