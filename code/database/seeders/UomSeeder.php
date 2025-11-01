<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UOM;

class UomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultUoms = [
            [
                'code' => 'PZ',
                'name' => 'Pieza'
            ],
            [
                'code' => 'CAJA',
                'name' => 'Caja'
            ],
            [
                'code' => 'PACK',
                'name' => 'Pack'
            ],
            [
                'code' => 'KG',
                'name' => 'Kilogramo'
            ],
            [
                'code' => 'G',
                'name' => 'Gramo'
            ],
            [
                'code' => 'L',
                'name' => 'Litro'
            ],
            [
                'code' => 'ML',
                'name' => 'Mililitro'
            ],
            [
                'code' => 'M',
                'name' => 'Metro'
            ],
            [
                'code' => 'CM',
                'name' => 'Centímetro'
            ],
            [
                'code' => 'DOZ',
                'name' => 'Docena'
            ]
        ];

        foreach ($defaultUoms as $uom) {
            UOM::firstOrCreate(
                ['code' => $uom['code']],
                $uom
            );
        }
    }
}
