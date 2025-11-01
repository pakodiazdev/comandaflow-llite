<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Uom;

class UomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultUoms = [
            ['code' => 'pz', 'name' => 'Pieza'],
            ['code' => 'caja', 'name' => 'Caja'],
            ['code' => 'pack', 'name' => 'Pack'],
        ];

        foreach ($defaultUoms as $uom) {
            Uom::firstOrCreate(
                ['code' => $uom['code']],
                $uom
            );
        }
    }
}
