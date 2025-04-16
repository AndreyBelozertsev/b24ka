<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Position;
use MoonShine\UI\Fields\ID;

use MoonShine\UI\Fields\Text;
use Illuminate\Database\Eloquent\Model;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<Position>
 */
class PositionResource extends ModelResource
{
    protected string $model = Position::class;

    protected string $title = 'Должности';

    protected string $column = 'title';
    
    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            Text::make('Должность', 'title'),
            Text::make('Сортировка', 'sort')
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                Text::make('Название', 'title')
                    ->required(),
            
                Text::make('Сортировка', 'sort')
                    ->required(),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            Text::make('Название', 'title')
                ->required(),
            
            Text::make('Сортировка', 'sort')
                ->required(),
        ];
    }

    /**
     * @param Position $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'sort' => ['required', 'string', 'max:50'],
        ];
    }
}


// $table->id();
// $table->string('title');
// $table->string('sort');
// $table->timestamps();