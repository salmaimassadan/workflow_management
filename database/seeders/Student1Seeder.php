<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student1;


class Student1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student1::factory()->count(50)->create();    }
}
