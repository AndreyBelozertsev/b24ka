<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'staff_id' => 1,
                'start_at' => '2025-04-01 00:00:00',
                'summ' => 3500000,
                'conversion' => 40,
                'salary' => 69000,
                'options' => ['0-80' => '1', '80-100' => 2, '100' => 3]

            ],
            [
                'staff_id' => 2,
                'start_at' => '2025-04-01 00:00:00',
                'summ' => 2000000,
                'conversion' => 40,
                'salary' => 69000,
                'options' => ['0-500' => '2']
            ],            
            [
                'staff_id' => 3,
                'start_at' => '2025-04-01 00:00:00',
                'summ' => 2500000,
                'conversion' => 40,
                'salary' => 69000,
                'options' => ['0-80' => '1', '80-100' => 2, '100' => 3]

            ],            
            [
                'staff_id' => 4,
                'start_at' => '2025-04-01 00:00:00',
                'summ' => 2000000,
                'conversion' => 40,
                'salary' => 69000,
                'options' => ['0-80' => '1', '80-100' => 2, '100' => 3]

            ]
        ];

        foreach($items as $item){
            Plan::updateOrCreate(
                $item
            );
        }
    }
}




// $table->foreignId('staff_id')->constrained()->onDelete('cascade');
// $table->date('start_at');
// $table->integer('summ');
// $table->integer('conversion');
// $table->integer('salary');
// $table->json('options')->nullable();