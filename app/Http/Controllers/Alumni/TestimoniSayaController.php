<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestimoniSayaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $myTestimonials = Testimonials::where('user_id', auth()->id())->latest()->paginate(10);
        return view('testimoni.saya', compact('myTestimonials'));
    }

    public function edit(Testimonials $testimonial)
    {
        if ($testimonial->user_id !== auth()->id()) {
            abort(403);
        }
        return view('testimoni.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonials $testimonial)
    {
        if ($testimonial->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'nama' => 'required|string|max:100',
            'jurusan' => 'required|string|max:100',
            'tahun_lulus' => 'required|integer|min:1900|max:2100',
            'pekerjaan' => 'nullable|string|max:100',
            'perusahaan' => 'nullable|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'isi_testimoni' => 'required|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($testimonial->foto) {
                Storage::disk('public')->delete($testimonial->foto);
            }
            $data['foto'] = $request->file('foto')->store('testimonials', 'public');
        }

        $data['status'] = 'pending';
        $data['approved_by'] = null;
        $data['approved_at'] = null;

        $testimonial->update($data);

        return redirect()->route('testimoni.saya')->with('success', 'Testimoni berhasil diupdate dan dikirim ulang untuk review.');
    }

    public function destroy(Testimonials $testimonial)
    {
        if ($testimonial->user_id !== auth()->id()) {
            abort(403);
        }

        if ($testimonial->foto) {
            Storage::disk('public')->delete($testimonial->foto);
        }

        $testimonial->delete();

        return redirect()->route('testimoni.saya')->with('success', 'Testimoni berhasil dihapus.');
    }
}
