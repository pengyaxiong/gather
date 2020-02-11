<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [''];

    public function category()
    {
        return $this->belongsTo('App\Models\Cms\Category');
    }
}
