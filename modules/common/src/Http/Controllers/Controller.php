<?php

declare(strict_types=1);

namespace App\Admin\Common\Http\Controllers;

use App\Admin\Common\Models\HistoryAbuse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;

abstract class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    protected const string WRONG = 'Возникла ошибка!';
    protected const string FAILED = 'Ошибка!';
    protected const string ACCESS = 'Успешно!';
    protected const string ERROR = 'Ошибка! Внутренняя ошибка системы!';
    protected const string HOME = 'admin.home';

    public function __construct()
    {
        $this->middleware(middleware: 'auth');
    }

    protected function redirectBackWithError(string $message): RedirectResponse
    {
        return redirect()->back()->withErrors([$message]);
    }

    protected function getDateRange(string $time): string
    {
        /** @var string $tz */
        $tz = config('app.timezone');
        $now = Carbon::now($tz)->format('d/m/Y');

        $old = match ($time) {
            'now' => Carbon::now($tz)->format('d/m/Y'),
            'day' => Carbon::now($tz)->subDay()->format('d/m/Y'),
            'month' => Carbon::now($tz)->subMonth()->format('d/m/Y'),
            'year' => Carbon::now($tz)->subYear()->format('d/m/Y'),
            default => $now,
        };

        return $old . ' - ' . $now;
    }

    protected function redirectForUnAbuse(): RedirectResponse
    {
        return redirect()
            ->route('abuse.all')
            ->with('emails', HistoryAbuse::query()
                ->select(['email'])
                ->distinct(['email'])
                ->get())
            ->with('daterange', $this->getDateRange('month'))
            ->with('success', self::ACCESS);
    }
}
