<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@cratefit.id'],
            [
                'name'     => 'Admin Cratefit',
                'email'    => 'admin@cratefit.id',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );
 
        $this->command->info('Admin berhasil dibuat: admin@cratefit.id / admin123');
    }
}
