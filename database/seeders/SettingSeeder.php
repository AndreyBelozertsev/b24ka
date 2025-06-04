<?php

namespace Database\Seeders;


use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function isTesting(): bool
    {
        return false;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Setting::query()->count()) {
            return;
        }

        $items = [
            [
                'start_at' => '2025-05-01 00:00:00',
            ],
        ];

        foreach ($items as $item) {
            Setting::query()->create($item);
        }
    }
}
