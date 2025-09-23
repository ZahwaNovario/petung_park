<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = DB::table('users')->pluck('id');
        if ($userIds->isEmpty()) {
            $this->command->warn('Users kosong. Seed users dulu.');
            return;
        }

        $row = function (string $name, int $price, int $catId, string $desc) use ($userIds) {
            return [
                'name'               => $name,
                'description'        => $desc,
                'price'              => $price,
                'status'             => 1,
                'status_recommended' => 0,
                'created_at'         => now(),
                'updated_at'         => now(),
                'user_id'            => $userIds->random(),
                'gallery_id'         => 36,
                'category_id'        => $catId,
            ];
        };

        $items = [];

        // ===== Makanan (id = 1) =====
        $items = array_merge($items, [
            // $row('Paket Hemat 5–6 orang', 150000, 'Makanan', 'Paket makanan lengkap untuk 5–6 orang, cocok untuk keluarga.'),
            // $row('Paket Hemat Super 8–10 orang', 250000, 'Makanan', 'Paket super hemat untuk 8–10 orang dengan menu variatif.'),
            $row('Bebek Ngos Petung', 28000, 1, 'Bebek goreng khas Petung dengan bumbu gurih.'),
            $row('Ayam Goreng/Bakar', 26000, 1, 'Ayam pilihan digoreng atau dibakar dengan bumbu spesial.'),
            $row('Ayam Penyet Sambal Ijo', 26000, 1, 'Ayam goreng penyet dengan sambal ijo segar dan pedas.'),
            $row('Gurame Goreng/Bakar/Madu', 0, 1, 'Gurame dimasak goreng, bakar, atau madu, harga sesuai ukuran.'),
            $row('Mujaher Goreng', 15000, 1, 'Ikan mujair segar digoreng renyah.'),
            $row('Belut Goreng', 20000, 1, 'Belut goreng gurih dengan tekstur renyah.'),
            $row('Pecel Lele', 15000, 1, 'Lele goreng dengan sambal dan lalapan segar.'),
            $row('Jeroan Bebek', 20000, 1, 'Olahan jeroan bebek gurih khas Jawa.'),
            $row('Rica-rica Bebek', 28000, 1, 'Bebek pedas rica-rica dengan cita rasa khas.'),
            $row('Penyetan Tempe', 12000, 1, 'Tempe penyet sederhana dengan sambal tradisional.'),
            $row('Sego Goreng Petung', 13000, 1, 'Nasi goreng khas Petung dengan bumbu spesial.'),
            $row('Sego Goreng Petung Spesial', 16000, 1, 'Versi spesial nasi goreng Petung dengan topping lengkap.'),
            $row('Bakmi Petung (level 1-5)/Ori', 16000, 1, 'Bakmi khas Petung dengan pilihan level pedas.'),
            $row('Ayam Sambal Trancam', 22000, 1, 'Ayam goreng dengan sambal trancam segar.'),
            $row('Sambel Wader', 15000, 1, 'Ikan wader goreng kecil dengan sambal nikmat.'),
            $row('Sego Jagung', 15000, 1, 'Nasi jagung tradisional dengan lauk pendamping.'),
            $row('Klotok Sambal Trancam', 15000, 1, 'Sayur klotok dengan sambal trancam segar.'),
            $row('Ayam Geprek', 15000, 1, 'Ayam krispi yang digeprek dengan sambal pedas.'),
            $row('Sate Ayam', 15000, 1, 'Sate ayam dengan bumbu kacang khas Indonesia.'),
            $row('Cah Kangkung', 10000, 1, 'Tumis kangkung segar dengan bawang putih.'),
            $row('Oseng Rambusah', 10000, 1, 'Oseng rambusah sederhana dan gurih.'),
            $row('Oseng Jamur Tiram', 10000, 1, 'Tumis jamur tiram segar dengan bumbu bawang.'),
            $row('Oseng Pakis', 10000, 1, 'Tumis pakis segar dengan rasa khas pedesaan.'),
            $row('Urap-urap', 10000, 1, 'Sayuran rebus dengan parutan kelapa berbumbu.'),
        ]);

        // ===== Minuman (id = 2) =====
        $items = array_merge($items, [
            $row('Teh Hangat', 6000, 2, 'Teh hangat manis penyegar tenggorokan.'),
            $row('Es Teh', 7000, 2, 'Es teh manis dingin yang menyegarkan.'),
            $row('Es Jeruk', 7000, 2, 'Es jeruk segar dari buah jeruk pilihan.'),
            $row('Jeruk Hangat', 6000, 2, 'Jeruk hangat alami penghangat tubuh.'),
            $row('Wedang Uwuh', 7000, 2, 'Minuman tradisional rempah Jawa.'),
            $row('Kopi Filter', 8000, 2, 'Kopi hitam dengan metode filter manual.'),
            $row('Kopi Biasa', 6000, 2, 'Kopi hitam sederhana dengan rasa klasik.'),
            $row('Kopi Susu', 8000, 2, 'Kopi dengan campuran susu yang creamy.'),
            $row('Es Kopi Susu', 12000, 2, 'Es kopi susu kekinian yang menyegarkan.'),
            $row('Beras Kencur Petung', 12000, 2, 'Jamu beras kencur khas Petung.'),
            $row('Jus Alpukat', 12000, 2, 'Jus alpukat kental dengan topping coklat.'),
            $row('Jus Melon', 12000, 2, 'Jus melon segar manis alami.'),
            $row('Jus Buah Naga', 12000, 2, 'Jus buah naga segar kaya serat.'),
            $row('Jus Mangga', 12000, 2, 'Jus mangga segar manis legit.'),
            $row('Blue Ocean', 12000, 2, 'Minuman mocktail biru segar.'),
            $row('Strawberry Mojito', 12000, 2, 'Mojito dengan rasa stroberi menyegarkan.'),
            $row('Orange Squash', 12000, 2, 'Minuman squash rasa jeruk segar.'),
            $row('Sogem', 12000, 2, 'Minuman unik khas Petung bernama Sogem.'),
            $row('Melon Mocktail', 12000, 2, 'Mocktail segar dengan rasa melon.'),
            $row('Cocopandan Squash', 12000, 2, 'Squash dengan rasa cocopandan manis.'),
            $row('Green Red Squash', 12000, 2, 'Squash segar dengan warna hijau merah.'),
            $row('Melon Yakult Soda', 12000, 2, 'Soda melon segar dengan yakult.'),
            $row('Lime & Cocopandan Squash', 12000, 2, 'Campuran lime dan cocopandan segar.'),
        ]);

        // ===== Snack (id = 3) =====
        $items = array_merge($items, [
            $row('Pisang Goreng Wijen', 10000, 3, 'Pisang goreng ditaburi wijen gurih.'),
            $row('Singkong Keju', 10000, 3, 'Singkong goreng dengan topping keju parut.'),
            $row('Tempe Mendoan', 10000, 3, 'Tempe tipis goreng tepung khas Banyumas.'),
            $row('Stik Kentang', 10000, 3, 'Kentang goreng stik renyah dan gurih.'),
            $row('Pisang Geprek', 10000, 3, 'Pisang goreng geprek dengan taburan gula.'),
            $row('Piscok', 10000, 3, 'Pisang coklat lumer dibalut kulit lumpia.'),
            $row('Cilok Petung', 10000, 3, 'Cilok kenyal khas Petung dengan bumbu kacang.'),
            $row('Tahu Bulat', 10000, 3, 'Tahu bulat gurih lembut dalam gigitan.'),
            $row('Tahu Isi Petung', 10000, 3, 'Tahu isi sayuran khas Petung.'),
            $row('Bakwan Petung', 10000, 3, 'Bakwan goreng renyah khas Petung.'),
            $row('Roti Bakar', 10000, 3, 'Roti bakar dengan aneka topping manis.'),
        ]);

        // ===== Chocco Shake + Topping (id = 4) =====
        $items = array_merge($items, [
            $row('Black Forest', 12000, 4, 'Choco shake dengan rasa black forest manis.'),
            $row('Hazel Nut', 12000, 4, 'Choco shake dengan rasa hazelnut gurih.'),
            $row('Chocco Oreo', 12000, 4, 'Choco shake dengan topping oreo renyah.'),
            $row('Dark Choccolate', 12000, 4, 'Choco shake rasa cokelat pekat.'),
            $row('Chococino', 12000, 4, 'Choco shake dengan sentuhan kopi ringan.'),
        ]);

        // ===== New Menu (id = 5) =====
        $items = array_merge($items, [
            $row('Es Blewah', 8000, 5, 'Es segar dengan potongan blewah manis.'),
            $row('Es Cincau', 8000, 5, 'Es cincau hitam segar dengan gula merah.'),
        ]);

        DB::table('menus')->upsert(
            $items,
            ['name', 'category_id'],
            ['description', 'price', 'status', 'status_recommended', 'updated_at', 'user_id', 'gallery_id']
        );
    }
}
