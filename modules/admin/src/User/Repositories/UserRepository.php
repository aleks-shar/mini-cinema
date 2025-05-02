<?php

declare(strict_types=1);

namespace App\Admin\User\Repositories;

use App\Admin\Models\User;
use App\Admin\Common\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

final class UserRepository extends BaseRepository
{
    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): User|false
    {
        $name = isset($data['name']) && is_string($data['name']) ? $data['name'] : null;
        $email = isset($data['email']) && is_string($data['email']) ? $data['email'] : null;
        $role = isset($data['role']) && is_string($data['role']) ? $data['role'] : null;
        $password = isset($data['password']) && is_string($data['password']) ? $data['password'] : null;

        if ($name === null || $email === null || $role === null || $password === null) {
            return false;
        }

        /** @var User */
        return User::query()->create([
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'password' => bcrypt($password),
        ]);
    }

    /** @param array<string, mixed> $data */
    public function update(array $data, User $user): User|false
    {
        $password = isset($data['password']) && is_string($data['password']) ? $data['password'] : null;
        $name = isset($data['name']) && is_string($data['name']) ? $data['name'] : null;
        $role = isset($data['role']) && is_string($data['role']) ? $data['role'] : null;

        if ($name === null || $role === null) {
            return false;
        }

        if ($password !== null) {
            $user->password = bcrypt($password);
        }

        $user->name = $name;
        $user->role = $role;
        $user->save();

        return $user;
    }

    public function destroy(User $user): bool
    {
        if (! $user->delete()) {
            return false;
        }

        return true;
    }

    public function getUserById(int $id): User|null
    {
        /** @var User|null */
        return User::query()->find($id);
    }

    public function getUsers(): Collection|null
    {
        /** @var Collection|null $users */
        return User::query()->get();
    }
}
