<?php

declare(strict_types=1);

namespace App\Admin\Abuse\Http\Controllers;

use App\Admin\Abuse\Http\Requests\AllAbuseRequest;
use App\Admin\Abuse\Services\AbuseService;
use App\Admin\Common\Http\Controllers\Controller;
use App\Admin\Common\Models\HistoryAbuse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

final class AllAbusesController extends Controller
{
    public function __construct(
        private readonly AbuseService $service,
    ) {
        parent::__construct();
    }

    /**
     * @throws BindingResolutionException
     */
    public function __invoke(AllAbuseRequest $request): Renderable|RedirectResponse
    {
        /** @var array<array-key, mixed> $validated */
        $validated = $request->validated();
        $validated['daterange'] = $validated['daterange'] ?? $this->getDateRange('month');
        $validated['abuse'] = true;
        $data = $this->service->allAbusesForFilter($validated);

        return view('abuse::abused.main', [
            'abused' => $data,
            'title' => $validated['title'] ?? null,
            'type' => $validated['type'] ?? null,
            'daterange' => $validated['daterange'],
            'emails' => HistoryAbuse::query()->select(['email'])->distinct(['email'])->get(),
        ]);
    }
}
