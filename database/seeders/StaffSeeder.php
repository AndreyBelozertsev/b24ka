<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'Сиёвуш',
                'position_id' => 1,
                'bitrix_id' => 56035
            ],
            [
                'name' => 'Марат Мукожев',
                'position_id' => 1,
                'bitrix_id' => 49723
            ],
            [
                'name' => 'Каюмарс Сафаров',
                'position_id' => 1,
                'bitrix_id' => 4553
            ]
        ];

        foreach($items as $item){
            Staff::updateOrCreate(
                $item
            );
        }

    }
}