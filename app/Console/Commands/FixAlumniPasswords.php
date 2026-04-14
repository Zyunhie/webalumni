<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixAlumniPasswords extends Command
{
    protected $signature = 'alumni:fix-passwords';
    protected $description = 'Set password alumni = NIM (hash)';

    public function handle()
    {
        $users = User::where('role', 'alumni')->get();
        $count = 0;
        foreach ($users as $user) {
            if ($user->nim) {
                $user->password = Hash::make($user->nim);
                $user->save();
                $count++;
            }
        }
        $this->info("$count user alumni password-nya diset ke NIM.");
    }
}