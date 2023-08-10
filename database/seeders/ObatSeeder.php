<?php

namespace Database\Seeders;

use App\Models\Drug;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{

    public function run()
    {
        Drug::factory(1500)->create();
    }
}
