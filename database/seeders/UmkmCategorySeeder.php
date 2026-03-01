<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UmkmCategory;
use Illuminate\Support\Str;

class UmkmCategorySeeder extends Seeder
{
    public function run(): void
    {
        $cats = [
            ['name' => 'Kuliner',       'icon' => '🍛'],
            ['name' => 'Fashion',       'icon' => '👗'],
            ['name' => 'Kerajinan',     'icon' => '🧶'],
            ['name' => 'Kecantikan',    'icon' => '💄'],
            ['name' => 'Pertanian',     'icon' => '🌿'],
            ['name' => 'Jasa & Servis', 'icon' => '🔧'],
            ['name' => 'Pendidikan',    'icon' => '📚'],
            ['name' => 'Furnitur',      'icon' => '🪑'],
        ];

        foreach ($cats as $c) {
            UmkmCategory::firstOrCreate(
                ['slug' => Str::slug($c['name'])],
                ['name' => $c['name'], 'icon' => $c['icon'], 'is_active' => true]
            );
        }
    }
}