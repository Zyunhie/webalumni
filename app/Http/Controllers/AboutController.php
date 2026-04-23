<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use Illuminate\Http\Request;
use App\Models\About;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function __construct()
    {
        // hanya admin boleh update
        $this->middleware(['auth', 'role:admin'])
             ->only(['updateText', 'updateImage']);
    }

    /*
    |--------------------------------------------------------------------------
    | PUBLIC VIEW
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $about = About::first();
        $heroTentang = HeroSlide::aktif()->forPage('tentang')->first();

        // safety net: kalau tabel kosong
        if (!$about) {
            $about = About::create([
                'visi' => '',
                'misi' => '',
                'struktur_image' => null,
            ]);
        }

         return view('tentang', compact('about', 'heroTentang'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE VISI / MISI (AJAX - JSON)
    |--------------------------------------------------------------------------
    */

    public function updateText(Request $request)
    {
        $request->validate([
            'field' => 'required|in:visi,misi',
            'value' => 'nullable|string',
        ]);

        $about = About::firstOrFail();

        $about->{$request->field} = $request->value;
        $about->save();

        return response()->json([
            'success' => true,
            'message' => 'Teks berhasil diperbarui',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE STRUKTUR KAMPUS (FORM UPLOAD)
    |--------------------------------------------------------------------------
    */

    public function updateImage(Request $request)
{
    $request->validate([
        'struktur_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $about = About::first(); // sesuaikan dengan model Anda

    if ($request->hasFile('struktur_image')) {
        // Hapus gambar lama jika ada
        if ($about->struktur_image) {
            Storage::disk('public')->delete($about->struktur_image);
        }

        // Simpan gambar baru ke folder 'public' dengan nama unik
        $path = $request->file('struktur_image')->store('struktur', 'public');
        // $path akan bernilai: "struktur/nama-file.jpg"

        $about->struktur_image = $path; // simpan path relatif terhadap disk public
        $about->save();
    }

    return redirect()->back()->with('success', 'Gambar berhasil diperbarui.');
}
}