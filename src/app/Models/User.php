<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements AuthenticatableContract
{
    use HasApiTokens;

    public $timestamps = false;

//    protected $attributes = [
//        'id',
//        'password',
//        'email',
//        'first_name',
//        'last_name',
//        'avatar',
//        'gender',
//        'age'
//    ];
}
