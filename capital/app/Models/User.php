<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    use HasApiTokens, HasFactory, Notifiable;

    protected $attributes = [
        'date_of_birth' => '1970-01-01',
        'motto' => '',
        'gender' => '',
        'post_code' => '',
        'latitude' => '',
        'longitude' => '',
        'forget_password_code' => '',
        'forget_password_date' => '1970-01-01',
        'active' => 1,
        'deleted' => 0,
        'token_lifetime' => 120
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'date_of_birth',
        'laravel_password',
        'token_lifetime'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'laravel_password',
        'two_factor_token'
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

    public function permissions()
    {
        return $this->hasMany('App\UserPermission', 'user_id');
    }

    public function permission()
    {
        return $this->hasOne('App\UserPermission', 'user_id', 'id');
    }

    /* public function activity() {
        return $this->hasOne('App\UserActivity');
    } */

    public function activities()
    {
        return $this->hasMany('App\UserActivity', 'user_id')->orderBy('created_at', 'desc');
    }

    public function isOnline()
    {
        return $this->activity()->whereRaw('TIMEDIFF(NOW(), created_at) < 60');
    }

    public function gns()
    {
        return $this->hasMany('App\GnsUser', 'user_id');
    }
}
