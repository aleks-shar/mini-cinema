<?php

declare(strict_types=1);

namespace App\Admin\User\Http\Controllers;

use App\Admin\Models\User;
use App\Admin\Common\Http\Controllers\Controller;
use App\Admin\User\Http\Requests\StoreUserRequest;
use App\Admin\User\Http\Requests\UpdateUserFieldsRequest;
use App\Admin\User\Repositories\UserRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

final class UserController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
        parent::__construct();
    }

    public function index(): Renderable|RedirectResponse
    {
        return view('admin::user.index', ['users' => $this->userRepository->getUsers()]);
    }

    public function create(): Renderable
    {
        return view('admin::user.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = $this->userRepository->create($request->validated());

        if (! $user instanceof User) {
            return redirect()->route(self::HOME)->withErrors([self::WRONG]);
        }

        return redirect()->route('user.index')->with('success', 'User successfully created!');
    }

    public function edit(User $user): Renderable
    {
        return view('admin::user.edit', ['user' => $this->userRepository->getUserById($user->id)]);
    }

    public function update(UpdateUserFieldsRequest $request, User $user): RedirectResponse
    {
        $user = $this->userRepository->update($request->validated(), $user);

        if (! $user instanceof User) {
            return redirect()->route(self::HOME)->withErrors([self::WRONG]);
        }

        return redirect()->route('user.index')->with('success', 'User profile successfully modified!');
    }

    public function destroy(User $user): RedirectResponse
    {
        if (! $this->userRepository->destroy($user)) {
            return redirect()->route(self::HOME)->withErrors([self::WRONG]);
        }

        return redirect()->route('user.index')->with('success', 'User successfully deleted!');
    }

    public function block(int $id): RedirectResponse
    {
        $user = User::query()->find($id);

        if (! $user instanceof User) {
            return redirect()->route('user.index')->withErrors(['User is not blocked!']);
        }

        $user->is_active = $user->is_active === 1 ? 0 : 1;
        $user->save();

        if ($user->is_active === 0) {
            DB::query()->from('sessions')->where('user_id', $user->id)->delete();
        }

        return redirect()->route('user.index')->with('success', 'OK');
    }
}
