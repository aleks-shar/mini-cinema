<?php

declare(strict_types=1);

namespace App\Admin\Abuse\Http\Controllers;

use App\Admin\Abuse\Services\AbuseService;
use App\Admin\Common\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

final class AbuseController extends Controller
{
    public function __construct(
        private readonly AbuseService $service,
    ) {
        parent::__construct();
    }

    public function __invoke(int $id, string $category): RedirectResponse
    {

        if (! $this->service->abuse($id, $category)) {
            return redirect()->route('abuse.all')->withErrors([self::FAILED]);
        }

        return redirect()->route('abuse.all')->with('success', self::ACCESS);
    }
}
