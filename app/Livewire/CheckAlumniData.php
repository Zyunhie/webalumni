<?php

namespace App\Livewire;

use App\Models\Alumni;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class CheckAlumniData extends Component
{
    public $nim = '';
    public $name = '';
    public $prodi = '';
    public $angkatan = '';
    public $email = '';
    public $isDataFound = false;
    public $message = '';
    public $messageType = 'info';
    
    public function updatedNim()
    {
        if (strlen(trim($this->nim)) < 3) {
            $this->resetForm();
            return;
        }
        
        $this->checkAlumniDatabase();
    }
    
    public function checkAlumniDatabase()
    {
        try {
            $alumni = Alumni::where('nim', $this->nim)->first();
            
            if ($alumni && !$alumni->user_id) {
                // Data ditemukan dan belum punya user
                $this->isDataFound = true;
                $this->name = $alumni->nama;
                $this->prodi = $alumni->prodi;
                $this->angkatan = $alumni->angkatan;
                $this->email = $alumni->email ?? '';
                $this->message = '✓ Data alumni ditemukan! Form akan terisi otomatis.';
                $this->messageType = 'success';
                
                Log::info('Auto-fill data found', ['nim' => $this->nim]);
            } elseif ($alumni && $alumni->user_id) {
                // Data ditemukan tapi sudah punya user
                $this->resetForm();
                $this->message = '⚠ NIM ini sudah terdaftar. Silakan login atau hubungi admin.';
                $this->messageType = 'warning';
            } else {
                // Data tidak ditemukan
                $this->resetForm();
                $this->message = '⚠ Data tidak ditemukan. Silakan isi form manual. Admin akan verifikasi data Anda.';
                $this->messageType = 'warning';
            }
        } catch (\Exception $e) {
            Log::error('Auto-fill error: ' . $e->getMessage());
            $this->message = 'Terjadi kesalahan. Silakan isi form manual.';
            $this->messageType = 'error';
        }
    }
    
    private function resetForm()
    {
        $this->isDataFound = false;
        // Jangan reset name, prodi, angkatan biar user bisa isi manual
        // $this->name = '';
        // $this->prodi = '';
        // $this->angkatan = '';
        // $this->email = '';
    }
    
    public function render()
    {
        return view('livewire.check-alumni-data');
    }
}