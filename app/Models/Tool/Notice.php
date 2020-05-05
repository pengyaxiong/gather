<?php

namespace App\Models\Tool;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    //黑名单为空
    protected $guarded = [];
    protected $table = 'tool_notice';

   // public $timestamps = false;
}
