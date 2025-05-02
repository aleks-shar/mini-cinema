<?php

declare(strict_types=1);

namespace App\Admin\Models;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string $theme
 * @property ?string $two_factor_code
 * @property int $is_active
 * @property ?int $single_mode
 * @method removeRole(string $role)
 */
final class User extends Authenticatable implements Authorizable
{
    use Notifiable;

    protected $table = 'users';

    protected string $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'role',
        'theme',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
