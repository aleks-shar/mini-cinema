<?php

declare(strict_types=1);

namespace App\Admin\Seo\Http\Filters;

use App\Admin\Models\User;
use App\Admin\Common\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

final class ListDomainIndividualSeoFilter extends AbstractFilter
{
    public const string TYPE = 'type';
    public const string EMAIL = 'email';
    public const string TITLE = 'title';
    public const string DATERANGE = 'daterange';

    /**
     * @return array<string, callable>
     */
    protected function getCallbacks(): array
    {
        return [
            self::TYPE => [$this, 'type'],
            self::TITLE => [$this, 'title'],
            self::EMAIL => [$this, 'email'],
            self::DATERANGE => [$this, 'dateRange'],
        ];
    }

    public function type(Builder $builder, mixed $value): void
    {
        $builder->where(['entity_type' => $value]);
    }

    public function title(Builder $builder, mixed $value): void
    {
        $builder->where('name', 'like', '%' . $value . '%');
    }

    public function email(Builder $builder, mixed $value): void
    {
        $user = User::query()->where('name', '=', $value)->first();

        if (! $user instanceof User) {
            return;
        }

        $builder->where(['email' => $user->email]);
    }
}
