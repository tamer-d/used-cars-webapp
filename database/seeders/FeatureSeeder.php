<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [

            ['name' => 'Air Conditioning'],
            ['name' => 'Automatic Climate Control'],
            ['name' => 'Heated Seats'],
            ['name' => 'Leather Seats'],
            ['name' => 'Ventilated Seats'],
            ['name' => 'Power Adjustable Seats'],
            ['name' => 'Massage Seats'],
            ['name' => 'Panoramic Sunroof'],
            ['name' => 'Sunroof'],
            ['name' => 'Ambient Lighting'],
            ['name' => 'Rear AC Vents'],


            ['name' => 'Bluetooth'],
            ['name' => 'USB Port'],
            ['name' => 'Aux Input'],
            ['name' => 'Apple CarPlay'],
            ['name' => 'Android Auto'],
            ['name' => 'Touchscreen Display'],
            ['name' => 'Navigation System'],
            ['name' => 'Premium Sound System'],
            ['name' => 'Wireless Charging'],


            ['name' => 'ABS (Anti-lock Braking System)'],
            ['name' => 'Airbags'],
            ['name' => 'Traction Control'],
            ['name' => 'Hill Start Assist'],
            ['name' => 'Rear Parking Sensors'],
            ['name' => 'Front Parking Sensors'],
            ['name' => 'Rearview Camera'],
            ['name' => '360° Camera'],
            ['name' => 'Blind Spot Monitor'],
            ['name' => 'Lane Departure Warning'],
            ['name' => 'Adaptive Cruise Control'],
            ['name' => 'Emergency Brake Assist'],
            ['name' => 'Tyre Pressure Monitoring System (TPMS)'],
            ['name' => 'Auto Headlights'],
            ['name' => 'Rain Sensing Wipers'],


            ['name' => 'Alloy Wheels'],
            ['name' => 'Fog Lights'],
            ['name' => 'LED Headlights'],
            ['name' => 'Roof Rails'],
            ['name' => 'Sport Suspension'],
            ['name' => 'Keyless Entry'],
            ['name' => 'Push Start Button'],
            ['name' => 'Power Mirrors'],
            ['name' => 'Electric Tailgate'],
            ['name' => 'Tow Hitch'],


            ['name' => 'Heads-up Display'],
            ['name' => 'Digital Dashboard'],
            ['name' => 'Auto Parking Assist'],
            ['name' => 'Collision Warning System'],
            ['name' => 'Driving Mode Selector'],
        ];

        DB::table('features')->insert($features);
    }
}
