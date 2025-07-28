<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $categories = [
            ['name' => 'deportivo'],
            ['name' => 'remera'],
            ['name' => 'mujer'],
            ['name' => 'pantalon'],
            ['name' => 'salir'],
        ];

        foreach ($categories as $categoryData) {
        Category::create($categoryData);


        }
}}
