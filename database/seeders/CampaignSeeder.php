<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Campaign;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Insert sample campaigns
        Campaign::insert([
            [
                'created_by' => 2, // ID of the user who created the campaign
                'title' => 'Bantuan Pendidikan Anak Yatim',
                'image_path' => 'donation_images/1.jpeg',
                'description' => 'Membantu menyediakan keperluan pendidikan untuk anak-anak yatim di RPTAR.',
                'target_amount' => 50000.00,
                'current_amount' => 0.0,
                'start_date' => '2026-01-01',
                'end_date' => '2026-12-31',
                'status' => 'active',
            ],
            [
                'created_by' => 2,
                'title' => 'Program Makanan Berkhasiat',
                'image_path' => 'donation_images/2.jpg',
                'description' => 'Menyediakan makanan berkhasiat untuk anak-anak yatim di RPTAR.',
                'target_amount' => 20000.00,
                'current_amount' => 0.0,
                'start_date' => '2026-02-01',
                'end_date' => '2026-06-30',
                'status' => 'pending',
            ],
            [
                'created_by' => 2,
                'title' => 'Kempen Pakaian Sekolah',
                'image_path' => 'donation_images/3.png',
                'description' => 'Membekalkan pakaian sekolah untuk anak-anak yatim di RPTAR.',
                'target_amount' => 15000.00,
                'current_amount' => 0.0,
                'start_date' => '2026-03-01',
                'end_date' => '2026-08-31',
                'status' => 'pending',
            ],
        ]);
    }
}
