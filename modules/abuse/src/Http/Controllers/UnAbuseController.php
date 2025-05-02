<?php

declare(strict_types=1);

namespace App\Admin\Abuse\Http\Controllers;

use App\Admin\Abuse\Services\AbuseService;
use App\Admin\Common\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

final class UnAbuseController extends Controller
{
    public function __construct(
        private readonly AbuseService $service,
    ) {
        parent::__construct();
    }

    public function __invoke(int $id, string $category): Renderable|RedirectResponse
    {
        if (! $this->service->unAbuse($id, $category)) {
            return redirect()->back()->withErrors([self::FAILED]);
        }

        return $this->redirectForUnAbuse();
    }
}
