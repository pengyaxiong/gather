<?php

namespace App\Models\Tool;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spider extends Model
{
    protected $guarded = [];
    use SoftDeletes;

    protected $dates = ['deleted_at'];

}
