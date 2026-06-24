<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Profile;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert users
        DB::table('users')->insert([
            // Admin
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Staff
            [
                'name' => 'Staff',
                'email' => 'staff@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // User
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Fetch the inserted users
        $admin = DB::table('users')->where('email', 'admin@gmail.com')->first();
        $staff = DB::table('users')->where('email', 'staff@gmail.com')->first();
        $user = DB::table('users')->where('email', 'user@gmail.com')->first();

        // Insert profiles for each user
        DB::table('profiles')->insert([
            // Admin Profile
            [
                'user_id' => $admin->id,
                'full_name' => 'Admin User',
                'gender' => 'male',
                'date_of_birth' => '1990-01-01',
                'contact_number' => '1234567890',
                'address' => '123 Admin Street, Admin City',
                'bio' => 'I am the admin of this system.',
                'profile_pic' => null, // You can add a default profile picture path if needed
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Staff Profile
            [
                'user_id' => $staff->id,
                'full_name' => 'Staff User',
                'gender' => 'female',
                'date_of_birth' => '1995-05-05',
                'contact_number' => '0987654321',
                'address' => '456 Staff Street, Staff City',
                'bio' => 'I am a staff member of this system.',
                'profile_pic' => null, // You can add a default profile picture path if needed
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // User Profile
            [
                'user_id' => $user->id,
                'full_name' => 'Regular User',
                'gender' => 'female',
                'date_of_birth' => '2000-10-10',
                'contact_number' => '5555555555',
                'address' => '789 User Street, User City',
                'bio' => 'I am a regular user of this system.',
                'profile_pic' => null, // You can add a default profile picture path if needed
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Create sample users and profiles
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);

            Profile::create([
                'user_id' => $user->id,
                'full_name' => 'User ' . $i,
                'gender' => ($i % 2 === 0) ? 'male' : 'female',
                'date_of_birth' => now()->subYears(rand(20, 40))->format('Y-m-d'),
                'contact_number' => '1234567890',
                'address' => '123 Main St, City ' . $i,
                'bio' => 'This is a sample bio for User ' . $i,
                'job' => 'Sample Job ' . $i,
                'facebook' => 'https://facebook.com/user' . $i,
                'instagram' => 'https://instagram.com/user' . $i,
                'linkedin' => 'https://linkedin.com/in/user' . $i,
                'profile_pic' => null, // Add a default profile picture path if needed
            ]);
        }

    }
}
