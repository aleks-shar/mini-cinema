<?php

declare(strict_types=1);

namespace App\Admin\Abuse\Http\Controllers;

use App\Admin\Abuse\Http\Requests\HistoryAbuseRequest;
use App\Admin\Abuse\Services\AbuseService;
use App\Admin\Common\Http\Controllers\Controller;
use App\Admin\Common\Models\HistoryAbuse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

final class HistoryAbuseController extends Controller
{
    public function __construct(
        private readonly AbuseService $service,
    ) {
        parent::__construct();
    }

    /**
     * @throws BindingResolutionException
     */
    public function __invoke(): Renderable|RedirectResponse
    {
        /** @var array<array-key, mixed> $validated */
        $validated = request()->validate((new HistoryAbuseRequest())->rules());

        if (empty($validated)) {
            $validated['daterange'] = $this->getDateRange('month');
        }

        return view('abuse::history.main', [
            'data' => $this->service->getHistoryAbuseList($validated),
            'title' => $validated['title'] ?? null,
            'type' => $validated['type'] ?? null,
            'abuse' => $validated['abuse'] ?? null,
            'daterange' => $validated['daterange'],
            'emails' => HistoryAbuse::query()->select(['email'])->distinct(['email'])->get(),
        ]);
    }
}
