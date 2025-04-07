<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Client extends Authenticatable
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    
    use HasApiTokens, Notifiable;

    protected $guarded = ['id'];

    protected $table = 'clients';

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function getAuthPassword() {
        return $this->password;
    }

    public function generateToken($client) {
        return $client->createToken();
    }

    public function companies() {
        return $this->hasMany('App\Company', 'client_id');
    }
}
