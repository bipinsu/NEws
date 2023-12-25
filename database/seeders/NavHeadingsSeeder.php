<?php

namespace Database\Seeders;

use App\Models\NavHeading;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NavHeadingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $navHeadings = [
            ['name' => 'Home'],
            ['name' => 'Loan'],
            ['name' => 'News'],
            // Add more headings as needed
        ];


        NavHeading::insert($navHeadings);

    }
}
