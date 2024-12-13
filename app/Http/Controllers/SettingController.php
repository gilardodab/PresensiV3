<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    // Menampilkan halaman pengaturan
    public function index()
    {
        $setting = Setting::first(); // Ambil satu data pengaturan
        // $settings = Setting::where('id', '1');
        // dd($settings);
        return view('adminyofa.settings.index', compact('setting'));
    }

    public function loadSettingUmum()
    {
        // Ambil satu data pengaturan
        $settings = Setting::where('id', 1)->first(); // Menggunakan first() untuk ambil data
    
        // Pastikan variabel yang dikirim ke view sudah sesuai dengan field di database
        return view('adminyofa.settings.umum', [
            'site_name' => $settings->site_name,
            'site_description' => $settings->site_description,
            'site_phone' => $settings->site_phone,
            'site_address' => $settings->site_address,
            'site_email' => $settings->site_email,
            'site_email_domain' => $settings->site_email_domain,
            'site_url' => $settings->site_url,
            'site_logo' => $settings->site_logo,
            'level_user' => auth()->user()->level_user // Misalnya ambil level dari user yang sedang login
        ]);
    }

    public function loadSettingProfile()
    {
        // Pastikan view profile.blade.php ada di folder views/settings
        $settings = Setting::where('id', 1)->first(); // Menggunakan first() untuk ambil data
    
        // Pastikan variabel yang dikirim ke view sudah sesuai dengan field di database
        return view('adminyofa.settings.profile', [
            'site_company' => $settings->site_company,
            'site_director' => $settings->site_director,
            'site_manager' => $settings->site_manager,
            'level_user' => auth()->user()->level_user // Misalnya ambil level dari user yang sedang login
        ]);
        // return view('adminyofa.settings.profile', [
        //     'site_company' => 'My Company',
        //     'site_director' => 'John Doe',
        //     'site_manager' => 'Jane Smith',
        //     'level_user' => 1
        // ]);
    }

    // Menampilkan form untuk mengedit pengaturan
    public function edit()
    {
        $setting = Setting::first(); // Ambil satu data pengaturan
        return view('settings.edit', compact('setting'));
    }

    // Metode untuk memperbarui pengaturan umum
    public function updateSetting(Request $request)
    {
        // Validasi input form
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'required|string|max:500',
            'site_phone' => 'required|string|max:15',
            'site_address' => 'required|string|max:255',
            'site_email' => 'required|email',
            'site_email_domain' => 'required|string|max:255',
            'site_url' => 'required|url',
            'site_logo' => 'nullable|image|max:2048' // Untuk file gambar
        ]);

        // Update data setting di database
        $setting = Setting::find(1);
        $setting->site_name = $request->site_name;
        $setting->site_description = $request->site_description;
        $setting->site_phone = $request->site_phone;
        $setting->site_address = $request->site_address;
        $setting->site_email = $request->site_email;
        $setting->site_email_domain = $request->site_email_domain;
        $setting->site_url = $request->site_url;

        // Proses upload file logo jika ada
        if ($request->hasFile('site_logo')) {
            $logoPath = $request->file('site_logo')->store('logos', 'public');
            $setting->site_logo = $logoPath;
        }

        // Simpan perubahan
        $setting->save();

        return response()->json(['success' => 'Pengaturan berhasil diperbarui']);
    }
    public function updateProfile(Request $request)
    {
        // Validasi input form
        $request->validate([
            'site_manager' => 'required|string|max:255',
            'site_company' => 'required|string|max:255',
            'site_director' => 'required|string|max:255'
        ]);

        // Update data profil di database
        $setting = Setting::find(1);
        $setting->site_manager = $request->site_manager;
        $setting->site_company = $request->site_company;
        $setting->site_director = $request->site_director;

        // Simpan perubahan
        $setting->save();

        return response()->json(['success' => 'Profil berhasil diperbarui']);
    }

    public function StorageLink(){
        Artisan::call('storage:link');
        return redirect('/adminyofa')->with('status', "Storage link created!");
    }
}
