<?php

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'firstname' => 'Admin',
            'lastname' => 'Resabilletcse',
            'email' => 'admin@resabilletcse.com',
            'password' => Hash::make('rbU89a-4'),
            'group' => 'admin',
            'active' => true
        ]);

        User::create([
            'firstname' => 'Agent',
            'lastname' => 'Resabilletcse',
            'email' => 'agent@resabilletcse.com',
            'password' => Hash::make('rbU89a-4'),
            'group' => 'agent',
            'active' => true
        ]);

        User::create([
            'firstname' => 'Client',
            'lastname' => 'Resabilletcse',
            'email' => 'customer@resabilletcse.com',
            'password' => Hash::make('rbU89a-4'),
            'group' => 'customer',
            'active' => true
        ]);
        \App\Models\User\User::factory(10)->create(['group' => 'customer', 'active' => true]);
        $this->call(ShopSeeder::class);
        $this->call(CatalogueSeeder::class);
    }
}
