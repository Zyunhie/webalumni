<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendLowonganNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $lowongan;
    
    public function __construct($lowongan)
    {
        $this->lowongan = $lowongan;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $alumnis = \App\Models\Alumni::where('status', 'approved')
            ->whereIn('prodi', $this->lowongan->target_prodi)
            ->with('user')
            ->get();
        
        foreach ($alumnis as $alumni) {
            if ($alumni->user && $alumni->user->email) {
                \Illuminate\Support\Facades\Mail::to($alumni->user->email)
                    ->queue(new \App\Mail\LowonganNotification($this->lowongan, $alumni));
            }
        }
    }

}
