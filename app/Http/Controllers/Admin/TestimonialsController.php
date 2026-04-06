<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestimonialsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function pending()
    {
        $pending = Testimonials::pending()->with('user')->latest()->paginate(15);
        return view('admin.testimonials.pending', compact('pending'));
    }

    public function approve(Testimonials $testimonial)
    {
        $testimonial->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Testimoni berhasil disetujui.');
    }

    public function reject(Request $request, Testimonials $testimonial)
    {
        $request->validate([
            'alasan' => 'required|string|max:500'
        ]);

        $testimonial->update([
            'status' => 'rejected',
            'alasan_penolakan' => $request->alasan,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Testimoni berhasil ditolak.');
    }
}
