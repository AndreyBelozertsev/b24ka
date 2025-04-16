<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use DateTime;
use App\Models\Plan;

use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use Illuminate\Database\Eloquent\Model;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;

/**
 * @extends ModelResource<Plan>
 */
class PlanResource extends ModelResource
{
    protected string $model = Plan::class;

    protected string $title = 'Плановые показатели';

    protected string $column = 'staff.name';
    
    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            BelongsTo::make('Сотрудник', 'staff', 'name')
                ->searchable(),

            Date::make('Месяц', 'start_at')
                ->format('Y-m'),

            Number::make('План', 'summ'),

            Number::make('Конверсия', 'conversion'),

            Number::make('Ставка', 'salary')
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            BelongsTo::make('Сотрудник', 'staff', 'name')
                ->required()
                ->searchable(),

            Date::make('Первый день месяца на который установлен план', 'start_at')
                ->format('Y-m'),

            Number::make('План', 'summ')
                ->required()
                ->min(0)
                ->step(1),

            Number::make('Конверсия', 'conversion')
                ->required()
                ->min(0)
                ->max(100)
                ->step(1),

            Number::make('Ставка', 'salary')
                ->required()
                ->min(0)
                ->step(1),

            Json::make('Дополнительные параметры', 'options')
                ->keyValue('% выполнения плана', '% премии')
                ->removable(),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            BelongsTo::make('Сотрудник', 'staff', 'name')
                ->required()
                ->searchable(),

            Date::make('Первый день месяца на который установлен план', 'start_at')
                ->format('Y-m'),

            Number::make('План', 'summ')
                ->required()
                ->min(0)
                ->step(1),

            Number::make('Конверсия', 'conversion')
                ->required()
                ->min(0)
                ->max(100)
                ->step(1),

            Number::make('Ставка', 'salary')
                ->required()
                ->min(0)
                ->step(1),

            Json::make('Дополнительные параметры', 'options')
                ->keyValue('% выполнения плана', '% премии')
                ->removable(),
        ];
    }

    /**
     * @param Plan $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            'staff_id' => ['required', 'integer', 'exists:staff,id'],
            'start_at' => ['required', 'date'],
            'summ' => ['required'],
            'conversion' => ['required', 'integer', 'min:0', 'max:100'],
            'salary' => ['required'],
            'options' => ['nullable', 'array'],
        ];
    }

    public function search(): array
    {
        return ['id', 'summ'];
    }

    public function filters(): array
    {
        return [
            BelongsTo::make('Сотрудник', 'staff', 'name')
                ->searchable(),

            Number::make('Сумма', 'summ')
                ->min(0),
        ];
    }
}
