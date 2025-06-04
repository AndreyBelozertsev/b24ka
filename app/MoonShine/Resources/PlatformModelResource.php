<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;


use App\Models\MoonshineUser;
use Illuminate\Support\Enumerable;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Laravel\Collections\Fields;
use MoonShine\Contracts\Core\CrudPageContract;
use MoonShine\Laravel\Resources\ModelResource;
use Illuminate\Container\Attributes\CurrentUser;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;

/**
 * @template TData of Model
 *
 * @template-covariant TIndexPage of CrudPageContract
 * @template-covariant TFormPage of CrudPageContract
 * @template-covariant TDetailPage of CrudPageContract
 *
 * @extends ModelResource<TData, TIndexPage, TFormPage, TDetailPage, Fields, Enumerable>
 */
abstract class PlatformModelResource extends ModelResource
{
    public function __construct(
        CoreContract $core,
        #[CurrentUser]
        private readonly MoonshineUser $user,
    ) {
        parent::__construct($core);
    }

    protected function onLoad(): void
    {
        parent::onLoad();

        abort_if(! $this->user->isSuperUser(), 403);
    }
}
