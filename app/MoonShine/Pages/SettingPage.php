<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use MoonShine\UI\Fields\Hidden;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\Laravel\Pages\Crud\FormPage;
use App\MoonShine\Resources\SettingResource;
use MoonShine\MenuManager\Attributes\SkipMenu;

#[SkipMenu]
/**
 * @extends FormPage<SettingResource>
 */
class SettingPage extends FormPage
{
    public function getBreadcrumbs(): array
    {
        return [
            '#' => $this->getTitle(),
        ];
    }

    public function getTitle(): string
    {
        return $this->title ?: 'Параметры';
    }

    public function components(): array
    {
        if ($this->getResource() === null) {
            return [];
        }

        $item = $this->getResource()->getItem();

        if ($item === null) {
            return [];
        }

        return [
            FormBuilder::make(
                $this->getResource()->getRoute('crud.update', $item->getKey()),
            )
                ->async()
                ->fields(
                    $this
                        ->getResource()
                        ->getFormFields()
                        ->push(
                            Hidden::make('_method')->setValue('PUT'),
                        )
                        ->toArray(),
                )
                ->name('crud')
                ->fillCast($item, $this->getResource()->getCaster())
                ->submit(__('moonshine::ui.save'), ['class' => 'btn-primary btn-lg']),
        ];
    }
}
