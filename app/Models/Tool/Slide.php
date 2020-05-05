<?php

namespace App\Models\Tool;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    //黑名单为空
    protected $guarded = [];
    protected $table = 'tool_slide';

    public $timestamps = false;
}
