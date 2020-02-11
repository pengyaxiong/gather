<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'label','slug','description'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }
}
