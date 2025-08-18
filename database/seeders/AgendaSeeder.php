<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Retrieve a list of existing staff emails
        $userId = DB::table('users')->pluck('id');

        // Ensure we have at least one staff to reference
        if ($userId->isEmpty()) {
            $this->command->info('No staff found. Please seed the staffs table first.');
            return;
        }

        // Insert multiple records into the agendas table
        DB::table('agendas')->insert([
            [
                'event_name' => 'Soft Opening Petung Park',
                'event_start_date' => '2022-11-18',
                'event_end_date' => '2022-11-18',
                'event_location' => 'Petung Park',
                'status' => 1,
                'description' => 'Soft Opening Petung Park pada tanggal 18 November 2022. Ayo datang dan nikmati suasana baru. Nikmati makanan dan minuman yang sangat enak',
                'created_at' => now(),
                'updated_at' => now(),
                'user_id' => $userId->random(),
            ],
            [
                'event_name' => 'Soft Opening Baby Pool',
                'event_start_date' => '2023-12-25',
                'event_end_date' => '2023-12-25',
                'event_location' => 'Baby Pool',
                'status' => 1,
                'description' => 'Ayo datang pada Soft Opening Baby Pool yang sangat Kids Friendly !!',
                'created_at' => now(),
                'updated_at' => now(),
                'user_id' => $userId->random(),
            ],
            [
                'event_name' => 'Sambang Desa dengan Menteri Desa, Pembangunan Daerah Tertinggal, dan Transmigrasi, Dr. (H.C.) Drs. H. Abdul Halim Iskandar, M.Pd',
                'event_start_date' => '2024-08-27',
                'event_end_date' => '2024-08-27',
                'event_location' => 'Petung Park',
                'status' => 1,
                'description' => 'Mengunjungi Petung Park (Taman Bambu Petung), Desa Belik, Kec. Trawas, Kab. Mojokerto oleh Bapak Dr. (H.C.) Drs. H. Abdul Halim Iskandar, M.Pd ',
                'created_at' => now(),
                'updated_at' => now(),
                'user_id' => $userId->random(),
            ],
            [
                'event_name' => 'Atraksi Budaya Lokal (Senam Sehat, Jalan Santai, Pencak Silat dan Bantengan)',
                'event_start_date' => '2024-08-25',
                'event_end_date' => '2024-08-25',
                'event_location' => 'Hutan Bambu',
                'status' => 1,
                'description' => 'Ayo Ramaikan Event yang sangat dinanti oleh masyarakat yaitu Event Budaya Lokal. Terdapat banyak event yaitu Senam Sehat, Jalan Santai, Pencak Silat dan Bantengan.',
                'created_at' => now(),
                'updated_at' => now(),
                'user_id' => $userId->random(),
            ],
            [
                'event_name' => 'Pelatihan Pelayanan Prima',
                'event_start_date' => '2024-09-13',
                'event_end_date' => '2024-09-13',
                'event_location' => 'Petung Park',
                'status' => 1,
                'description' => 'Pelatihan yang diselenggarakan oleh Universitas Surabaya (Ubaya) untuk pengelola atau staff desa wisata petung park dengan tema Pelatihan Pelayanan Prima',
                'created_at' => now(),
                'updated_at' => now(),
                'user_id' => $userId->random(),
            ],
            // [
            //     'event_name' => 'Pelatihan Ekowisata dan Kelembagaan Wisata',
            //     'event_start_date' => '2024-09-06',
            //     'event_end_date' => '2024-09-13',
            //     'event_location' => 'Petung Park',
            //     'status' => 1,
            //     'description' => 'Pelatihan yang diselenggarakan oleh Universitas Surabaya (Ubaya) untuk pengelola atau staff desa wisata petung park dengan tema Pelatihan Ekowisata dan Kelembagaan Wisata',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            //     'user_id' => $userId->random(),
            // ],
            // [
            //     'event_name' => 'Hash Oktober 2024',
            //     'event_start_date' => '2024-10-01',
            //     'event_end_date' => '2024-10-02',
            //     'event_location' => 'Hutan Bambu',
            //     'status' => 1,
            //     'description' => 'Kegiatan Hash Oktober 2024 diikuti oleh kelompok pelari dan pejalan kaki dari berbagai daerah, melintasi jalur menantang di Hutan Bambu. Acara ini menggabungkan olahraga, petualangan, dan kebersamaan, dengan titik akhir di lokasi perkemahan yang asri.',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            //     'user_id' => $userId->random(),
            // ],
        ]);
    }
}
