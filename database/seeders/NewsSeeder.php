<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $news = [
            [
                'title' => 'Kunjungan Mara Negeri Pahang ke RPTAR',
                'slug' => Str::slug('Kunjungan Mara Negeri Pahang ke RPTAR'),
                'content' => 'PEKAN, 25 Dec 2024 - Pejabat MARA Daerah Pekan dengan kerjasama GIATMARA Negeri Pahang GIATMARA Pekan dan Persatuan Penyewa Arked MARA Pekan telah menganjurkan satu program iaitu Tanggungjawab Sosial Korporat (CSR) sempena hari MARA ke 58 bertujuan untuk mengedarkan bubur lambuk kepada orangf awam di sekitar Arked MARA 2, Pekan dan juga di Rumah Penyayang Tun Abdul Razak, Pekan, Pahang.',
                'user_id' => 2,
                'image' => 'news_images/1.jpg',
                'is_active' => true,
                'views' => 0,
                'published_date' => '2024-12-25 00:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Bersantai di Pantai Sepat',
                'slug' => Str::slug('Bersantai di Pantai Sepat'),
                'content' => 'PEKAN 23 Nov 2024, Penghuni Rumah Penyanyang, pelajar putera telah menghabiskan masa cuti hujung minggu dengan bersantai di pantai sepat kuantan, setelah membuat kunjungan mesra di rumah anak yatim permata camar.',
                'user_id' => 2,
                'image' => 'news_images/2.jpg',
                'is_active' => true,
                'views' => 0,
                'published_date' => '2024-11-23 00:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Program Mahasiswa Kolej Islam Pahang Sultan Haji Ahmad Shah bersama Anak-anak Penyayang',
                'slug' => Str::slug('Program KIP'),
                'content' => 'PEKAN 15 Nov 2024, Mahasiswa KIPSAS telah mengadakan program bersama anak-anak penyayang selama 2 hari, program yang diadakan adalah bertujuan untuk mengeratkan lagi hubungan silaturahim antara mahasiswa dan anak yatim. Selain itu mahasiswa KIPSAS mengadakan ceramah motivasi, LDK, Qiamullail dan beberapa Games yang mencabar minda dan menguji ketahanan mental,yang mana program ini berlangsung pada jam 11.30 malam dan berakhir pada jam 1.30pagi. Program ini juga di meriahkan lagi dengan majlis sambutan hari lahir bagi anak2 penyayang dan mahasiswa kipsas yang lahir pada bulan 7, 8 & 9. Mereka di jamukan dengan pulut kuning beserta rendang daging dan penyampaian hadiah kepada yang menyambut hari lahir. Program berakhir pada hari sabtu jam 10 pagi dengan majlis menyampaian hadiah dan hamper kepada anak-anak penyayang serta sumbangan cenderamata kepada pihak pengurusan Rumah Penyayang...',
                'user_id' => 2,
                'image' => 'news_images/3.jpeg',
                'is_active' => true,
                'views' => 0,
                'published_date' => '2024-11-15 00:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Tadarus Quran Ramadhan',
                'slug' => Str::slug('Tadarus Quran Ramadhan'),
                'content' => 'PEKAN 14 Apr 2024, pelajar rumah penyayang melakukan aktiviti Tadarus Quran antara magrib dan isyak sepanjang bulan ramadhan ini.',
                'user_id' => 2,
                'image' => 'news_images/4.jpg',
                'is_active' => true,
                'views' => 0,
                'published_date' => '2024-04-14 00:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Lawatan ke Melaka 2024',
                'slug' => Str::slug('Lawatan ke Melaka 2024'),
                'content' => 'PEKAN 20 Dec 2024, Bertarikh 12 - 15 December 2024, Penghuni Rumah Penyayang telah membuat lawatan ke Melaka bandaraya bersejarah. Lawatan selama 6 hari itu telah membawa semua pelajar ruptar mengelilingi bandaraya melaka.. Mereka merasa sangat gembira selain dapat merehatkan minda setelah setahun memerah otak menuntut ilmu. Selain itu juga mereka dapat melihat sendiri kesan-kesan sejarah yang terdapat di bandaraya melaka.',
                'user_id' => 2,
                'image' => 'news_images/5.JPG',
                'is_active' => true,
                'views' => 0,
                'published_date' => '2024-12-20 00:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('news')->insert($news);
    }
}