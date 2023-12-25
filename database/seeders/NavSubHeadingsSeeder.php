<?php

namespace Database\Seeders;

use App\Models\NavSubHeading;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NavSubHeadingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $navSubHeadings = [
            ['nav_headings_id' => 2,'name' => 'type'],
            ['nav_headings_id' => 2,'name' => 'hype'],
            ['nav_headings_id' => 3,'name' => 'ripe'],
            ['nav_headings_id' => 3,'name' => 'cype'],
            // Add more sub-headings as needed
        ];
        NavSubHeading::insert($navSubHeadings);
    }
}
