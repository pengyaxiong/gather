<?php

namespace App\Models\Tool;

use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    //黑名单为空
    protected $guarded = [];
    protected $table = 'tool_help';

    public $timestamps = false;
}
