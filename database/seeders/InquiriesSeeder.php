<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inquiries;

class InquiriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert sample inquiries
        Inquiries::insert([
            [
                'user_id' => 3, // Reference to the users table
                'assign_id' => 2, // Reference to the assigned user (e.g., admin or staff)
                'category' => 'complaint',
                'title' => 'Saya tak dapat tukar password',
                'image_path' => null,
                'description' => 'Bila saya pergi page tukar password, saya tak dapat tukar password',
                'resolved_date' => null,
                'solution' => null,
                'status' => 'In Progress',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5,
                'assign_id' => 2,
                'category' => 'general',
                'title' => 'Refund Policy',
                'image_path' => null,
                'description' => 'Boleh tak explain pasal refund policy?',
                'resolved_date' => '2023-10-15',
                'solution' => 'Refunds akan di proses dalam masa 7 hari',
                'status' => 'Resolved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'assign_id' => null,
                'category' => 'others',
                'title' => 'Maklum Balas Mengenai Perkhidmatan Pelanggan',
                'image_path' => null,
                'description' => 'Pasukan perkhidmatan pelanggan sangat membantu.',
                'resolved_date' => null,
                'solution' => null,
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
