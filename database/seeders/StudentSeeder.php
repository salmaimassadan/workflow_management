<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student1;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 students
        Student1::factory()->count(10)->create();
    }
}
