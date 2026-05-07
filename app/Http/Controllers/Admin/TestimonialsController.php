<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function pending()
    {
        $pending = Testimonials::where('status', 'pending')
            ->with('user')
            ->latest()
            ->paginate(15);
            
        return view('admin.testimonials.pending', compact('pending'));
    }

    public function approve(Testimonials $testimonial)
    {
        // Pastikan auth()->id() tidak null
        $approvedBy = Auth::check() ? Auth::id() : null;
        
        $testimonial->update([
            'status' => 'approved',
            'approved_by' => $approvedBy,
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Testimoni berhasil disetujui.');
    }

    public function reject(Request $request, Testimonials $testimonial)
    {
        $request->validate([
            'alasan' => 'required|string|max:500'
        ]);

        $approvedBy = Auth::check() ? Auth::id() : null;

        $testimonial->update([
            'status' => 'rejected',
            'alasan_penolakan' => $request->alasan,
            'approved_by' => $approvedBy,
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Testimoni berhasil ditolak.');
    }
}