<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Staff;
use MoonShine\UI\Fields\ID;

use MoonShine\UI\Fields\Text;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Model;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;

/**
 * @extends ModelResource<Staff>
 */
class StaffResource extends ModelResource
{
    protected string $model = Staff::class;

    protected string $title = 'Сотрудники';
    
    protected string $column = 'name';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            Text::make('ФИО', 'name'),
            Text::make('Bitrix ID', 'bitrix_id'),
            BelongsTo::make('Должность',
                'position',
                'title',
                PositionResource::class,
            ),
            Switcher::make('Статус', 'status'),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Tabs::make([
                Tab::make('Общая информация', [
                    Text::make('ФИО', 'name'),
                    Text::make('Bitrix ID', 'bitrix_id'),
                    Switcher::make('Статус', 'status'),
                    BelongsTo::make('Должность',
                        'position',
                        'title',
                        PositionResource::class,
                    ),
                ]),
                Tab::make('Планы', [
                    HasMany::make(
                        'Планы',
                        'plans',
                        resource: PlanResource::class
                    )
                    ->searchable(false)
                ]),
            ]),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            Text::make('ФИО', 'name'),
            Text::make('Bitrix ID', 'bitrix_id'),
            BelongsTo::make('Должность',
                'position',
                'title',
                PositionResource::class,
            ),
            Switcher::make('Статус', 'status'),
            HasMany::make(
                    'Планы',
                    'plans',
                    resource: PlanResource::class
                )
                ->searchable(false)
        ];
    }

    /**
     * @param Staff $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
