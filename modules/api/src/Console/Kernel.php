<?php

declare(strict_types=1);

namespace App\Api\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * @var string[]
     */
    protected $commands = [
       //
    ];

    protected function schedule(Schedule $schedule): void
    {
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
