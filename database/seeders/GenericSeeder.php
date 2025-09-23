<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class GenericSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $footer = '/images/footer/';
        // Retrieve a list of existing staff emails
        $userId = DB::table('users')->pluck('id');

        // Ensure we have at least one staff to reference
        if ($userId->isEmpty()) {
            $this->command->info('No staff found. Please seed the staffs table first.');
            return;
        }

        // Insert multiple records into the generic table
        DB::table('generic')->insert([
            [
                'created_at' => now(),
                'key' => 'link_tautan_website_desa',
                'user_id' => $userId->random(),
                'status' => 1,
                'updated_at' => now(),
                'value' => 'https://belik-mjkkab.desa.id/',
                'icon_picture_link' => null,
            ],
            [
                'created_at' => now(),
                'key' => 'sosial_media_instagram',
                'user_id' => $userId->random(),
                'status' => 1,
                'updated_at' => now(),
                'value' => 'https://www.instagram.com/petungparktrawasnew/?hl=en',
                'icon_picture_link' => $footer.'logoIG.png',
            ],
            [
                'created_at' => now(),
                'key' => 'sosial_media_tiktok',
                'user_id' => $userId->random(),
                'status' => 1,
                'updated_at' => now(),
                'value' => 'https://www.tiktok.com/@petungparktrawasnew?fbclid=PAZXh0bgNhZW0CMTEAAaavE7U4_iIUJ6DVAe5el2Frdvv4r1PWGBSwhBr5yTyBKjsFqaTEgp6-sSU_aem_wy-t6MY_1yGqZyNJmIjecQ',
                'icon_picture_link' => $footer.'logoTikTok.png',
            ],
            [
                'created_at' => now(),
                'key' => 'sosial_media_youtube',
                'user_id' => $userId->random(),
                'status' => 1,
                'updated_at' => now(),
                'value' => 'https://youtube.com/channel/UCL5gPtEXsolRhYjpbXLYgmg',
                'icon_picture_link' => $footer.'logoYoutube.png',
            ],
            [
                'created_at' => now(),
                'key' => 'alamat_petung_park_trawas',
                'user_id' => $userId->random(),
                'status' => 1,
                'updated_at' => now(),
                'value' => 'Jibru, Belik, Trawas, Mojokerto Regency, East Java 61375',
                'icon_picture_link' => null, 
            ],
            [
                'created_at' => now(),
                'key' => 'teks_footer',
                'user_id' => $userId->random(),
                'status' => 1,
                'updated_at' => now(),
                'value' => '©2024 Petung Park Trawas. All rights reserved.',
                'icon_picture_link' => null, 
            ],
            [
                'created_at' => now(),
                'key' => 'kontak_whatsapp',
                'user_id' => $userId->random(),
                'status' => 1,
                'updated_at' => now(),
                'value' => '083132819058',
                'icon_picture_link' => $footer.'logoWA.png',
            ],
            [
                'created_at' => now(),
                'key' => 'gambar_baris_1',
                'user_id' => $userId->random(),
                'status' => 1,
                'updated_at' => now(),
                'value' => 'baris pertama',
                'icon_picture_link' => '/images/galeri/pemandangan/jalanHutanBambu_2.JPG', 
            ],
            [
                'created_at' => now(),
                'key' => 'gambar_baris_2',
                'user_id' => $userId->random(),
                'status' => 1,
                'updated_at' => now(),
                'value' =>'baris kedua',
                'icon_picture_link' =>  '/images/galeri/pemandangan/jalanHutanBambu.JPG', 
            ],
            [
                'created_at' => now(),
                'key' => 'gambar_baris_3',
                'user_id' => $userId->random(),
                'status' => 1,
                'updated_at' => now(),
                'value' => 'baris ketiga',
                'icon_picture_link' => '/images/galeri/pemandangan/pohonBambu.JPG', 
            ],
            [
                'created_at' => now(),
                'key' => 'visi_misi',
                'user_id' => $userId->random(),
                'status' => 1,
                'updated_at' => now(),
                'value' => 'Mewujudkan Dusun Jibru, Desa Belik sebagai desa mandiri dengan 
                            potensi wisata alam yang dikelola secara berkelanjutan, melalui pelestarian 
                            kearifan lokal dan sumber daya alam seperti bambu petung, serta meningkatkan 
                            kesejahteraan masyarakat melalui pengembangan sektor pariwisata.
                            ',
                'icon_picture_link' => null, 
            ],
            [
                'created_at' => now(),
                'key' => 'visi_misi_2',
                'user_id' => $userId->random(),
                'status' => 1,
                'updated_at' => now(),
                'value' => 'Menjaga kelestarian bambu petung sebagai ikon wisata dan sumber daya alam, serta 
                            mengembangkan Petung Park untuk mendukung perekonomian lokal. Selain itu, misi ini 
                            mendorong kemandirian desa melalui pengelolaan wisata berbasis desa yang berkelanjutan,
                             dengan melibatkan partisipasi aktif masyarakat dalam menjaga lingkungan dan memanfaatkan 
                             sumber daya alam demi kesejahteraan bersama.',
                'icon_picture_link' => null, 
            ],
            [
                'created_at' => now(),
                'key' => 'sejarah',
                'user_id' => $userId->random(),
                'status' => 1,
                'updated_at' => now(),
                'value' => 'Petung Park, terletak di Desa Belik yang memiliki arti 
                "mata air kecil," memanfaatkan potensi alam desa yang kaya akan sumber mata air alami.
                 Salah satu yang paling menonjol adalah hutan bambu Petung, seluas 3,5 hektar, yang dipenuhi oleh 
                 bambu Petung berusia ratusan tahun. Hutan ini bahkan disebut sebagai salah satu yang tertua di Jawa Timur. 
                 Awalnya, Desa Belik hanya menjadi jalur lintas di perbatasan Trawas dan Prigen, hingga kepala desa memutuskan 
                 untuk mengembangkan potensi wisatanya.',
                'icon_picture_link' => null, 
            ],
            [
                'created_at' => now(),
                'key' => 'sejarah_2',
                'user_id' => $userId->random(),
                'status' => 1,
                'updated_at' => now(),
                'value' => 'Petung Park menawarkan pemandangan sawah hijau, hutan bambu yang rimbun,
                  serta udara segar yang sejuk. Fasilitas wisata semakin lengkap dengan dibangunnya pujasera dan gazebo unik di tahun 2021, 
                  yang mengalirkan air langsung dari sumber mata air alami. Pengunjung dapat menikmati hidangan sambil bermain air di gazebo 
                  dengan latar pemandangan Gunung Penanggungan. Petung Park kini menjadi destinasi wisata populer yang menawarkan pengalaman 
                  alam eksotis dan relaksasi dengan harga terjangkau, ideal untuk bersantai dan menghilangkan penat.',
                'icon_picture_link' => null, 
            ],
            [
                'created_at' => now(),
                'key' => 'video_promosi',
                'user_id' => $userId->random(),
                'status' => 1,
                'updated_at' => now(),
                'value' => 'https://www.youtube.com/embed/wq8MRjtlkxQ',
                'icon_picture_link' => $footer.'logoYoutube.png',
            ],
            [
                'created_at' => now(),
                'key' => 'sejarah_beranda',
                'user_id' => $userId->random(),
                'status' => 1,
                'updated_at' => now(),
                'value' => 'Petung Park berada di Desa Belik, kata “Belik”
                memiliki arti mata air kecil. Seperti namanya, Desa
                Belik memang mempunyai banyak mata air kecil
                alami, salah satunya yang berada di hutan bambu
                Petung. Hutan bambu Petung memiliki luas sekitar
                3,5 hektar yang ditumbuhi pohon bambu Petung
                berusia ratusan tahun, bahkan perangkat Desa
                menyebut hutan bambu petung di Belik ini
                merupakan salah satu hutan bambu tertua di Jawa
                Timur.',
                'icon_picture_link' => null, 
            ],
            [
                'created_at' => now(),
                'key' => 'lokasi',
                'user_id' => $userId->random(),
                'status' => 1,
                'updated_at' => now(),
                'value' => 'Jibru, Belik, Kec. Trawas, Kabupaten Mojokerto, Jawa Timur 61375',
                'icon_picture_link' => "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3954.217618060445!2d112.61724131177796!3d-7.659736192324794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7d92930acc995%3A0x820cde960a28c319!2sPETUNG%20PARK!5e0!3m2!1sid!2sid!4v1727851391086!5m2!1sid!2sid", 
            ],
            [
                'created_at' => now(),
                'key' => 'jam_operasional',
                'user_id' => $userId->random(),
                'status' => 1,
                'updated_at' => now(),
                'value' => '09.00 - 17.00',
                'icon_picture_link' => "/images/beranda/logo/jam.png", 
            ],
        ]);
    }
}
