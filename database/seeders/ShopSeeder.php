<?php

namespace Database\Seeders;

use App\Models\Core\Shop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shop::create([
            'holding' => "Resabilletcse",
            "address" => "22 Rue Maryse Bastié",
            "postal" => "85100",
            "city" => "Les Sables d'Olonne",
            "email" => "contact@resabilletcse.com",
            "phone" => "0 899 492 648",
            "bic" => "TRZOFR21XXX",
            "iban" => "FR76 1679 8000 0100 0005 8984 075",
            "siret" => "521 809 061 00059"
        ]);
    }
}
