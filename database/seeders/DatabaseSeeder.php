<?php

namespace Database\Seeders;

use App\Models\User;
use  App\Models\Bloc ;
use App\Models\Store;
use Database\Factories\BlocFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(10)->create();

        
        bloc::factory()->count(50)->create(); 
        Store::factory()->count(50)->create();
    }
}
