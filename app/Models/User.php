<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @OA\Schema(
 * schema="User",
 * title="User",
 * description="User model",
 * @OA\Property(
 * property="id",
 * type="integer",
 * format="int64",
 * description="ID of the user",
 * readOnly=true
 * ),
 * @OA\Property(
 * property="name",
 * type="string",
 * description="Name of the user"
 * ),
 * @OA\Property(
 * property="email",
 * type="string",
 * format="email",
 * description="Email of the user"
 * ),
 * @OA\Property(
 * property="email_verified_at",
 * type="string",
 * format="date-time",
 * description="Timestamp when email was verified",
 * nullable=true
 * ),
 * @OA\Property(
 * property="created_at",
 * type="string",
 * format="date-time",
 * description="Timestamp when the user was created",
 * readOnly=true
 * ),
 * @OA\Property(
 * property="updated_at",
 * type="string",
 * format="date-time",
 * description="Timestamp when the user was last updated",
 * readOnly=true
 * )
 * )
 */

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
