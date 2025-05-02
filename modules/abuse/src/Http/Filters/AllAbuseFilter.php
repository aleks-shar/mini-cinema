<?php

declare(strict_types=1);

namespace App\Admin\Abuse\Http\Filters;

use App\Admin\Models\User;
use App\Admin\Common\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

final class AllAbuseFilter extends AbstractFilter
{
    public const string TYPE = 'type';
    public const string EMAIL = 'email';
    public const string ABUSE = 'abuse';
    public const string DATERANGE = 'daterange';

    /**
     * @return array<string, callable>
     */
    protected function getCallbacks(): array
    {
        return [
            self::TYPE => [$this, 'type'],
            self::ABUSE => [$this, 'abuse'],
            self::EMAIL => [$this, 'email'],
            self::DATERANGE => [$this, 'dateRangeUpdate'],
        ];
    }

    public function type(Builder $builder, mixed $value): void
    {
        $builder->where('entity_type', '=', $value);
    }

    public function abuse(Builder $builder, mixed $value): void
    {
        $builder->where('is_abuse', '=', $value);
    }

    public function email(Builder $builder, mixed $value): void
    {
        $user = User::query()->where('name', '=', $value)->first();

        if (! $user instanceof User) {
            return;
        }

        $builder->where(['email' => $user->email]);
    }

    public function dateRangeUpdate(Builder $builder, mixed $value): void
    {
        if (is_string($value)) {
            $dateparts = explode(' - ', $value);
            $start = $this->getDate($dateparts[0], 'Y-m-d 00:00:00');
            $end = $this->getDate($dateparts[1], 'Y-m-d 23:59:59');

            if ($start && $end) {
                $builder->whereBetween('updated_at', [$start, $end]);
            }
        }
    }
}
