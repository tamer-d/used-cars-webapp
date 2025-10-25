<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\CarModel;

class CarModelSeeder extends Seeder
{
    public function run(): void
    {
        $modelsData = [
            'Toyota' => ['Corolla', 'Camry', 'Prius', 'RAV4', 'Highlander', 'Yaris', 'Auris', 'Avensis', 'C-HR', 'Land Cruiser'],
            'BMW' => ['Série 1', 'Série 3', 'Série 5', 'Série 7', 'X1', 'X3', 'X5', 'X6', 'Z4', 'i3', 'i8'],
            'Mercedes-Benz' => ['Classe A', 'Classe B', 'Classe C', 'Classe E', 'Classe S', 'GLA', 'GLC', 'GLE', 'GLS', 'CLA'],
            'Audi' => ['A1', 'A3', 'A4', 'A6', 'A8', 'Q2', 'Q3', 'Q5', 'Q7', 'Q8', 'TT', 'R8'],
            'Volkswagen' => ['Golf', 'Polo', 'Passat', 'Tiguan', 'Touran', 'Touareg', 'Arteon', 'T-Cross', 'T-Roc', 'Up!'],
            'Peugeot' => ['208', '308', '508', '2008', '3008', '5008', 'Partner', 'Expert', 'Boxer', '108'],
            'Renault' => ['Clio', 'Mégane', 'Scenic', 'Captur', 'Kadjar', 'Koleos', 'Twingo', 'Zoe', 'Talisman', 'Espace'],
            'Citroën' => ['C1', 'C3', 'C4', 'C5', 'C3 Aircross', 'C5 Aircross', 'Berlingo', 'Jumpy', 'Jumper', 'DS3'],
            'Ford' => ['Fiesta', 'Focus', 'Mondeo', 'Kuga', 'EcoSport', 'Edge', 'S-Max', 'Galaxy', 'Mustang', 'Ranger'],
            'Opel' => ['Corsa', 'Astra', 'Insignia', 'Crossland', 'Grandland', 'Mokka', 'Zafira', 'Vivaro', 'Movano', 'Adam'],
            'Nissan' => ['Micra', 'Note', 'Pulsar', 'Qashqai', 'X-Trail', 'Juke', 'Leaf', '370Z', 'GT-R', 'Navara'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'HR-V', 'Jazz', 'Pilot', 'Ridgeline', 'Insight', 'Fit', 'Odyssey'],
            'Hyundai' => ['i10', 'i20', 'i30', 'Elantra', 'Sonata', 'Tucson', 'Santa Fe', 'Kona', 'Nexo', 'Ioniq'],
            'Kia' => ['Picanto', 'Rio', 'Ceed', 'Optima', 'Sportage', 'Sorento', 'Stonic', 'Niro', 'Soul', 'Carnival'],
            'Mazda' => ['Mazda2', 'Mazda3', 'Mazda6', 'CX-3', 'CX-5', 'CX-30', 'CX-9', 'MX-5', 'RX-8', 'BT-50'],
        ];

        foreach ($modelsData as $brandName => $models) {
            $brand = Brand::where('name', $brandName)->first();
            if ($brand) {
                foreach ($models as $modelName) {
                    CarModel::create([
                        'brand_id' => $brand->id,
                        'name' => $modelName,
                    ]);
                }
            }
        }
    }
}