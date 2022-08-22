<?php

namespace Database\Seeders;

use App\Models\Catalogue\Catalogue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Catalogue::query()->create([
            'uuid' => Str::uuid(),
            'name' => "Ciné",
            "url" => "reduccine.fr"
        ])->create([
            'uuid' => Str::uuid(),
            'name' => "Parc & Loisirs",
            "url" => "reducparc.fr"
        ])->create([
            'uuid' => Str::uuid(),
            'name' => "Cadeaux",
            "url" => "reduckdo.fr"
        ]);
    }
}
