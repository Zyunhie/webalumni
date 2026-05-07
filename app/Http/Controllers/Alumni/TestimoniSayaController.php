<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Testimonials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // ✅ TAMBAHKAN INI

class TestimoniSayaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::check() ? Auth::id() : null;
        
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $myTestimonials = Testimonials::where('user_id', $userId)->latest()->paginate(10);
        return view('testimoni.saya', compact('myTestimonials'));
    }

    public function edit(Testimonials $testimonial)
    {
        $userId = Auth::check() ? Auth::id() : null;
        
        if ($testimonial->user_id !== $userId) {
            abort(403, 'Anda tidak memiliki akses ke testimoni ini.');
        }
        
        return view('testimoni.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonials $testimonial)
    {
        $userId = Auth::check() ? Auth::id() : null;
        
        if ($testimonial->user_id !== $userId) {
            abort(403, 'Anda tidak memiliki akses ke testimoni ini.');
        }

        $request->validate([
            'nama' => 'required|string|max:100',
            'jurusan' => 'required|string|max:100',
            'tahun_lulus' => 'required|integer|min:1900|max:' . date('Y'),
            'pekerjaan' => 'nullable|string|max:100',
            'perusahaan' => 'nullable|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'isi_testimoni' => 'required|string',
        ]);

        $data = $request->except(['_token', '_method', 'foto']);

        if ($request->hasFile('foto')) {
            if ($testimonial->foto && Storage::disk('public')->exists($testimonial->foto)) {
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
        $userId = Auth::check() ? Auth::id() : null;
        
        if ($testimonial->user_id !== $userId) {
            abort(403, 'Anda tidak memiliki akses ke testimoni ini.');
        }

        if ($testimonial->foto && Storage::disk('public')->exists($testimonial->foto)) {
            Storage::disk('public')->delete($testimonial->foto);
        }

        $testimonial->delete();

        return redirect()->route('testimoni.saya')->with('success', 'Testimoni berhasil dihapus.');
    }
}