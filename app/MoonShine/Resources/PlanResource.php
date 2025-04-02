<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use DateTime;
use App\Models\Plan;

use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Json;
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
    
    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Сотрудник', 'staff', 'name')
                ->required()
                ->searchable(),

            Date::make('Месяц и год', 'start_at')
                ->format('Y-m'),

            Number::make('Сумма', 'summ')
                ->required()
                ->min(0)
                ->step(1),

            Number::make('Конверсия', 'conversion')
                ->required()
                ->min(0)
                ->max(100)
                ->step(1),

            Number::make('Зарплата', 'salary')
                ->required()
                ->min(0)
                ->step(1),

            Json::make('Дополнительные параметры', 'options')
                ->keyValue('Параметр', 'Значение')
                ->removable(),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return $this->indexFields();
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return $this->indexFields();
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
            'summ' => ['required', 'integer', 'min:0'],
            'conversion' => ['required', 'integer', 'min:0', 'max:100'],
            'salary' => ['required', 'integer', 'min:0'],
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


// $table->id();
// $table->foreignId('staff_id')->constrained()->onDelete('cascade');
// $table->date('start_at');
// $table->integer('summ');
// $table->integer('conversion');
// $table->integer('salary');
// $table->json('options')->nullable();
// $table->timestamps();