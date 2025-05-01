<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'khaled',
                'email' => 'khaled.admin@example.com',
                'phone' => '0600000001',
                'address' => json_encode(['city' => 'Casablanca', 'street' => 'Main St']),
                'password' => Hash::make('SecurePass#2025'),
                'age' => 30,
                'is_banned' => false,
            ],
            [
                'username' => 'mohammed',
                'email' => 'mohammed.branch@example.com',
                'phone' => '0600000002',
                'address' => json_encode(['city' => 'Rabat', 'street' => 'Second St']),
                'password' => Hash::make('BranchUser@2025'),
                'age' => 28,
                'is_banned' => false,
            ],
            [
                'username' => 'ali',
                'email' => 'ali.imam@example.com',
                'phone' => '0600000003',
                'address' => json_encode(['city' => 'Fes', 'street' => 'Third St']),
                'password' => Hash::make('Imam$Role2025'),
                'age' => 35,
                'is_banned' => false,
            ],
            [
                'username' => 'asem',
                'email' => 'asem.quran@example.com',
                'phone' => '0600000004',
                'address' => json_encode(['city' => 'Marrakech', 'street' => 'Fourth St']),
                'password' => Hash::make('Tajweed123!'),
                'age' => 32,
                'is_banned' => false,
            ]
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                [
                    'email' => $user['email'],
                    'phone' => $user['phone'],
                ],
                $user
            );
        }
    }
}
