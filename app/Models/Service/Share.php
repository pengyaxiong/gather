<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    //黑名单为空
    protected $guarded = [];
    protected $table = 'service_help';

    // public $timestamps = false;
}
