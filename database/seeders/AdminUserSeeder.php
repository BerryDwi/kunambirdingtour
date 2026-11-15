<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the administrator account.
     */
    public function run(): void
    {
        $email = config('admin.email');
        $password = config('admin.password');

        if (blank($email) || blank($password)) {
            $this->command?->warn('ADMIN_EMAIL or ADMIN_PASSWORD is not configured. Skipping admin user seeder.');

            return;
        }

        $admin = User::firstOrNew(['email' => $email]);

        $admin->name = config('admin.name');
        $admin->password = Hash::make($password);
        $admin->email_verified_at = $admin->email_verified_at ?? now();
        $admin->is_admin = true;
        $admin->save();
    }
}
