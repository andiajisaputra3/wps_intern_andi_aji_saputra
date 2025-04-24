<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Jhon Doe',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password')
        ]);

        $admin->assignRole('admin');

        // Direktur
        $direktur = User::create([
            'name' => 'Andi Aji Saputra',
            'email' => 'direktur@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $direktur->assignRole('direktur');

        // Manager Operasional
        $managerOperasional = User::create([
            'name' => 'Maulana Achmad Aminullah',
            'email' => 'manageroperasional@gmail.com',
            'password' => Hash::make('password'),
            'atasan_id' => $direktur->id,
        ]);
        $managerOperasional->assignRole('manager operasional');

        // Manager Keuangan
        $managerKeuangan = User::create([
            'name' => 'Taufik Irawan',
            'email' => 'managerkeuangan@gmail.com',
            'password' => Hash::make('password'),
            'atasan_id' => $direktur->id,
        ]);
        $managerKeuangan->assignRole('manager keuangan');

        // Staf Operasional
        $staffOperasional = User::create([
            'name' => 'Bagus Setiawan',
            'email' => 'staffoperasional@gmail.com',
            'password' => Hash::make('password'),
            'atasan_id' => $managerOperasional->id,
        ]);
        $staffOperasional->assignRole('staff operasional');

        // Staf Keuangan
        $staffKeuangan = User::create([
            'name' => 'Ilham Taufik',
            'email' => 'staffkeuangan@gmail.com',
            'password' => Hash::make('password'),
            'atasan_id' => $managerKeuangan->id,
        ]);
        $staffKeuangan->assignRole('staff keuangan');
    }
}
