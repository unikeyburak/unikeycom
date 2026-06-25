<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@unikeyterra.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        // Create additional staff users
        $users = [
            [
                'name' => 'Ahmet Yılmaz',
                'email' => 'ahmet.yilmaz@unikeyterra.com',
                'password' => Hash::make('unikeyterra2024'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Ayşe Demir',
                'email' => 'ayse.demir@unikeyterra.com',
                'password' => Hash::make('unikeyterra2024'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Mehmet Kaya',
                'email' => 'mehmet.kaya@unikeyterra.com',
                'password' => Hash::make('unikeyterra2024'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Fatma Öztürk',
                'email' => 'fatma.ozturk@unikeyterra.com',
                'password' => Hash::make('unikeyterra2024'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Ali Çelik',
                'email' => 'ali.celik@unikeyterra.com',
                'password' => Hash::make('unikeyterra2024'),
                'email_verified_at' => now(),
            ]
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}