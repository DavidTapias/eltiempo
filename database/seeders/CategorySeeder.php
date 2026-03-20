<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            "Novela",
            "Cuento",
            "Novela gráfica",
            "Poesía",
            "Biografia",
            "Ensayo",
            "Infantil",
            "Juvenil",
            "Autoayuda",
            "Historia"
        ];

        foreach ($categories as $name) {
            Category::create([
                "name" => $name
            ]);
        }
    }
}
