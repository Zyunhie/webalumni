<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('page')->orderBy('urutan')->get()->groupBy('page');
        return view('admin.hero-slides.index', compact('slides'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|max:3072',
            'page' => 'required|in:home,tentang,alumni,agenda,testimoni,berita,lowongan,kontak,users,verifikasi_akun,kelola_user',
        ]);

        $path = $request->file('gambar')->store('hero', 'public');

        $singlePages = [
            'tentang', 'alumni', 'agenda', 'testimoni',
            'berita', 'lowongan', 'kontak', 'users',
            'verifikasi_akun', 'kelola_user',
        ];

        if (in_array($request->page, $singlePages)) {
            $existing = HeroSlide::where('page', $request->page)->first();
            if ($existing) {
                Storage::disk('public')->delete($existing->gambar);
                $existing->delete();
            }
        }

        HeroSlide::create([
            'gambar' => $path,
            'page'   => $request->page,
            'urutan' => HeroSlide::where('page', $request->page)->max('urutan') + 1,
            'aktif'  => true,
        ]);

        return back()->with('success', 'Foto berhasil disimpan.');
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $request->validate([
            'gambar' => 'nullable|image|max:3072',
            'aktif'  => 'boolean',
        ]);

        $data = ['aktif' => $request->boolean('aktif')];

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($heroSlide->gambar);
            $data['gambar'] = $request->file('gambar')->store('hero', 'public');
        }

        $heroSlide->update($data);

        return back()->with('success', 'Slide berhasil diupdate.');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        Storage::disk('public')->delete($heroSlide->gambar);
        $heroSlide->delete();

        return back()->with('success', 'Slide berhasil dihapus.');
    }
}