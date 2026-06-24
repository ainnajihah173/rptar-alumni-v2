<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventOrganizer;

class EventOrganizerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EventOrganizer::insert([
            [
                'organizer_name' => 'Tech Group Malaysia',
                'organizer_contact' => '012-3456789',
                'organizer_email' => 'contact@techgroup.my',
            ],
            [
                'organizer_name' => 'Alumni Association',
                'organizer_contact' => '013-9876543',
                'organizer_email' => 'info@alumniassociation.org',
            ],
            [
                'organizer_name' => 'Career Boosters',
                'organizer_contact' => '014-1234567',
                'organizer_email' => 'support@careerboosters.com',
            ],
            [
                'organizer_name' => 'Healthy Living Society',
                'organizer_contact' => '011-22334455',
                'organizer_email' => 'health@livingsociety.org',
            ],
            [
                'organizer_name' => 'Art & Music Lovers',
                'organizer_contact' => '016-5566778',
                'organizer_email' => 'events@artmusiclovers.com',
            ],
            [
                'organizer_name' => 'RPTAR Volunteer Group',
                'organizer_contact' => '019-8899000',
                'organizer_email' => 'volunteers@rptar.org',
            ],
        ]);
    }
}
