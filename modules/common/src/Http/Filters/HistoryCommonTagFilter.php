<?php

declare(strict_types=1);

namespace App\Admin\Common\Http\Filters;

use App\Admin\Models\User;
use Illuminate\Database\Eloquent\Builder;

final class HistoryCommonTagFilter extends AbstractFilter
{
    public const string ALIAS = 'alias';
    public const string EMAIL = 'email';
    public const string DATERANGE = 'daterange';

    /**
     * @return array<string, callable>
     */
    protected function getCallbacks(): array
    {
        return [
            self::ALIAS => [$this, 'alias'],
            self::EMAIL => [$this, 'email'],
            self::DATERANGE => [$this, 'dateRange'],
        ];
    }

    public function alias(Builder $builder, mixed $value): void
    {
        $builder->where(['alias' => $value]);
    }

    public function email(Builder $builder, mixed $value): void
    {
        if (! is_string($value)) {
            return;
        }

        $user = User::query()->where('name', '=', $value)->first();

        if (! $user instanceof User) {
            return;
        }

        $builder->where(['email' => $user->email]);
    }
}
