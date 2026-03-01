<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UmkmCategory;
use App\Models\UmkmProfile;
use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── USERS ──────────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Admin UMKM Padang',
            'email'    => 'admin@umkmpadang.id',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'is_active'=> true,
        ]);

        $dinas = User::create([
            'name'     => 'Dinas Koperasi Kota Padang',
            'email'    => 'dinas@umkmpadang.id',
            'password' => Hash::make('password'),
            'role'     => 'dinas',
            'is_active'=> true,
        ]);

        $customer = User::create([
            'name'     => 'Siti Pelanggan',
            'email'    => 'pelanggan@umkmpadang.id',
            'password' => Hash::make('password'),
            'role'     => 'customer',
            'is_active'=> true,
        ]);

        // ── UMKM CATEGORIES ────────────────────────────────────
        $cats = [
            ['name'=>'Kuliner',       'icon'=>'🍛'],
            ['name'=>'Fashion',       'icon'=>'👗'],
            ['name'=>'Kerajinan',     'icon'=>'🧶'],
            ['name'=>'Kecantikan',    'icon'=>'💄'],
            ['name'=>'Pertanian',     'icon'=>'🌿'],
            ['name'=>'Jasa & Servis', 'icon'=>'🔧'],
            ['name'=>'Pendidikan',    'icon'=>'📚'],
            ['name'=>'Furnitur',      'icon'=>'🪑'],
        ];

        $umkmCats = [];
        foreach ($cats as $c) {
            $umkmCats[$c['name']] = UmkmCategory::create([
                'name'      => $c['name'],
                'slug'      => Str::slug($c['name']),
                'icon'      => $c['icon'],
                'is_active' => true,
            ]);
        }

        // ── PRODUCT CATEGORIES ─────────────────────────────────
        $prodCats = ['Makanan','Minuman','Pakaian','Aksesoris','Tas','Perawatan','Sayuran','Buah','Mebel'];
        $productCats = [];
        foreach ($prodCats as $pc) {
            $productCats[$pc] = ProductCategory::create([
                'name'      => $pc,
                'slug'      => Str::slug($pc),
                'is_active' => true,
            ]);
        }

        // ── UMKM PROFILES ──────────────────────────────────────
        $umkmData = [
            ['name'=>'Rendang Bu Maimun',       'cat'=>'Kuliner',   'kec'=>'Padang Barat',   'lat'=>-0.9492, 'lng'=>100.3543],
            ['name'=>'Songket Minangkabau Asli','cat'=>'Fashion',   'kec'=>'Koto Tangah',    'lat'=>-0.8692, 'lng'=>100.3721],
            ['name'=>'Kopi Solok Radjo',         'cat'=>'Kuliner',   'kec'=>'Padang Timur',   'lat'=>-0.9310, 'lng'=>100.3760],
            ['name'=>'Kerajinan Rotan Saiyo',    'cat'=>'Kerajinan', 'kec'=>'Lubuk Kilangan', 'lat'=>-0.9980, 'lng'=>100.4120],
            ['name'=>'Kue Sapik Uni Ros',        'cat'=>'Kuliner',   'kec'=>'Nanggalo',       'lat'=>-0.9050, 'lng'=>100.3620],
            ['name'=>'Kosmetik Alami Minang',    'cat'=>'Kecantikan','kec'=>'Padang Selatan', 'lat'=>-0.9680, 'lng'=>100.3450],
        ];

        foreach ($umkmData as $u) {
            $user = User::create([
                'name'     => 'Pemilik ' . $u['name'],
                'email'    => Str::slug($u['name']) . '@umkm.test',
                'password' => Hash::make('password'),
                'role'     => 'umkm',
                'is_active'=> true,
            ]);

            $umkmProfile = UmkmProfile::create([
                'user_id'     => $user->id,
                'name'        => $u['name'],
                'slug'        => Str::slug($u['name']),
                'category_id' => $umkmCats[$u['cat']]->id,
                'description' => 'UMKM ' . $u['name'] . ' menyediakan produk berkualitas dari Kota Padang.',
                'address'     => 'Jl. Contoh No. 1, ' . $u['kec'],
                'kecamatan'   => $u['kec'],
                'latitude'    => $u['lat'],
                'longitude'   => $u['lng'],
                'whatsapp'    => '08' . rand(100000000, 999999999),
                'status'      => 'active',
                'verified_at' => now(),
            ]);

            // Buat 3 produk per UMKM
            for ($i = 1; $i <= 3; $i++) {
                $prodCat = $productCats[array_key_first($productCats)];
                Product::create([
                    'umkm_id'      => $umkmProfile->id,
                    'category_id'  => $prodCat->id,
                    'name'         => 'Produk ' . $i . ' dari ' . $u['name'],
                    'slug'         => Str::slug('Produk ' . $i . ' ' . $u['name']) . '-' . uniqid(),
                    'description'  => 'Deskripsi produk unggulan dari ' . $u['name'],
                    'price'        => rand(15, 500) * 1000,
                    'stock'        => rand(10, 100),
                    'unit'         => 'pcs',
                    'is_available' => true,
                    'is_featured'  => $i === 1,
                ]);
            }
        }

        $this->command->info('✅ Seeder selesai! Akun tersedia:');
        $this->command->info('   Admin   : admin@umkmpadang.id / password');
        $this->command->info('   Dinas   : dinas@umkmpadang.id / password');
        $this->command->info('   Customer: pelanggan@umkmpadang.id / password');
        $this->command->info('   UMKM    : [nama-umkm]@umkm.test / password');
    }
}
