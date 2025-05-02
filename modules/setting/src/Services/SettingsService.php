<?php

declare(strict_types=1);

namespace App\Admin\Setting\Services;

use App\Admin\Models\User;
use App\Admin\Common\Repositories\BaseRepository;
use App\Admin\Common\Models\HistorySetting;
use App\Admin\Setting\Models\DomainSettings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

final class SettingsService extends BaseRepository
{
    public function getEmailsForHistory(): Builder
    {
        return HistorySetting::query()->select(['email'])->distinct(['email']);
    }

    public function getDomainSettings(): ?Collection
    {
        return DomainSettings::query()->orderBy('updated_at', 'DESC')->get();
    }

    public function getDomainSettingsBySettingsId(int $settingsId): ?Model
    {
        return DomainSettings::query()->where(['id' => $settingsId])->first();
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): ?Model
    {
        /** @var User $user */
        $user = auth()->guard('admin')->user();

        return DomainSettings::query()->create([
            'key' => $data['key'],
            'value' => $data['value'] ?? null,
            'description' => $data['description'],
            'email_create' => $user->email,
            'email_update' => $user->email,
        ]);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(array $data, DomainSettings $setting): DomainSettings|false
    {
        if (isset($data['key']) && is_string($data['key'])) {
            $setting->key = $data['key'];
        }

        $value = isset($data['value']) && is_string($data['value']) ? $data['value'] : null;
        $description = isset($data['description']) && is_string($data['description']) ? $data['description'] : null;

        if ($value === null || $description === null) {
            return false;
        }

        $setting->value = $value;
        $setting->description = $description;
        $setting->email_update = auth()->guard('admin')->user()->email ?? 'admin@admin.org';
        $setting->save();

        if (! $setting->save()) {
            return false;
        }

        return $setting;
    }

    public function destroy(DomainSettings $setting): bool
    {
        if (! $setting->delete()) {
            return false;
        }

        return true;
    }

    public function findSettings(int $settingsId): Model|null
    {
        return $this->getDomainSettingsBySettingsId($settingsId);
    }
}
