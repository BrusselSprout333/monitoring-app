<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'name',
        'job'
    ];

    protected $attributes = [
        'id',
        'email',
        'first_name',
        'last_name',
        'avatar'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->attributes['id'] = $attributes['id'];
        $this->attributes['email'] = $attributes['email'];
        $this->attributes['first_name'] = $attributes['first_name'];
        $this->attributes['last_name'] = $attributes['last_name'];
        $this->attributes['avatar'] = $attributes['avatar'];
    }
}
