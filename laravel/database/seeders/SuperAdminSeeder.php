<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    /**
     * Creates the super admin from ADMIN_EMAIL / ADMIN_PASSWORD in .env.
     * If ADMIN_PASSWORD is empty a random one is generated and printed once.
     * An existing admin's password is never changed by re-seeding.
     */
    public function run(): void
    {
        $user = User::firstOrNew(['email' => config('app.admin_email')]);

        if (! $user->exists) {
            $password = (string) config('app.admin_password');
            if ($password === '') {
                $password = Str::password(16, symbols: false);
                $this->command?->warn('ADMIN_PASSWORD is not set — generated super admin password: '.$password);
            }
            $user->password = Hash::make($password);
        }

        $user->forceFill([
            'name' => 'Super Admin',
            'role' => 'super_admin',
            'email_verified_at' => $user->email_verified_at ?? now(),
        ])->save();
    }
}
