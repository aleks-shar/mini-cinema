<?php

declare(strict_types=1);

namespace App\Admin\Common\Http\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractFilter implements FilterInterface
{
    /**
     * @var array<string, mixed>
     */
    private array $queryParams;

    /**
     * @param array<string, mixed> $queryParams
     */
    public function __construct(array $queryParams)
    {
        $this->queryParams = $queryParams;
    }

    /**
     * @return array<string, callable>
     */
    abstract protected function getCallbacks(): array;

    public function apply(Builder $builder): void
    {
        foreach ($this->getCallbacks() as $name => $callback) {
            if (isset($this->queryParams[$name])) {
                call_user_func($callback, $builder, $this->queryParams[$name]);
            }
        }
    }

    public function dateRange(Builder $builder, mixed $value): void
    {
        if (! is_string($value)) {
            return;
        }

        $dateParts = explode(' - ', $value);

        $start = $this->getDate($dateParts[0], 'Y-m-d 00:00:00');

        $end = $this->getDate($dateParts[1], 'Y-m-d 23:59:59');

        if ($start && $end) {
            $builder->whereBetween('created_at', [$start, $end]);
        }
    }

    protected function getDate(string $date, string $format): string
    {
        /** @var Carbon $carbon */
        $carbon = Carbon::createFromFormat(format: 'd/m/Y', time: $date);

        return $carbon->format($format);
    }
}
