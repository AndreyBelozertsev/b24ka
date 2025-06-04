<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Setting;

use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Text;
use App\MoonShine\Pages\SettingPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\Contracts\UI\FieldContract;

/**
 * @extends PlatformModelResource<Setting>
 */
class SettingResource extends PlatformModelResource
{
    protected string $model = Setting::class;

    protected string $title = 'Параметры';

    /**
     * @return list<FieldContract>
     */
    protected function pages(): array
    {
        return [
            SettingPage::class,
        ];
    }

    public function indexFields(): array
    {
        return [
        ];
    }

    public function formFields(): array
    {
        return [
            Box::make([
                ID::make()->sortable(),
                Date::make('Отображать показатели за период', 'start_at')
                    ->format('Y-m'),
            ]),
        ];
    }

    public function detailFields(): array
    {
        return [
            ...$this->indexFields(),
        ];
    }

    public function getItemID(): int|string|null
    {
        return 1;
    }

    public function rules(mixed $item): array
    {
        return [
            'organization_full' => ['nullable', 'string', 'max:1000'],
            'organization_short' => ['nullable', 'string', 'max:255'],
            'inn' => ['nullable', 'string', 'size:10', 'regex:/^[0-9]+$/'],
            'chief_fio' => ['nullable', 'string', 'max:255'],
            'chief_position' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function search(): array
    {
        return [];
    }
}
