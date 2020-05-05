<?php

namespace App\Models\Tool;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    //黑名单为空
    protected $guarded = [];
    protected $table = 'tool_about';

    public $timestamps = false;
}
