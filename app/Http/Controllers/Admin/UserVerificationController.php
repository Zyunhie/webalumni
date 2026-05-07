<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\HeroSlide;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserVerificationController extends Controller
{
    public function index()
    {
        $heroVerif = HeroSlide::where('page', 'verifikasi_akun')->where('aktif', true)->first();
        $pendingUsers = User::where('status', 'pending')
            ->where('role', 'alumni')
            ->latest()
            ->paginate(20);
            
        // ✅ Pastikan ini mengarah ke file view yang benar
      return view('admin.users.pending', compact('pendingUsers', 'heroVerif'));  // ✅ BENAR
    }
    
    public function approve($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->status !== 'pending') {
            return back()->with('warning', 'User sudah diproses sebelumnya.');
        }
        
        $user->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
        
        return redirect()->route('admin.users.pending')->with('success', 
            "Akun {$user->name} berhasil diverifikasi."
        );
    }
    
    public function reject(Request $request, $id)
    {
        $request->validate(['reason' => 'required|string|min:5|max:500']);
        
        $user = User::findOrFail($id);
        
        $user->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
        
        return redirect()->route('admin.users.pending')->with('error', 
            "Akun {$user->name} ditolak. Alasan: {$request->reason}"
        );
    }
    
    public function approvedList()
    {
        $approvedUsers = User::where('status', 'approved')
            ->where('role', 'alumni')
            ->latest('approved_at')
            ->paginate(20);
            
        return view('admin.users.approved', compact('approvedUsers'));
    }
    
    public function rejectedList()
    {
        $rejectedUsers = User::where('status', 'rejected')
            ->where('role', 'alumni')
            ->latest('approved_at')
            ->paginate(20);
            
        return view('admin.users.rejected', compact('rejectedUsers'));
    }
}