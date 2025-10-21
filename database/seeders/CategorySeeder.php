<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Berline', 'description' => 'Voitures confortables, idéales pour la route et la ville.'],
            ['name' => 'Citadine', 'description' => 'Petites voitures pratiques et économiques pour la ville.'],
            ['name' => 'SUV', 'description' => 'Véhicules spacieux, puissants et tout-terrain.'],
            ['name' => '4x4', 'description' => 'Véhicules robustes conçus pour les terrains difficiles.'],
            ['name' => 'Coupé', 'description' => 'Voitures sportives à deux portes.'],
            ['name' => 'Cabriolet', 'description' => 'Voitures décapotables pour le plaisir de conduite.'],
            ['name' => 'Break', 'description' => 'Voitures familiales avec grand coffre.'],
            ['name' => 'Pickup', 'description' => 'Véhicules utilitaires avec benne arrière.'],
            ['name' => 'Utilitaire', 'description' => 'Véhicules destinés au transport de marchandises.'],
            ['name' => 'Monospace', 'description' => 'Véhicules familiaux spacieux avec plusieurs sièges.'],
        ];

        DB::table('categories')->insert($categories);
    }
}
