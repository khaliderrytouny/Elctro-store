<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Catigory; 

class CatigorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        Catigory::factory()->count(10)->create();
    }
}
