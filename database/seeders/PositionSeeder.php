<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'title' => 'Менеджер отдела продаж',
                'sort' => 100
            ],
            [
                'title' => 'Кладовщик',
                'sort' => 200
            ],
        ];

        foreach($items as $item){
            Position::updateOrCreate(
                $item
            );
        }
    }
}


// $table->id();
// $table->string('title');
// $table->string('sort');
// $table->timestamps();