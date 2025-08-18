<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ArticleSeeder extends Seeder
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

        // Retrieve a list of existing agenda IDs
        $agendaIds = DB::table('agendas')->orderBy('id')->pluck('id');

        // Ensure we have at least one staff and one agenda to reference
        if ($userId->isEmpty() || $agendaIds->isEmpty()) {
            $this->command->info('No staff or agendas found. Please seed the staffs and agendas tables first.');
            return;
        }

        // Insert multiple records into the articles table
        DB::table('articles')->insert([
            // [
            //     'title' => 'Kemah in Petung Park',
            //     'main_content' => 'Petung Park, sebuah destinasi alam yang memikat di tengah kesejukan hutan pinus, menjadi lokasi ideal untuk
            //      kegiatan kemah yang tak terlupakan. Berkemah di Petung Park memberikan pengalaman berbeda bagi para pecinta alam dan keluarga 
            //      yang ingin merasakan nuansa alam terbuka. Suasana yang tenang, udara sejuk, dan rindangnya pepohonan pinus menciptakan harmoni
            //       sempurna untuk melepas penat dari rutinitas sehari-hari. Para peserta kemah dapat menikmati berbagai aktivitas seperti trekking di jalur hutan, 
            //       mengamati bintang di langit malam yang jernih, serta menikmati api unggun bersama teman atau keluarga. Dengan fasilitas yang nyaman dan lingkungan yang asri, 
            //       Petung Park menjadi tempat yang sempurna untuk merasakan kedamaian dan keindahan alam, menjadikan momen kemah kali ini penuh kesan dan kebahagiaan.',
            //     'status' => 1,
            //     'user_id' => $userId->random(),
            //     'number_love' => $faker->numberBetween(0, 100),
            //     'agenda_id' => $agendaIds[3],
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
            [
                'title' => 'Soft Opening Petung Park',
                'main_content' => 'Petung Park kembali menghadirkan destinasi wisata alam yang memikat dengan pembukaan Wisata Hutan Bambu. 
                 Hutan bambu yang asri dan rindang ini menawarkan pengalaman baru bagi para pengunjung yang ingin menikmati kesejukan alam serta suasana yang tenang dan damai.
                 Dengan jalan setapak yang teratur di antara rumpun bambu yang menjulang tinggi, para wisatawan dapat merasakan kedekatan dengan alam sambil menikmati semilir angin yang menyejukkan.
                  Tidak hanya sebagai tempat rekreasi, wisata ini juga menjadi ajang edukasi untuk mengenal lebih dalam tentang ekosistem hutan bambu dan pentingnya menjaga kelestarian alam. 
                  Pembukaan Wisata Hutan Bambu di Petung Park menjadi langkah positif dalam memperkaya destinasi wisata alam di daerah ini, 
                  menawarkan keindahan yang menenangkan sekaligus memberikan ruang bagi pengunjung untuk berinteraksi dengan alam secara langsung.',
                'status' => 1,
                'user_id' => $userId->random(),
                'agenda_id' => $agendaIds[0],
                'number_love' => $faker->numberBetween(0, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Baby Pool sambil Menikmati Pemandangan Desa',
                'main_content' => 'Menghabiskan waktu di baby pool sambil menikmati pemandangan desa menjadi pilihan rekreasi yang sempurna untuk keluarga, 
                terutama bagi orang tua dengan anak kecil. Kolam renang khusus anak ini didesain dengan kedalaman yang aman, memungkinkan si kecil bermain air dengan riang dan bebas.
                 Sambil menemani anak-anak bermain, para orang tua dapat bersantai menikmati keindahan alam desa yang asri, dengan latar belakang hamparan sawah, perbukitan hijau, dan udara segar yang menenangkan.
                  Suasana pedesaan yang tenang dan jauh dari keramaian kota memberikan sensasi liburan yang menyejukkan hati dan pikiran. Baby pool ini tidak hanya menawarkan kesenangan bagi anak-anak, tetapi juga 
                  menjadi tempat bagi keluarga untuk merasakan kebersamaan dan harmoni dengan alam sekitar.',
                'status' => 1,
                'user_id' => $userId->random(),
                'agenda_id' =>  $agendaIds[1],
                'number_love' => $faker->numberBetween(0, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sambang Desa dengan Menteri Desa, Pembangunan Daerah Tertinggal, dan Transmigrasi, Dr. (H.C.) Drs. H. Abdul Halim Iskandar, M.Pd',
                'main_content' => 'Dikutip dari instagram @halimiskandarnu, Mengunjungi Petung Park (Taman Bambu Petung), Desa Belik, Kec. Trawas, Kab. Mojokerto. 
                Desa ini memiliki lahan kurang lebih 5 hektar kebun bambu petung. Sementara masih dimanfaatkan 5% dari luas lahan untuk rumah makan yang terbuat dari bambu petung. 
                Menu masakannya banyak, ada bebek mentok, ada lele, aneka lalapan, urap dan lain lain. Percaya Desa, Desa Bisa!',
                'status' => 1,
                'user_id' => $userId->random(),
                'agenda_id' =>  $agendaIds[2],
                'number_love' => $faker->numberBetween(0, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Atraksi Budaya Lokal (Senam Sehat, Jalan Santai, Pencak Silat dan Bantengan)',
                'main_content' => 'Desa Belik memiliki banyak potensi untuk atraksi wisata. Sampai saat ini potensi dan
                kearifan lokal belum dijadikan sebagai salah satu atraksi untuk menarik wisatawan. Budaya lokal yang dimiliki antara lain tari daerah yang biasanya ditampilkan anak-anak SD, pencak silat, dan bentengan. 
                Pada 25 Agustus 2024, bersamaan dengan peringatan kemerdekaan Indonesia yang ke-79, ditampilkan budaya lokal untuk mengenalkan ke masyarakat dan meningkatkan pengunjung. Masyarakat sangat antusias mengikuti pertunjukkan budaya local ini. Setelah acara doorprize kemerdekaan, Masyarakat setia menanti pertunjukkan. Wisatawa juga antusias melihat pertunjukkan sambil menikmati menu makanan Petung Park.',
                'status' => 1,
                'user_id' => $userId->random(),
                'agenda_id' =>  $agendaIds[3],
                'number_love' => $faker->numberBetween(0, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pelatihan Pelayanan Prima',
                'main_content' => 'Pelatihan pelayanan prima dilakukan pada tanggal 13 September 2024 di Petung Park. Narasumber pada pelatihan ini adalah Bapak Hayomi Gunawan, SH. MK. CHt atau biasa di panggil Pak Bram. Narasumber adalah seorang pakar komunikasi, motivator, penyiar yang sangat menguasai topik terkait pelayanan prima ke pelanggan. Pada kegiatan ini, peserta selain mendapat materi juga diajak langsung untuk praktek dalam melayani pelanggan. Selain itu peserta diminta untuk mempresentasikan hasil diskusi terkait topik kerjasama dalam tim. Namun karena keterbatasan waktu, topik manajemen komplain belum terbahas. Hal ini disebabkan peserta sangat antusias untuk berdiskusi terkait pelayanan prima, sehingga tanpa sadar waktu sudah habis.',
                'status' => 1,
                'user_id' => $userId->random(),
                'agenda_id' =>  $agendaIds[4],
                'number_love' => $faker->numberBetween(0, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // [
            //     'title' => 'Pelatihan Ekowisata dan Kelembagaan Wisata',
            //     'main_content' => 'Pelatihan Ekowisata dan kelembagaan wisata diberikan pada hari Jumat, 6 September 2024 di Petung Park dengan narasumber Bapak Joko Mijiarto, S.Hut., M.Si. Narasumber merupakan salah satu anggota tim pengabdian dengan kepakaran ekowisata. Materi pelatihan dapat dilihat pada materi ekowisata. Pada pelatihan ini, selain memberikan materi terkait, narasumber juga mengajak peserta untuk menggali potensi desa yang bisa dikembangkan sehingga bisa mendukung pengembangan desa wisata.',
            //     'status' => 1,
            //     'user_id' => $userId->random(),
            //     'agenda_id' =>  $agendaIds[6],
            //     'number_love' => $faker->numberBetween(0, 20),
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
            // [
            //     'title' => 'Tracking di Hutan Bambu Hash Oktober 2024',
            //     'main_content' => 'Oktober 2024 menjadi bulan yang ditunggu-tunggu oleh para penggemar petualangan alam dengan diadakannya acara Tracking di Hutan Bambu Petung Park Hash. 
            //     Mengusung konsep perjalanan menyusuri hutan bambu yang rimbun dan menyejukkan, kegiatan ini menghadirkan pengalaman yang penuh tantangan sekaligus menyegarkan.
            //      Para peserta akan melintasi jalur yang telah disiapkan khusus, melewati pepohonan bambu yang menjulang tinggi, serta merasakan sejuknya suasana hutan yang jauh dari hiruk-pikuk kota.
            //       Acara ini tidak hanya menguji fisik, tetapi juga mengajak para peserta untuk lebih dekat dengan alam. Dengan berbagai rintangan alami seperti jalur tanah berbatu dan akar bambu yang menjalar, 
            //       tracking di Hutan Bambu Petung Park Hash menjanjikan sensasi petualangan yang unik dan penuh kegembiraan. Suasana yang asri, ditambah dengan kesempatan untuk bersosialisasi dengan sesama pecinta alam, 
            //       menjadikan event ini sebagai salah satu kegiatan outdoor paling dinantikan di tahun ini.',
            //     'status' => 1,
            //     'user_id' => $userId->random(),
            //     'agenda_id' =>  $agendaIds[4],
            //     'number_love' => $faker->numberBetween(0, 100),
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
        ]);
    }
}
