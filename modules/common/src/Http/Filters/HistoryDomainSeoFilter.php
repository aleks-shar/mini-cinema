<?php

declare(strict_types=1);

namespace App\Admin\Common\Http\Filters;

use App\Admin\Models\User;
use Illuminate\Database\Eloquent\Builder;

final class HistoryDomainSeoFilter extends AbstractFilter
{
    public const string TYPE = 'type';
    public const string EMAIL = 'email';
    public const string TITLE = 'title';
    public const string ACTION = 'action';
    public const string DATERANGE = 'daterange';

    /**
     * @return array<string, callable>
     */
    protected function getCallbacks(): array
    {
        return [
            self::TYPE => [$this, 'type'],
            self::TITLE => [$this, 'title'],
            self::ACTION => [$this, 'action'],
            self::EMAIL => [$this, 'email'],
            self::DATERANGE => [$this, 'dateRange'],
        ];
    }

    public function type(Builder $builder, mixed $value): void
    {
        $builder->where(['type' => $value]);
    }

    public function action(Builder $builder, mixed $value): void
    {
        $builder->where(['action' => $value]);
    }

    public function title(Builder $builder, mixed $value): void
    {
        if (is_string($value)) {
            $builder->where('name', 'like', '%' . $value . '%');
        }
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
