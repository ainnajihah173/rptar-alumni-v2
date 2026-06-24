<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Events;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Events::insert([
            [
                'organizer_id' => 1,
                'name' => 'Program Bakti RPTAR',
                'created_by' => 2,
                'image_path' => 'event_images/1.jpg',
                'description' => 'Program bakti untuk memberikan sokongan dan kasih sayang kepada anak-anak yatim di RPTAR.',
                'start_date' => '2025-02-15',
                'end_date' => '2025-02-15',
                'start_time' => '09:00:00',
                'end_time' => '14:00:00',
                'location' => 'Rumah Penyayang Tun Abdul Razak (RPTAR)',
                'capacity' => 50,
                'registered_count' => 0,
                'is_active' => true,
                'status' => 'approved',
            ],
            [
                'organizer_id' => 2,
                'name' => 'Kem Motivasi RPTAR',
                'created_by' => 2,
                'image_path' => 'event_images/2.jpeg',
                'description' => 'Kem motivasi untuk membina keyakinan diri dan semangat belajar anak-anak yatim.',
                'start_date' => '2025-03-10',
                'end_date' => '2025-03-12',
                'start_time' => '08:00:00',
                'end_time' => '17:00:00',
                'location' => 'Dewan RPTAR',
                'capacity' => 30,
                'registered_count' => 0,
                'is_active' => true,
                'status' => 'approved',
            ],
            [
                'organizer_id' => 3,
                'name' => 'Majlis Hari Raya RPTAR',
                'created_by' => 2,
                'image_path' => 'event_images/3.jpeg',
                'description' => 'Majlis sambutan Hari Raya bersama anak-anak yatim di RPTAR.',
                'start_date' => '2025-04-20',
                'end_date' => '2025-04-20',
                'start_time' => '10:00:00',
                'end_time' => '15:00:00',
                'location' => 'Rumah Penyayang Tun Abdul Razak (RPTAR)',
                'capacity' => 100,
                'registered_count' => 0,
                'is_active' => true,
                'status' => 'approved',
            ],
            [
                'organizer_id' => 4,
                'name' => 'Program Pendidikan & Bimbingan',
                'created_by' => 2,
                'image_path' => 'event_images/4.jpg',
                'description' => 'Program pendidikan dan bimbingan untuk membantu anak-anak yatim dalam pelajaran.',
                'start_date' => '2025-05-05',
                'end_date' => '2025-05-05',
                'start_time' => '14:00:00',
                'end_time' => '17:00:00',
                'location' => 'Pusat Sumber RPTAR',
                'capacity' => 20,
                'registered_count' => 0,
                'is_active' => true,
                'status' => 'approved',
            ],
            [
                'organizer_id' => 5,
                'name' => 'Aktiviti Sukan & Rekreasi',
                'created_by' => 2,
                'image_path' => 'event_images/5.jpg',
                'description' => 'Aktiviti sukan dan rekreasi untuk menggalakkan gaya hidup sihat di kalangan anak-anak yatim.',
                'start_date' => '2025-06-01',
                'end_date' => '2025-06-01',
                'start_time' => '08:00:00',
                'end_time' => '12:00:00',
                'location' => 'Padang Bola RPTAR',
                'capacity' => 40,
                'registered_count' => 0,
                'is_active' => false,
                'status' => 'pending',
            ],
            [
                'organizer_id' => 6,
                'name' => 'Program Kebajikan & Sumbangan',
                'created_by' => 2,
                'image_path' => 'event_images/6.jpg',
                'description' => 'Program kebajikan untuk memberikan sumbangan kepada anak-anak yatim di RPTAR.',
                'start_date' => '2025-07-15',
                'end_date' => '2025-07-15',
                'start_time' => '10:00:00',
                'end_time' => '13:00:00',
                'location' => 'Rumah Penyayang Tun Abdul Razak (RPTAR)',
                'capacity' => 60,
                'registered_count' => 0,
                'is_active' => false,
                'status' => 'pending',
            ],
        ]);
    }
}