<?php

namespace App\Models\System;

use App\Models\Cms\Customer;
use App\Models\Tool\PV;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use Notifiable, HasRoles, LogsActivity;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'real_name', 'state', 'phone', 'qq'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function pvs()
    {
        return $this->hasMany(PV::class);
    }
}
